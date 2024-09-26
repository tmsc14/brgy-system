<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FaviconMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof \Illuminate\Http\Response) {
            // Modify the response content by adding the favicon link tag
            $content = $response->getContent();

            // Add the favicon just before the closing </head> tag
            $faviconTag = '<link rel="icon" type="image/x-icon" href="' . asset('resources/img/favicon.ico') . '">';
            $content = str_replace('</head>', $faviconTag . '</head>', $content);

            $response->setContent($content);
        }

        return $response;
    }
}
