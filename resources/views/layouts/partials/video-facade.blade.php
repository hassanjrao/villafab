{{--
    Click-to-play YouTube facade.

    A YouTube iframe pulls roughly 850 KB of player JavaScript on page load,
    whether or not anyone presses play. This renders a self-hosted poster and
    only swaps in the real iframe on click, with autoplay so the click still
    starts the video in one action.

    Usage:
        @include('layouts.partials.video-facade', [
            'videoId' => 'u5zfhEQfkpk',
            'title'   => 'Tour Villa Fabulosa',
        ])

    Optional: 'ratio' (default '16by9'), 'height' (fixed px instead of ratio).
--}}
@php
    $videoId = $videoId ?? 'u5zfhEQfkpk';
    $title   = $title ?? 'Villa Fabulosa video tour';
    $height  = $height ?? null;
@endphp

{{-- Styles live in frontend/style.css so they arrive with the head and
     cannot shift the layout; only the click handler is pushed. --}}
@once
    @push('video_facade_assets')
        <script>
            document.addEventListener('click', function (e) {
                var box = e.target.closest ? e.target.closest('.yt-facade') : null;
                if (!box || box.dataset.loaded) return;

                box.dataset.loaded = '1';

                var frame = document.createElement('iframe');
                frame.src = 'https://www.youtube-nocookie.com/embed/' + box.dataset.video +
                            '?autoplay=1&rel=0';
                frame.title = box.dataset.title || 'YouTube video player';
                frame.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
                frame.allowFullscreen = true;

                box.innerHTML = '';
                box.appendChild(frame);
            });
        </script>
    @endpush
@endonce

<button type="button" class="yt-facade" data-ratio="16by9"
        data-video="{{ $videoId }}" data-title="{{ $title }}"
        aria-label="Play video: {{ $title }}"
        @if ($height) style="aspect-ratio:auto;height:{{ $height }}px;" @endif>
    <img src="{{ asset('frontend/imgs/villa-fabulosa-video-poster.webp') }}"
         srcset="{{ asset('frontend/imgs/villa-fabulosa-video-poster-sm.webp') }} 640w, {{ asset('frontend/imgs/villa-fabulosa-video-poster.webp') }} 1280w"
         sizes="(max-width: 767px) 100vw, 1000px"
         width="1280" height="720" loading="lazy" decoding="async"
         alt="{{ $title }}">
    <span class="yt-facade-play" aria-hidden="true">
        <svg viewBox="0 0 68 48"><path class="yt-bg" d="M66.52 7.74a8 8 0 0 0-5.63-5.67C55.79 1 34 1 34 1s-21.79 0-26.89 1.07a8 8 0 0 0-5.63 5.67A83.5 83.5 0 0 0 .5 24a83.5 83.5 0 0 0 .98 16.26 8 8 0 0 0 5.63 5.67C12.21 47 34 47 34 47s21.79 0 26.89-1.07a8 8 0 0 0 5.63-5.67A83.5 83.5 0 0 0 67.5 24a83.5 83.5 0 0 0-.98-16.26z"/><path d="M27 34V14l18 10z" fill="#fff"/></svg>
    </span>
</button>
