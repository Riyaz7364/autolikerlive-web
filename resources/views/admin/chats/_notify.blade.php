{{-- Shared admin desktop-notification helper for live chat.
     Usage: @include('admin.chats._notify') then call AlChatNotify.ping(title, body, url, tag, backgroundOnly) --}}
<script>
window.AlChatNotify = (function(){
  var supported = ('Notification' in window);
  function permission(){ return supported ? Notification.permission : 'denied'; }
  function ensure(){
    if(!supported || Notification.permission!=='default') { paintBell(); return; }
    try{
      var p = Notification.requestPermission();
      if(p && p.then) p.then(function(){ paintBell(); });
    }catch(e){ try{ Notification.requestPermission(); }catch(_){} }
    setTimeout(paintBell, 1000);
  }
  function unlockAudio(){
    try{
      var C = window.AudioContext||window.webkitAudioContext; if(!C) return;
      var ctx = new C(); if(ctx.state==='suspended') ctx.resume();
    }catch(e){}
  }
  function ping(title, body, url, tag, backgroundOnly){
    if(!supported || Notification.permission!=='granted') return;
    try{
      if(backgroundOnly && !document.hidden && document.hasFocus && document.hasFocus()) return;
    }catch(e){}
    try{
      var n = new Notification(title||'New live chat message', { body: body||'', tag: tag||'al-chat', renotify: true });
      n.onclick = function(){ try{ window.focus(); }catch(e){} if(url){ location.href = url; } try{ n.close(); }catch(e){} };
    }catch(e){}
  }
  function paintBell(){
    var b = document.getElementById('chat-bell'); if(!b) return;
    var p = permission();
    if(p==='granted'){ b.textContent='🔔 Notifications on'; b.className='btn btn-sm btn-success'; }
    else if(p==='denied'){ b.textContent='🔕 Notifications blocked'; b.className='btn btn-sm btn-outline-danger'; b.title='Allow notifications in your browser site settings'; }
    else { b.textContent='🔔 Enable notifications'; b.className='btn btn-sm btn-outline-primary'; }
  }
  // browsers require a user gesture: ask once on first click anywhere
  document.addEventListener('click', function once(){ ensure(); unlockAudio(); paintBell(); }, { once:true });
  document.addEventListener('DOMContentLoaded', paintBell);
  return { ping: ping, ensure: ensure, paintBell: paintBell };
})();
</script>
