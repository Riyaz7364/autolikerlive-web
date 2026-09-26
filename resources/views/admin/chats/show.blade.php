@extends('admin.layout')

@section('title', 'Chat with '.$conv->name)
@section('heading', 'Chat — '.$conv->name)

@section('content')
<div class="mb-2 d-flex gap-2"><a href="{{ route('admin.chats.index') }}" class="btn btn-sm btn-outline-secondary">← All chats</a><button type="button" id="chat-bell" class="btn btn-sm btn-outline-primary" onclick="AlChatNotify.ensure()">🔔 Enable notifications</button></div>
<div class="row g-3">
  <div class="col-lg-8">
    <div class="card shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-bold">{{ $conv->name }} <small class="text-muted">{{ $conv->email }}</small></span>
        <span>
          <span class="badge bg-{{ $guestOnline ? 'success' : 'secondary' }}">{{ $guestOnline ? '🟢 Guest online' : '⚪ Guest offline' }}</span>
          <span class="badge bg-{{ $conv->status==='open'?'success':($conv->status==='blocked'?'danger':'secondary') }}">{{ $conv->status }}</span>
        </span>
      </div>
      <div id="chat-thread" class="card-body" style="height:420px;overflow-y:auto;background:#f3f5f9">
        @foreach($messages as $m)
          @if($m->sender==='system')
            <div class="text-center my-1"><span class="badge bg-warning text-dark">{{ $m->body }} <small>{{ $m->created_at->format('H:i') }}</small></span></div>
          @elseif($m->sender==='admin')
            <div class="d-flex justify-content-end mb-2"><div class="bg-primary text-white rounded px-3 py-2" style="max-width:80%">{{ $m->body }}<div class="small opacity-75">{{ $m->created_at->format('H:i') }}</div></div></div>
          @else
            <div class="d-flex mb-2"><div class="bg-white border rounded px-3 py-2" style="max-width:80%">{{ $m->body }}<div class="small text-muted">{{ $m->created_at->format('H:i') }}</div></div></div>
          @endif
        @endforeach
      </div>
      <div id="chat-typing" class="px-3 small fst-italic text-muted" style="display:none;background:#f3f5f9">Visitor is typing…</div>
      <div class="card-footer">
        <form id="chat-reply-form" method="POST" action="{{ route('admin.chats.reply', $conv->uuid) }}" class="d-flex gap-2">
          @csrf
          <input name="body" id="chat-input" class="form-control" maxlength="2000" placeholder="Reply as admin…" autocomplete="off" {{ $conv->status==='blocked' ? 'disabled' : '' }}>
          <button class="btn btn-primary" {{ $conv->status==='blocked' ? 'disabled' : '' }}>Send</button>
        </form>
        <div class="small text-muted mt-1">Shortcuts: type <code>/thanks</code> for a canned reply. Live typing + sound on.</div>
        @if (!$guestOnline)
          @if ($conv->email)
            <div class="alert alert-info py-2 px-3 mt-2 mb-0 small">⚪ Guest is offline — your reply will also be <strong>emailed to {{ $conv->email }}</strong>.</div>
          @else
            <div class="alert alert-warning py-2 px-3 mt-2 mb-0 small">⚪ Guest is offline and left <strong>no email</strong> — they won't see your reply until they return to the chat.</div>
          @endif
        @endif
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card shadow-sm mb-3">
      <div class="card-header fw-bold">Visitor details</div>
      <ul class="list-group list-group-flush small">
        <li class="list-group-item"><strong>Name:</strong> {{ $conv->name }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $conv->email ?? '—' }}</li>
        <li class="list-group-item"><strong>IP:</strong> <code>{{ $conv->ip }}</code></li>
        <li class="list-group-item"><strong>Location:</strong> {{ $conv->city ?? '' }} {{ $conv->country ?? 'unknown' }}</li>
        <li class="list-group-item"><strong>Page:</strong> <a href="{{ $conv->page_url }}" target="_blank">{{ \Str::limit($conv->page_url ?? '', 60) }}</a></li>
        <li class="list-group-item"><strong>Browser:</strong> {{ $conv->browser }} {{ $conv->browser_version }} on {{ $conv->platform }} ({{ $conv->device }})</li>
        <li class="list-group-item text-break"><strong>User-Agent:</strong><br><code>{{ $conv->user_agent }}</code></li>
        <li class="list-group-item"><strong>Started:</strong> {{ $conv->created_at }}<br><strong>Last msg:</strong> {{ $conv->last_message_at }}</li>
      </ul>
    </div>
    <div class="card shadow-sm">
      <div class="card-header fw-bold">Controls</div>
      <div class="card-body d-flex flex-wrap gap-2">
        <form method="POST" action="{{ route('admin.chats.status', $conv->uuid) }}">@csrf<input type="hidden" name="status" value="pending"><button class="btn btn-sm btn-outline-warning">Pending</button></form>
        <form method="POST" action="{{ route('admin.chats.status', $conv->uuid) }}">@csrf<input type="hidden" name="status" value="resolved"><button class="btn btn-sm btn-outline-success">Resolve</button></form>
        <form method="POST" action="{{ route('admin.chats.status', $conv->uuid) }}">@csrf<input type="hidden" name="status" value="closed"><button class="btn btn-sm btn-outline-secondary">Close</button></form>
        <form method="POST" action="{{ route('admin.chats.status', $conv->uuid) }}">@csrf<input type="hidden" name="status" value="open"><button class="btn btn-sm btn-outline-primary">Reopen</button></form>
        @if($conv->status!=='blocked')
        <form method="POST" action="{{ route('admin.chats.block', $conv->uuid) }}" onsubmit="return confirm('Block this visitor (IP + token)?')">@csrf<input type="hidden" name="reason" value="Blocked by admin"><button class="btn btn-sm btn-danger">⛔ Block</button></form>
        @else
        <form method="POST" action="{{ route('admin.chats.unblock', $conv->uuid) }}">@csrf<button class="btn btn-sm btn-success">✅ Unblock</button></form>
        @endif
        <a href="{{ route('admin.chats.export', $conv->uuid) }}" class="btn btn-sm btn-outline-dark">Export CSV</a>
        <form method="POST" action="{{ route('admin.chats.destroy', $conv->uuid) }}" onsubmit="return confirm('Delete conversation?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form>
      </div>
      <div class="card-footer">
        <form method="POST" action="{{ route('admin.chats.note', $conv->uuid) }}" class="d-flex gap-2">@csrf<input name="body" class="form-control form-control-sm" maxlength="1000" placeholder="Private note (guest can't see)"><button class="btn btn-sm btn-secondary">Note</button></form>
      </div>
    </div>
  </div>
