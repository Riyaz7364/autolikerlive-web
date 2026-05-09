<?php

namespace App\Http\Services\tempmail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Tempmail;
use App\Models\Profile;
use App\Models\Statistic;
use Webklex\PHPIMAP\ClientManager;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Cache;

class TempMailController
{

   private $mailbox;
   private $username;
   private $password;
   protected $clientManager;

   function __construct(){
        $this->mailbox = '{82.180.146.92:993/imap/ssl/novalidate-cert}INBOX';
        $this->username = 'master@autolikerlive.com';
        $this->password = 'Riyaz@7364';
        $this->clientManager = new ClientManager(base_path('config/imap.php'));
   }

   public function connection()
   {
       $client = $this->clientManager->make([
           'protocol'      => 'imap',
           'host' => '82.180.146.92',
           'port' => '993',
           'encryption' => 'ssl',
           'validate_cert' => false,
           'username' => 'master@autolikerlive.com',
           'password' => 'Riyaz@7364',
           'authentication' => null,
       ]);

       $client->connect();

        $message_mask = \Webklex\PHPIMAP\Support\Masks\MessageMask::class;
        $client->setDefaultMessageMask($message_mask);


       return $client;
   }

   public function extractEmail($email)
   {
       $parts = explode('@', $email);

       // Check if there are exactly two parts (prefix and domain)
       if (count($parts) === 2) {
           $prefix = $parts[0];
           $domain = $parts[1];
           $domainPrefix = explode('.', $domain);
           return [
               'prefix' => $prefix,
               'domain' => $domain,
               'domainPrefix' => $domainPrefix[0],
               'tag' => $domain == "gmail.com" ? $this->processString($prefix) : "main"
           ];
       } else {
           return false;
       }
   }


   public function allMessages(Request $request)
   {
        $validator = Validator::make($request->all(), [
            'email'=>'required',
        ]);

        $email = $request['email'];
        $time = 0;
        $extractEmail = $this->extractEmail($email);

        $domainPrefix = $extractEmail['domainPrefix'];
        $prefix = $extractEmail['prefix'];
        $tag = $extractEmail['tag'];


       try {
           $client = $this->connection();
           $folder = $client->getFolderByName('INBOX');
           dd($client);
           $messages = $time == 0
               ? $folder->query()->to($email)->get()
               : $folder->query()->to($email)->since(Carbon::now()->subDays($time)->format('d-M-Y'))->get();

           return $this->formatResponse($email, $messages, $domainPrefix, $prefix, $client);
       } catch (\Exception $e) {
           return [
                'status' => false,
                'mailbox' => "Unable to retrieve emails at this time. Please try Again",
                'messages' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'stack' => $e->getTraceAsString(),
           ];
       }
   }

   protected function formatResponse($email, $messages, $domainPrefix, $prefix, $client)
    {
        $response = [
            'status' => true,
            'mailbox' => $email,
            'email_token' => $this->encrypt_email($email),
            'messages' => []
        ];

        for ($i=0; $i < count($messages); $i++) {

            $response['messages'][$i] = $this->formatMessage($messages[$i], $domainPrefix, $prefix, $client);

            try {
                $is_seen = $messages[$i]->getFlags()['seen'] == 'Seen';
            } catch (\Throwable $th) {
                $is_seen = false;
            }
            $response['messages'][$i]['is_seen'] = $is_seen;
        }

        foreach ($messages as $message) {

        }

        return $response;
    }

    function encrypt_email($email)
    {
        $key = config('app.key'); // Use Laravel's app key
        $iv = '1234567890123456'; // Fixed IV (16 bytes)

        // Ensure the key is 32 bytes long for AES-256-CBC
        $key = substr(hash('sha256', $key), 0, 32);

        // Encrypt the email
        $encrypted = openssl_encrypt($email, 'AES-256-CBC', $key, 0, $iv);

        // Encode the encrypted string to make it URL-safe
        return rtrim(strtr(base64_encode($encrypted), '+/', '-_'), '=');
    }

    function encode_hash($id, $connection = "main")
    {
        return Hashids::connection($connection)->encode($id);
    }


    protected function formatMessage($message, $domainPrefix, $prefix)
    {
        $id = $message->getAttributes()["uid"];

        $hash_id = $this->encode_hash($id, 'mail') .'0';

        return Cache::remember($hash_id, 10000 * 60, function () use ($message, $hash_id, $domainPrefix, $prefix) {

            Statistic::firstOrCreate(
                ['key' => 'messages', 'value' => $hash_id], // Check for existence based on these fields
                ['key' => 'messages', 'value' => $hash_id]  // Create with these values if not found
            );


            return $this->extractMessageData($message, $hash_id, $domainPrefix, $prefix);
        });
    }

