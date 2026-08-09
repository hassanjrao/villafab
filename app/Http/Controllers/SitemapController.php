<?php

namespace App\Http\Controllers;

use App\Support\Seo;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Public routes, grouped by how often they change and how much they
     * matter relative to each other. Anything marked noindex in
     * config/seo.php is filtered out below rather than listed here twice.
     *
     * @var array<string, array{priority: string, changefreq: string, routes: array<int, string>}>
     */
    private const GROUPS = [
        'primary' => [
            'priority'   => '1.0',
            'changefreq' => 'weekly',
            'routes'     => ['home', 'book-now'],
        ],
        'core' => [
            'priority'   => '0.9',
            'changefreq' => 'monthly',
            'routes'     => ['about', 'events', 'gallery', 'villa-fabulosa', 'short-term-rental', 'corporate-retreats'],
        ],
        'secondary' => [
            'priority'   => '0.7',
            'changefreq' => 'monthly',
            'routes'     => [
                'the-rooms', 'game-rooms', 'bridal-suite', 'the-pool', 'miniature-golf-course',
                'the-sports-area', 'birds-eye', 'floorplan', 'kitchen', 'instructions', 'your-hosts',
                'wineries', 'favorite-wineries', 'temecula', 'team-bonding', 'maps',
                'yoga-retreats', 'meditation-retreats', 'spiritual-retreats', 'nature-retreats',
                'couples-retreats', 'fitness-retreats', 'spa-retreats',
                'digital-detox-retreats', 'weight-loss-retreats', 'detox-retreats',
            ],
        ],
        'supporting' => [
            'priority'   => '0.4',
            'changefreq' => 'yearly',
            'routes'     => [
                'balloon-race', 'butt-balloon', 'legs-tied', 'mine-fields', 'pass-the-ball',
                'pass-the-block', 'ping-pong-in-a-cup', 'rope-escape', 'stuck-on-paper',
                'the-nuts-stacker',
            ],
        ],
    ];

    public function index(): Response
    {
        $urls = [];

        foreach (self::GROUPS as $group) {
            foreach ($group['routes'] as $name) {
                if ($this->isNoindex($name)) {
                    continue;
                }

                $urls[] = [
                    'loc'        => Seo::absolute(ltrim(route($name, [], false), '/')),
                    'priority'   => $group['priority'],
                    'changefreq' => $group['changefreq'],
                ];
            }
        }

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }

    private function isNoindex(string $route): bool
    {
        // Direct array access — route names may contain dots, which config()
        // would misread as nested keys.
        $robots = config('seo.pages')[$route]['robots'] ?? '';

        return str_contains($robots, 'noindex');
    }
}
