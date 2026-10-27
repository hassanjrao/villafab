{{-- ══════════════════════════════════════════
     SCROLL WALKTHROUGH
     The 3D estate stays pinned behind the page while each scroll-length
     chapter moves the camera to its next stop: up the drive, round the
     grounds into dusk at the pool, through the patio doors (real interior
     photos take over there) and up over the mini golf. Without WebGL the
     same chapters crossfade between real photos instead.
══════════════════════════════════════════ --}}
@php
    $walkChapters = [
        ['id' => 'arrive', 'intro' => true,
         'bg' => 'frontend/imgs/photos-for-vrbo/villa-fabulosa-pool-01-hero.webp'],
        ['id' => 'drive', 'kicker' => 'The arrival', 'title' => 'Up the private drive',
         'text' => 'A private drive climbs to the gated estate, with parking beside the house and two Tesla chargers waiting.',
         'bg' => 'frontend/imgs/villa-fabulosa-aerial-view-108.webp', 'thumb' => 'frontend/imgs/villa-fabulosa-aerial-view-108-thumb.webp',
         'alt' => 'Aerial view of the drive and the walled estate', 'href' => '/birds-eye', 'link' => 'See it from above'],
        ['id' => 'court', 'kicker' => 'Game on', 'title' => 'The sports court',
         'text' => 'A full sports court for basketball, pickleball, volleyball and badminton, right beside the lawn.',
         'bg' => 'frontend/imgs/villa-fabulosa-sports-field-38.webp', 'thumb' => 'frontend/imgs/villa-fabulosa-sports-field-38-thumb.webp',
         'alt' => 'Blue sports court with Villa Fabulosa lettering at dusk', 'href' => '/the-sports-area', 'link' => 'See the sports area'],
        ['id' => 'lawn', 'kicker' => 'Out on the lawn', 'title' => 'Bocce, putting and volleyball',
         'text' => 'Bocce lanes, a putting green and a volleyball net, with 360-degree views across wine country.',
         'bg' => 'frontend/imgs/villa-fabulosa-sports-field-40.webp', 'thumb' => 'frontend/imgs/villa-fabulosa-sports-field-40-thumb.webp',
         'alt' => 'Putting green on the lawn beside the villa', 'href' => '/the-sports-area', 'link' => 'See the lawn'],
        ['id' => 'pool', 'kicker' => 'Golden hour', 'title' => 'The pool & 14-person spa',
         'text' => 'A designer pool with dual Baja shelves and in-pool loungers. As the sun goes down, the water lights up.',
         'bg' => 'frontend/imgs/photos-for-vrbo/villa-fabulosa-2-pool.webp', 'thumb' => 'frontend/imgs/photos-for-vrbo/villa-fabulosa-2-pool-thumb.webp',
         'alt' => 'Lit pool with in-pool loungers at dusk', 'href' => '/the-pool', 'link' => 'See the pool'],
        ['id' => 'pavilion', 'kicker' => 'Evenings', 'title' => 'The poolside pavilion',
         'text' => 'Settle into the covered lounge and watch the sky change over the hills.',
         'bg' => 'frontend/imgs/photos-for-vrbo/villa-fabulosa-pergola.webp', 'thumb' => 'frontend/imgs/photos-for-vrbo/villa-fabulosa-pergola-thumb.webp',
         'alt' => 'Covered pavilion lounge beside the pool', 'href' => '/the-pool', 'link' => 'See the pavilion'],
        ['id' => 'kitchen', 'kicker' => 'Dinner outside', 'title' => 'Outdoor kitchen & bar',
         'text' => 'Pizza ovens, a teppanyaki grill and a BBQ station, with bar seats facing the pool.',
         'bg' => 'frontend/imgs/villa-fabulosa-pool-13-2.webp', 'thumb' => 'frontend/imgs/villa-fabulosa-pool-13-2-thumb.webp',
         'alt' => 'Outdoor kitchen and bar beside the pool at dusk', 'href' => '/the-pool', 'link' => 'See the pool area'],
        ['id' => 'living', 'interior' => true, 'kicker' => 'Step inside', 'title' => 'A brand-new Ibiza-style home',
         'text' => 'The living room rises to a 22-foot ceiling around an impressive fireplace.',
         'bg' => 'frontend/imgs/photos-for-vrbo/villa-fabulosa-living-room-06.webp', 'href' => '/the-rooms', 'link' => 'See the rooms'],
        ['id' => 'dining', 'interior' => true, 'kicker' => 'Gather', 'title' => 'Chef’s kitchen & dining for 16',
         'text' => 'Two dishwashers, ice makers and every cooking gadget imaginable, with two dining tables seating 16.',
         'bg' => 'frontend/imgs/photos-for-vrbo/villa-fabulosa-7-kitchen.webp', 'href' => '/the-rooms', 'link' => 'See the kitchen'],
        ['id' => 'bedrooms', 'interior' => true, 'kicker' => 'Rest', 'title' => '7 bedrooms, 12 beds',
         'text' => 'Room for up to 24 guests, plus a bridal suite for getting ready before the big day.',
         'bg' => 'frontend/imgs/photos-for-vrbo/villa-fabulosa-54-bedroom.webp', 'href' => '/the-rooms', 'link' => 'See the bedrooms'],
        ['id' => 'game', 'interior' => true, 'kicker' => 'Play', 'title' => 'The game room',
         'text' => 'A full arcade, professional pool table, poker table, shuffleboard and air hockey.',
         'bg' => 'frontend/imgs/photos-for-vrbo/villa-fabulosa-5-arcade.webp', 'href' => '/game-rooms', 'link' => 'See the game room'],
        ['id' => 'golf', 'kicker' => 'One more thing', 'title' => '18-hole miniature golf',
         'text' => 'A professional course on its own hillside terrace.',
         'bg' => 'frontend/imgs/photos-for-vrbo/villa-fabulosa-mini-golf-11.webp', 'thumb' => 'frontend/imgs/photos-for-vrbo/villa-fabulosa-mini-golf-11-thumb.webp',
         'alt' => 'Aerial view of the 18-hole miniature golf course', 'href' => '/miniature-golf-course', 'link' => 'See the course'],
        ['id' => 'finale', 'finale' => true,
         'bg' => 'frontend/imgs/photos-for-vrbo/villa-fabulosa-aerial-view-13.webp'],
    ];
    $walkStops = array_values(array_filter($walkChapters, fn ($c) => empty($c['intro']) && empty($c['finale'])));