    protected function extractMessageData($message, $hash_id, $domainPrefix, $prefix, $client = null, $seenFlag = false)
    {
        $data = [];




        $attributes = $message->getAttributes();
        $header = $message->getHeader();

        //MyLog('attributes', ['attributes' =>  $attributes]);
        //MyLog('header', ['header' =>  $header]);

        $date = Carbon::parse($message->getAttributes()['date'][0]);
        //$delivery_date = Carbon::parse($message->getAttributes()['delivery_date'][0]);

        $data['subject'] = strip_tags($this->decodeSubject($message->getAttributes()['subject'][0]));
        $data['from'] = $message->getAttributes()['from'][0]->personal;
        $data['from_email'] = $message->getAttributes()['from'][0]->mail;
        $data['to'] = $message->getAttributes()['to'][0]->mail;
        //$data['receivedAt'] =  $date;
        //$data['delivery_date'] =  $delivery_date;

        $data['receivedAt'] =  $date->setTimezone(config('app.timezone'))->toDateTimeString();
        //$data['Indian/Maldives'] =  $date->setTimezone('Indian/Maldives')->toDateTimeString();

        //$/data['UTC2'] =  $delivery_date->setTimezone('UTC')->toDateTimeString();
        //$data['Indian/Maldives2'] =  $delivery_date->setTimezone('Indian/Maldives')->toDateTimeString();

        $data['id'] = $hash_id;
        $data['html'] = $message->hasHTMLBody();

        $data['content'] = $message->hasHTMLBody()
            ? str_replace('<a', '<a target="blank"', $message->mask()->getHTMLBodyWithEmbeddedBase64Images())
            : str_replace(['\r\n', '\n'], '<br/>', str_replace('<a', '<a target="blank"', $message->getTextBody()));

        $data['attachments'] = [];
        // $data['attachments'] = $this->handleAttachments($message, $hash_id, $domainPrefix, $prefix);

        if ($client !== null) {
            $client->disconnect();
        }

        return $data;
    }

   protected function processString($inputString)
   {
       // Remove dots
       $step1 = str_replace('.', '', $inputString);

       // Find the position of the plus sign
       $plusPosition = strpos($step1, '+');

       // If plus sign is found, remove text after it
       if ($plusPosition !== false) {
           $result = substr($step1, 0, $plusPosition);
       } else {
           // If no plus sign, return the original string
           $result = $step1;
       }

       return $result;
   }


   protected function decodeSubject($subject)
   {

       $parts = preg_match_all("/(=\?[^\?]+\?[BQ]\?)([^\?]+)(\?=)[\r\n\t ]*/i", $subject, $m);

       $joined_parts = '';
       if (count($m[1]) > 1 && !empty($m[2])) {
           // Example: GyRCQGlNVTtZRTkhIT4uTlMbKEI=
           $joined_parts = $m[1][0] . implode('', $m[2]) . $m[3][0];

           $subject_decoded = iconv_mime_decode($joined_parts, ICONV_MIME_DECODE_CONTINUE_ON_ERROR, "UTF-8");

           if ($subject_decoded && trim($subject_decoded) != trim(rtrim($joined_parts, '='))) {
               return $subject_decoded;
           }
       }

       // iconv_mime_decode() can't decode:
       // =?iso-2022-jp?B?IBskQiFaSEcyPDpuQC4wTU1qIVs3Mkp2JSIlLyU3JSItahsoQg==?=
       $subject_decoded = iconv_mime_decode($subject, ICONV_MIME_DECODE_CONTINUE_ON_ERROR, "UTF-8");

       // Sometimes iconv_mime_decode() can't decode some parts of the subject:
       // =?iso-2022-jp?B?IBskQiFaSEcyPDpuQC4wTU1qIVs3Mkp2JSIlLyU3JSItahsoQg==?=
       // =?iso-2022-jp?B?GyRCQGlNVTtZRTkhIT4uTlMbKEI=?=
       if (preg_match_all("/=\?[^\?]+\?[BQ]\?/i", $subject_decoded)) {
           $subject_decoded = \imap_utf8($subject);
       }

       if (!$subject_decoded) {
           $subject_decoded = $subject;
       }

       return $subject_decoded;
   }



   protected function handleAttachments($message, $hash_id, $domainPrefix, $prefix)
   {
       $attachmentsData = [];

       if ($message->hasAttachments()) {
            $attachments = $message->getAttachments();

            $directory = $this->getDirectoryPath($hash_id, $domainPrefix, $prefix);
            $download = $this->getDownloadPath($hash_id, $domainPrefix, $prefix);

           foreach ($attachments as $attachment) {
               if ($attachment->getAttributes()['disposition'] == 'attachment') {
                   $processedAttachment = $this->processAttachment($attachment, $directory, $download);
                   if (!empty($processedAttachment)) {
                       $attachmentsData[] = $processedAttachment;
                   }
               }
           }
       }

       return $attachmentsData;
   }

