<?php

/*
|--------------------------------------------------------------------------
| SEO Metadata
|--------------------------------------------------------------------------
|
| Per-route title/description/image used by layouts/partials/head.blade.php.
| Keys are route names as defined in routes/web.php.
|
| A page can still override any of these with @section('description'),
| @section('og_image') or @section('robots') in its own Blade file.
|
| Descriptions should sit between 140 and 160 characters so Google shows
| them whole. Anything longer gets truncated in the SERP.
|
*/

return [

    // Falls back to these when a route has no entry below.
    'defaults' => [
        'title'       => 'Villa Fabulosa',
        'description' => 'Villa Fabulosa is a 7-bedroom luxury estate in Temecula Wine Country sleeping 24 guests, with a pool, mini golf course and panoramic vineyard views.',
        'image'       => 'frontend/imgs/banner-1.jpeg',
    ],

    // Used for LocalBusiness/NAP output and social profiles.
    'business' => [
        'name'      => 'Villa Fabulosa',
        'phone'     => '619-578-4013',
        'street'    => '39575 Camino Del Vino',
        'locality'  => 'Temecula',
        'region'    => 'CA',
        'postal'    => '92592',
        'country'   => 'US',
        'latitude'  => 33.5477843,
        'longitude' => -117.026276,
        'profiles'  => [
            'https://www.instagram.com/villa.fabulosa/',
            'https://www.tiktok.com/@villafabulosa',
        ],
    ],

    'pages' => [

        // ── Core ──────────────────────────────────────────────────────────
        'home' => [
            'description' => 'Rent Villa Fabulosa, a 7-bedroom estate in Temecula Wine Country for up to 24 guests. Pool, mini golf, sports court and 55 wineries minutes away.',
        ],
        'about' => [
            'description' => 'Everything about Villa Fabulosa: 7 bedrooms, 12 beds, 5.5 baths, the spaces your group can use, guest access and what is included with your stay.',
        ],
        'your-hosts' => [
            'description' => 'Meet the hosts of Villa Fabulosa, published wedding and event authors who have spent years making group stays in Temecula Wine Country effortless.',
        ],
        'instructions' => [
            'description' => 'Guest guide to Villa Fabulosa: how to use the kitchen, game room, pool, sports area and mini golf course so your group gets the most out of the estate.',
        ],
        'book-now' => [
            'description' => 'Check availability and book Villa Fabulosa direct. Live calendar, instant pricing for your dates and no booking-platform service fee.',
        ],
        'gallery' => [
            'description' => 'Photo gallery of Villa Fabulosa: the rooms, pool, bridal suite, game room, mini golf course and aerial views across Temecula Wine Country.',
        ],
        'events' => [
            'description' => 'Host private events for up to 125 guests at Villa Fabulosa. The backyard converts into a lit outdoor venue, with tables, chairs and linens provided.',
        ],
        'kitchen' => [
            'description' => 'The chef-scale kitchen at Villa Fabulosa, equipped to cater for groups of up to 24 guests, with room for caterers to work during private events.',
        ],

        // ── Gallery detail ────────────────────────────────────────────────
        'the-rooms' => [
            'description' => 'Tour the 7 bedrooms and 12 beds at Villa Fabulosa, plus the grand room, dining room and kitchen that anchor group stays in Temecula Wine Country.',
        ],
        'game-rooms' => [
            'description' => 'The game room at Villa Fabulosa: arcade games, billiards and gathering space that keeps large groups entertained after a day in the vineyards.',
        ],
        'bridal-suite' => [
            'description' => 'The bridal suite at Villa Fabulosa, a private space for getting ready before a Temecula Wine Country wedding, with room for the full bridal party.',
        ],
        'the-pool' => [
            'description' => 'The pool and patio at Villa Fabulosa, a hillside setting with vineyard views, outdoor shower and space for the whole group to spread out.',
        ],
        'miniature-golf-course' => [
            'description' => 'Villa Fabulosa has its own private miniature golf course on the grounds, a rare amenity for a Temecula group rental and a favourite with corporate guests.',
        ],
        'the-sports-area' => [
            'description' => 'The private sports court and field at Villa Fabulosa, used for games and team bonding and convertible into an event venue for up to 125 guests.',
        ],
        'birds-eye' => [
            'description' => 'Aerial views of Villa Fabulosa, showing the full hillside estate, pool, sports field and mini golf course set against Temecula Wine Country.',
        ],
        'floorplan' => [
            'description' => 'Villa Fabulosa floor plan: how the 7 bedrooms, 5.5 baths and shared living spaces are laid out, so you can plan sleeping arrangements for your group.',
        ],

        // ── Experiences ───────────────────────────────────────────────────
        'wineries' => [
            'description' => 'Over 55 wineries sit within minutes of Villa Fabulosa. Driving times, tasting room details and directions from the estate to each Temecula winery.',
        ],
        'favorite-wineries' => [
            'description' => 'Our hosts pick the Temecula wineries worth your afternoon, with what each does best and how far it is from Villa Fabulosa.',
        ],
        'temecula' => [
            'description' => 'What to do in Temecula Wine Country: hot air balloon rides, Old Town, tasting rooms and golf, all within a short drive of Villa Fabulosa.',
        ],
        'team-bonding' => [
            'description' => 'A coached team bonding programme at Villa Fabulosa for groups of 16 to 40, with all props, games and medals included. Ideal for company offsites.',
        ],
        'maps' => [
            'description' => 'Find Villa Fabulosa at 39575 Camino Del Vino, Temecula, CA 92592, with maps and driving directions from San Diego, Los Angeles and Orange County.',
        ],

        // ── Team bonding games ────────────────────────────────────────────
        'balloon-race' => [
            'description' => 'Balloon Race, one of the coached team bonding games run at Villa Fabulosa in Temecula. How it works, group size and what the game teaches.',
        ],
        'butt-balloon' => [
            'description' => 'Butt Balloon, a coached team bonding game run on the sports field at Villa Fabulosa in Temecula. Rules, group size and equipment provided.',
        ],
        'legs-tied' => [
            'description' => 'Legs Tied, a coached team bonding game at Villa Fabulosa in Temecula that puts groups of 16 to 40 through a coordination challenge.',
        ],
        'mine-fields' => [
            'description' => 'Mine Fields, a trust and communication team bonding game run on the grounds at Villa Fabulosa in Temecula Wine Country.',
        ],
        'pass-the-ball' => [
            'description' => 'Pass the Ball, a coached team bonding game at Villa Fabulosa in Temecula. Rules, group size and how it fits into a company offsite.',
        ],
        'pass-the-block' => [
            'description' => 'Pass the Block, a coordination-focused team bonding game run at Villa Fabulosa in Temecula for corporate groups of 16 to 40.',
        ],
        'ping-pong-in-a-cup' => [
            'description' => 'Ping Pong in a Cup, a fast coached team bonding game played at Villa Fabulosa in Temecula Wine Country. Rules and group size.',
        ],
        'rope-escape' => [
            'description' => 'Untangle, also called Rope Escape, a problem-solving team bonding game run at Villa Fabulosa in Temecula for corporate groups.',
        ],
        'stuck-on-paper' => [
            'description' => 'Stuck on Paper, a coached team bonding game at Villa Fabulosa in Temecula that pushes groups to solve a challenge together under pressure.',
        ],
        'the-nuts-stacker' => [
            'description' => 'Nuts Stacker, a precision team bonding game run at Villa Fabulosa in Temecula Wine Country for company offsites and group retreats.',
        ],

        // ── Retreats ──────────────────────────────────────────────────────
        'villa-fabulosa' => [
            'description' => 'Villa Fabulosa in Temecula Wine Country: a 7-bedroom hillside estate for 24 guests, built for retreats, offsites, celebrations and large group stays.',
        ],
        'short-term-rental' => [
            'description' => 'Book Villa Fabulosa as a short term rental in Temecula Wine Country. 7 bedrooms, 24 guests, pool and mini golf, with direct booking and no platform fee.',
        ],
        'corporate-retreats' => [
            'description' => 'Host a corporate retreat at Villa Fabulosa in Temecula Wine Country. Space for 24 overnight, coached team bonding and 55 wineries minutes away.',
        ],
        'meditation-retreats' => [
            'description' => 'Run a meditation retreat at Villa Fabulosa in Temecula Wine Country, with quiet hillside grounds, vineyard views and room for 24 guests to stay on site.',
        ],
        'yoga-retreats' => [
            'description' => 'Host a yoga retreat at Villa Fabulosa in Temecula Wine Country. Open outdoor practice space, private pool area and accommodation for up to 24 guests.',
        ],
        'spiritual-retreats' => [
            'description' => 'A private hillside estate in Temecula Wine Country for spiritual retreats, with space for 24 guests and grounds set well away from the road.',
        ],
        'nature-retreats' => [
            'description' => 'Villa Fabulosa sits on a hillside above Temecula Wine Country, with open grounds and vineyard views that suit nature retreats for up to 24 guests.',
        ],
        'couples-retreats' => [
            'description' => 'Bring several couples to Villa Fabulosa in Temecula Wine Country. 7 bedrooms, 5.5 baths, a private pool and 55 wineries within a short drive.',
        ],
        'fitness-retreats' => [
            'description' => 'Host a fitness retreat at Villa Fabulosa in Temecula Wine Country, with a private sports field, pool and space for 24 guests to stay on site.',
        ],
        'digital-detox-retreats' => [
            'description' => 'A hillside estate in Temecula Wine Country for digital detox retreats, with games, a pool, mini golf and plenty of reasons to leave the phone indoors.',
        ],
        'weight-loss-retreats' => [
            'description' => 'Villa Fabulosa offers a private Temecula Wine Country base for weight loss retreats, with a full kitchen, sports field and room for 24 guests.',
        ],
        'detox-retreats' => [
            'description' => 'Run a detox retreat at Villa Fabulosa in Temecula Wine Country, with a chef-scale kitchen, private pool and accommodation for up to 24 guests.',
        ],
        'spa-retreats' => [
            'description' => 'Host a spa retreat at Villa Fabulosa in Temecula Wine Country, with a private pool, outdoor shower, quiet hillside grounds and space for 24 guests.',
        ],

        // ── Booking-platform pages ────────────────────────────────────────
        // These target other companies' brand names and cannot rank. They are
        // kept live for existing links but excluded from the index and the
        // sitemap. Phase 4 consolidates them into one "where to book" page.
        'airbnb'       => ['robots' => 'noindex,follow'],
        'vrbo'         => ['robots' => 'noindex,follow'],
        'trip-advisor' => ['robots' => 'noindex,follow'],
        'booking'      => ['robots' => 'noindex,follow'],
        'expedia'      => ['robots' => 'noindex,follow'],

        // ── Transactional, never indexed ──────────────────────────────────
        'booking.success'     => ['robots' => 'noindex,nofollow'],
        'booking.update-card' => ['robots' => 'noindex,nofollow'],
    ],
];
