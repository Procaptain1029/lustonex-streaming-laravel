@extends('layouts.admin')

@section('title', __('admin.gamification.badges.edit.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item">Gamificación</span>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('admin.gamification.badges.index') }}" class="breadcrumb-item">{{ __('admin.gamification-2.badges.index.title_header') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">Editar</span>
@endsection

@section('styles')
    <style>
        /* ----- Badge Create/Edit Professional Styling ----- */
        .sh-page-container {
            max-width: 1000px;
            margin: 0 auto;
            padding-bottom: 80px;
        }

        .sh-form-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        }

        /* Preview Section */
        .sh-badge-preview-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 40px;
            padding: 30px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 16px;
            border: 1px dashed rgba(255, 255, 255, 0.1);
        }

        .sh-icon-preview {
            width: 120px;
            height: 120px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            margin-bottom: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .sh-name-preview {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Form Elements */
        .sh-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }

        .sh-form-group {
            margin-bottom: 24px;
        }

        .sh-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .sh-input,
        .sh-select,
        .sh-textarea {
            width: 100%;
            background: rgba(0, 0, 0, 0.2);
            /* Darker input bg */
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 12px 16px;
            color: #fff;
            font-size: 16px;
            transition: all 0.2s ease;
        }

        .sh-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .sh-input:focus,
        .sh-select:focus,
        .sh-textarea:focus {
            outline: none;
            border-color: #fff;
            background: rgba(0, 0, 0, 0.4);
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.05);
        }

        .sh-color-input {
            height: 48px;
            padding: 4px 8px;
            cursor: pointer;
        }

        /* Requirements Section */
        .sh-req-container {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 12px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sh-req-row {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 12px;
            margin-bottom: 12px;
        }

        .sh-btn-remove {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .sh-btn-remove:hover {
            background: #ef4444;
            color: #fff;
        }

        .sh-btn-add {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px dashed rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .sh-btn-add:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.3);
        }

        /* Actions */
        .sh-form-actions {
            display: flex;
            gap: 16px;
            margin-top: 40px;
        }

        .sh-btn-save {
            flex: 1;
            padding: 14px 28px;
            border-radius: 12px;
            background: var(--gradient-gold);
            color: #000 !important;
            font-weight: 800;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .sh-btn-save:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
            color: #000 !important;
        }

        .sh-btn-cancel {
            padding: 14px 24px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .sh-btn-cancel:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.2);
        }

        @media(max-width: 768px) {
            .sh-form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.gamification-2.badges.edit.title') }}</h1>
        <p class="page-subtitle">{{ __('admin.gamification-2.badges.edit.subtitle', ['name' => $badge->name]) }}</p>
    </div>

    <div class="sh-page-container">
        <div class="sh-form-card">
            <form action="{{ route('admin.gamification.badges.update', $badge->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Live Preview -->
                <div class="sh-badge-preview-container">
                    <div id="preview-icon" class="sh-icon-preview"
                        style="color: {{ $badge->color }}; background: {{ $badge->color }}1A; border: 1px solid {{ $badge->color }}4D;">
                        <i class="fas {{ $badge->icon }}"></i>
                    </div>
                    <div id="preview-name" class="sh-name-preview">{{ $badge->name }}</div>
                </div>

                <!-- Identity -->
                <div class="sh-form-grid">
                    <div class="sh-form-group">
                        <label class="sh-label">{{ __('admin.gamification-2.badges.form.name') }}</label>
                        <input type="text" name="name" class="sh-input" value="{{ old('name', $badge->name) }}" required
                            onkeyup="updatePreview(this.value, 'name')">
                    </div>
                    <div class="sh-form-group">
                        <label class="sh-label">{{ __('admin.gamification-2.badges.form.icon') }}</label>
                        <input type="text" name="icon" class="sh-input" value="{{ old('icon', $badge->icon) }}" required
                            onkeyup="updatePreview(this.value, 'icon')">
                    </div>
                </div>

                <div class="sh-form-grid">
                    <div class="sh-form-group">
                        <label class="sh-label">{{ __('admin.gamification-2.badges.form.color') }}</label>
                        <input type="color" name="color" class="sh-input sh-color-input"
                            value="{{ old('color', $badge->color) }}" onchange="updateColors(this.value)">
                    </div>
                    <div class="sh-form-group">
                        <label class="sh-label">{{ __('admin.gamification-2.badges.form.category') }}</label>
                        <select name="type" class="sh-select" required>
                            <option value="milestone" {{ $badge->type == 'milestone' ? 'selected' : '' }}>{{ __('admin.gamification-2.badges.form.categories.milestone') }}
                            </option>
                            <option value="hall_of_fame" {{ $badge->type == 'hall_of_fame' ? 'selected' : '' }}>{{ __('admin.gamification-2.badges.form.categories.hall_of_fame') }}
                            </option>
                            <option value="event" {{ $badge->type == 'event' ? 'selected' : '' }}>{{ __('admin.gamification-2.badges.form.categories.event') }}</option>
                            <option value="special" {{ $badge->type == 'special' ? 'selected' : '' }}>{{ __('admin.gamification-2.badges.form.categories.special') }}</option>
                        </select>
                    </div>
                </div>

                <div class="sh-form-group">
                    <label class="sh-label">{{ __('admin.gamification-2.badges.form.description') }}</label>
                    <textarea name="description" class="sh-textarea"
                        required>{{ old('description', $badge->description) }}</textarea>
                </div>

                <div class="sh-form-group">
                    <label class="sh-label">{{ __('admin.gamification-2.badges.form.requirements') }}</label>
                    <div class="sh-req-container" id="req-container">
                        @if($badge->requirements && is_array($badge->requirements))
                            @foreach($badge->requirements as $key => $val)
                                <div class="sh-req-row">
                                    <input type="text" name="req_key[]" class="sh-input" value="{{ $key }}" placeholder="{{ __('admin.gamification-2.badges.form.req_key_placeholder') }}">
                                    <input type="text" name="req_val[]" class="sh-input" value="{{ $val }}" placeholder="{{ __('admin.gamification-2.badges.form.req_val_placeholder') }}">
                                    <button type="button" class="sh-btn-remove" onclick="this.parentElement.remove()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="sh-req-row">
                                <input type="text" name="req_key[]" class="sh-input" placeholder="{{ __('admin.gamification-2.badges.form.req_key_placeholder') }}">
                                <input type="text" name="req_val[]" class="sh-input" placeholder="{{ __('admin.gamification-2.badges.form.req_val_placeholder') }}">
                                <button type="button" class="sh-btn-remove" onclick="this.parentElement.remove()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="sh-btn-add" onclick="addRequirement()">
                        <i class="fas fa-plus"></i> {{ __('admin.gamification-2.badges.form.add_req') }}
                    </button>
                </div>

                <div class="sh-form-group">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ $badge->is_active ? 'checked' : '' }}
                            style="width: 18px; height: 18px;">
                        <span style="color: #fff; font-weight: 600;">{{ __('admin.gamification-2.badges.form.is_active') }}</span>
                    </label>
                </div>

                <div class="sh-form-actions">
                    <a href="{{ route('admin.gamification.badges.index') }}" class="sh-btn-cancel">{{ __('admin.gamification-2.badges.form.cancel') }}</a>
                    <button type="submit" class="sh-btn-save">{{ __('admin.gamification-2.badges.form.submit_edit') }}</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updatePreview(val, type) {
            if (type === 'name') document.getElementById('preview-name').textContent = val || '{{ __('admin.gamification-2.badges.form.preview_name') }}';
            if (type === 'icon') {
                const iconConfig = val.includes('fa-') ? val : 'fa-' + val;
                document.querySelector('#preview-icon i').className = 'fas ' + iconConfig;
            }
        }

        function updateColors(color) {
            const iconBox = document.getElementById('preview-icon');
            iconBox.style.color = color;
            iconBox.style.background = color + '1A'; // 10% opacity
            iconBox.style.borderColor = color + '4D'; // 30% opacity
        }

        function addRequirement() {
            const container = document.getElementById('req-container');
            const row = document.createElement('div');
            row.className = 'sh-req-row';
            row.innerHTML = `
                <input type="text" name="req_key[]" class="sh-input" placeholder="{{ __('admin.gamification-2.badges.form.req_key_placeholder') }}">
                <input type="text" name="req_val[]" class="sh-input" placeholder="{{ __('admin.gamification-2.badges.form.req_val_placeholder') }}">
                <button type="button" class="sh-btn-remove" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(row);
        }
    </script>
@endsection