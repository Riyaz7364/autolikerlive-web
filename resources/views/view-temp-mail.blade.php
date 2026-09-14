<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="robots" content="index, follow" />
    <meta name="author" content="AutoLikerLive" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="temp mail, temporary email, disposable email, read message, fake email, email burner, anonymous email, free temp mail">
    <link rel="canonical" href="{{ request()->url() }}" />
    <title>Temp Mail - Read Message</title>
    <meta name="description" content="Read your received temp mail message. View the content of disposable temporary emails with Temp Mail - your solution for private, spam-free email.">
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Temp Mail - Read Message" />
    <meta property="og:description" content="Read your received temp mail message with Temp Mail - your solution for private, spam-free email." />
    <meta property="og:image" content="https://www.autolikerlive.com/blog/wp-content/uploads/2025/05/ChatGPT-Image-May-1-2025-08_11_55-AM.webp" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Temp Mail - Read Message" />
    <meta name="twitter:description" content="Read your received temp mail message with Temp Mail." />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Roboto+Mono:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8426510303593933" crossorigin="anonymous"></script>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('images/favicons/temp-mail/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('images/favicons/temp-mail/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('images/favicons/temp-mail/favicon-16x16.png') }}">

    <style>
        :root {
            --tm: #0d9488;
            --tm-dark: #0f766e;
            --tm-grad: linear-gradient(120deg, #14b8a6, #10b981);
            --ink: #1c1e21;
            --muted: #65676b;
            --bg: #eef4f5;
            --card: #ffffff;
            --border: #e4e6eb;
            --radius: 18px;
            --shadow: 0 12px 34px rgba(13, 148, 136, .14);
            --shadow-lg: 0 24px 60px rgba(15, 70, 70, .22);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { -webkit-text-size-adjust: 100%; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(1000px 480px at 12% -10%, rgba(20, 184, 166, .16), transparent 60%),
                radial-gradient(1000px 480px at 88% -10%, rgba(16, 185, 129, .13), transparent 60%),
                var(--bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.55;
        }

        a { color: var(--tm); text-decoration: none; }
        a:hover { text-decoration: underline; }

        /* ============ Header ============ */
        .tm-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, .94);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
        }
        .tm-header-inner {
            max-width: 1220px;
            margin: 0 auto;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .tm-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--ink);
            font-weight: 800;
            font-size: 18px;
        }
        .tm-brand:hover { text-decoration: none; }
        .tm-brand-logo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--tm-grad);
            display: grid;
            place-items: center;
            box-shadow: 0 6px 16px rgba(13, 148, 136, .35);
            flex-shrink: 0;
            color: #fff;
        }
        .tm-brand-logo svg { width: 22px; height: 22px; }
        .tm-brand-sub { display: block; font-size: 12px; font-weight: 500; color: var(--muted); line-height: 1.1; }
        .tm-header-links { display: flex; align-items: center; gap: 10px; }
        .tm-ghost {
            border: 1px solid var(--border);
            background: #fff;
            color: var(--ink);
            font-weight: 600;
            font-size: 14px;
            padding: 9px 16px;
            border-radius: 10px;
            transition: .2s;
            cursor: pointer;
        }
        .tm-ghost:hover { border-color: var(--tm); color: var(--tm); text-decoration: none; }

        /* ============ Compact hero ============ */
        .tm-hero {
            text-align: center;
            padding: 26px 24px 24px;
            background:
                radial-gradient(900px 300px at 12% -10%, rgba(20, 184, 166, .2), transparent 60%),
                radial-gradient(900px 300px at 88% -10%, rgba(16, 185, 129, .16), transparent 60%),
                linear-gradient(180deg, #fff 0%, rgba(13, 148, 136, .06) 100%);
            border-bottom: 1px solid rgba(13, 148, 136, .12);
        }
        .tm-hero-inner { max-width: 1080px; margin: 0 auto; }
        .tm-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            border: 1px solid var(--border);
            color: var(--tm);
            font-size: 13px;
            font-weight: 600;
            padding: 7px 14px;
            border-radius: 999px;
            box-shadow: 0 2px 8px rgba(13, 148, 136, .08);
            cursor: pointer;
        }
        .tm-badge a { color: inherit; }
        .tm-badge a:hover { text-decoration: none; }
        .tm-hero h1 {
            font-size: clamp(24px, 4vw, 34px);
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.12;
            margin: 14px 0 6px;
        }
        .tm-hero h1 .grad {
            background: var(--tm-grad);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .tm-hero p { color: var(--muted); font-size: clamp(14px, 2vw, 16px); }

        /* ============ Layout ============ */
        .tm-layout {
            width: 100%;
            max-width: 1080px;
            margin: 0 auto;
            padding: 18px 24px 44px;
            display: flex;
            flex-direction: column;
            gap: 26px;
        }
        .tm-main { min-width: 0; display: flex; flex-direction: column; gap: 26px; flex: 1; }
        .tm-split {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 320px;
            gap: 24px;
            align-items: start;
        }
        .tm-split-ad { display: flex; justify-content: center; align-items: flex-start; }
        .side-ad { width: 100%; max-width: 320px; margin: 0 auto; }

        /* ============ Message card ============ */
        .tm-card {
            background: var(--card);
            border-radius: 22px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(13, 148, 136, .14);
            padding: clamp(22px, 3.5vw, 34px);
            position: relative;
        }
        .tm-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 5px;
            border-radius: 22px 22px 0 0;
            background: var(--tm-grad);
        }
        .tm-label {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 16px;
        }
        .tm-label svg { width: 20px; height: 20px; color: var(--tm); flex-shrink: 0; }

        /* Back link */
        .msg-back {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 13px;
            font-weight: 700;
            color: var(--tm-dark);
            background: #ecfaf7;
            border: 1px solid #bfe9df;
            padding: 8px 14px;
            border-radius: 999px;
            margin-bottom: 18px;
            transition: .2s;
        }
        .msg-back:hover { background: #dcf5ef; color: var(--tm-dark); text-decoration: none; }
        .msg-back svg { width: 15px; height: 15px; }

        /* Sender header */
        .msg-head {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            flex-wrap: wrap;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--border);
        }
        .msg-avatar {
            width: 56px;
            height: 56px;
            flex-shrink: 0;
            border-radius: 50%;
            background: var(--tm-grad);
            color: #fff;
            font-weight: 800;
            font-size: 20px;
            display: grid;
            place-items: center;
            box-shadow: 0 6px 16px rgba(13, 148, 136, .32);
            letter-spacing: .02em;
        }
        .msg-from { display: flex; flex-direction: column; min-width: 0; }
        .msg-from-name { font-size: 17px; font-weight: 800; color: var(--ink); word-break: break-word; }
        .msg-from-email {
            font-size: 13.5px;
            font-family: 'Roboto Mono', monospace;
            color: var(--tm-dark);
            word-break: break-all;
        }
        .msg-meta { margin-left: auto; text-align: right; display: flex; flex-direction: column; gap: 6px; }
        .msg-meta .chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            color: var(--tm-dark);
            background: #ecfaf7;
            border: 1px solid #bfe9df;
            padding: 4px 11px;
            border-radius: 999px;
            white-space: nowrap;
        }
        .msg-meta .chip svg { width: 13px; height: 13px; flex-shrink: 0; }
        .msg-date { font-size: 12.5px; color: var(--muted); font-style: italic; white-space: nowrap; }

        /* Subject */
        .msg-subject-block { padding: 18px 0; }
        .msg-subject-label {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 6px;
        }
        .msg-subject { font-size: clamp(19px, 3vw, 24px); font-weight: 800; color: var(--ink); word-break: break-word; }

        /* Body */
        .msg-body {
            background: #f2fbfa;
            border: 1px solid rgba(13, 148, 136, .18);
            border-radius: 16px;
            padding: clamp(18px, 3vw, 26px);
            overflow-wrap: break-word;
            min-height: 180px;
        }
        .msg-body p, .msg-body li, .msg-body blockquote, .msg-body div {
            color: #22242b;
        }
        .msg-body img { max-width: 100%; height: auto; border-radius: 8px; }
        .msg-body a { color: var(--tm-dark); text-decoration: underline; }
        .msg-body table { max-width: 100%; }
        .msg-body pre { white-space: pre-wrap; }

        /* Attachments placeholder (attachments currently disabled) */
        .msg-attach { margin-top: 16px; }

        /* ============ Info sections ============ */
        .tm-section-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: clamp(20px, 3.5vw, 32px);
            box-shadow: 0 4px 14px rgba(15, 70, 70, .05);
        }
        .tm-section-card h3 { font-size: 18px; font-weight: 800; margin-bottom: 10px; color: var(--ink); }
        .tm-section-card p { color: var(--muted); font-size: 15px; margin-bottom: 12px; }

        /* ============ Footer ============ */
        .tm-footer {
            margin-top: auto;
            background: #fff;
            border-top: 1px solid var(--border);
            padding: 26px 24px;
            text-align: center;
        }
        .tm-footer-links { display: flex; justify-content: center; gap: 18px; flex-wrap: wrap; margin-bottom: 10px; }
        .tm-footer a { color: var(--muted); font-size: 14px; font-weight: 600; }
        .tm-footer a:hover { color: var(--tm); }
        .tm-footer .copy { color: #9aa0a6; font-size: 13px; }

        /* ============ Page loader bar ============ */
        .pageLoader {
            position: fixed;
            top: 0;
            left: 0;
            width: 0;
            height: 4px;
            background: var(--tm-grad);
            transition: width .3s linear;
            z-index: 9999;
        }

        /* ============ Responsive ============ */
        @media (max-width: 960px) {
            .tm-split { grid-template-columns: 1fr; gap: 18px; }
            .tm-split-ad { order: 2; }
        }
        @media (max-width: 620px) {
            .msg-meta { margin-left: 0; text-align: left; flex-direction: row; flex-wrap: wrap; }
            .msg-head { flex-wrap: wrap; }
        }
    </style>
</head>

<body>

    <div class="pageLoader"></div>

    <!-- ============ Header ============ -->
    <header class="tm-header">
        <div class="tm-header-inner">
            <a href="{{ url('temp-mail') }}" class="tm-brand">
                <span class="tm-brand-logo">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                </span>
                <span>
                    Temp Mail
                    <span class="tm-brand-sub">by AutoLikerLive</span>
                </span>
            </a>
            <div class="tm-header-links">
                <a href="{{ url('services') }}" class="tm-ghost hide-sm">All Tools</a>
                <a href="{{ url('/') }}" class="tm-ghost">Home</a>
            </div>
        </div>
    </header>

    <!-- ============ Hero ============ -->
    <section class="tm-hero">
        <div class="tm-hero-inner">
            <a href="{{ url('temp-mail') }}" class="tm-badge">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                Back to Inbox
            </a>
            <h1>Read Your <span class="grad">Message</span></h1>
            <p>View the contents of your received temporary email.</p>
        </div>
    </section>

    @php

        function getInitials($name)
        {
            $nameArray = explode(' ', $name);
            $initials = '';

            foreach ($nameArray as $word) {
                $initials .= strtoupper(substr($word, 0, 1));
            }

            return $initials;
        }

        $safe = is_array($email) ? $email : [];
        $from = isset($safe['from']) && is_string($safe['from']) ? $safe['from'] : 'Unknown';
        $fromEmail = isset($safe['from_email']) ? $safe['from_email'] : '';
        $to = isset($safe['to']) ? $safe['to'] : '';
        $subject = isset($safe['subject']) ? $safe['subject'] : 'No Subject';
        $receivedAt = isset($safe['receivedAt']) ? $safe['receivedAt'] : null;

        if (isset($safe['content'])) {
            $emailBody = $safe['content'];
            $pattern =
                '/Content-Type:\s*image\/[a-z]+;\s*name="([^"]+)"(.*?)Content-Disposition:\s*inline;\s*filename="([^"]+)"(.*?)Content-Transfer-Encoding:\s*base64\s*Content-ID:\s*<([^>]+)>(.*?)X-Attachment-Id: [^\s]+\s+([\s\S]+?)(?=\nContent-Type|\n*$)/s';
            if (preg_match_all($pattern, $emailBody, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $cid = $match[5];
                    $base64Content = trim($match[7]);
                    $dataUri = 'data:image/png;base64,' . $base64Content;
                    $emailBody = str_replace("cid:$cid", $dataUri, $emailBody);
                }
            }
            $emailBody = preg_replace(
                '/Content-Type:\s*image\/[a-z]+;\s*name="[^"]+"\s*Content-Disposition:\s*inline;\s*filename="[^"]+"\s*Content-Transfer-Encoding:\s*base64\s*Content-ID:\s*<[^>]+>\s*X-Attachment-Id:[^\n]+\s+[\s\S]+?(?=\nContent-Type|$)/',
                '',
                $emailBody,
            );
        } else {
            $emailBody = '';
        }

    @endphp

    <!-- ============ Main layout ============ -->
    <div class="tm-layout">
        <main class="tm-main">

            <div class="tm-split">
                <article class="tm-card">

                    <a href="{{ url('temp-mail') }}" class="msg-back">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                        Back to Inbox
                    </a>

                    <div class="msg-head">
                        <div class="msg-avatar">{{ e(getInitials($from)) }}</div>
                        <div class="msg-from">
                            <span class="msg-from-name">{{ $from }}</span>
                            @if ($fromEmail)
                                <span class="msg-from-email">{{ $fromEmail }}</span>
                            @endif
                        </div>
                        <div class="msg-meta">
                            <span class="chip">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z"/></svg>
                                @if ($to)
                                    To: {{ $to }}
                                @else
                                    Temporary Inbox
                                @endif
                            </span>
                            <span class="msg-date">
                                {{ $receivedAt ? \Carbon\Carbon::parse($receivedAt)->format('d M Y, h:i A') : 'No date' }}
                                ({{ $receivedAt ? \Carbon\Carbon::parse($receivedAt)->diffForHumans() : '' }})
                            </span>
                        </div>
                    </div>

                    <div class="msg-subject-block">
                        <div class="msg-subject-label">Subject</div>
                        <div class="msg-subject">{{ $subject }}</div>
                    </div>

                    <div class="msg-body">
                        {!! $emailBody !== '' ? html_entity_decode($emailBody) : '<p class="text-muted mb-0">This message has no content.</p>' !!}
                    </div>

                </article>

                <aside class="tm-split-ad">
                    <div class="side-ad">
                        <x-ads.sidebar />
                    </div>
                </aside>
            </div>

            <section class="tm-section-card">
                <h3>What is Disposable Temporary E-mail?</h3>
                <p>Disposable Email: This is a free email service that allows you to receive emails at a temporary address that self-destructs after a period of time. Also known as: temporary email, 10 minute email, disposable email, fake email, email burner or spam. Many forums, Wi-Fi network owners, websites and blogs require visitors to register before they can view content, post comments or download anything. Temp-Mail is the most advanced email service that helps you avoid spam and stay safe.</p>
            </section>

            <section class="tm-section-card">
                <h3>The Tech behind Disposable Email Addresses</h3>
                <p>Everyone has an email address every hour, whether they're contacting potential clients at work or using their email address as an online passport to contact friends and colleagues. Almost 99% of all apps and services we sign up for today require an email address, as do most customer loyalty cards, contests, offer flyers, etc. It's also common for store databases to be hacked, putting your business email address at risk and making it more likely to end up on spam lists. However, nothing done online is 100% private.</p>
            </section>

        </main>
    </div>

    <!-- ============ Footer ============ -->
    <footer class="tm-footer">
        <div class="tm-footer-links">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('services') }}">All Tools</a>
            <a href="{{ url('temp-mail') }}">Temp Mail</a>
            <a href="{{ url('privacy') }}">Privacy</a>
            <a href="{{ url('terms') }}">Terms</a>
        </div>
        <div class="copy">&copy; autolikerlive.com &mdash; For entertainment purposes only.</div>
    </footer>

</body>
</html>