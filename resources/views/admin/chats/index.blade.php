@extends('admin.layout')

@section('title', 'Live Chats')
@section('heading', 'Live Chats — guest → admin')

@section('content')
<div class="row g-3">
  <div class="col-12">
    <div class="btn-group mb-2" role="group">
      @foreach(['all'=>'All','open'=>'Open','pending'=>'Pending / offline','resolved'=>'Resolved','closed'=>'Closed','blocked'=>'Blocked'] as $k=>$label)
        <a href="{{ route('admin.chats.index', ['status'=>$k]) }}" class="btn btn-sm {{ ($status??'all')===$k ? 'btn-primary' : 'btn-outline-primary' }}">{{ $label }}</a>
      @endforeach
      <span class="btn btn-sm btn-outline-danger disabled">Unread: {{ $counts['unread'] ?? 0 }}</span>
      <button type="button" id="chat-bell" class="btn btn-sm btn-outline-primary" onclick="AlChatNotify.ensure()">🔔 Enable notifications</button>
    </div>
    <form method="GET" class="d-flex gap-2 mb-3" style="max-width:420px">
      <input type="hidden" name="status" value="{{ $status ?? 'all' }}">
      <input name="s" class="form-control form-control-sm" placeholder="Search name / email / IP / page…" value="{{ request('s') }}">
      <button class="btn btn-sm btn-secondary">Search</button>
    </form>
  </div>
  <div class="col-12">
    <div class="card shadow-sm">
      <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
          <thead class="table-light"><tr><th>Visitor</th><th>Page</th><th>Status</th><th>Unread</th><th>Last</th><th></th></tr></thead>
          <tbody>
          @forelse($conversations as $c)
            <tr class="{{ $c->admin_unread>0 ? 'table-warning' : '' }}">
              <td><strong>{{ $c->name }}</strong><br><small class="text-muted">{{ $c->email }} · {{ $c->ip }} · {{ $c->country }} {{ $c->city }} · {{ $c->device }}</small></td>
              <td><small class="text-truncate d-inline-block" style="max-width:220px" title="{{ $c->page_url }}">{{ $c->page_url }}</small></td>
              <td><span class="badge bg-{{ $c->status==='open'?'success':($c->status==='blocked'?'danger':'secondary') }}">{{ $c->status }}</span></td>
              <td>{!! $c->admin_unread>0 ? '<span class="badge bg-danger">'.$c->admin_unread.'</span>' : '<span class="text-muted">0</span>' !!}</td>
              <td><small>{{ $c->last_message_at }}</small></td>
              <td><a href="{{ route('admin.chats.show', $c->uuid) }}" class="btn btn-sm btn-primary">Open</a></td>
            </tr>
          @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No conversations yet.</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
      <div class="card-footer">{{ $conversations->links() }}</div>
    </div>
  </div>
</div>
@push('scripts')
@include('admin.chats._notify')
<script>
(function(){
  var WS_URL = @json(config('chat.ws_url'));
  var SHOW_URL = @json(route('admin.chats.show', ['uuid' => '__UUID__']));
  function showUrl(uuid){ return SHOW_URL.replace('__UUID__', uuid); }
  var lastUnread = {{ (int)($counts['unread'] ?? 0) }};
  function beep(){ try{ var c=new (window.AudioContext||window.webkitAudioContext)(); var o=c.createOscillator(),g=c.createGain(); o.connect(g); g.connect(c.destination); o.frequency.value=880; g.gain.value=.08; o.start(); o.stop(c.currentTime+.2);}catch(e){} }
  function alertAdmin(name, body, uuid){
    beep();
    AlChatNotify.ping('💬 '+(name||'New guest message'), body||'', showUrl(uuid), 'chat-'+(uuid||'all'), false);
  }
  async function check(){
    try{ var r=await fetch("{{ route('admin.chats.unread') }}"); var j=await r.json();
      // polling path (also covers WS-down): notify with guest name + preview, then refresh list
      if(j.ok && j.unread>lastUnread){ if(j.latest) alertAdmin(j.latest.name, j.latest.body, j.latest.uuid); else beep(); location.reload(); return; }
      lastUnread=j.unread||0; document.title=(lastUnread>0?'('+lastUnread+') ':'')+'Live Chats';
    }catch(e){}
  }
  try{
    var ws=new WebSocket(WS_URL), pollFallback=false;
    function armFallback(){ if(!pollFallback){ pollFallback=true; setInterval(check,3000); } }
    ws.onopen=function(){ ws.send(JSON.stringify({type:'join',role:'admin'})); };
    ws.onmessage=function(ev){ var d; try{d=JSON.parse(ev.data);}catch(e){return;}
      if(d.type==='message'&&d.message&&d.message.sender==='guest'){ alertAdmin(d.name||'New guest message', d.message.body, d.uuid); check(); } };
    ws.onerror=armFallback;
    ws.onclose=armFallback;
  }catch(e){ setInterval(check,3000); }
  setInterval(check,15000);
})();
</script>
@endpush
@endsection
