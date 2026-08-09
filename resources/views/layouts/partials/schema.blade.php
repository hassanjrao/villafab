@php
    $biz  = config('seo.business');
    $home = \App\Support\Seo::absolute('');

    // Only facts stated elsewhere on the site go in here. In particular there
    // is deliberately no aggregateRating: reviews are not displayed on-site
    // yet, and marking up ratings you do not show is a manual-action risk.
    $lodging = [
        '@context'    => 'https://schema.org',
        '@type'       => 'LodgingBusiness',
        '@id'         => $home . '#lodging',
        'name'        => $biz['name'],
        'url'         => $home,
        'description' => config('seo.defaults.description'),
        'image'       => \App\Support\Seo::absolute(config('seo.defaults.image')),
        'telephone'   => $biz['phone'],
        'priceRange'  => '$$$',
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => $biz['street'],
            'addressLocality' => $biz['locality'],
            'addressRegion'   => $biz['region'],
            'postalCode'      => $biz['postal'],
            'addressCountry'  => $biz['country'],
        ],
        'geo' => [
            '@type'     => 'GeoCoordinates',
            'latitude'  => $biz['latitude'],
            'longitude' => $biz['longitude'],
        ],
        'sameAs'                 => $biz['profiles'],
        'numberOfRooms'          => 7,
        'petsAllowed'            => false,
        'maximumAttendeeCapacity' => 125,
        'containsPlace' => [
            '@type'         => 'Accommodation',
            'name'          => 'Villa Fabulosa',
            'numberOfRooms' => 7,
            'numberOfBedrooms'      => 7,
            'numberOfBathroomsTotal' => 5.5,
            'occupancy' => [
                '@type'    => 'QuantitativeValue',
                'maxValue' => 24,
                'unitText' => 'guests',
            ],
        ],
        'amenityFeature' => array_map(
            fn ($name) => ['@type' => 'LocationFeatureSpecification', 'name' => $name, 'value' => true],
            [
                'Private swimming pool',
                'Miniature golf course',
                'Private sports court',
                'Game room',
                'Full kitchen',
                'Bridal suite',
                'Free parking',
                'Vineyard views',
            ]
        ),
    ];

    // Breadcrumbs: Home > current page. Flat site, so one level is honest.
    $crumbs = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $home],
        ],
    ];

    if (! request()->is('/')) {
        $crumbs['itemListElement'][] = [
            '@type'    => 'ListItem',
            'position' => 2,
            'name'     => trim(str_replace('— Villa Fabulosa', '', $seoTitle)),
            'item'     => $seoCanonical,
        ];
    }

    $graph = [$lodging, $crumbs];

    // The backyard converts into a licensed private event space for 125.
    if (request()->routeIs('events')) {
        $graph[] = [
            '@context'    => 'https://schema.org',
            '@type'       => 'EventVenue',
            'name'        => 'Villa Fabulosa Private Event Venue',
            'url'         => $seoCanonical,
            'description' => 'Villa Fabulosa\'s private backyard converts from a sports court into an outdoor event venue seating up to 125 guests, with tables, chairs and linens provided.',
            'maximumAttendeeCapacity' => 125,
            'address'     => $lodging['address'],
            'geo'         => $lodging['geo'],
            'telephone'   => $biz['phone'],
        ];
    }
@endphp

@foreach ($graph as $node)
<script type="application/ld+json">{!! json_encode($node, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endforeach
