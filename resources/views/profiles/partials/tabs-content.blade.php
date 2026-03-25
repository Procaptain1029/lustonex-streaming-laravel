<div class="content-tabs">
    <div class="tab-item active" data-tab="photos" style="font-size: 0.9rem;"><i class="fas fa-images" style="font-size: 0.85rem;"></i> {{ __('profiles.tabs.photos') }}</div>
    <div class="tab-item" data-tab="videos" style="font-size: 0.9rem;"><i class="fas fa-video" style="font-size: 0.85rem;"></i> {{ __('profiles.tabs.videos') }}</div>
   
    <div class="tab-item" data-tab="about" style="font-size: 0.9rem;"><i class="fas fa-address-card" style="font-size: 0.85rem;"></i> {{ __('profiles.tabs.bio') }}</div>
</div>

<div id="photos-pane" class="tab-pane active" >
    <div class="media-grid">
        @forelse($photos as $photo)
            <div class="media-card" data-id="{{ $photo->id }}" @if($canViewContent || $photo->is_public) onclick="openPhotoModal('{{ $photo->url }}', {{ $photo->id }}, {{ auth()->check() && $photo->isLikedBy(auth()->id()) ? 'true' : 'false' }}, {{ $photo->likes()->count() }})" style="cursor: pointer;" @endif>
                @if($canViewContent || $photo->is_public)
                    <img src="{{ $photo->url }}">
                @else
                    <img src="{{ $photo->url }}" style="filter: blur(40px);">
                    <div class="lock-overlay">
                        <i class="fas fa-lock fa-2x"></i>
                        <span style="font-weight: 800; font-size: 0.8rem; text-transform: uppercase;">Suscríbete para ver el
                            contenido premium</span>
                    </div>
                @endif

                <div class="media-actions">
                    <button class="btn-media-heart {{ auth()->check() && $photo->isLikedBy(auth()->id()) ? 'active' : '' }}"
                        onclick="toggleMediaLike(event, 'photo', {{ $photo->id }}, this)">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="media-likes-count">
                    <i class="fas fa-heart" style="font-size: 0.6rem;"></i>
                    <span class="count">{{ $photo->likes()->count() }}</span>
                </div>
            </div>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 4rem; color: #555;">
                <i class="fas fa-camera fa-3x mb-4"></i>
                <p>{{ __('profiles.content.no_photos') }}</p>
            </div>
        @endforelse
    </div>
</div>

<div id="videos-pane" class="tab-pane" style="display: none; min-height: 400px;">
    <div class="media-grid">
        @forelse($videos as $video)
            <div class="media-card" style="cursor: pointer;" @if($canViewContent || $video->is_public)
            onclick="openVideoModal('{{ $video->url }}')" @endif>
                @if($canViewContent || $video->is_public)
                    <img src="{{ $video->thumbnail_url ?? asset('images/video-placeholder.jpg') }}">
                    <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-play-circle fa-3x" style="color: white; opacity: 0.8;"></i>
                    </div>
                @else
                    <img src="{{ $video->thumbnail_url ?? asset('images/video-placeholder.jpg') }}" style="filter: blur(40px);">
                    <div class="lock-overlay">
                        <i class="fas fa-lock fa-2x"></i>
                        <span style="font-weight: 800; font-size: 0.8rem; text-transform: uppercase;">{{ __('profiles.content.subscribe_to_view') }}</span>
                    </div>
                @endif

                <div class="media-actions">
                    <button class="btn-media-heart {{ auth()->check() && $video->isLikedBy(auth()->id()) ? 'active' : '' }}"
                        onclick="toggleMediaLike(event, 'video', {{ $video->id }}, this)">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="media-likes-count">
                    <i class="fas fa-heart" style="font-size: 0.6rem;"></i>
                    <span class="count">{{ $video->likes()->count() }}</span>
                </div>
            </div>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 4rem; color: #555;">
                <i class="fas fa-film fa-3x mb-4"></i>
                <p>{{ __('profiles.content.no_videos') }}</p>
            </div>
        @endforelse
    </div>
</div>



<div id="about-pane" class="tab-pane" style="display: none; min-height: 400px;">
    <div class="sidebar-widget">
        <div class="widget-title"><i class="fas fa-user"></i> {{ __('profiles.tabs.bio') }}</div>
        <p style="line-height: 1.8; color: rgba(255,255,255,0.8);">
            {{ $model->profile->bio ?? __('profiles.content.no_bio') }}
        </p>

        <div style="margin-top: 2rem; display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            @if($model->profile->age)
                <div>
                    <span style="color: rgba(255,255,255,0.4); font-size: 0.8rem; display: block;">{{ __('profiles.content.age') }}</span>
                    <span style="font-weight: 700;">{{ __('profiles.content.age_years', ['age' => $model->profile->age]) }}</span>
                </div>
            @endif
            @if($model->profile->country)
                <div>
                    <span style="color: rgba(255,255,255,0.4); font-size: 0.8rem; display: block;">{{ __('profiles.content.country') }}</span>
                    <span style="font-weight: 700;">{{ $model->profile->country_display }}</span>
                </div>
            @endif
        </div>
    </div>
</div>




<div id="videoModal"
    style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,0.95); justify-content: center; align-items: center;">
    <button onclick="closeVideoModal()"
        style="position: absolute; top: 20px; right: 20px; color: white; background: none; border: none; font-size: 2rem; cursor: pointer; z-index: 10000;">
        <i class="fas fa-times"></i>
    </button>
    <div style="width: 90%; max-width: 1000px; aspect-ratio: 16/9;">
        <video id="modalVideoPlayer" controls
            style="width: 100%; height: 100%; border-radius: 12px; box-shadow: 0 0 50px rgba(212, 175, 55, 0.2);">
            <source src="" type="video/mp4">
            {{ __('profiles.content.browser_no_video') }}
        </video>
    </div>