@endphp

<style>
    .estate-walk {
        --nav: 72px;
        --navy: #0b1430;
        --gold: #f0c27a;
        position: relative;
        background: var(--navy);
        color: #fff;
    }

    .estate-walk__sticky {
        position: sticky;
        top: var(--nav);
        height: calc(100vh - var(--nav));
        height: calc(100svh - var(--nav));
        overflow: hidden;
        isolation: isolate;
    }

    .estate-walk__stage,
    .walk-backdrop,
    .estate-walk__canvas,
    .estate-walk__shade {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }

    .walk-backdrop {
        object-fit: cover;
        opacity: 0;
        z-index: 1;
        transform: scale(1.04);
    }

    /* Over the model, interior photos sit above the canvas. Without 3D all
       backdrops share a layer and stack in tour order. */
    .estate-walk.is-3d .walk-backdrop.is-interior {
        z-index: 3;
    }

    .estate-walk__canvas {
        display: block;
        z-index: 2;
        opacity: 0;
        transition: opacity 1.2s ease;
    }

    .estate-walk.is-3d .estate-walk__canvas {
        opacity: 1;
    }

    .estate-walk__shade {
        z-index: 4;
        pointer-events: none;
        background:
            linear-gradient(90deg, rgba(8, 12, 32, 0.72) 0%, rgba(8, 12, 32, 0.3) 34%, rgba(8, 12, 32, 0) 58%),
            linear-gradient(0deg, rgba(8, 12, 32, 0.45) 0%, rgba(8, 12, 32, 0) 30%);
    }

    .estate-walk__chapters {
        position: relative;
        z-index: 5;
        pointer-events: none;
        margin-top: calc(-100vh + var(--nav));
        margin-top: calc(-100svh + var(--nav));
    }

    /* The chapter layer scrolls over the pinned stage. Only the cards take
       the pointer, so the stop rail underneath stays clickable. */
    .walk-chapter {
        height: calc(100vh - var(--nav));
        height: calc(100svh - var(--nav));
        display: flex;
        align-items: center;
        padding: 0 clamp(20px, 5vw, 80px);
        pointer-events: none;
    }

    .walk-chapter > * {
        pointer-events: auto;
    }

    .walk-chapter--finale {
        justify-content: center;
        text-align: center;
    }

    .walk-intro,
    .walk-card {
        will-change: opacity;
    }

    .walk-intro {
        max-width: 540px;
    }

    .walk-intro__eyebrow {
        margin: 0 0 0.6rem;
        font-size: 0.85rem;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: var(--gold);
        font-weight: 700;
    }

    .walk-intro__eyebrow span {
        white-space: nowrap;
    }

    .walk-intro__title {
        margin: 0;
        font-size: clamp(2.6rem, 5.6vw, 5.2rem);
        line-height: 0.95;
        font-weight: 700;
        letter-spacing: 0.02em;
        text-shadow: 0 6px 30px rgba(0, 0, 0, 0.45);
    }

    .walk-intro__lead {
        margin: 1rem 0 1.4rem;
        font-size: 1.15rem;
        line-height: 1.5;
        color: rgba(255, 255, 255, 0.9);
        max-width: 26em;
    }

    .walk-facts {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin: 0 0 1.6rem;
        padding: 0;
        list-style: none;
    }

    .walk-facts li {
        padding: 7px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.22);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        font-size: 0.92rem;
    }

    .walk-facts strong {
        font-size: 1.05rem;
        margin-right: 3px;
    }

    .walk-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .walk-chapter--finale .walk-actions {
        justify-content: center;
    }

    .walk-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 50px;
        padding: 0 26px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }

    .walk-btn--primary {
        background: linear-gradient(180deg, #ffd796, #e9a94e);
        color: #1d1306;
        box-shadow: 0 10px 30px rgba(233, 169, 78, 0.35);
    }

    .walk-btn--primary:hover,
    .walk-btn--primary:focus-visible {
        color: #1d1306;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .walk-btn--ghost {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
        border-color: rgba(255, 255, 255, 0.45);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .walk-btn--ghost:hover,
    .walk-btn--ghost:focus-visible {
        background: rgba(255, 255, 255, 0.18);
    }

    .walk-card {
        max-width: 430px;
        padding: 24px 26px 24px;
        border-radius: 20px;
        background: rgba(11, 20, 48, 0.66);
        border: 1px solid rgba(255, 255, 255, 0.16);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        box-shadow: 0 30px 60px rgba(4, 8, 24, 0.35);
    }

    .walk-chapter--finale .walk-card {
        max-width: 560px;
    }

    .walk-card__kicker {
        margin: 0 0 6px;
        font-size: 0.8rem;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--gold);
        font-weight: 700;
    }

    .walk-card__kicker span {
        color: rgba(255, 255, 255, 0.6);
        margin-right: 6px;
    }

    .walk-card__title {
        margin: 0 0 8px;
        font-size: clamp(1.6rem, 2.6vw, 2.2rem);
        font-weight: 700;
        line-height: 1.1;
    }

    .walk-card__text {
        margin: 0 0 14px;
        font-size: 1.05rem;
        line-height: 1.55;
        color: rgba(255, 255, 255, 0.88);
    }

    .walk-card__thumb {
        display: none;
        width: 100%;
        height: auto;
        aspect-ratio: 3 / 2;
        object-fit: cover;
        border-radius: 12px;
        margin: 0 0 14px;
    }

    /* Over the model, each outdoor stop also shows its real photo. */
    .estate-walk.is-3d .walk-card__thumb {
        display: block;
    }

    .walk-card__link {
        font-weight: 700;
        color: var(--gold);
    }

    .walk-card__link:hover,
    .walk-card__link:focus-visible {
        color: #ffe2b0;
    }

    .walk-card__link::after {
        content: " \2192";
    }

    .walk-btn:focus-visible,
    .walk-card__link:focus-visible,
    .walk-rail button:focus-visible {
        outline: 3px solid var(--gold);
        outline-offset: 3px;
    }

    /* Stop rail: where you are, and a way to jump between stops. */
    .walk-rail {
        position: absolute;
        right: clamp(14px, 2.4vw, 34px);
        top: 50%;
        transform: translateY(-50%);
        z-index: 6;
    }

    .walk-rail ol {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 4px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .walk-rail button {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        min-height: 30px;
        padding: 0 4px 0 12px;
        border: 0;
        background: none;
        color: #fff;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
    }

    .walk-rail__label {
        padding: 4px 10px;
        border-radius: 999px;
        background: rgba(11, 20, 48, 0.72);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        white-space: nowrap;
        opacity: 0;
        transform: translateX(6px);
        transition: opacity 0.2s ease, transform 0.2s ease;
        pointer-events: none;
    }

    .walk-rail button:hover .walk-rail__label,
    .walk-rail button:focus-visible .walk-rail__label,
    .walk-rail button[aria-current="step"] .walk-rail__label {
        opacity: 1;
        transform: none;
    }

    .walk-rail__dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.8);
        transition: background 0.2s ease, transform 0.2s ease;
    }

    .walk-rail button:hover .walk-rail__dot,
    .walk-rail button:focus-visible .walk-rail__dot {
        background: #fff;
        transform: scale(1.3);
    }

    .walk-rail button[aria-current="step"] .walk-rail__dot {
        background: var(--gold);
        border-color: var(--gold);
        transform: scale(1.3);
    }

    .walk-progress {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 3px;
        z-index: 6;
        background: rgba(255, 255, 255, 0.15);
    }

    .walk-progress span {
        display: block;
        height: 100%;
        background: var(--gold);
        transform-origin: left;
        transform: scaleX(0);
    }

    .walk-hint {
        position: absolute;
        left: 50%;
        bottom: 22px;
        z-index: 6;
        transform: translateX(-50%);
        margin: 0;
        font-size: 0.85rem;
        letter-spacing: 0.08em;
        text-align: center;
        color: rgba(255, 255, 255, 0.85);
        transition: opacity 0.4s ease;
        pointer-events: none;
    }

    .walk-hint::after {
        content: "";
        display: block;
        width: 12px;
        height: 12px;
        margin: 8px auto 0;
        border-right: 2px solid currentColor;
        border-bottom: 2px solid currentColor;
        transform: rotate(45deg);
        animation: walk-nudge 1.8s ease-in-out infinite;
    }

    @keyframes walk-nudge {
        50% { transform: translateY(6px) rotate(45deg); }
    }

    .walk-note {
        position: absolute;
        right: clamp(14px, 2.4vw, 34px);
        bottom: 14px;
        z-index: 6;
        margin: 0;
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.65);
    }

    @media (prefers-reduced-motion: reduce) {
        .walk-hint::after,
        .estate-walk__canvas {
            animation: none;
            transition: none;
        }
    }

    @media (max-width: 991.98px) {
        .estate-walk {
            --nav: 64px;
        }

        .walk-rail {
            display: none;
        }

        .estate-walk__shade {
            background: linear-gradient(0deg, rgba(8, 12, 32, 0.82) 0%, rgba(8, 12, 32, 0.25) 45%, rgba(8, 12, 32, 0) 65%);
        }

        .walk-chapter {
            align-items: flex-end;
            padding: 0 14px 22px;
        }

        .walk-chapter--intro {
            padding-bottom: 64px;
        }

        .walk-intro {
            padding: 20px 18px;
            border-radius: 20px;
            background: rgba(11, 20, 48, 0.66);
            border: 1px solid rgba(255, 255, 255, 0.16);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .walk-intro__title {
            font-size: 2.4rem;
        }

        .walk-intro__lead {
            font-size: 1rem;
            margin: 0.7rem 0 1rem;
        }

        .walk-facts {
            margin-bottom: 1rem;
        }

        .walk-hint {
            bottom: 14px;
        }

        .walk-chapter--finale {
            align-items: center;
        }

        .walk-card {
            max-width: none;
            width: 100%;
            padding: 18px 18px 18px;
        }

        .walk-card__text {
            font-size: 0.95rem;
            margin-bottom: 10px;
        }

        .walk-note {
            display: none;
        }
    }

    @media (min-width: 992px) {
        .walk-progress {
            display: none;
        }
    }

    @media (max-width: 575.98px) {
        .estate-walk.is-3d .walk-card__thumb {
            display: none;
        }

        .walk-intro__eyebrow {
            font-size: 0.75rem;
            letter-spacing: 0.14em;
        }

        .walk-facts {
            gap: 6px;
        }

        .walk-facts li {
            font-size: 0.8rem;
            padding: 4px 10px;
        }

        .walk-facts strong {
            font-size: 0.92rem;
        }

        .walk-actions {
            gap: 8px;
        }

        .walk-btn {
            flex: 1 1 0;
            min-height: 46px;
            padding: 0 12px;
            font-size: 0.92rem;
            white-space: nowrap;
        }
    }
</style>

<section class="estate-walk" id="estateWalk" aria-labelledby="estateWalkTitle"
    data-module="{{ \App\Support\Seo::versioned('frontend/js/villa-estate-3d.js') }}">

    <div class="estate-walk__sticky">
        <div class="estate-walk__stage" id="walkStage">
            @foreach ($walkChapters as $i => $chapter)
                <img class="walk-backdrop{{ !empty($chapter['interior']) ? ' is-interior' : '' }}" alt="" aria-hidden="true" decoding="async"
                    @if ($i === 0) src="{{ asset($chapter['bg']) }}" fetchpriority="high" style="opacity:1" @else data-src="{{ asset($chapter['bg']) }}" @endif>
            @endforeach
        </div>
        <div class="estate-walk__shade" aria-hidden="true"></div>

        <div class="walk-progress" aria-hidden="true"><span id="walkProgressBar"></span></div>

        <nav class="walk-rail" aria-label="Tour stops">
            <ol>
                @foreach ($walkChapters as $i => $chapter)
                    @php $label = $chapter['title'] ?? (!empty($chapter['intro']) ? 'Welcome' : 'Book your stay'); @endphp
                    <li>
                        <button type="button" data-goto="{{ $i }}" aria-label="Go to: {{ $label }}">
                            <span class="walk-rail__label" aria-hidden="true">{{ $label }}</span>
                            <span class="walk-rail__dot" aria-hidden="true"></span>
                        </button>
                    </li>
                @endforeach
            </ol>
        </nav>

        <p class="walk-hint" id="walkHint">Scroll to walk the estate</p>
        <p class="walk-note" id="walkNote" hidden>Illustrative 3D model, not to scale</p>
    </div>

    <div class="estate-walk__chapters">
        @foreach ($walkChapters as $i => $chapter)
            @if (!empty($chapter['intro']))
                <div class="walk-chapter walk-chapter--intro" data-chapter-id="{{ $chapter['id'] }}">
                    <div class="walk-intro">
                        <p class="walk-intro__eyebrow"><span>Temecula Wine Country</span> <span aria-hidden="true">&middot;</span> <span>Private 5&#8209;acre estate</span></p>
                        <h1 class="walk-intro__title" id="estateWalkTitle">Villa Fabulosa</h1>
                        <p class="walk-intro__lead">Take a walk through the estate before you arrive: round the grounds as the sun sets, then step inside.</p>
                        <ul class="walk-facts">
                            <li><strong>24</strong> guests</li>
                            <li><strong>7</strong> bedrooms</li>
                            <li><strong>12</strong> beds</li>
                            <li><strong>5.5</strong> baths</li>
                        </ul>
                        <div class="walk-actions">
                            <a href="#book" class="walk-btn walk-btn--primary">Check availability</a>
                            <button type="button" class="walk-btn walk-btn--ghost" onclick="openPhotoTour()">Show all photos</button>
                        </div>
                    </div>
                </div>
            @elseif (!empty($chapter['finale']))
                <div class="walk-chapter walk-chapter--finale" data-chapter-id="{{ $chapter['id'] }}">
                    <div class="walk-card">
                        <p class="walk-card__kicker">Your stay</p>
                        <h2 class="walk-card__title">Ready to visit for real?</h2>
                        <p class="walk-card__text">Check your dates and book direct with the hosts.</p>
                        <div class="walk-actions">
                            <a href="#book" class="walk-btn walk-btn--primary">Check availability</a>
                            <button type="button" class="walk-btn walk-btn--ghost" onclick="openPhotoTour()">Show all photos</button>
                        </div>
                    </div>
                </div>
            @else
                <article class="walk-chapter" data-chapter-id="{{ $chapter['id'] }}" aria-labelledby="walk-{{ $chapter['id'] }}">
                    <div class="walk-card">
                        <p class="walk-card__kicker"><span>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</span>{{ $chapter['kicker'] }}</p>
                        <h2 class="walk-card__title" id="walk-{{ $chapter['id'] }}">{{ $chapter['title'] }}</h2>
                        <p class="walk-card__text">{{ $chapter['text'] }}</p>
                        @if (!empty($chapter['thumb']))
                            <img class="walk-card__thumb" src="{{ asset($chapter['thumb']) }}" alt="{{ $chapter['alt'] }}" width="640" height="427" loading="lazy" decoding="async">
                        @endif
                        <a class="walk-card__link" href="{{ url($chapter['href']) }}">{{ $chapter['link'] }}</a>
                    </div>
                </article>
            @endif
        @endforeach
    </div>
</section>

<script>
    (function () {
        var walk = document.getElementById('estateWalk');
        if (!walk) return;

        var sticky = walk.querySelector('.estate-walk__sticky');
        var stage = document.getElementById('walkStage');
        var chapters = Array.prototype.slice.call(walk.querySelectorAll('.walk-chapter'));
        var panels = chapters.map(function (c) { return c.firstElementChild; });
        var backdrops = Array.prototype.slice.call(stage.querySelectorAll('.walk-backdrop'));
        var railButtons = Array.prototype.slice.call(walk.querySelectorAll('.walk-rail button'));
        var bar = document.getElementById('walkProgressBar');
        var hint = document.getElementById('walkHint');
        var note = document.getElementById('walkNote');
        var ids = chapters.map(function (c) { return c.dataset.chapterId; });
        var last = chapters.length - 1;
        var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var api = null;
        var k = 0;
        var queued = false;
        var activeStop = -1;

        // The last index of each run of interior chapters, so an interior
        // photo stays up while the next one fades in over it.
        var runEnd = backdrops.map(function (img, i) {
            if (!img.classList.contains('is-interior')) return i;
            var j = i;
            while (backdrops[j + 1] && backdrops[j + 1].classList.contains('is-interior')) j++;
            return j;
        });

        function clamp01(x) { return Math.min(Math.max(x, 0), 1); }

        // Pin the stage directly under the fixed navbar, whatever its height
        // at this breakpoint.
        var mainNav = document.getElementById('mainNav');
        function syncNav() {
            if (mainNav) walk.style.setProperty('--nav', mainNav.offsetHeight + 'px');
        }
        syncNav();
        window.addEventListener('resize', syncNav);

        function navOffset() {
            return parseFloat(getComputedStyle(sticky).top) || 0;
        }

        // Chapter position: 0 when the first chapter fills the stage, 1 when
        // the second does, and so on.
        function measure() {
            var h = sticky.clientHeight || 1;
            return Math.min(Math.max((navOffset() - walk.getBoundingClientRect().top) / h, 0), last);
        }

        function update() {
            queued = false;
            k = measure();
            if (api) api.setProgress(k);
            var is3d = walk.classList.contains('is-3d');

            backdrops.forEach(function (img, i) {
                var interior = img.classList.contains('is-interior');
                var opacity = 0;
                if (!is3d || interior) {
                    var fadeIn = i === 0 ? 1 : clamp01((k - i + 0.5) * 2.5);
                    var fadeOut = (is3d && interior) ? clamp01((runEnd[i] + 0.6 - k) * 2.5) : 1;
                    opacity = fadeIn * fadeOut;
                }
                if (opacity > 0 || Math.abs(k - i) < 1.6) {
                    if (!img.getAttribute('src') && img.dataset.src) img.src = img.dataset.src;
                }
                img.style.opacity = opacity.toFixed(3);
                if (!reduceMotion) img.style.transform = 'scale(' + (1.04 + clamp01(k - i + 0.5) * 0.06).toFixed(4) + ')';
            });

            panels.forEach(function (panel, i) {
                panel.style.opacity = clamp01(1.3 - Math.abs(k - i) * 1.9).toFixed(3);
            });

            var stop = Math.round(k);
            if (stop !== activeStop) {
                activeStop = stop;
                railButtons.forEach(function (b, i) {
                    if (i === stop) b.setAttribute('aria-current', 'step');
                    else b.removeAttribute('aria-current');
                });
            }
            bar.style.transform = 'scaleX(' + (k / last).toFixed(4) + ')';
            hint.style.opacity = k > 0.12 ? '0' : '1';
        }

        function onScroll() {
            if (!queued) {
                queued = true;
                requestAnimationFrame(update);
            }
        }
        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', onScroll);

        railButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var i = parseInt(button.dataset.goto, 10);
                var top = walk.getBoundingClientRect().top + window.pageYOffset - navOffset() + i * sticky.clientHeight;
                window.scrollTo({ top: top, behavior: reduceMotion ? 'auto' : 'smooth' });
                var heading = chapters[i].querySelector('h1, h2');
                if (heading) {
                    heading.setAttribute('tabindex', '-1');
                    heading.focus({ preventScroll: true });
                }
            });
        });

        update();

        function webglAvailable() {
            try {
                var c = document.createElement('canvas');
                return !!(window.WebGLRenderingContext && (c.getContext('webgl2') || c.getContext('webgl')));
            } catch (e) {
                return false;
            }
        }

        function boot() {
            var conn = navigator.connection;
            if ((conn && conn.saveData) || !webglAvailable()) return;
            import(walk.dataset.module).then(function (m) {
                api = m.mountEstateWalk(stage, {
                    chapters: ids,
                    progress: measure(),
                    reducedMotion: reduceMotion,
                    canvasClass: 'estate-walk__canvas',
                    onReady: function () {
                        walk.classList.add('is-3d');
                        note.hidden = false;
                        update();
                    },
                    onLost: function () {
                        walk.classList.remove('is-3d');
                        note.hidden = true;
                        api = null;
                        update();
                    }
                });
            }).catch(function (err) {
                // The photo crossfade already covers every chapter.
                if (window.console) console.warn('3D walkthrough unavailable:', err);
            });
        }

        // After load and an idle moment, so the first photo stays the LCP.
        function whenIdle(fn) {
            (window.requestIdleCallback || function (f) { setTimeout(f, 300); })(fn, { timeout: 2500 });
        }
        if (document.readyState === 'complete') whenIdle(boot);
        else window.addEventListener('load', function () { whenIdle(boot); });
    })();
</script>
