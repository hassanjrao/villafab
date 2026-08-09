<?php

namespace App\Http\Middleware;

use App\Support\Seo;
use Closure;
use Illuminate\Http\Request;

/**
 * Collapses http/https and www/non-www variants onto the single host in
 * APP_URL with a 301, so link equity and crawl budget are not split across
 * four addresses for the same page.
 *
 * Production only — local development runs on 127.0.0.1 with no TLS.
 */
class ForceCanonicalUrl
{
    public function handle(Request $request, Closure $next)
    {
        if (! app()->environment('production') || ! $request->isMethod('GET')) {
            return $next($request);
        }

        $canonicalHost = Seo::canonicalHost();

        if (! $canonicalHost) {
            return $next($request);
        }

        $needsHostFix   = $request->getHost() !== $canonicalHost;
        $needsSchemeFix = ! $request->secure() && str_starts_with(config('app.url'), 'https://');

        if (! $needsHostFix && ! $needsSchemeFix) {
            return $next($request);
        }

        $target = Seo::absolute($request->path());

        if ($query = $request->getQueryString()) {
            $target .= '?' . $query;
        }

        return redirect($target, 301);
    }
}
