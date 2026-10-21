<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Webklex\PHPIMAP\ClientManager;
use Webklex\PHPIMAP\IMAP;

class AdminMailController extends Controller
{
    private function boxes(): array
    {
        return [
            'master' => [
                'label' => 'master@autolikerlive.com (temp-mail + aliases)',
                'username' => env('TEMP_IMAP_USERNAME', 'master@autolikerlive.com'),
                'password' => env('TEMP_IMAP_PASSWORD', ''),
            ],
            'contact' => [
                'label' => 'contact@autolikerlive.com (contact form)',
                'username' => env('CONTACT_IMAP_USERNAME', 'contact@autolikerlive.com'),
                'password' => env('CONTACT_IMAP_PASSWORD', ''),
            ],
        ];
    }

    private function connect(array $box)
    {
        $client = (new ClientManager())->make([
            'host' => env('TEMP_IMAP_HOST', 'mail.bharatiyagharseva.com'),
            'port' => (int) env('TEMP_IMAP_PORT', 993),
            'protocol' => 'imap',
            'encryption' => 'ssl',
            'validate_cert' => false,
            'username' => $box['username'],
            'password' => $box['password'],
            'authentication' => null,
        ]);
        $client->connect();

        return $client;
    }

    private function summarize($message): array
    {
        $attrs = $message->getAttributes();
        $uid = $attrs['uid'] ?? 0;

        try {
            $date = Carbon::parse($attrs['date'][0] ?? null);
        } catch (\Throwable $e) {
            $date = null;
        }

        $from = $attrs['from'][0] ?? null;

        return [
            'uid' => $uid,
            'subject' => isset($attrs['subject'][0]) ? strip_tags(imap_utf8($attrs['subject'][0])) : '(no subject)',
            'from_name' => $from->personal ?? '',
            'from_email' => $from->mail ?? '',
            'to' => $attrs['to'][0]->mail ?? '',
            'date' => $date,
            'seen' => (bool) ($message->getFlags()->contains('Seen') ?? false),
            'has_html' => $message->hasHTMLBody(),
        ];
    }

    public function index(Request $request)
    {
        $boxes = $this->boxes();
        $boxKey = $request->get('box', 'master');
        if (!isset($boxes[$boxKey])) {
            $boxKey = 'master';
        }
        $search = trim((string) $request->get('q', ''));
        $page = max(1, (int) $request->get('page', 1));
        $perPage = 20;
        $error = null;
        $paginator = null;
        $skipped = 0;
        $skippedUids = [];

        try {
            $client = $this->connect($boxes[$boxKey]);
            $folder = $client->getFolderByName('INBOX');

            // Last 90 days cap so big mailboxes stay fast; paginate newest-first in PHP.
            // NOTE: fetch UID-by-UID instead of one bulk ->get(). A single message with
            // malformed headers makes the IMAP library's bulk FETCH parser throw
            // ("Undefined array key 2" / count(string)), which previously nuked the
            // whole inbox view. Per-message isolation lets us skip just the bad one.
            $uids = $folder->query()->since(Carbon::now()->subDays(90)->format('d-M-Y'))->search();

            $rows = [];
            foreach ($uids as $uid) {
                try {
                    $rows[] = $this->summarize($folder->query()->getMessageByUid($uid));
                } catch (\Throwable $e) {
                    $skipped++;
                    $skippedUids[] = $uid;
                    \Log::warning("AdminMail skipped unparseable message UID {$uid} in {$boxKey}: " . $e->getMessage());
                }
            }
            $client->disconnect();

            usort($rows, fn($a, $b) => $b['uid'] <=> $a['uid']);

            if ($search !== '') {
                $rows = array_values(array_filter($rows, function ($r) use ($search) {
                    return stripos($r['subject'] . ' ' . $r['from_name'] . ' ' . $r['from_email'] . ' ' . $r['to'], $search) !== false;
                }));
            }

            $total = count($rows);
            $paginator = new LengthAwarePaginator(
                array_slice($rows, ($page - 1) * $perPage, $perPage),
                $total,
                $perPage,
                $page,
                ['path' => route('admin.mails.index'), 'query' => ['box' => $boxKey, 'q' => $search]]
            );
        } catch (\Throwable $e) {
            $error = 'Could not connect to ' . $boxes[$boxKey]['username'] . ': ' . $e->getMessage();
            \Log::error('AdminMail index error: ' . $e->getMessage());
        }

        return view('admin.mails.index', [
            'boxes' => $boxes,
            'boxKey' => $boxKey,
            'search' => $search,
            'paginator' => $paginator,
            'error' => $error,
            'skipped' => $skipped,
            'skippedUids' => $skippedUids,
        ]);
    }

    public function show(Request $request, string $box, int $uid)
    {
        $boxes = $this->boxes();
        if (!isset($boxes[$box])) {
            abort(404);
        }
        $error = null;
        $mail = null;

        try {
            $client = $this->connect($boxes[$box]);
            $folder = $client->getFolderByName('INBOX');
            $message = $folder->query()->getMessageByUid($uid);

            $row = $this->summarize($message);
            $row['body_html'] = $message->hasHTMLBody() ? $message->getHTMLBody() : null;
            $row['body_text'] = $message->getTextBody();
            try {
                $row['attachments'] = collect($message->getAttachments())->map(fn($a) => [
                    'name' => $a->getName(),
                    'size' => $a->getSize(),
                ])->all();
            } catch (\Throwable $e) {
                $row['attachments'] = [];
            }
            $client->disconnect();
            $mail = $row;
        } catch (\Throwable $e) {
            $error = 'Could not load message: ' . $e->getMessage();
            \Log::error('AdminMail show error: ' . $e->getMessage());
        }

        return view('admin.mails.show', [
            'boxes' => $boxes,
            'boxKey' => $box,
            'mail' => $mail,
            'error' => $error,
        ]);
    }

    public function destroy(Request $request, string $box, int $uid)
    {
        $boxes = $this->boxes();
        if (!isset($boxes[$box])) {
            abort(404);
        }

        try {
            $client = $this->connect($boxes[$box]);
            $folder = $client->getFolderByName('INBOX');
            $message = $folder->query()->getMessageByUid($uid);
            $message->delete();
            $client->expunge();
            $client->disconnect();

            return redirect()->route('admin.mails.index', ['box' => $box])->with('success', 'Message deleted.');
        } catch (\Throwable $e) {
            \Log::warning('AdminMail normal delete failed for UID ' . $uid . ', trying raw delete: ' . $e->getMessage());

            // Fallback for messages with malformed headers that the IMAP library
            // cannot parse (constructor throws before we can flag them): set the
            // \Deleted flag directly by UID without fetching anything.
            try {
                $client = $this->connect($boxes[$box]);
                $client->openFolder('INBOX');
                $client->getConnection()->store(['\Deleted'], $uid, null, '+', true, IMAP::ST_UID);
                $client->expunge();
                $client->disconnect();

                return redirect()->route('admin.mails.index', ['box' => $box])->with('success', 'Message deleted.');
            } catch (\Throwable $e2) {
                \Log::error('AdminMail delete error: ' . $e2->getMessage());

                return redirect()->route('admin.mails.index', ['box' => $box])->withErrors(['mail' => 'Delete failed: ' . $e2->getMessage()]);
            }
        }
    }
}