</div>
@push('scripts')
@include('admin.chats._notify')
<script>
(function(){
  var WS_URL=@json(config('chat.ws_url')), UUID=@json($conv->uuid), GUEST=@json($conv->name);
  var thread=document.getElementById('chat-thread'), typing=document.getElementById('chat-typing'), input=document.getElementById('chat-input');
  thread.scrollTop=thread.scrollHeight;
  function beep(){ try{var c=new(window.AudioContext||window.webkitAudioContext)();var o=c.createOscillator(),g=c.createGain();o.connect(g);g.connect(c.destination);o.frequency.value=880;g.gain.value=.08;o.start();o.stop(c.currentTime+.2);}catch(e){} }
  function esc(s){return String(s).replace(/[&<>"']/g,function(c){return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c];});}
  function guestHtml(body){return '<div class="d-flex mb-2"><div class="bg-white border rounded px-3 py-2" style="max-width:80%">'+esc(body)+'</div></div>';}
  var ws=null, typingT=null, typingHideT=null;
  try{
    ws=new WebSocket(WS_URL);
    ws.onopen=function(){ws.send(JSON.stringify({type:'join',role:'admin'}));};
    ws.onmessage=function(ev){var d;try{d=JSON.parse(ev.data);}catch(e){return;}
      if(d.type==='message'&&d.uuid===UUID){
        if(d.message.sender==='guest'){thread.insertAdjacentHTML('beforeend',guestHtml(d.message.body));thread.scrollTop=thread.scrollHeight;beep();
          // desktop alert only when this tab is in the background (inline + beep already cover the focused case)
          AlChatNotify.ping('💬 '+GUEST, d.message.body, null, 'chat-'+UUID, true);}
        else if(d.message.sender==='system'){location.reload();}
      }
      if(d.type==='typing'&&d.uuid===UUID&&d.from==='guest'){
        clearTimeout(typingHideT);
        if(d.typing){ typing.style.display='block';
          // safety: never leave "typing…" stuck if the guest's tab closes mid-type
          typingHideT=setTimeout(function(){ typing.style.display='none'; },5000);
        } else { typing.style.display='none'; }
      }
      if(d.type==='presence'){/* admin count changed */}
    };
  }catch(e){}
  function sendTypingFalse(){ try{ if(ws&&ws.readyState===1) ws.send(JSON.stringify({type:'typing',uuid:UUID,typing:false})); }catch(e){} }
  // the reply form reloads the page — clear "typing…" on the guest side immediately
  document.getElementById('chat-reply-form').addEventListener('submit',sendTypingFalse);
  window.addEventListener('pagehide',sendTypingFalse);
  // live typing → guest
  input.addEventListener('input',function(){
    if(!ws||ws.readyState!==1)return;
    ws.send(JSON.stringify({type:'typing',uuid:UUID,typing:true}));
    clearTimeout(typingT);typingT=setTimeout(function(){try{ws.send(JSON.stringify({type:'typing',uuid:UUID,typing:false}));}catch(e){}},1200);
  });
  // canned reply
  input.addEventListener('keydown',function(e){
    if(e.key==='Enter'&&input.value.trim()==='/thanks'){e.preventDefault();input.value='Thanks for reaching out! How can I help you today?';}
  });
  // fallback poll every 5s if WS down
  setInterval(async function(){
    if(ws&&ws.readyState===1)return;
    try{var r=await fetch("{{ route('admin.chats.show', $conv->uuid) }}",{headers:{'Accept':'application/json'}});var j=await r.json();
      if(j.ok){thread.innerHTML='';j.messages.forEach(function(m){
        if(m.sender==='system')thread.insertAdjacentHTML('beforeend','<div class="text-center my-1"><span class="badge bg-warning text-dark">'+esc(m.body)+'</span></div>');
        else if(m.sender==='admin')thread.insertAdjacentHTML('beforeend','<div class="d-flex justify-content-end mb-2"><div class="bg-primary text-white rounded px-3 py-2" style="max-width:80%">'+esc(m.body)+'</div></div>');
        else thread.insertAdjacentHTML('beforeend',guestHtml(m.body));});
        thread.scrollTop=thread.scrollHeight;}}catch(e){}
  },5000);
})();
</script>
@endpush
@endsection
