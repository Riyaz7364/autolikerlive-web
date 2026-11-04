@extends('layouts.master')

@section('title', 'ReelSwipe Video Downloader – Save Videos as MP4')
@section('description', 'Download ReelSwipe videos as MP4. Open a shared ReelSwipe link to decode its stream automatically, or paste a NetShort episode share link.')
@section('keywords', 'reelswipe video downloader, reelswipe downloader, download reelswipe video, reelswipe video download, reelswipe mp4 downloader, short video downloader, netshort episode downloader')
@section('full-width', '1')

@push('styles')
<style>
.nsx-wrap{background:#0b0b12;color:#f5f5f7;border-radius:24px;overflow:hidden;position:relative;box-shadow:0 24px 60px rgba(0,0,0,.35);border:1px solid rgba(255,255,255,.08)}
.nsx-bg{position:absolute;inset:0;pointer-events:none;background:
 radial-gradient(700px 380px at 12% -5%, rgba(103,64,255,.36), transparent 60%),
 radial-gradient(600px 420px at 95% 10%, rgba(14,165,233,.28), transparent 60%),
 radial-gradient(900px 500px at 50% 115%, rgba(103,64,255,.16), transparent 60%)}
.nsx-grain{position:absolute;inset:0;opacity:.5;pointer-events:none;background-image:radial-gradient(rgba(255,255,255,.06) 1px, transparent 1px);background-size:22px 22px;mask-image:linear-gradient(to bottom, black, transparent 55%)}
.nsx-topbar{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:16px 20px;position:sticky;top:0;z-index:5;background:rgba(11,11,18,.78);backdrop-filter:blur(16px);border-bottom:1px solid rgba(255,255,255,.08)}
.nsx-brand{display:flex;align-items:center;gap:10px;font-weight:800;letter-spacing:.2px}
.nsx-n{width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#7958ff,#4525c8);display:grid;place-items:center;font-weight:900;font-size:20px;color:#fff;box-shadow:0 6px 18px rgba(103,64,255,.5)}
.nsx-brand small{display:block;font-size:11px;font-weight:600;color:#b9b9c7;letter-spacing:.14em;text-transform:uppercase}
.nsx-brand strong{font-size:17px;line-height:1}
.nsx-tabs{display:none;gap:6px;background:rgba(255,255,255,.07);padding:4px;border-radius:999px;border:1px solid rgba(255,255,255,.08)}
.nsx-tabs span{font-size:13px;font-weight:700;padding:7px 14px;border-radius:999px;color:#c9c9d6;white-space:nowrap}
.nsx-tabs .on{background:#fff;color:#111}
.nsx-appbtn{background:#6740ff;border:0;color:#fff;font-weight:800;font-size:13px;padding:10px 16px;border-radius:999px;box-shadow:0 8px 22px rgba(103,64,255,.4);white-space:nowrap;text-decoration:none}
.nsx-hero{position:relative;z-index:1;display:grid;gap:28px;padding:30px 20px 22px}
@media(min-width:960px){.nsx-hero{grid-template-columns:1.05fr .95fr;align-items:center;padding:44px 44px 30px}.nsx-tabs{display:flex}}
.nsx-kicker{display:inline-flex;align-items:center;gap:8px;font-size:12px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:#d7ceff;background:rgba(103,64,255,.16);border:1px solid rgba(103,64,255,.45);padding:7px 12px;border-radius:999px}
.nsx-kicker i{width:7px;height:7px;border-radius:50%;background:#a78bfa;box-shadow:0 0 12px #a78bfa;display:inline-block;animation:nsxblink 1.4s infinite}
@keyframes nsxblink{50%{opacity:.35}}
.nsx-h1{font-size:clamp(30px,4.4vw,50px);line-height:1.02;font-weight:900;letter-spacing:-.02em;margin:14px 0 10px}
.nsx-h1 em{font-style:normal;background:linear-gradient(90deg,#a78bfa,#38bdf8);-webkit-background-clip:text;background-clip:text;color:transparent}
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
.nsx-input:focus{border-color:#7958ff!important;box-shadow:0 0 0 4px rgba(103,64,255,.22)!important;outline:none}
.nsx-actions{display:flex;gap:8px}
.nsx-paste{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.14);color:#fff;font-weight:800;font-size:13px;border-radius:14px;padding:0 16px;white-space:nowrap}
.nsx-paste:hover{background:rgba(255,255,255,.16)}
.nsx-go{width:100%;margin-top:10px;border:0;border-radius:14px;padding:15px;font-weight:900;font-size:15px;color:#fff;background:linear-gradient(135deg,#7958ff,#4525c8);box-shadow:0 12px 28px rgba(103,64,255,.4);display:flex;align-items:center;justify-content:center;gap:10px}
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
.nsx-q720{background:linear-gradient(135deg,#7958ff,#4525c8)}
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
.nsx-live{position:absolute;top:44px;left:12px;z-index:2;background:linear-gradient(135deg,#7958ff,#4525c8);font-size:11px;font-weight:900;letter-spacing:.08em;padding:5px 10px;border-radius:999px;display:flex;gap:6px;align-items:center}
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
.nsx-progress i{display:block;width:38%;height:100%;background:#8b70ff}
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
.nsx-ico{width:38px;height:38px;border-radius:12px;display:grid;place-items:center;font-size:18px;background:rgba(103,64,255,.16);border:1px solid rgba(103,64,255,.35)}
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
.nsx-tablewrap th{background:rgba(103,64,255,.2);color:#fff;text-align:left;padding:11px 14px;font-size:11.5px;letter-spacing:.06em;text-transform:uppercase;white-space:nowrap}
.nsx-tablewrap td{padding:11px 14px;color:#cfcfdd;border-top:1px solid rgba(255,255,255,.08);vertical-align:top}
.nsx-tablewrap td:first-child{color:#fff;font-weight:800;white-space:nowrap}
.nsx-minis{position:relative;z-index:1;padding:12px 20px 0;display:grid;gap:10px}
@media(min-width:560px){.nsx-minis{grid-template-columns:repeat(2,1fr)}}
@media(min-width:960px){.nsx-minis{padding:12px 44px 0;grid-template-columns:repeat(4,1fr)}}
.nsx-mini{background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:16px;padding:15px;font-size:13px;color:#b6b6c7;line-height:1.6}
.nsx-mini b{color:#fff;display:block;font-size:13.5px;margin-bottom:4px}
.nsx-mini code{color:#d7ceff;background:rgba(103,64,255,.18);padding:1px 6px;border-radius:6px;font-size:11px;word-break:break-all}
.nsx-devices{position:relative;z-index:1;padding:12px 20px 0;display:grid;gap:10px}
@media(min-width:960px){.nsx-devices{padding:12px 44px 0;grid-template-columns:repeat(3,1fr)}}
.nsx-seo a{color:#b5a5ff;font-weight:700;text-decoration:none}
.nsx-seo p{margin:0 0 10px}
@media(min-width:960px){.nsx-seo{padding:6px 44px 30px}}
.nsx-seo strong{color:#c9c9d6}
.nsx-foot{position:relative;z-index:1;border-top:1px solid rgba(255,255,255,.09);padding:14px 20px 18px;font-size:12px;color:#8b8ba0;display:flex;gap:10px;flex-wrap:wrap;justify-content:space-between}
.nsx-modal{position:fixed;inset:0;margin:auto;width:min(32rem,calc(100% - 2rem));max-height:calc(100dvh - 2rem);overflow-y:auto;border:1px solid rgba(255,255,255,.14);border-radius:20px;background:#101019;color:#f5f5f7;padding:0;box-shadow:0 24px 80px rgba(0,0,0,.7)}
.nsx-modal::backdrop{background:rgba(0,0,0,.78);backdrop-filter:blur(5px)}
.nsx-modal-content{padding:22px}
.nsx-modal-close{border:1px solid rgba(255,255,255,.16);border-radius:999px;background:rgba(255,255,255,.08);color:#fff;padding:7px 12px;font-weight:700}
.nsx-qlist-single{grid-template-columns:minmax(0,1fr);max-width:28rem;margin-inline:auto}
.nsx-load-progress{width:100%;height:8px;overflow:hidden;border:0;border-radius:99px;background:rgba(255,255,255,.12)}
.nsx-load-progress::-webkit-progress-bar{border-radius:99px;background:rgba(255,255,255,.12)}
.nsx-load-progress::-webkit-progress-value{border-radius:99px;background:linear-gradient(90deg,#7958ff,#38bdf8)}
.nsx-load-progress::-moz-progress-bar{border-radius:99px;background:linear-gradient(90deg,#7958ff,#38bdf8)}
.nsx-spinner{width:44px;height:44px;border:4px solid rgba(255,255,255,.16);border-top-color:#a78bfa;border-radius:50%;animation:nsxspin .8s linear infinite}
@keyframes nsxspin{to{transform:rotate(360deg)}}
</style>
@endpush

@section('content')
<div class="nsx-wrap my-3">
  <div class="nsx-bg"></div><div class="nsx-grain"></div>

  <div class="nsx-topbar">
    <div class="nsx-brand"><div class="nsx-n">R</div><div><small>ReelSwipe</small><strong>Video Downloader</strong></div></div>
    <div class="nsx-tabs"><span class="on">Downloader</span><span>MP4 downloads</span><span>How it works</span></div>
    <a class="nsx-appbtn" href="https://play.google.com/store/apps/details?id=com.reelswipe" target="_blank" rel="noopener">Get ReelSwipe</a>
  </div>

  <div class="nsx-hero">
    <div>
      <span class="nsx-kicker"><i></i> ReelSwipe Video Downloader • MP4 Saver</span>
      <h1 class="nsx-h1">Save videos with <em>ReelSwipe</em></h1>
      <p class="nsx-sub">Open a ReelSwipe download link and the video source is decoded automatically. Download supported HLS videos as MP4, or paste a NetShort episode share link to fetch its available qualities.</p>
      <div class="nsx-stats">
        <span class="nsx-stat">⚡ Encoded links decode automatically</span>
        <span class="nsx-stat">🎬 HLS to MP4</span>
        <span class="nsx-stat">📱 Mobile friendly</span>
      </div>

      <div class="nsx-dlcard">
        <form method="POST" action="{{ route('netshort-video-downloader.fetch') }}" id="nsx-form">
          @csrf
          <div class="nsx-label"><span>Video link, NetShort share link, or ID</span><a href="#nsx-how" title="Copy a share link from the NetShort app">Where's my link?</a></div>
          <div class="nsx-field">
            <input id="nsx-url" type="text" name="url" class="nsx-input" placeholder="Paste a ReelSwipe link, NetShort share link, or episode ID" value="{{ old('url', $input) }}" required autocomplete="off">
            <div class="nsx-actions"><button type="button" class="nsx-paste" id="nsx-paste">📋 Paste</button></div>
          </div>
          @error('url')<div class="nsx-err">{{ $message }}</div>@enderror
          @error('linkId')<div class="nsx-err">{{ $message }}</div>@enderror
          <button type="submit" class="nsx-go">⬇ Find video</button>
        </form>
        <p class="nsx-hint">ReelSwipe links keep the encoded source in this field. Press <strong>Find video</strong> to decode, convert, and temporarily cache the MP4 before downloading.</p>

        @if ($error)
          <div class="nsx-err">⚠ {{ $error }}</div>
        @endif

        @if ($result)
          <dialog id="nsx-download-dialog" class="nsx-modal" aria-labelledby="nsx-download-title">
          <div class="nsx-modal-content">
            <div class="flex items-start justify-between gap-4">
              <div>
                <h2 id="nsx-download-title" class="text-xl font-extrabold">Your video is ready</h2>
                @if ($result['prepared'] ?? false)
                  <p class="mt-1 text-sm text-white/65">The {{ $result['sourceFormat'] ?? 'video' }} has been prepared and temporarily cached as MP4.</p>
                @else
                  <p class="mt-1 text-sm text-white/65">Your video links are ready to download.</p>
                @endif
              </div>
              <button class="nsx-modal-close" type="button" data-close-dialog="nsx-download-dialog" aria-label="Close download dialog">Close</button>
            </div>
            <div class="nsx-ok mt-5" id="nsx-result">
            <div class="nsx-ok-head">
              <div class="nsx-thumb">🎭</div>
              <div style="min-width:0">
                <h3>{{ $result['name'] ?? 'Episode '.$result['episodeNo'] }}</h3>
                @if ($result['prepared'] ?? false)
                  <p>{{ $result['sourceFormat'] ?? 'Video source' }} &middot; MP4 download ready</p>
                @else
                  <p>Episode {{ $result['episodeNo'] }} &middot; ID <code>{{ $result['episodeId'] }}</code> &middot; MP4</p>
                @endif
              </div>
            </div>
            <div class="nsx-qlist {{ ($result['prepared'] ?? false) ? 'nsx-qlist-single' : '' }}">
              @if ($result['prepared'] ?? false)
                <a class="nsx-q nsx-q720" href="{{ $result['dl']['720p'] }}" download="reelswipe-video.mp4"><span><b>⬇ Download MP4</b><small>Prepared and cached video file</small></span><span class="nsx-dicon">⤓</span></a>
              @elseif ($result['files']['720p'])
                <a class="nsx-q nsx-q720" href="{{ $result['dl']['720p'] ?? $result['files']['720p'] }}" download="netshort-ep{{ $result['episodeNo'] }}-720p.mp4"><span><b>⬇ Download 720p</b><small>HD · smaller MP4 file</small></span><span class="nsx-dicon">⤓</span></a>
              @else
                <span class="nsx-q nsx-qoff"><span><b>720p unavailable</b><small>try 1080p</small></span><span class="nsx-dicon">×</span></span>
              @endif
              @if (! ($result['prepared'] ?? false))
                @if ($result['files']['1080p'])
                  <a class="nsx-q nsx-q1080" href="{{ $result['dl']['1080p'] ?? $result['files']['1080p'] }}" download="netshort-ep{{ $result['episodeNo'] }}-1080p.mp4"><span><b>⬇ Download 1080p</b><small>Full HD · best quality</small></span><span class="nsx-dicon">⤓</span></a>
                @else
                  <span class="nsx-q nsx-qoff"><span><b>1080p unavailable</b><small>try 720p</small></span><span class="nsx-dicon">×</span></span>
                @endif
              @endif
            </div>
            <div class="nsx-copyrow">
              <button class="nsx-copy" type="button" data-copy="{{ $result['files']['1080p'] ?? $result['files']['720p'] }}">🔗 Copy {{ ($result['prepared'] ?? false) ? 'source' : 'direct' }} link</button>
              <button class="nsx-copy" type="button" onclick="document.getElementById('nsx-url').focus();document.getElementById('nsx-url').select()">↑ New link</button>
            </div>
            @if ($result['prepared'] ?? false)
              <p class="nsx-note">The video was prepared without re-encoding and cached temporarily. Tap <strong>Download MP4</strong> to save it.</p>
            @else
              <p class="nsx-note">Tap a quality button to save the MP4 to your device.</p>
            @endif
          </div>
          </div>
          </dialog>
        @endif
      </div>
    </div>

    <div class="nsx-phonewrap">
      <div class="nsx-float nsx-f1">▶ Video preview <small>Check the stream before saving</small></div>
      <div class="nsx-phone" id="nsx-phone">
        @if ($result && ($result['files']['1080p'] ?? $result['files']['720p'] ?? null))
          <video id="nsx-phonevid" class="nsx-screenvid" src="{{ $result['files']['1080p'] ?? $result['files']['720p'] }}" autoplay muted loop playsinline preload="auto"></video>
          <div class="nsx-shade"></div>
          <button class="nsx-mutef" id="nsx-mute" type="button">🔇 Tap to unmute</button>
        @else
          <div class="nsx-screen"></div>
        @endif
        <div class="nsx-notch"></div>
        <div class="nsx-live"><i></i> REELSWIPE</div>
        <div class="nsx-ep">{{ ! empty($result['prepared']) ? 'VIDEO' : ($result ? 'EP '.$result['episodeNo'] : 'REELS') }}</div>
        @if (empty($result))
          <div class="nsx-play"><span>▶</span></div>
        @endif
        <div class="nsx-rail"><div><em>♥</em>182K</div><div><em>💬</em>4.2K</div><div><em>↗</em>Share</div></div>
        <div class="nsx-cap"><b>{{ $result['name'] ?? 'Your next favorite video' }}</b><p>{{ ! empty($result['prepared']) ? ($result['sourceFormat'] ?? 'Video source').' preview' : ($result ? 'Episode '.$result['episodeNo'] : 'Ready when you are') }}</p><div class="nsx-progress"><i></i></div></div>
        <div class="nsx-bottomnav"><span class="on">⌂ Home</span><span>▶ Watch</span><span>＋ Saved</span><span>👤 Profile</span></div>
      </div>
      <div class="nsx-float nsx-f2">⬇ MP4 <small>Ready to save</small></div>
    </div>
  </div>

  <dialog id="nsx-progress-dialog" class="nsx-modal" aria-labelledby="nsx-progress-title" aria-describedby="nsx-progress-description">
    <div class="nsx-modal-content flex flex-col items-center gap-4 text-center">
      <div class="nsx-spinner" aria-hidden="true"></div>
      <div>
        <h2 id="nsx-progress-title" class="text-xl font-extrabold">Preparing your video</h2>
        <p id="nsx-progress-description" class="mt-2 text-sm leading-6 text-white/70">Finding the video source. ReelSwipe HLS streams are converted to MP4 and cached before the download button appears. Keep this page open.</p>
      </div>
        <progress class="nsx-load-progress" aria-label="Video preparation in progress"></progress>
      <p class="text-xs text-white/50">The download button will appear when the MP4 is ready.</p>
    </div>
  </dialog>

  <h2 class="nsx-h2" id="nsx-how">How ReelSwipe downloads work</h2>
  <div class="nsx-steps">
    <div class="nsx-step"><span class="nsx-num">1</span><div><b>Open a ReelSwipe download link</b>Use the Download button in ReelSwipe to open this page with the encoded video source.</div></div>
    <div class="nsx-step"><span class="nsx-num">2</span><div><b>Preview the decoded stream</b>The source is decoded automatically. For a NetShort episode, paste its share link or ID above.</div></div>
    <div class="nsx-step"><span class="nsx-num">3</span><div><b>Save as MP4</b>Tap Download MP4. HLS segments are combined on the server without re-encoding.</div></div>
  </div>

  <h2 class="nsx-h2">A simple way to save your videos</h2>
  <p class="nsx-lead">ReelSwipe decodes shared video links and prepares supported HLS streams as MP4 downloads. NetShort share links continue to offer their available MP4 qualities.</p>
  <div class="nsx-sections">
    <div class="nsx-feat"><div class="nsx-ico">🔗</div><h3>Automatic link decoding</h3><p>Open the ReelSwipe download URL and the encoded stream is loaded into the page for preview and download.</p></div>
    <div class="nsx-feat"><div class="nsx-ico">🎬</div><h3>HLS converted to MP4</h3><p>HLS segments are combined into an MP4 file without re-encoding, preserving the stream's original quality.</p></div>
    <div class="nsx-feat"><div class="nsx-ico">📱</div><h3>Designed for your devices</h3><p>Use the download button on Android, iPhone, tablet, or desktop to save the resulting MP4.</p></div>
  </div>

  <h2 class="nsx-h2">Supported video links</h2>
  <p class="nsx-lead">This page supports the ReelSwipe HLS stream handoff and the existing NetShort episode share-link flow.</p>
  <div class="nsx-tablewrap">
    <table>
      <tr><th>Link type</th><th>How to use it</th><th>Download</th><th>Notes</th></tr>
      <tr><td>ReelSwipe HLS link</td><td>Open the link from the app</td><td>MP4 conversion</td><td>FFmpeg is required on the server</td></tr>
      <tr><td>NetShort episode</td><td>Paste its share URL or link ID</td><td>720p / 1080p when available</td><td>Existing share-link support</td></tr>
    </table>
  </div>

  <h2 class="nsx-h2">ReelSwipe downloader FAQs</h2>
  <div class="nsx-faq">
    <details open><summary>How does the ReelSwipe link open this page?</summary><p class="mt-2 mb-0">The app puts the stream URL in a base64url-encoded <code>?url=</code> parameter. This page decodes it automatically and shows the available download.</p></details>
    <details><summary>How is an HLS stream downloaded as MP4?</summary><p class="mt-2 mb-0">The server uses FFmpeg to combine the HLS stream into an MP4 without re-encoding. FFmpeg must be installed on the server for this option to work.</p></details>
    <details><summary>Can I still use a NetShort share link?</summary><p class="mt-2 mb-0">Yes. Paste a NetShort episode share URL or its link ID into the form to fetch the available 720p and 1080p MP4 files.</p></details>
    <details><summary>Where is my downloaded video saved?</summary><p class="mt-2 mb-0">Your browser saves the MP4 to its usual Downloads location. On iPhone, check Files → Downloads.</p></details>
    <details><summary>Is every video source supported?</summary><p class="mt-2 mb-0">Direct HLS downloads are limited to the supported stream provider. Only download videos you have permission to save and respect the provider's terms.</p></details>
  </div>

  <div class="nsx-seo">
    <p><strong>ReelSwipe Video Downloader</strong> decodes shared video URLs and makes supported HLS streams available as MP4 downloads. You can also paste a NetShort episode share link to fetch its available MP4 qualities.</p>
    <p>Use ReelSwipe to discover and save short videos for offline viewing when permitted. Explore our <a href="{{ url('services') }}">free social media tools</a> —
    including <a href="{{ route('free-tiktok-views') }}">TikTok views</a>, <a href="{{ route('free-instagram-likes') }}">Instagram likes</a> and <a href="{{ route('temp-mail') }}">Temp Mail</a> —
    or <a href="https://play.google.com/store/apps/details?id=com.reelswipe" target="_blank" rel="noopener">get ReelSwipe on Google Play</a>.</p>
  </div>

  <div class="nsx-foot"><span>© autolikerlive.com — ReelSwipe Video Downloader.</span><span>Only download videos you have permission to save. Not affiliated with NetShort.</span></div>
</div>

<script type="application/ld+json">
{!! json_encode([
  '@context' => 'https://schema.org',
  '@graph' => [
    ['@type' => 'WebApplication', 'name' => 'ReelSwipe Video Downloader',
     'url' => url('/netshort-video-downloader'),
     'applicationCategory' => 'MultimediaApplication', 'operatingSystem' => 'Any',
     'offers' => ['@type' => 'Offer', 'price' => '0'],
     'description' => 'Decode ReelSwipe video links and download supported HLS streams as MP4.'],
    ['@type' => 'FAQPage', 'mainEntity' => [
      ['@type' => 'Question', 'name' => 'How does the ReelSwipe link open this page?',
       'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'The page decodes the base64url stream URL in the query automatically and displays the download option.']],
      ['@type' => 'Question', 'name' => 'How is an HLS stream downloaded as MP4?',
       'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'The server uses FFmpeg to combine the HLS stream into an MP4 without re-encoding.']],
      ['@type' => 'Question', 'name' => 'Can I still use a NetShort share link?',
       'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Yes, paste a NetShort episode share URL or link ID to fetch available MP4 qualities.']],
    ]],
    ['@type' => 'HowTo', 'name' => 'How to download a video with ReelSwipe',
     'step' => [
       ['@type' => 'HowToStep', 'name' => 'Open a ReelSwipe download link', 'text' => 'Use the download action in ReelSwipe to open this page with the encoded stream URL.'],
       ['@type' => 'HowToStep', 'name' => 'Preview the video', 'text' => 'The page decodes the stream URL automatically.'],
       ['@type' => 'HowToStep', 'name' => 'Save the MP4', 'text' => 'Tap Download MP4 to convert the supported HLS stream and save it.'],
     ]],
  ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
<script>
document.getElementById('nsx-paste')?.addEventListener('click', async () => {
  try { const t = await navigator.clipboard.readText(); if (t) document.getElementById('nsx-url').value = t.trim(); }
  catch(e){ document.getElementById('nsx-url').focus(); }
});
document.getElementById('nsx-form')?.addEventListener('submit', () => {
  document.getElementById('nsx-progress-dialog')?.showModal();
});
document.querySelectorAll('[data-close-dialog]')?.forEach(button => button.addEventListener('click', () => {
  document.getElementById(button.dataset.closeDialog)?.close();
}));
document.querySelectorAll('[data-copy]')?.forEach(b => b.addEventListener('click', async () => {
  try { await navigator.clipboard.writeText(b.dataset.copy); b.textContent = '✅ Copied!'; setTimeout(()=>b.textContent='🔗 Copy link',1600);} catch(e){}
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
  document.getElementById('nsx-download-dialog')?.showModal();
  @endif
})();
</script>
@endsection