   public function download($hash_id, $file)
   {
       if (true) {

           $message = Cache::remember($hash_id, $this->cacheExpired(), function () use ($hash_id) {
               return $this->getMessage($hash_id);
           });


           $email = $message['to'];

           $extractEmail = $this->extractEmail($email);

           $domainPrefix = $extractEmail['domainPrefix'];
           $prefix = $extractEmail['prefix'];

           $path = 'temp/attachments/' . $domainPrefix . '/' . $prefix . '/' . $hash_id . '/' . $file;

           $directory = url('').'/storage/'.$path;
           $storage_path = storage_path('app/public/'.$path);

           if (file_exists($storage_path)) {
               return response()->download($storage_path);
           } else {
               abort(404);
           }
       } else {
           abort(403);
       }
   }

   protected function getDirectoryPath($hash_id, $domainPrefix, $prefix)
   {
       $path =  config('lobage.attachment_path') . $domainPrefix . '/' . $prefix . '/' . $hash_id . '/';

       if (!is_dir($path)) {
           mkdir($path, 0777, true);
       }
       return $path;
   }

   protected function getDownloadPath($hash_id, $domainPrefix, $prefix)
   {
       return url('/') . '/api/v1/d/' . $hash_id . '/';
   }

   protected function processAttachment($attachment, $directory, $download)
   {
       $extension = $attachment->getExtension();
       $allowed = ['txt', 'png', 'xml', 'html', 'jpg', 'jpeg', 'webp', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'zip', 'rar', 'mp4', 'mp3', 'wav', 'gif'];

       $name = str_replace(' ', '_', basename(htmlspecialchars($attachment->getAttributes()['name'])));

       if (in_array($extension, $allowed)) {
           if (!file_exists($directory . $name)) {
               $attachment->save($directory, $name);

           }
           if ($name !== 'undefined') {
               $size = filesize($directory . $name);
               $url = $download . $name;
               return [
                   'name' => $name,
                   'extension' => $extension,
                   'size' => $size,
                   'url' => $url
               ];
           }
       }

       return [];
   }

   public function getMessage(Request $request)
   {
    $hash_id = $request['hash_id'];
       try {

           //return Cache::remember($hash_id, 10000 * 60, function () use ($message, $hash_id, $domainPrefix, $prefix) {
           //return $this->extractMessageData($message, $hash_id, $domainPrefix, $prefix);


           $id = $this->decode_hash(substr($hash_id, 0, 45), 'mail');

           $imap_id = substr($hash_id, 45);

           $client = $this->connection();
           $folder = $client->getFolderByName('INBOX');
           $message = $folder->query()->getMessageByUid($id);
           $email = $message->getAttributes()["to"][0]->mail;

           $message->setFlag('Seen');

           $extractEmail = $this->extractEmail($email);

           $domainPrefix = $extractEmail['domainPrefix'];
           $prefix = $extractEmail['prefix'];

           return $this->extractMessageData($message, $hash_id, $domainPrefix, $prefix, $client, true);
           //});
       } catch (\Exception $e) {

           return $e->getMessage();
       }
   }


   function decode_hash($hash, $connection = "main")
   {
       $id = Hashids::connection($connection)->decode($hash);

       if (is_array($id) && count($id) > 0) {
           return $id[0];
       }

       return false;
   }

   public function cacheExpired()
   {
        $time_unit = 'day';
        $email_lifetime = 1;
       if ($time_unit == 'day') {
           $email_lifetime =  $email_lifetime * 24 * 60;
       } elseif ($time_unit == 'hour') {
           $email_lifetime =  $email_lifetime *  60;
       }
       return $email_lifetime * 60;
   }

   public function cookieExpired()
   {
       $time_unit = 'day';
       $email_lifetime = 1;
       if ($time_unit == 'day') {
           $email_lifetime =  $email_lifetime * 24 * 60;
       } elseif ($time_unit == 'hour') {
           $email_lifetime =  $email_lifetime *  60;
       }
       return $email_lifetime * 1;
   }

   public function fetchDomains(Request $request){

        $mails = Tempmail::where('status',1)->get();
        $profiles = Profile::inRandomOrder()->limit(20)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Email List',
            'data'      => $mails,
            'profiles'  => $profiles,
        ]);

   }

   public function updateEmail(Request $request){
        $email = $request['email'];
        $email = $this->extractEmail($email);
        if(Tempmail::where('status',1)->where('name', $email['domain'])->exists()){
            return response()->json([
                'success'   => true,
            ], 200);
        }else{
            return response()->json(
            [
                'success' => false,
                'message' => "Invalid Domain",
            ], 422);
        }

   }







   public function deleteAllMail(Request $request){

        $validator = Validator::make($request->all(), [
            'email'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'message'=> $validator->errors()
            ]);
        }
        $email = $request['email'];
        $connection = imap_open($this->mailbox, $this->username, $this->password);
        if ($connection) {
            $email_ids = imap_search($connection, 'TO "'.$email.'"');
            if ($email_ids) {
                foreach ($email_ids as $email_id) {
                    imap_delete($connection, $email_id);
                }
            }
            imap_expunge($connection);
            imap_close($connection);
            return response()->json([
                'success'=> true,
                'message'=>'Emails Deleted',
                ]);
            }
   }
}
