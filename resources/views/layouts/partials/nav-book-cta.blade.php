{{-- Header booking button for the redesigned home page previews. It sits
     outside the collapsing menu so it stays visible on phones, and it takes
     visitors straight into the date picker of the booking card (#book)
     instead of only scrolling there. Only the preview pages, which always
     have that card, include it. --}}
<style>
    .nav-book-cta {
        position: relative;
        order: 5;
        flex: none;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-left: 18px;
        padding: 6px 18px 6px 6px;
        border-radius: 999px;
        background: linear-gradient(135deg, #ffd796 0%, #e9a94e 100%);
        color: #1d1306;
        text-decoration: none;
        line-height: 1.15;
        overflow: hidden;
        isolation: isolate;
        box-shadow: 0 8px 22px rgba(233, 169, 78, 0.45);
        animation: nav-cta-glow 3.2s ease-in-out infinite;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .nav-book-cta:hover,
    .nav-book-cta:focus-visible {
        color: #1d1306;
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: 0 12px 28px rgba(233, 169, 78, 0.6);
    }

    .nav-book-cta:focus-visible {
        outline: 3px solid #0b1430;
        outline-offset: 3px;
    }

    /* A light sweep across the button every few seconds. */
    .nav-book-cta::after {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        left: -60%;
        width: 50%;
        z-index: -1;
        background: linear-gradient(100deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.7) 50%, rgba(255, 255, 255, 0) 100%);
        transform: skewX(-20deg);
        animation: nav-cta-shine 4.5s ease-in-out infinite;
    }

    .nav-book-cta__icon {
        display: grid;
        place-items: center;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #0b1430;
        color: #f0c27a;
        flex: none;
    }

    .nav-book-cta__text {
        display: flex;
        flex-direction: column;
    }

    .nav-book-cta__text strong {
        font-size: 0.98rem;
    }

    .nav-book-cta__short {
        display: none;
    }

    .nav-book-cta__text small {
        font-size: 0.74rem;
        font-weight: 700;
        opacity: 0.8;
    }

    @keyframes nav-cta-glow {
        0%, 100% { box-shadow: 0 8px 22px rgba(233, 169, 78, 0.45), 0 0 0 0 rgba(233, 169, 78, 0.5); }
        50% { box-shadow: 0 8px 22px rgba(233, 169, 78, 0.45), 0 0 0 7px rgba(233, 169, 78, 0); }
    }

    @keyframes nav-cta-shine {
        0%, 55% { left: -60%; }
        85%, 100% { left: 130%; }
    }

    @media (prefers-reduced-motion: reduce) {
        .nav-book-cta,
        .nav-book-cta::after {
            animation: none;
        }
    }

    /* Laptop widths: the full menu plus the button only fit if both
       tighten up. */
    @media (min-width: 992px) and (max-width: 1279.98px) {
        /* style.css forces 15px padding and 20px type with !important. */
        #mainNav .navbar-nav .nav-link {
            padding-left: 8px !important;
            padding-right: 8px !important;
            font-size: 17px;
            white-space: nowrap;
        }

        .nav-book-cta__text small,
        .nav-book-cta__long {
            display: none;
        }

        .nav-book-cta__short {
            display: inline;
        }

        .nav-book-cta {
            margin-left: 8px;
            padding-right: 14px;
        }
    }

    /* Narrow screens: brand, button and menu toggle share one row. */
    @media (max-width: 991.98px) {
        #mainNav .navbar-brand .h3 {
            font-size: 1.45rem;
        }

        .nav-book-cta {
            order: 0;
            margin: 0 10px 0 auto;
            padding-right: 14px;
        }

        .nav-book-cta__text small {
            display: none;
        }
    }

    @media (max-width: 575.98px) {
        .nav-book-cta__long {
            display: none;
        }

        .nav-book-cta__short {
            display: inline;
        }
    }

    @media (max-width: 399.98px) {
        #mainNav .navbar-brand .h3 {
            font-size: 1.25rem;
        }

        .nav-book-cta {
            padding: 4px 12px 4px 4px;
            gap: 6px;
        }

        .nav-book-cta__icon {
            width: 32px;
            height: 32px;
        }

        .nav-book-cta__text strong {
            font-size: 0.88rem;
        }
    }
</style>

<a class="nav-book-cta" href="#book" data-book-cta="header">
    <span class="nav-book-cta__icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" width="18" height="18" focusable="false"><path fill="currentColor" d="M7 2h2v2h6V2h2v2h2a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2zm12 8H5v9h14zM7 12h3v3H7z"/></svg>
    </span>
    <span class="nav-book-cta__text">
        <strong><span class="nav-book-cta__long">Book your stay</span><span class="nav-book-cta__short">Book</span></strong>
        <small><span aria-hidden="true">&#9733;</span> 5.0 &middot; Guest favorite</small>
    </span>
</a>

<script>
    (function () {
        // Any "book" button on the page (header, hero, walkthrough) scrolls
        // to the booking card, flashes it, and opens the check-in calendar.
        document.addEventListener('click', function (e) {
            var link = e.target.closest && e.target.closest('a[href="#book"], a[data-book-cta]');
            var card = document.getElementById('book');
            if (!link || !card) return;
            e.preventDefault();

            var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            // Scroll to the card's grid rather than the card: the card is
            // sticky on wide screens, and scrollIntoView on a sticky element
            // overshoots. The grid starts where the card does at every width.
            var anchor = card.closest('.vf-book__grid') || card;
            var nav = document.getElementById('mainNav');
            var top = anchor.getBoundingClientRect().top + window.pageYOffset - (nav ? nav.offsetHeight : 0) - 24;
            window.scrollTo({ top: Math.max(top, 0), behavior: reduceMotion ? 'auto' : 'smooth' });
            card.classList.remove('is-highlighted');
            void card.offsetWidth;
            card.classList.add('is-highlighted');

            var opened = false;
            function openCalendar() {
                if (opened) return;
                opened = true;
                var checkin = document.getElementById('checkin_date');
                var cell = card.querySelector('.booking-date-cell[data-date-target="checkin"]');
                if (checkin && !checkin.value && cell) tryOpen(cell, 16);
                else (document.getElementById('booking-book-now-btn') || card).focus({ preventScroll: true });
            }

            // The calendar is created only after the booked dates arrive, so
            // a very early click can land before it exists: retry briefly.
            function tryOpen(cell, attemptsLeft) {
                cell.click();
                setTimeout(function () {
                    var picker = document.querySelector('.litepicker');
                    var shown = picker && getComputedStyle(picker).display !== 'none';
                    if (!shown && attemptsLeft > 0) setTimeout(function () { tryOpen(cell, attemptsLeft - 1); }, 250);
                }, 150);
            }
            // Open the calendar once the scroll has settled; opening it
            // mid-scroll gets it dismissed again.
            var distance = Math.abs(Math.max(top, 0) - window.pageYOffset);
            if (distance < 2 || reduceMotion) setTimeout(openCalendar, 50);
            else if ('onscrollend' in window) window.addEventListener('scrollend', openCalendar, { once: true });
            else setTimeout(openCalendar, Math.min(600 + distance / 4, 3000));

            if (window.villaTrack) villaTrack('booking_cta', { placement: link.dataset.bookCta || 'page' });
        });
    })();
</script>
