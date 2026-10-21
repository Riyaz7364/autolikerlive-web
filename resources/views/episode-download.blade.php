@extends('layouts.master')

@section('title', 'NetShort Video Downloader – Download NetShort Videos & Episodes in HD')
@section('description', 'NetShort Video Downloader: download NetShort videos & drama episodes as MP4 in 720p HD or 1080p Full HD. Free NetShort downloader, no watermark, no app needed.')
@section('keywords', 'netshort video downloader, netshort downloader, download netshort video, netshort video download, netshort episode downloader, netshort drama downloader, download netshort drama episode, netshort mp4 download, netshort video saver, netshort shorts downloader, netshort hd video downloader')
@section('full-width', '1')
@section('ogimage', asset('images/netshort-video-downloader-hero.webp'))

@section('favicons')
<link rel="icon" type="image/png" href="/favicons/netshort/files/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="/favicons/netshort/files/favicon.svg" />
<link rel="shortcut icon" href="/favicons/netshort/files/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="/favicons/netshort/files/apple-touch-icon.png" />
<link rel="manifest" href="/favicons/netshort/files/site.webmanifest" />
@endsection

@push('styles')
<style>
.nsx-wrap{background:#0b0b12;color:#f5f5f7;border-radius:24px;overflow:hidden;position:relative;box-shadow:0 24px 60px rgba(0,0,0,.35);border:1px solid rgba(255,255,255,.08)}
.nsx-bg{position:absolute;inset:0;pointer-events:none;background:
 radial-gradient(700px 380px at 12% -5%, rgba(229,9,20,.38), transparent 60%),
 radial-gradient(600px 420px at 95% 10%, rgba(124,58,237,.32), transparent 60%),
 radial-gradient(900px 500px at 50% 115%, rgba(229,9,20,.16), transparent 60%)}
.nsx-grain{position:absolute;inset:0;opacity:.5;pointer-events:none;background-image:radial-gradient(rgba(255,255,255,.06) 1px, transparent 1px);background-size:22px 22px;mask-image:linear-gradient(to bottom, black, transparent 55%)}
.nsx-topbar{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:16px 20px;position:sticky;top:0;z-index:5;background:rgba(11,11,18,.78);backdrop-filter:blur(16px);border-bottom:1px solid rgba(255,255,255,.08)}
.nsx-brand{display:flex;align-items:center;gap:10px;font-weight:800;letter-spacing:.2px}
.nsx-n{width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#ff2a3c,#b00612);display:grid;place-items:center;font-weight:900;font-size:20px;color:#fff;box-shadow:0 6px 18px rgba(229,9,20,.5)}
.nsx-brand small{display:block;font-size:11px;font-weight:600;color:#b9b9c7;letter-spacing:.14em;text-transform:uppercase}
.nsx-brand strong{font-size:17px;line-height:1}
.nsx-tabs{display:none;gap:6px;background:rgba(255,255,255,.07);padding:4px;border-radius:999px;border:1px solid rgba(255,255,255,.08)}
.nsx-tabs span{font-size:13px;font-weight:700;padding:7px 14px;border-radius:999px;color:#c9c9d6;white-space:nowrap}
.nsx-tabs .on{background:#fff;color:#111}
.nsx-appbtn{background:#e50914;border:0;color:#fff;font-weight:800;font-size:13px;padding:10px 16px;border-radius:999px;box-shadow:0 8px 22px rgba(229,9,20,.45);white-space:nowrap}
.nsx-hero{position:relative;z-index:1;display:grid;gap:28px;padding:30px 20px 22px}
@media(min-width:960px){.nsx-hero{grid-template-columns:1.05fr .95fr;align-items:center;padding:44px 44px 30px}.nsx-tabs{display:flex}}
.nsx-kicker{display:inline-flex;align-items:center;gap:8px;font-size:12px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:#ffb3b9;background:rgba(229,9,20,.16);border:1px solid rgba(229,9,20,.4);padding:7px 12px;border-radius:999px}
.nsx-kicker i{width:7px;height:7px;border-radius:50%;background:#ff3b47;box-shadow:0 0 12px #ff3b47;display:inline-block;animation:nsxblink 1.4s infinite}
@keyframes nsxblink{50%{opacity:.35}}
.nsx-h1{font-size:clamp(30px,4.4vw,50px);line-height:1.02;font-weight:900;letter-spacing:-.02em;margin:14px 0 10px}
.nsx-h1 em{font-style:normal;background:linear-gradient(90deg,#ff4d5e,#ff8a5c);-webkit-background-clip:text;background-clip:text;color:transparent}
.nsx-sub{color:#c6c6d4;font-size:15px;line-height:1.6;max-width:56ch}
.nsx-stats{display:flex;gap:10px;flex-wrap:wrap;margin:16px 0 0}
.nsx-stat{display:flex;align-items:center;gap:8px;font-size:13px;font-weight:700;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);padding:8px 12px;border-radius:999px;color:#e9e9f0}
.nsx-dlcard{margin-top:20px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);border-radius:20px;padding:16px;backdrop-filter:blur(18px);box-shadow:0 18px 40px rgba(0,0,0,.35)}
.nsx-label{font-size:13px;font-weight:800;color:#fff;display:flex;justify-content:space-between;align-items:center;margin-bottom:10px}
.nsx-label a{font-size:12px;color:#ff8a95;font-weight:700;text-decoration:none}
.nsx-field{display:flex;gap:8px;flex-direction:column}
@media(min-width:560px){.nsx-field{flex-direction:row}}
.nsx-input{flex:1;background:#13131d!important;border:1.5px solid rgba(255,255,255,.14)!important;color:#fff!important;border-radius:14px!important;padding:14px 15px!important;font-size:14px!important}
.nsx-input::placeholder{color:#7d7d90}
.nsx-input:focus{border-color:#e50914!important;box-shadow:0 0 0 4px rgba(229,9,20,.22)!important;outline:none}
.nsx-actions{display:flex;gap:8px}
.nsx-paste{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.14);color:#fff;font-weight:800;font-size:13px;border-radius:14px;padding:0 16px;white-space:nowrap}
.nsx-paste:hover{background:rgba(255,255,255,.16)}
.nsx-go{width:100%;margin-top:10px;border:0;border-radius:14px;padding:15px;font-weight:900;font-size:15px;color:#fff;background:linear-gradient(135deg,#ff2a3c,#a50713);box-shadow:0 12px 28px rgba(229,9,20,.45);display:flex;align-items:center;justify-content:center;gap:10px}
.nsx-go:hover{filter:brightness(1.08)}
.nsx-hint{font-size:12.5px;color:#9a9ab0;margin:10px 2px 0}
.nsx-hint code{color:#ffb3b9;background:rgba(229,9,20,.14);padding:1px 6px;border-radius:6px;font-size:12px}
.nsx-err{margin-top:12px;background:rgba(229,9,20,.14);border:1px solid rgba(255,42,60,.5);color:#ffc9ce;font-size:13.5px;font-weight:600;border-radius:14px;padding:12px 14px}
.nsx-ok{margin-top:14px;background:#101019;border:1px solid rgba(255,255,255,.12);border-radius:18px;overflow:hidden}
.nsx-ok-head{display:flex;gap:12px;align-items:center;padding:14px}
.nsx-thumb{width:56px;height:76px;border-radius:12px;flex:0 0 56px;background:linear-gradient(160deg,#2a2a3a,#101018);border:1px solid rgba(255,255,255,.14);display:grid;place-items:center;font-size:22px;overflow:hidden;position:relative}
.nsx-ok-head h3{font-size:16px;margin:0;font-weight:800}
.nsx-ok-head p{margin:3px 0 0;font-size:12.5px;color:#a9a9bf}
.nsx-ok-head code{color:#ffb3b9;font-size:12px}
.nsx-qlist{display:grid;gap:10px;padding:14px}
@media(min-width:560px){.nsx-qlist{grid-template-columns:1fr 1fr}}
.nsx-q{border-radius:16px;padding:14px;display:flex;align-items:center;justify-content:space-between;gap:10px;text-decoration:none;color:#fff!important;border:1px solid rgba(255,255,255,.12)}
.nsx-q b{font-size:15px;display:block}
.nsx-q small{color:rgba(255,255,255,.78);font-size:12px}
.nsx-q .nsx-dicon{width:42px;height:42px;border-radius:12px;background:rgba(255,255,255,.18);display:grid;place-items:center;font-size:19px;flex:0 0 42px}
.nsx-q720{background:linear-gradient(135deg,#ff7a3c,#e50914)}
.nsx-q1080{background:linear-gradient(135deg,#7c3aed,#0ea5e9)}
.nsx-q:hover{transform:translateY(-2px);filter:brightness(1.06)}
.nsx-qoff{background:rgba(255,255,255,.07);color:#8b8ba0!important;pointer-events:none}
.nsx-copyrow{display:flex;gap:8px;padding:0 14px 14px;flex-wrap:wrap}
.nsx-copy{flex:1;min-width:140px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.14);color:#fff;border-radius:12px;font-size:13px;font-weight:700;padding:11px}
.nsx-note{font-size:12px;color:#8f8fa6;padding:0 14px 14px}
/* phone */
.nsx-phonewrap{display:flex;justify-content:center;position:relative}
.nsx-phone{width:min(300px,80vw);aspect-ratio:9/19;background:#000;border-radius:38px;border:1px solid rgba(255,255,255,.18);box-shadow:0 30px 70px rgba(0,0,0,.55), 0 0 0 10px #17171f;overflow:hidden;position:relative}
.nsx-screen{position:absolute;inset:0;background:linear-gradient(180deg,rgba(0,0,0,.05) 40%,rgba(0,0,0,.82)),radial-gradient(300px 300px at 70% 20%, #4c1d95, transparent),linear-gradient(160deg,#2b1035,#0b0b12 60%),url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=600&q=60&auto=format&fit=crop') center/cover}
.nsx-screenvid{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;background:#000}
.nsx-shade{position:absolute;inset:0;background:linear-gradient(180deg,rgba(0,0,0,.28) 0%,transparent 35%,transparent 55%,rgba(0,0,0,.82) 100%);z-index:1;pointer-events:none}
.nsx-notch{position:absolute;top:10px;left:50%;transform:translateX(-50%);width:110px;height:24px;background:#000;border-radius:999px;z-index:3;border:1px solid rgba(255,255,255,.12)}
.nsx-live{position:absolute;top:44px;left:12px;z-index:2;background:#e50914;font-size:11px;font-weight:900;letter-spacing:.08em;padding:5px 10px;border-radius:999px;display:flex;gap:6px;align-items:center}
.nsx-live i{width:7px;height:7px;background:#fff;border-radius:50%;animation:nsxblink 1s infinite}
.nsx-ep{position:absolute;top:44px;right:12px;z-index:2;background:rgba(0,0,0,.55);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.18);font-size:11px;font-weight:800;padding:5px 10px;border-radius:999px}
.nsx-play{position:absolute;inset:0;display:grid;place-items:center;z-index:2}
.nsx-play span{width:68px;height:68px;border-radius:50%;background:rgba(255,255,255,.14);border:1.5px solid rgba(255,255,255,.5);backdrop-filter:blur(10px);display:grid;place-items:center;font-size:26px;color:#fff;padding-left:4px}
.nsx-mutef{position:absolute;left:12px;top:76px;z-index:2;background:rgba(0,0,0,.55);border:1px solid rgba(255,255,255,.2);color:#fff;font-size:11px;font-weight:800;border-radius:999px;padding:5px 10px;cursor:pointer}
.nsx-rail{position:absolute;right:10px;bottom:110px;z-index:2;display:flex;flex-direction:column;gap:12px;align-items:center}
.nsx-rail div{display:flex;flex-direction:column;align-items:center;font-size:10px;font-weight:800;color:#fff;gap:3px}
.nsx-rail em{width:44px;height:44px;border-radius:50%;background:rgba(0,0,0,.5);border:1px solid rgba(255,255,255,.2);backdrop-filter:blur(8px);display:grid;place-items:center;font-size:18px;font-style:normal}
.nsx-cap{position:absolute;left:12px;right:66px;bottom:56px;z-index:2}
.nsx-cap b{font-size:14px;display:block;text-shadow:0 2px 10px rgba(0,0,0,.8)}
.nsx-cap p{font-size:11.5px;color:#d8d8e4;margin:4px 0 8px;text-shadow:0 2px 10px rgba(0,0,0,.8)}
.nsx-progress{height:3px;background:rgba(255,255,255,.25);border-radius:99px;overflow:hidden}
.nsx-progress i{display:block;width:38%;height:100%;background:#e50914}
.nsx-bottomnav{position:absolute;left:0;right:0;bottom:0;z-index:2;display:flex;justify-content:space-around;padding:10px 6px 14px;background:linear-gradient(transparent,rgba(0,0,0,.85));font-size:10px;font-weight:700;color:#bdbdcd}
.nsx-bottomnav .on{color:#fff}
.nsx-float{position:absolute;background:rgba(20,20,30,.85);border:1px solid rgba(255,255,255,.14);backdrop-filter:blur(12px);border-radius:16px;padding:10px 12px;font-size:12px;font-weight:800;box-shadow:0 14px 30px rgba(0,0,0,.45);z-index:3;display:flex;gap:8px;align-items:center}
.nsx-f1{top:16%;left:-8px}
.nsx-f2{bottom:24%;right:-6px}
@media(max-width:959px){.nsx-f1{left:2px}.nsx-f2{right:2px}}
.nsx-float small{display:block;font-weight:600;color:#a9a9bf;font-size:11px}
.nsx-h2{position:relative;z-index:1;font-size:22px;font-weight:900;letter-spacing:-.01em;padding:10px 20px 0;margin:0}
@media(min-width:960px){.nsx-h2{padding:10px 44px 0}}
.nsx-lead{position:relative;z-index:1;color:#b6b6c7;font-size:13.5px;line-height:1.7;padding:8px 20px 0;margin:0;max-width:110ch}
@media(min-width:960px){.nsx-lead{padding:8px 44px 0}}
.nsx-sections{position:relative;z-index:1;padding:14px 20px 26px;display:grid;gap:14px}
@media(min-width:960px){.nsx-sections{grid-template-columns:repeat(3,1fr);padding:14px 44px 30px}}
.nsx-feat{background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:18px;padding:18px}
.nsx-feat h3{font-size:14.5px;margin:10px 0 6px}
.nsx-feat p{font-size:13px;color:#b6b6c7;margin:0;line-height:1.6}
.nsx-ico{width:38px;height:38px;border-radius:12px;display:grid;place-items:center;font-size:18px;background:rgba(229,9,20,.16);border:1px solid rgba(229,9,20,.35)}
.nsx-steps{position:relative;z-index:1;padding:0 20px 8px;display:grid;gap:10px}
@media(min-width:960px){.nsx-steps{grid-template-columns:repeat(3,1fr);padding:0 44px 8px}}
.nsx-step{display:flex;gap:12px;background:rgba(255,255,255,.04);border:1px dashed rgba(255,255,255,.16);border-radius:16px;padding:14px;font-size:13.5px;color:#cfcfdd}
.nsx-step b{color:#fff;display:block;font-size:13.5px;margin-bottom:2px}
.nsx-num{width:30px;height:30px;flex:0 0 30px;border-radius:50%;background:#fff;color:#111;font-weight:900;display:grid;place-items:center;font-size:14px}
.nsx-faq{position:relative;z-index:1;padding:14px 20px 10px;display:grid;gap:10px}
@media(min-width:960px){.nsx-faq{padding:14px 44px 10px;grid-template-columns:1fr 1fr}}
.nsx-faq details{background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:14px;padding:13px 15px;font-size:13.5px;color:#cfcfdd}
.nsx-faq summary{font-weight:800;color:#fff;cursor:pointer;font-size:13.5px}
.nsx-tablewrap{position:relative;z-index:1;margin:12px 20px 0;border:1px solid rgba(255,255,255,.1);border-radius:16px;overflow:hidden;overflow-x:auto}
@media(min-width:960px){.nsx-tablewrap{margin:12px 44px 0}}
.nsx-tablewrap table{width:100%;border-collapse:collapse;font-size:13px;min-width:520px}
.nsx-tablewrap th{background:rgba(229,9,20,.18);color:#fff;text-align:left;padding:11px 14px;font-size:11.5px;letter-spacing:.06em;text-transform:uppercase;white-space:nowrap}
.nsx-tablewrap td{padding:11px 14px;color:#cfcfdd;border-top:1px solid rgba(255,255,255,.08);vertical-align:top}
.nsx-tablewrap td:first-child{color:#fff;font-weight:800;white-space:nowrap}
.nsx-minis{position:relative;z-index:1;padding:12px 20px 0;display:grid;gap:10px}
@media(min-width:560px){.nsx-minis{grid-template-columns:repeat(2,1fr)}}
@media(min-width:960px){.nsx-minis{padding:12px 44px 0;grid-template-columns:repeat(4,1fr)}}
.nsx-mini{background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:16px;padding:15px;font-size:13px;color:#b6b6c7;line-height:1.6}
.nsx-mini b{color:#fff;display:block;font-size:13.5px;margin-bottom:4px}
.nsx-mini code{color:#ffb3b9;background:rgba(229,9,20,.14);padding:1px 6px;border-radius:6px;font-size:11px;word-break:break-all}
.nsx-devices{position:relative;z-index:1;padding:12px 20px 0;display:grid;gap:10px}
@media(min-width:960px){.nsx-devices{padding:12px 44px 0;grid-template-columns:repeat(3,1fr)}}
.nsx-seo a{color:#ff8a95;font-weight:700;text-decoration:none}
.nsx-seo p{margin:0 0 10px}
@media(min-width:960px){.nsx-seo{padding:6px 44px 30px}}
.nsx-seo strong{color:#c9c9d6}
.nsx-foot{position:relative;z-index:1;border-top:1px solid rgba(255,255,255,.09);padding:14px 20px 18px;font-size:12px;color:#8b8ba0;display:flex;gap:10px;flex-wrap:wrap;justify-content:space-between}
</style>
@endpush

@section('content')
<div class="nsx-wrap my-3">
  <div class="nsx-bg"></div><div class="nsx-grain"></div>

  <div class="nsx-topbar">
    <div class="nsx-brand"><div class="nsx-n">N</div><div><small>NetShort</small><strong>Video Downloader</strong></div></div>
    <div class="nsx-tabs"><span class="on">Downloader</span><span>Trending</span><span>How it works</span></div>
    <button class="nsx-appbtn" type="button" onclick="document.getElementById('nsx-url').focus()">⬇ Get Episode</button>
  </div>

  <div class="nsx-hero">
    <div>
      <span class="nsx-kicker"><i></i> NetShort Video Downloader • Free MP4 Saver</span>
      <h1 class="nsx-h1">NetShort Video <em>Downloader</em></h1>
      <p class="nsx-sub">Download NetShort videos and short-drama episodes as MP4 — <strong style="color:#fff">720p HD</strong> or <strong style="color:#fff">1080p Full HD</strong>. Paste any NetShort share link below and this free NetShort downloader fetches the original episode file. No watermark, no app, no sign-up.</p>
      <div class="nsx-stats">
        <span class="nsx-stat">⚡ Instant NetShort download</span>
        <span class="nsx-stat">🎬 720p · 1080p MP4</span>
        <span class="nsx-stat">📱 Mobile friendly</span>
      </div>

      <div class="nsx-dlcard">
        <form method="POST" action="{{ route('netshort-video-downloader.fetch') }}" id="nsx-form">
          @csrf
          <div class="nsx-label"><span>NetShort share link or link ID</span><a href="#nsx-how" title="Copy from the NetShort app: Share → Copy Link">Where's my link?</a></div>
          <div class="nsx-field">
            <input id="nsx-url" type="text" name="url" class="nsx-input" placeholder="https://netshort.onelink.me/7xW2?deep_link_value=…" value="{{ old('url', $input) }}" required autocomplete="off">
            <div class="nsx-actions"><button type="button" class="nsx-paste" id="nsx-paste">📋 Paste</button></div>
          </div>
          @error('url')<div class="nsx-err">{{ $message }}</div>@enderror
          @error('linkId')<div class="nsx-err">{{ $message }}</div>@enderror
          <button type="submit" class="nsx-go">⬇ Download NetShort Video</button>
        </form>
        <p class="nsx-hint">From the NetShort app tap <strong>Share → Copy Link</strong>, then paste it above. We read the <code>deep_link_value</code> ID automatically. Watch it auto-play in the phone on the right, then tap Download.</p>

        @if ($error)
          <div class="nsx-err">⚠ {{ $error }}</div>
        @endif

        @if ($result)
          <div class="nsx-ok" id="nsx-result">
            <div class="nsx-ok-head">
              <div class="nsx-thumb">🎭</div>
              <div style="min-width:0">
                <h3>{{ $result['name'] ?? 'Episode '.$result['episodeNo'] }}</h3>
                <p>Episode {{ $result['episodeNo'] }} &middot; ID <code>{{ $result['episodeId'] }}</code> &middot; MP4</p>
              </div>
            </div>
            <div class="nsx-qlist">
              @if ($result['files']['720p'])
                <a class="nsx-q nsx-q720" href="{{ $result['dl']['720p'] ?? $result['files']['720p'] }}" download="netshort-ep{{ $result['episodeNo'] }}-720p.mp4"><span><b>⬇ Download 720p</b><small>HD · smaller MP4 file</small></span><span class="nsx-dicon">⤓</span></a>
              @else
                <span class="nsx-q nsx-qoff"><span><b>720p unavailable</b><small>try 1080p</small></span><span class="nsx-dicon">×</span></span>
              @endif
              @if ($result['files']['1080p'])
                <a class="nsx-q nsx-q1080" href="{{ $result['dl']['1080p'] ?? $result['files']['1080p'] }}" download="netshort-ep{{ $result['episodeNo'] }}-1080p.mp4"><span><b>⬇ Download 1080p</b><small>Full HD · best quality</small></span><span class="nsx-dicon">⤓</span></a>
              @else
                <span class="nsx-q nsx-qoff"><span><b>1080p unavailable</b><small>try 720p</small></span><span class="nsx-dicon">×</span></span>
              @endif
            </div>
            <div class="nsx-copyrow">
              <button class="nsx-copy" type="button" data-copy="{{ $result['files']['1080p'] ?? $result['files']['720p'] }}">🔗 Copy direct link</button>
              <button class="nsx-copy" type="button" onclick="document.getElementById('nsx-url').focus();document.getElementById('nsx-url').select()">↑ New link</button>
            </div>
            <p class="nsx-note">Tap <strong>Download</strong> and the MP4 saves straight to your device — no new tab. Video not saving? Long-press the button → “Download link”, or use Copy direct link.</p>
          </div>
        @endif
      </div>
    </div>

    <div class="nsx-phonewrap">
      <div class="nsx-float nsx-f1">❤️ 2.4M <small>Loved this episode</small></div>
      <div class="nsx-phone" id="nsx-phone">
        @if ($result && ($result['files']['1080p'] ?? $result['files']['720p'] ?? null))
          <video id="nsx-phonevid" class="nsx-screenvid" src="{{ $result['files']['1080p'] ?? $result['files']['720p'] }}" autoplay muted loop playsinline preload="auto"></video>
          <div class="nsx-shade"></div>
          <button class="nsx-mutef" id="nsx-mute" type="button">🔇 Tap to unmute</button>
        @else
          <div class="nsx-screen"></div>
        @endif
        <div class="nsx-notch"></div>
        <div class="nsx-live"><i></i> NETSHORT</div>
        <div class="nsx-ep">EP {{ $result['episodeNo'] ?? '12' }} · {{ isset($result['name']) ? \Illuminate\Support\Str::limit($result['name'], 14) : 'Hidden Wolf King' }}</div>
        @if (empty($result))
          <div class="nsx-play"><span>▶</span></div>
        @endif
        <div class="nsx-rail"><div><em>♥</em>182K</div><div><em>💬</em>4.2K</div><div><em>↗</em>Share</div></div>
        <div class="nsx-cap"><b>{{ $result['name'] ?? 'Hidden Wolf King' }}</b><p>S1 • EP {{ $result['episodeNo'] ?? '12' }} — CEO romance • Revenge</p><div class="nsx-progress"><i></i></div></div>
        <div class="nsx-bottomnav"><span class="on">⌂ Home</span><span>🔍 Discover</span><span>＋ My List</span><span>👤 Me</span></div>
      </div>
      <div class="nsx-float nsx-f2">⬇ 1080p <small>Full HD MP4 ready</small></div>
    </div>
  </div>

  <h2 class="nsx-h2" id="nsx-how">How to download NetShort videos</h2>
  <div class="nsx-steps">
    <div class="nsx-step"><span class="nsx-num">1</span><div><b>Copy the NetShort link</b>Open the NetShort app → open any drama episode → Share → Copy Link.</div></div>
    <div class="nsx-step"><span class="nsx-num">2</span><div><b>Paste it above</b>This NetShort video downloader reads the episode ID and fetches the original 720p / 1080p MP4 files.</div></div>
    <div class="nsx-step"><span class="nsx-num">3</span><div><b>Watch &amp; save the MP4</b>The episode auto-plays in the phone preview — tap Download 720p or 1080p to save it to your device.</div></div>
  </div>

  <h2 class="nsx-h2">Why use this NetShort downloader?</h2>
  <p class="nsx-lead">The fastest way to <strong>download NetShort videos</strong> in original quality — free NetShort video download in HD, works for short dramas, reels and episodes, on Android, iPhone and PC.</p>
  <div class="nsx-sections">
    <div class="nsx-feat"><div class="nsx-ico">🎬</div><h3>True HD NetShort MP4 files</h3><p>Download NetShort drama episodes from the original CDN — crisp 720p for sharing, 1080p Full HD for archiving. No extra watermark added.</p></div>
    <div class="nsx-feat"><div class="nsx-ico">⚡</div><h3>One-tap NetShort video download</h3><p>Buttons save the file directly (attachment download) — no new tab, no player maze. Paste link → fetch → save in seconds, no sign-up.</p></div>
    <div class="nsx-feat"><div class="nsx-ico">📱</div><h3>Auto-play phone preview</h3><p>Every fetched episode auto-plays in the NetShort-style vertical phone, so you can confirm it's the right episode before you download.</p></div>
  </div>

  <h2 class="nsx-h2">NetShort video quality guide — 720p vs 1080p</h2>
  <p class="nsx-lead">Every NetShort video download comes straight from the original episode file on NetShort's CDN. Choose the quality that fits your device and data plan:</p>
  <div class="nsx-tablewrap">
    <table>
      <tr><th>Quality</th><th>Best for</th><th>File size</th><th>Playback</th></tr>
      <tr><td>720p HD</td><td>Phones, WhatsApp &amp; TikTok sharing, slow networks</td><td>Smaller — fast NetShort video download</td><td>Smooth on every device</td></tr>
      <tr><td>1080p Full HD</td><td>Archiving, big screens, best detail</td><td>Larger (≈2× of 720p)</td><td>Crisp cinema-style vertical video</td></tr>
    </table>
  </div>

  <h2 class="nsx-h2">Which NetShort links can you download?</h2>
  <p class="nsx-lead">This NetShort downloader accepts every share format the NetShort app produces — single episodes, dramas and shorts alike.</p>
  <div class="nsx-minis">
    <div class="nsx-mini"><b>🔗 NetShort share URL</b>Copied via Share → Copy Link in the app. Example: <code>netshort.onelink.me/7xW2?deep_link_value=…</code></div>
    <div class="nsx-mini"><b>🆔 32-character link ID</b>Only have the ID? Paste the <code>deep_link_value</code> code alone — no full URL needed.</div>
    <div class="nsx-mini"><b>🎭 Single episodes</b>Download any NetShort episode — werewolf love stories, CEO romance, revenge dramas and more.</div>
    <div class="nsx-mini"><b>📺 Full drama series</b>Want a whole short drama? Fetch it episode by episode and save the complete NetShort series in HD.</div>
  </div>

  <h2 class="nsx-h2">Save NetShort videos on Android, iPhone &amp; PC</h2>
  <div class="nsx-devices">
    <div class="nsx-step"><span class="nsx-num">🤖</span><div><b>Android</b>Tap Download 720p / 1080p in Chrome — the MP4 lands in Downloads / Gallery. Play it with any video app.</div></div>
    <div class="nsx-step"><span class="nsx-num">🍎</span><div><b>iPhone (Safari)</b>Tap Download, confirm the file, then open Files → Downloads to watch your NetShort video offline.</div></div>
    <div class="nsx-step"><span class="nsx-num">💻</span><div><b>PC / Mac</b>Click a quality button to save the MP4 instantly — or right-click → “Save link as” to choose a folder.</div></div>
  </div>

  <h2 class="nsx-h2">NetShort video downloader FAQs</h2>
  <div class="nsx-faq">
    <details open><summary>How do I download NetShort videos?</summary><p class="mt-2 mb-0">Copy the episode's share link from the NetShort app (<code>netshort.onelink.me/…?deep_link_value=…</code>), paste it into this NetShort video downloader, then tap <strong>Download 720p</strong> or <strong>1080p</strong>. The MP4 saves directly to your device.</p></details>
    <details><summary>Which links does this NetShort downloader accept?</summary><p class="mt-2 mb-0">Any NetShort OneLink share URL or the 32-character link ID itself. The tool also works for most NetShort short-drama and episode links.</p></details>
    <details><summary>Can I download NetShort videos in 1080p Full HD?</summary><p class="mt-2 mb-0">Yes — when the episode offers it, the 1080p button saves the Full HD MP4. Pick 720p for a smaller, faster NetShort video download.</p></details>
    <details><summary>Is the NetShort video download free? Any watermark?</summary><p class="mt-2 mb-0">Yes, 100% free with no sign-up. Files are the original NetShort CDN MP4s — we add no extra watermark.</p></details>
    <details><summary>Where is my downloaded NetShort video saved?</summary><p class="mt-2 mb-0">Check your Downloads folder (Android / PC) or the Files app → Downloads (iPhone). The video auto-plays in the phone preview first so you can verify it.</p></details>
    <details><summary>Why is only 720p or 1080p available for my NetShort video?</summary><p class="mt-2 mb-0">Some episodes — especially locked or premium ones — only expose one rendition on the CDN. Try the other quality, or check whether the episode is unlocked in the NetShort app.</p></details>
    <details><summary>Can I download a full NetShort drama series at once?</summary><p class="mt-2 mb-0">This NetShort video downloader saves one episode per link. To download a full NetShort drama, share each episode from the app and fetch them one by one — each saves as its own HD MP4.</p></details>
    <details><summary>Is it legal to download NetShort drama episodes?</summary><p class="mt-2 mb-0">Only download NetShort videos you have the right to save, for personal offline viewing. Respect NetShort's terms and the creators' rights.</p></details>
  </div>

  <div class="nsx-seo">
    <p><strong>NetShort Video Downloader</strong> is a free online tool to <strong>download NetShort videos</strong>, short dramas and episodes in HD MP4.
    Whether you searched for <strong>netshort downloader</strong>, <strong>netshort video download</strong>, <strong>download netshort drama episode</strong> or <strong>netshort mp4 download</strong>,
    just paste the share link and save any episode in 720p or 1080p — fast NetShort video saver with auto-play preview, direct download buttons and no app install.</p>
    <p>Popular uses: <strong>download NetShort short drama series</strong> for offline watching, save <strong>NetShort werewolf, CEO romance and revenge episodes</strong> in Full HD,
    or grab <strong>NetShort shorts</strong> to rewatch anywhere. Looking for more? Explore our <a href="{{ url('services') }}">free social media tools</a> —
    including <a href="{{ route('free-tiktok-views') }}">TikTok views</a>, <a href="{{ route('free-instagram-likes') }}">Instagram likes</a> and <a href="{{ route('temp-mail') }}">Temp Mail</a> —
    or get the <a href="{{ url('/download') }}">AutoLiker app</a>.</p>
  </div>

  <div class="nsx-foot"><span>© autolikerlive.com — NetShort Video Downloader. For entertainment purposes only.</span><span>Not affiliated with NetShort / NETSTORY PTE. LTD.</span></div>
</div>

<script type="application/ld+json">
{!! json_encode([
  '@context' => 'https://schema.org',
  '@graph' => [
    ['@type' => 'WebApplication', 'name' => 'NetShort Video Downloader',
     'url' => url('/netshort-video-downloader'),
     'applicationCategory' => 'MultimediaApplication', 'operatingSystem' => 'Any',
     'offers' => ['@type' => 'Offer', 'price' => '0'],
     'description' => 'Download NetShort videos and drama episodes as MP4 in 720p HD or 1080p Full HD. Free, no watermark.'],
    ['@type' => 'FAQPage', 'mainEntity' => [
      ['@type' => 'Question', 'name' => 'How do I download NetShort videos?',
       'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Copy the episode share link from the NetShort app, paste it into the NetShort Video Downloader, then tap Download 720p or 1080p.']],
      ['@type' => 'Question', 'name' => 'Can I download NetShort videos in 1080p Full HD?',
       'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Yes, when available the 1080p button saves the Full HD MP4; 720p is smaller and faster.']],
      ['@type' => 'Question', 'name' => 'Is the NetShort video download free?',
       'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Yes, free with no sign-up. Files are original NetShort CDN MP4s with no extra watermark.']],
    ]],
    ['@type' => 'HowTo', 'name' => 'How to download NetShort videos',
     'step' => [
       ['@type' => 'HowToStep', 'name' => 'Copy the NetShort link', 'text' => 'Open the NetShort app, tap Share on any episode, then Copy Link.'],
       ['@type' => 'HowToStep', 'name' => 'Paste it in the downloader', 'text' => 'Paste the share link or 32-character link ID into the NetShort Video Downloader and submit.'],
       ['@type' => 'HowToStep', 'name' => 'Save the MP4', 'text' => 'Preview the auto-playing episode, then tap Download 720p or 1080p to save the MP4.'],
     ]],
  ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
<script>
document.getElementById('nsx-paste')?.addEventListener('click', async () => {
  try { const t = await navigator.clipboard.readText(); if (t) document.getElementById('nsx-url').value = t.trim(); }
  catch(e){ document.getElementById('nsx-url').focus(); }
});
document.querySelectorAll('[data-copy]')?.forEach(b => b.addEventListener('click', async () => {
  try { await navigator.clipboard.writeText(b.dataset.copy); b.textContent = '✅ Copied!'; setTimeout(()=>b.textContent='🔗 Copy direct link',1600);} catch(e){}
}));
// Phone autoplay: ensure muted autoplay starts, tap toggles sound.
(function(){
  const v = document.getElementById('nsx-phonevid');
  const m = document.getElementById('nsx-mute');
  if (v) {
    v.muted = true;
    const p = v.play(); if (p && p.catch) p.catch(()=>{});
    const toggle = () => { v.muted = !v.muted; if (m) m.textContent = v.muted ? '🔇 Tap to unmute' : '🔊 Muted? tap again'; v.play().catch(()=>{}); };
    m?.addEventListener('click', toggle);
    v.addEventListener('click', toggle);
  }
  @if ($result)
  document.getElementById('nsx-result')?.scrollIntoView({behavior:'smooth', block:'nearest'});
  @endif
})();
</script>
@endsection
