@if(config('chat.enabled'))
{{-- Floating guest→admin live chat widget. Vanilla JS, no build step. --}}
<style>
#al-chat-fab{position:fixed;right:20px;bottom:20px;z-index:99990;width:60px;height:60px;border-radius:50%;background:#0d6efd;border:none;cursor:pointer;box-shadow:0 6px 24px rgba(13,110,253,.45);display:flex;align-items:center;justify-content:center}
#al-chat-fab svg{width:28px;height:28px;fill:#fff}
#al-chat-live{position:absolute;top:2px;right:2px;min-width:14px;height:14px;border-radius:8px;background:#22c55e;border:2px solid #fff;font-size:9px;font-weight:800;color:#fff;display:flex;align-items:center;justify-content:center;padding:0 3px;animation:al-pulse 1.6s infinite}
@keyframes al-pulse{0%{box-shadow:0 0 0 0 rgba(34,197,94,.6)}70%{box-shadow:0 0 0 8px rgba(34,197,94,0)}100%{box-shadow:0 0 0 0 rgba(34,197,94,0)}}
#al-chat-badge{position:absolute;top:-6px;left:-6px;min-width:22px;height:22px;border-radius:11px;background:#dc3545;color:#fff;font-size:12px;font-weight:700;display:none;align-items:center;justify-content:center;padding:0 5px}
#al-chat-panel{position:fixed;right:20px;bottom:92px;z-index:99990;width:380px;max-width:calc(100vw - 24px);height:520px;max-height:calc(100vh - 120px);background:#fff;border-radius:16px;box-shadow:0 12px 48px rgba(0,0,0,.25);display:none;flex-direction:column;overflow:hidden;font-family:system-ui,-apple-system,Segoe UI,Roboto,sans-serif}
#al-chat-panel.open{display:flex}
#al-chat-head{background:#0d6efd;color:#fff;padding:12px 14px;display:flex;align-items:center;gap:10px}
#al-chat-dot{width:10px;height:10px;border-radius:50%;background:#22c55e;box-shadow:0 0 6px #22c55e}
#al-chat-dot.off{background:#f59e0b;box-shadow:0 0 6px #f59e0b}
#al-chat-msgs{flex:1;overflow-y:auto;padding:12px;display:flex;flex-direction:column;gap:8px;background:#f3f5f9}
.al-m{max-width:82%;padding:8px 11px;border-radius:12px;font-size:14px;line-height:1.4;word-break:break-word}
.al-g{align-self:flex-end;background:#0d6efd;color:#fff;border-bottom-right-radius:4px}
.al-a{align-self:flex-start;background:#fff;color:#222;border:1px solid #e3e6ec;border-bottom-left-radius:4px}
.al-t{font-size:12px;color:#6b7280;font-style:italic}
#al-chat-form{display:flex;gap:8px;padding:10px;border-top:1px solid #e9ecef;background:#fff}
#al-chat-input{flex:1;border:1px solid #d7dce3;border-radius:10px;padding:9px 10px;font-size:14px;outline:none}
#al-chat-send{background:#0d6efd;color:#fff;border:none;border-radius:10px;padding:0 16px;font-weight:700;cursor:pointer}
#al-chat-start{padding:16px;display:flex;flex-direction:column;gap:10px;overflow-y:auto}
#al-chat-start input,#al-chat-start textarea{border:1px solid #d7dce3;border-radius:10px;padding:10px;font-size:14px;width:100%;box-sizing:border-box}
#al-chat-start button{background:#0d6efd;color:#fff;border:none;border-radius:10px;padding:11px;font-weight:700;cursor:pointer;font-size:15px}
#al-chat-err{display:none;background:#fde8e8;color:#b42318;border-radius:8px;padding:8px 10px;font-size:13px}
@media(max-width:480px){#al-chat-panel{right:12px;left:12px;width:auto}}
</style>

<button id="al-chat-fab" aria-label="Live chat">
  <span id="al-chat-badge">0</span>
  <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.02 2 11c0 2.72 1.24 5.16 3.2 6.83V22l3.94-2.16c.7.2 1.45.31 2.24.31h.07c4.86-.24 8.55-3.83 8.55-8.4 0-2.26-.94-4.31-2.45-5.78A8.6 8.6 0 0 0 12 2z"/></svg>
  <span id="al-chat-live">LIVE</span>
</button>

<div id="al-chat-panel" role="dialog" aria-label="Live chat">
  <div id="al-chat-head">
    <span id="al-chat-dot"></span>
    <div style="flex:1"><div style="font-weight:800">Live Support</div><div id="al-chat-sub" style="font-size:12px;opacity:.9">Connecting…</div></div>
    <button id="al-chat-close" style="background:none;border:none;color:#fff;font-size:20px;cursor:pointer">×</button>
  </div>
  <div id="al-chat-start">
    <div id="al-chat-err"></div>
    <input id="al-chat-name" maxlength="120" placeholder="Your name *" autocomplete="name">
    <input id="al-chat-email" type="email" maxlength="190" placeholder="Email (for offline reply)">
    <textarea id="al-chat-first" rows="3" maxlength="2000" placeholder="How can we help? (optional if we're online)" style="display:none"></textarea>
    <button id="al-chat-go">Start chat</button>
    <div style="font-size:12px;color:#6b7280">By chatting you agree to share basic browser info so support can help faster.</div>
  </div>
  <div id="al-chat-msgs" style="display:none"></div>
  <div id="al-chat-typing" class="al-t" style="display:none;padding:0 12px 4px;background:#f3f5f9">Support is typing…</div>
  <form id="al-chat-form" style="display:none">
    <input id="al-chat-input" maxlength="2000" placeholder="Type a message…" autocomplete="off">
    <button id="al-chat-send" type="submit">Send</button>
  </form>
</div>

<script>
(function(){
  var WS_URL = @json(config('chat.ws_url'));
  var POLL_MS = {{ (int) config('chat.poll_interval', 3000) }};
  var store = { get uuid(){ return localStorage.getItem('al_chat_uuid'); }, set uuid(v){ v?localStorage.setItem('al_chat_uuid',v):localStorage.removeItem('al_chat_uuid'); },
                get token(){ return localStorage.getItem('al_chat_token'); }, set token(v){ v?localStorage.setItem('al_chat_token',v):localStorage.removeItem('al_chat_token'); },
                get lastId(){ return parseInt(localStorage.getItem('al_chat_lastid')||'0',10)||0; }, set lastId(v){ try{localStorage.setItem('al_chat_lastid',String(v));}catch(e){} } };
  var fab=document.getElementById('al-chat-fab'), panel=document.getElementById('al-chat-panel'),
      badge=document.getElementById('al-chat-badge'), dot=document.getElementById('al-chat-dot'),
      sub=document.getElementById('al-chat-sub'), startBox=document.getElementById('al-chat-start'),
      msgsBox=document.getElementById('al-chat-msgs'), form=document.getElementById('al-chat-form'),
      input=document.getElementById('al-chat-input'), typingEl=document.getElementById('al-chat-typing'),
      errBox=document.getElementById('al-chat-err'), firstMsg=document.getElementById('al-chat-first');
  var ws=null, wsOk=false, lastId=store.lastId, unread=0, online=true, started=!!(store.uuid&&store.token), pollTimer=null, typingTimer=null, typingHideT=null;

  function csrf(){ var m=document.querySelector('meta[name="csrf-token"]'); return m?m.content:''; }
  function showErr(t){ errBox.style.display='block'; errBox.textContent=t; }
  function beep(){ try{ var c=new (window.AudioContext||window.webkitAudioContext)(); var o=c.createOscillator(),g=c.createGain(); o.connect(g); g.connect(c.destination); o.frequency.value=880; g.gain.value=.08; o.start(); o.stop(c.currentTime+.15);}catch(e){} }
  function esc(s){ return String(s).replace(/[&<>"']/g,function(c){return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c];}); }
  function addMsg(m, silent){
    if(m.id && m.id<=lastId) return; if(m.id){ lastId=Math.max(lastId,m.id); store.lastId=lastId; }
    if(m.sender==='system') return; // private admin notes stay hidden
    var d=document.createElement('div');
    d.className='al-m '+(m.sender==='guest'?'al-g':'al-a');
    d.innerHTML=esc(m.body).replace(/\n/g,'<br>');
    msgsBox.appendChild(d); msgsBox.scrollTop=msgsBox.scrollHeight;
    if(m.sender==='admin'){ if(panel.classList.contains('open')){ markRead(); } else if(!silent){ unread++; badge.style.display='flex'; badge.textContent=unread; beep(); } }
  }
  function setOnline(v){
    online=v;
    dot.classList.toggle('off',!v);
    sub.textContent=v?'Online — replies instantly':'Offline — leave a message';
    document.getElementById('al-chat-live').textContent=v?'LIVE':'AWAY';
    firstMsg.style.display=v?'none':'block'; // offline → ask name+email+message upfront
  }
  function connectWS(){
    try{ ws=new WebSocket(WS_URL); }catch(e){ return; }
    ws.onopen=function(){ wsOk=true; if(started) ws.send(JSON.stringify({type:'join',role:'guest',uuid:store.uuid})); };
    ws.onmessage=function(ev){
      var d; try{ d=JSON.parse(ev.data); }catch(e){ return; }
      if(d.type==='presence'){ setOnline(!!d.admin_online); }
      else if(d.type==='message'){ if(!d.message||d.message.sender==='system')return; if(started) addMsg(d.message); }
      else if(d.type==='typing'&&d.from==='admin'){
        clearTimeout(typingHideT);
        if(d.typing){ typingEl.style.display='block';
          // safety: never leave "typing…" stuck if the admin's tab closes mid-type
          typingHideT=setTimeout(function(){ typingEl.style.display='none'; },5000);
        } else { typingEl.style.display='none'; }
      }
    };
    ws.onclose=function(){ wsOk=false; };
  }
  function markRead(){ unread=0; badge.style.display='none'; }
  async function refreshStatus(){
    try{ var r=await fetch('/api/chat/status'); var j=await r.json(); if(j.ok) setOnline(!!j.admin_online); }catch(e){}
  }
  async function poll(){
    if(!started) return;
    try{
      var r=await fetch('/api/chat/poll',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf()},body:JSON.stringify({uuid:store.uuid,token:store.token,after_id:lastId})});
      var j=await r.json();
      if(j.ok){ setOnline(!!j.admin_online);
        var fresh=0;
        (j.messages||[]).forEach(function(m){ if(m.sender==='admin'&&m.id>lastId) fresh++; addMsg(m,true); });
        // seen messages are never counted — only truly new ones, beep once per batch
        if(fresh>0&&!panel.classList.contains('open')){ unread+=fresh; badge.style.display='flex'; badge.textContent=unread; beep(); }
      }
    }catch(e){}
  }
  fab.onclick=function(){
    panel.classList.toggle('open'); markRead();
    if(panel.classList.contains('open')){
      if(started){ startBox.style.display='none'; msgsBox.style.display='flex'; form.style.display='flex'; }
      refreshStatus();
    }
  };
  document.getElementById('al-chat-close').onclick=function(){ panel.classList.remove('open'); };
  document.getElementById('al-chat-go').onclick=async function(){
    var name=document.getElementById('al-chat-name').value.trim(),
        email=document.getElementById('al-chat-email').value.trim(),
        first=firstMsg.value.trim();
    if(!name){ showErr('Please enter your name.'); return; }
    if(!online && !email){ showErr("We're offline — please add your email so we can reply."); return; }
    if(!online && !first){ showErr("We're offline — please write your message."); return; }
    errBox.style.display='none';
    try{
      var r=await fetch('/api/chat/start',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf()},body:JSON.stringify({name:name,email:email||null,page_url:location.href,message:first||null})});
      var j=await r.json();
      if(!j.ok){ showErr(j.message||'Could not start chat.'); return; }
      store.uuid=j.uuid; store.token=j.token; started=true;
      lastId=0; store.lastId=0; unread=0; markRead(); // fresh chat — nothing seen yet, nothing counted
      setOnline(!!j.admin_online);
      startBox.style.display='none'; msgsBox.style.display='flex'; form.style.display='flex';
      (j.messages||[]).forEach(addMsg);
      if(wsOk) ws.send(JSON.stringify({type:'join',role:'guest',uuid:store.uuid}));
      poll();
    }catch(e){ showErr('Network error. Please try again.'); }
  };
  form.onsubmit=async function(e){
    e.preventDefault();
    var body=input.value.trim(); if(!body||!started) return;
    input.value='';
    try{ if(wsOk) ws.send(JSON.stringify({type:'typing',typing:false})); }catch(err){}
    clearTimeout(typingTimer);
    try{
      var r=await fetch('/api/chat/send',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf()},body:JSON.stringify({uuid:store.uuid,token:store.token,body:body})});
      var j=await r.json(); if(j.ok) addMsg(j.message);
    }catch(e){}
  };
  input.addEventListener('input',function(){
    if(!wsOk||!started) return;
    ws.send(JSON.stringify({type:'typing',typing:true}));
    clearTimeout(typingTimer); typingTimer=setTimeout(function(){ try{ws.send(JSON.stringify({type:'typing',typing:false}));}catch(e){} },1200);
  });

  // resume existing session silently
  if(started){ startBox.style.display='none'; msgsBox.style.display='flex'; form.style.display='flex'; poll(); }
  connectWS(); refreshStatus();
  setInterval(function(){ if(!wsOk) poll(); }, POLL_MS); // fallback only when WS down
  setInterval(function(){ if(panel.classList.contains('open')&&started) poll(); }, 15000); // read receipts + catch anything missed while reading
  setInterval(refreshStatus, 30000);
})();
</script>
@endif