</div>

<!-- Photo Modal -->
<div id="photoModal"
    style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,0.95); justify-content: center; align-items: center;">
    <button onclick="closePhotoModal()"
        style="position: absolute; top: 20px; right: 20px; color: white; background: none; border: none; font-size: 2rem; cursor: pointer; z-index: 10000; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
        <i class="fas fa-times"></i>
    </button>
    
    <div style="width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 20px;">
        <div style="position: relative; max-width: 100%; max-height: 85vh;">
            <img id="modalPhotoViewer" src="" 
                style="max-width: 100%; max-height: 85vh; object-fit: contain; border-radius: 8px; box-shadow: 0 0 50px rgba(0,0,0,0.5); cursor: pointer;">
            <div id="modalHeartOverlay" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) scale(0); color: #ff4d4d; font-size: 8rem; pointer-events: none; transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); opacity: 0; z-index: 100;">
                <i class="fas fa-heart"></i>
            </div>
        </div>
        
        <div id="modalLikeSection" style="margin-top: 20px; display: flex; align-items: center; gap: 15px; z-index: 10000;">
            <button id="modalLikeBtn" class="btn-media-heart" onclick="toggleModalLike(event)" style="position: static; transform: none; width: 50px; height: 50px; font-size: 1.5rem;">
                <i class="fas fa-heart"></i>
            </button>
            <div style="color: white; font-weight: 600; font-size: 1.2rem;">
                <span id="modalLikesCount">0</span> {{ __('profiles.content.likes') }}
            </div>
        </div>
    </div>
</div>

<script>
    function openVideoModal(videoUrl) {
        const modal = document.getElementById('videoModal');
        const player = document.getElementById('modalVideoPlayer');

        player.src = videoUrl;
        modal.style.display = 'flex';
        player.play();

        // Prevent body scrolling
        document.body.style.overflow = 'hidden';
    }

    function closeVideoModal() {
        const modal = document.getElementById('videoModal');
        const player = document.getElementById('modalVideoPlayer');

        player.pause();
        player.src = '';
        modal.style.display = 'none';

        // Restore body scrolling
        document.body.style.overflow = 'auto';
    }

    // Photo Modal logic
    let currentModalPhotoId = null;

    function openPhotoModal(photoUrl, photoId, isLiked, likesCount) {
        const modal = document.getElementById('photoModal');
        const img = document.getElementById('modalPhotoViewer');
        const likeBtn = document.getElementById('modalLikeBtn');
        const countSpan = document.getElementById('modalLikesCount');

        currentModalPhotoId = photoId;
        img.src = photoUrl;
        
        // Sync with grid state in case it changed since page load
        const gridCard = document.querySelector(`.media-card[data-id="${photoId}"]`);
        if (gridCard) {
            const gridLikeBtn = gridCard.querySelector('.btn-media-heart');
            const gridCountSpan = gridCard.querySelector('.media-likes-count .count');
            if (gridLikeBtn) isLiked = gridLikeBtn.classList.contains('active');
            if (gridCountSpan) likesCount = gridCountSpan.innerText;
        }

        if (photoId) {
            document.getElementById('modalLikeSection').style.display = 'flex';
            if (isLiked) {
                likeBtn.classList.add('active');
            } else {
                likeBtn.classList.remove('active');
            }
            countSpan.textContent = likesCount;
        } else {
            document.getElementById('modalLikeSection').style.display = 'none';
        }

        modal.style.display = 'flex';

        // Prevent body scrolling
        document.body.style.overflow = 'hidden';
    }
    
    function toggleModalLike(event) {
        if(event) event.stopPropagation();
        if(!currentModalPhotoId) return;
        
        const btn = document.getElementById('modalLikeBtn');
        
        // Use the global function defined in show.blade.php
        // It now handles syncing all instances (grid + modal) automatically
        toggleMediaLike(event, 'photo', currentModalPhotoId, btn);
    }

    function closePhotoModal() {
        const modal = document.getElementById('photoModal');
        const img = document.getElementById('modalPhotoViewer');

        img.src = '';
        currentModalPhotoId = null;
        modal.style.display = 'none';

        // Restore body scrolling
        document.body.style.overflow = 'auto';
    }

    function handlePhotoDblClick(event) {
        toggleModalLike(event);
        
        // Visual feedback
        const overlay = document.getElementById('modalHeartOverlay');
        if (overlay) {
            overlay.style.transform = 'translate(-50%, -50%) scale(1.2)';
            overlay.style.opacity = '1';
            
            setTimeout(() => {
                overlay.style.transform = 'translate(-50%, -50%) scale(0)';
                overlay.style.opacity = '0';
            }, 500);
        }
    }

    // Detectar doble clic/tap en la imagen del modal
    (function() {
        let lastTap = 0;
        const img = document.getElementById('modalPhotoViewer');
        
        const handleTap = function(e) {
            const currentTime = new Date().getTime();
            const tapLength = currentTime - lastTap;
            if (tapLength < 300 && tapLength > 0) {
                handlePhotoDblClick(e);
                // Prevenir que el segundo tap se convierta en un click fantasma
                if (e.type === 'touchend') e.preventDefault();
            }
            lastTap = currentTime;
        };

        img.addEventListener('click', handleTap);
        img.addEventListener('touchend', handleTap);
    })();

    // Close on click outside
    document.getElementById('videoModal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeVideoModal();
        }
    });

    document.getElementById('photoModal').addEventListener('click', function (e) {
        if (e.target === this) {
            closePhotoModal();
        }
    });

    // Close on escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeVideoModal();
            closePhotoModal();
        }
    });
</script>