<div>
    <div class="layout" style="display:flex; gap:25px; flex-wrap:wrap;">
        <div class="sidebar" style="flex:0 0 340px; min-width:280px;">
            @if ($error)
                <div style="background:rgba(255,0,0,0.1); border:1px solid rgba(255,0,0,0.2); border-radius:10px; padding:12px 16px; color:#ff6b6b; font-size:0.85rem; margin-bottom:16px;">{{ $error }}</div>
            @endif

            @php $templatePath = storage_path('app/public/id_card_base/bjp_id_card.png'); @endphp
            @if (!file_exists($templatePath))
                <div style="background:rgba(255,0,0,0.1); border:1px solid rgba(255,0,0,0.2); border-radius:10px; padding:12px 16px; color:#ff6b6b; font-size:0.85rem; margin-bottom:16px;">Template not found at <code>storage/app/public/id_card_base/bjp_id_card.png</code></div>
            @endif

            <div style="background:#1a1a1a; border:1px solid #2a2a2a; border-radius:14px; padding:20px; margin-bottom:16px;">
                <h3 style="color:#ffb347; font-size:0.85rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:15px; padding-bottom:8px; border-bottom:1px solid #2a2a2a;">Facebook URL</h3>
                <div style="margin-bottom:10px;">
                    <label style="color:rgba(255,255,255,0.6); font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; display:block; margin-bottom:3px;">Profile URL or ID</label>
                    <input wire:model.live="fburl" type="text" style="background:#0d0d0d; border:1px solid #2a2a2a; border-radius:8px; color:white; padding:8px 12px; font-size:0.9rem; width:100%;">
                </div>
            </div>

            <div style="background:#1a1a1a; border:1px solid #2a2a2a; border-radius:14px; padding:20px; margin-bottom:16px;">
                <h3 style="color:#ffb347; font-size:0.85rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:15px; padding-bottom:8px; border-bottom:1px solid #2a2a2a;">Profile Picture</h3>
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr 1fr; gap:8px;">
                    <div style="margin-bottom:10px;">
                        <label style="color:rgba(255,255,255,0.6); font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; display:block; margin-bottom:3px;">X</label>
                        <input wire:model.live="pp_x" type="number" style="background:#0d0d0d; border:1px solid #2a2a2a; border-radius:8px; color:white; padding:8px 12px; font-size:0.9rem; width:100%;">
                    </div>
                    <div style="margin-bottom:10px;">
                        <label style="color:rgba(255,255,255,0.6); font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; display:block; margin-bottom:3px;">Y</label>
                        <input wire:model.live="pp_y" type="number" style="background:#0d0d0d; border:1px solid #2a2a2a; border-radius:8px; color:white; padding:8px 12px; font-size:0.9rem; width:100%;">
                    </div>
                    <div style="margin-bottom:10px;">
                        <label style="color:rgba(255,255,255,0.6); font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; display:block; margin-bottom:3px;">W</label>
                        <input wire:model.live="pp_w" type="number" style="background:#0d0d0d; border:1px solid #2a2a2a; border-radius:8px; color:white; padding:8px 12px; font-size:0.9rem; width:100%;">
                    </div>
                    <div style="margin-bottom:10px;">
                        <label style="color:rgba(255,255,255,0.6); font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; display:block; margin-bottom:3px;">H</label>
                        <input wire:model.live="pp_h" type="number" style="background:#0d0d0d; border:1px solid #2a2a2a; border-radius:8px; color:white; padding:8px 12px; font-size:0.9rem; width:100%;">
                    </div>
                </div>
            </div>

            <div style="background:#1a1a1a; border:1px solid #2a2a2a; border-radius:14px; padding:20px; margin-bottom:16px;">
                <h3 style="color:#ffb347; font-size:0.85rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:15px; padding-bottom:8px; border-bottom:1px solid #2a2a2a;">FB ID Text</h3>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                    <div style="margin-bottom:10px;">
                        <label style="color:rgba(255,255,255,0.6); font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; display:block; margin-bottom:3px;">X</label>
                        <input wire:model.live="id_x" type="number" style="background:#0d0d0d; border:1px solid #2a2a2a; border-radius:8px; color:white; padding:8px 12px; font-size:0.9rem; width:100%;">
                    </div>
                    <div style="margin-bottom:10px;">
                        <label style="color:rgba(255,255,255,0.6); font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; display:block; margin-bottom:3px;">Y</label>
                        <input wire:model.live="id_y" type="number" style="background:#0d0d0d; border:1px solid #2a2a2a; border-radius:8px; color:white; padding:8px 12px; font-size:0.9rem; width:100%;">
                    </div>
                </div>
                <div style="margin-bottom:10px;">
                    <label style="color:rgba(255,255,255,0.6); font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; display:block; margin-bottom:3px;">Font Size</label>
                    <input wire:model.live="id_size" type="number" style="background:#0d0d0d; border:1px solid #2a2a2a; border-radius:8px; color:white; padding:8px 12px; font-size:0.9rem; width:100%;">
                </div>
            </div>

            <div style="background:#1a1a1a; border:1px solid #2a2a2a; border-radius:14px; padding:20px; margin-bottom:16px;">
                <h3 style="color:#ffb347; font-size:0.85rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:15px; padding-bottom:8px; border-bottom:1px solid #2a2a2a;">Date Text</h3>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                    <div style="margin-bottom:10px;">
                        <label style="color:rgba(255,255,255,0.6); font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; display:block; margin-bottom:3px;">X</label>
                        <input wire:model.live="date_x" type="number" style="background:#0d0d0d; border:1px solid #2a2a2a; border-radius:8px; color:white; padding:8px 12px; font-size:0.9rem; width:100%;">
                    </div>
                    <div style="margin-bottom:10px;">
                        <label style="color:rgba(255,255,255,0.6); font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; display:block; margin-bottom:3px;">Y</label>
                        <input wire:model.live="date_y" type="number" style="background:#0d0d0d; border:1px solid #2a2a2a; border-radius:8px; color:white; padding:8px 12px; font-size:0.9rem; width:100%;">
                    </div>
                </div>
                <div style="margin-bottom:10px;">
                    <label style="color:rgba(255,255,255,0.6); font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; display:block; margin-bottom:3px;">Font Size</label>
                    <input wire:model.live="date_size" type="number" style="background:#0d0d0d; border:1px solid #2a2a2a; border-radius:8px; color:white; padding:8px 12px; font-size:0.9rem; width:100%;">
                </div>
            </div>

            <button wire:click="generatePreview" wire:loading.attr="disabled" style="background:linear-gradient(135deg, #ff9933, #e68a00); color:white; border:none; border-radius:10px; padding:14px; font-weight:700; font-size:1rem; width:100%; cursor:pointer; transition:all .3s;">
                <span wire:loading.remove>Generate Preview</span>
                <span wire:loading>Generating...</span>
            </button>
            <button wire:click="resetDefaults" type="button" style="background:transparent; color:rgba(255,255,255,0.4); border:1px solid #2a2a2a; border-radius:10px; padding:10px; font-size:0.8rem; width:100%; cursor:pointer; margin-top:8px;">Reset to Defaults</button>
        </div>

        <div style="flex:1; min-width:300px;">
            <div style="background:#1a1a1a; border:1px solid #2a2a2a; border-radius:14px; padding:15px; text-align:center;">
                <span style="display:inline-block; background:#ff9933; color:#111; font-size:0.65rem; font-weight:700; padding:3px 10px; border-radius:20px; margin-bottom:10px;">Template</span>
                @if (file_exists(storage_path('app/public/id_card_base/bjp_id_card.png')))
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url('bjp_cards/sample.png') }}" alt="Template" loading="lazy" style="max-width:100%; height:auto; border-radius:8px;">
                @else
                    <p style="color:rgba(255,255,255,0.3); padding:40px 0;">Template not available</p>
                @endif
            </div>

            @if ($previewImage)
                <div style="margin-top:20px;">
                    <h3 style="color:#6fcf6f; font-size:0.85rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:12px;">Preview</h3>
                    <img src="{{ $previewImage }}?t={{ time() }}" alt="Preview" style="max-width:100%; height:auto; border-radius:12px; border:2px solid #2a2a2a;">
                </div>
            @endif
        </div>
    </div>
</div>