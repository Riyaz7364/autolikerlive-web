<div>
    <div class="editor-layout">
        {{-- Left Sidebar: Controls --}}
        <div class="editor-sidebar">
            @if ($error)
                <div class="alert alert-danger mb-12">{{ $error }}</div>
            @endif

            {{-- Background Settings --}}
            <div class="editor-card mb-12">
                <h2 class="editor-title">Background</h2>

                <div class="form-group mb-8">
                    <label class="editor-label">BG Image</label>
                    <input wire:model="bgImageUpload" type="file" accept="image/*" style="font-size:0.8rem;width:100%;">
                    @php $bgUrl = $savedBgImage ? asset('storage/' . $savedBgImage) . '?v=' . now()->timestamp : $bgImagePreview; @endphp
                    @if ($bgUrl)
                        <img src="{{ $bgUrl }}" style="max-height:60px;margin-top:6px;border-radius:4px;">
                    @endif
                </div>

                <div class="form-group mb-8">
                    <label class="editor-label">BG Color</label>
                    <input wire:model="bg_color" type="color" class="color-input" style="height:34px;">
                </div>

                <div class="editor-info-text">
                    Edit game title, description &amp; thumbnail at
                    <a href="{{ $gameId ? route('game.editor.edit-info', $gameId) : '#' }}">Edit Info →</a>
                </div>

                <div class="editor-mt-12">
                    <button wire:click="save" class="fb-btn fb-btn-sm fb-btn-green" style="width:100%;">
                        <span wire:loading.remove wire:target="save">💾 Save Canvas</span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </button>
                </div>
            </div>

            {{-- Layers --}}
            <div class="editor-card">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="editor-title" style="margin:0;">Layers</h2>
                    <div class="flex gap-4">
                        <button wire:click="addLayer('text', 'auto')" class="fb-btn fb-btn-xs" title="Auto text">+T</button>
                        <button wire:click="addLayer('text', 'manual')" class="fb-btn fb-btn-xs" style="background:#e4e6eb;color:var(--fb-text);" title="User text input">+T✏️</button>
                        <button wire:click="addLayer('text', 'dob')" class="fb-btn fb-btn-xs" style="background:#fff3e0;color:#e65100;" title="Date of birth">+T📅</button>
                        <button wire:click="addLayer('image', 'auto')" class="fb-btn fb-btn-xs fb-btn-green" title="Auto image">+I</button>
                        <button wire:click="addLayer('image', 'user')" class="fb-btn fb-btn-xs" style="background:#e8f5e9;color:#2e7d32;" title="User upload image">+I📷</button>
                    </div>
                </div>

                @if (empty($layers))
                    <p class="text-center text-secondary" style="padding:12px;font-size:0.8rem;">No layers yet.</p>
                @endif

                <div class="flex flex-col gap-6">
                    @foreach ($layers as $index => $layer)
                        <div class="layer-item {{ $layer['visible'] ? '' : 'layer-item-hidden' }}" style="padding:8px 10px;">
                            <div class="layer-header" style="margin-bottom:4px;">
                                <span class="layer-badge layer-badge-{{ $layer['type'] }}" style="font-size:0.65rem;">
                                    {{ $layer['type'] }}/{{ $layer['source_type'] }}
                                </span>
                                <div class="layer-actions">
                                    <button wire:click="moveLayerUp({{ $index }})" title="Move up" style="font-size:0.8rem;">↑</button>
                                    <button wire:click="moveLayerDown({{ $index }})" title="Move down" style="font-size:0.8rem;">↓</button>
                                    <button wire:click="removeLayer({{ $index }})" class="btn-remove" title="Remove" style="font-size:0.8rem;">×</button>
                                </div>
                            </div>

                            @if ($layer['type'] === 'text')
                                @if ($layer['source_type'] === 'auto')
                                    <select wire:model="layers.{{ $index }}.method_name" class="fb-input" style="margin-bottom:4px;font-size:0.8rem;">
                                        <option value="">Select method...</option>
                                        @foreach ($availableMethods as $key => $label)
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                @elseif ($layer['source_type'] === 'dob')
                                    <input wire:model="layers.{{ $index }}.prompt_label" type="text" class="fb-input" placeholder="Label e.g. Your date of birth" style="margin-bottom:4px;font-size:0.8rem;">
                                    <div style="display:flex;align-items:center;gap:6px;margin-top:4px;">
                                        <span style="font-size:0.65rem;color:var(--fb-text-secondary);white-space:nowrap;">User picks:</span>
                                        <input wire:model="layers.{{ $index }}.content" type="date" class="fb-input" style="font-size:0.75rem;flex:1;padding:4px 6px;">
                                    </div>
                                @elseif ($layer['source_type'] === 'manual')
                                    <input wire:model="layers.{{ $index }}.prompt_label" type="text" class="fb-input" placeholder="Label e.g. Enter your name" style="margin-bottom:4px;font-size:0.8rem;">
                                    <div style="display:flex;align-items:center;gap:6px;margin-top:4px;">
                                        <span style="font-size:0.65rem;color:var(--fb-text-secondary);white-space:nowrap;">User enters:</span>
                                        <input wire:model="layers.{{ $index }}.content" type="text" class="fb-input" placeholder="Sample value for preview" style="font-size:0.75rem;flex:1;padding:4px 6px;">
                                    </div>
                                @endif
                            @elseif ($layer['type'] === 'image')
                                @if ($layer['source_type'] === 'auto')
                                    <select wire:model="layers.{{ $index }}.method_name" class="fb-input" style="margin-bottom:4px;font-size:0.8rem;">
                                        <option value="">Select method...</option>
                                        @foreach ($availableMethods as $key => $label)
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input wire:model="layers.{{ $index }}.prompt_label" type="text" class="fb-input" placeholder='Prompt label e.g. "Upload your photo"' style="margin-bottom:4px;font-size:0.8rem;">
                                @endif
                            @endif

                            @if ($layer['type'] === 'image')
                            <div class="editor-grid-2" style="gap:4px;margin-top:4px;">
                                <div>
                                    <label style="font-size:0.6rem;color:var(--fb-text-secondary);">W</label>
                                    <input wire:model="layers.{{ $index }}.w" type="number" class="fb-input" style="font-size:0.7rem;padding:4px 6px;" placeholder="auto">
                                </div>
                                <div>
                                    <label style="font-size:0.6rem;color:var(--fb-text-secondary);">H</label>
                                    <input wire:model="layers.{{ $index }}.h" type="number" class="fb-input" style="font-size:0.7rem;padding:4px 6px;" placeholder="auto">
                                </div>
                            </div>
                            <div class="editor-grid-2" style="gap:4px;margin-top:4px;">
                                <div>
                                    <label style="font-size:0.6rem;color:var(--fb-text-secondary);">Rotation (deg)</label>
                                    <input wire:model="layers.{{ $index }}.rotation" type="number" class="fb-input" style="font-size:0.7rem;padding:4px 6px;" placeholder="0" min="-360" max="360">
                                </div>
                                <div>
                                    <label style="font-size:0.6rem;color:var(--fb-text-secondary);">Shape Filter</label>
                                    <select wire:model="layers.{{ $index }}.shape_filter" class="fb-input" style="font-size:0.7rem;padding:4px 6px;">
                                        <option value="">None</option>
                                        <option value="circle">Circle</option>
                                    </select>
                                </div>
                            </div>
                            @endif

                            <div class="editor-grid-4" style="gap:4px;margin-top:4px;">
                                <div>
                                    <label style="font-size:0.6rem;color:var(--fb-text-secondary);">X</label>
                                    <input wire:model="layers.{{ $index }}.x" type="number" class="fb-input" style="font-size:0.7rem;padding:4px 6px;">
                                </div>
                                <div>
                                    <label style="font-size:0.6rem;color:var(--fb-text-secondary);">Y</label>
                                    <input wire:model="layers.{{ $index }}.y" type="number" class="fb-input" style="font-size:0.7rem;padding:4px 6px;">
                                </div>
                                @if ($layer['type'] !== 'image')
                                <div>
                                    <label style="font-size:0.6rem;color:var(--fb-text-secondary);">Size</label>
                                    <input wire:model="layers.{{ $index }}.font_size" type="number" class="fb-input" style="font-size:0.7rem;padding:4px 6px;">
                                </div>
                                <div>
                                    <label style="font-size:0.6rem;color:var(--fb-text-secondary);">Color</label>
                                    <input wire:model="layers.{{ $index }}.font_color" type="color" class="color-input" style="height:26px;">
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right Side: Preview --}}
        <div class="editor-preview">
            <div class="editor-card">
                <h2 class="editor-title">Preview</h2>
                @if ($previewImage)
                    <img src="{{ $previewImage }}" class="canvas-preview">
                @else
                    <div class="canvas-empty">Click "Preview" to render</div>
                @endif
                <button wire:click="generatePreview" class="fb-btn fb-btn-sm" style="width:100%;margin-top:8px;">
                    <span wire:loading.remove wire:target="generatePreview">👁️ Preview</span>
                    <span wire:loading wire:target="generatePreview">...</span>
                </button>
            </div>
        </div>
    </div>
</div>
