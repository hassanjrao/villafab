<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;

/**
 * Resolves the SEO metadata for the current request from config/seo.php.
 *
 * Precedence, highest first:
 *   1. A @section('description') / @section('og_image') / @section('robots')
 *      in the page's own Blade file.
 *   2. The route's entry in config('seo.pages').
 *   3. config('seo.defaults').
 *
 * The Blade-level override is applied in layouts/partials/head.blade.php,
 * which has access to the rendered sections; everything else happens here.
 */
class Seo
{
    /**
     * Metadata for the route currently being handled.
     *
     * @return array{title: string, description: string, image: string, robots: string}
     */
    public static function current(): array
    {
        $defaults = config('seo.defaults');

        // Direct array access, not config('seo.pages.' . $name) — route names
        // like "booking.success" contain dots, which config() would read as
        // nested keys and never find.
        $page = config('seo.pages')[self::routeName()] ?? [];

        return [
            'title'       => $page['title']       ?? $defaults['title'],
            'description' => $page['description'] ?? $defaults['description'],
            'image'       => $page['image']       ?? $defaults['image'],
            'robots'      => $page['robots']      ?? 'index,follow',
        ];
    }

    /**
     * Absolute canonical URL for the current request.
     *
     * Built from APP_URL rather than the incoming Host header so that
     * www/non-www and http/https variants all resolve to one canonical form
     * even before the redirect middleware catches them.
     */
    public static function canonical(): string
    {
        return self::absolute(request()->path());
    }

    /**
     * Turn a path or asset-relative path into an absolute canonical URL.
     */
    public static function absolute(string $path): string
    {
        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        $base = rtrim(config('app.url'), '/');
        $path = trim($path, '/');

        return $path === '' ? $base : $base . '/' . $path;
    }

    /**
     * The canonical host, used by the redirect middleware.
     */
    public static function canonicalHost(): ?string
    {
        return parse_url(config('app.url'), PHP_URL_HOST) ?: null;
    }

    private static function routeName(): string
    {
        return Route::currentRouteName() ?? '';
    }
}
