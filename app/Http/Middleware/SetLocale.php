<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. If locale is requested via URL parameter, update session & profile
        if ($request->has('locale')) {
            $locale = $request->query('locale');
            if (in_array($locale, ['en', 'yo', 'ha', 'ig'])) {
                session(['locale' => $locale]);
                if (auth()->check()) {
                    auth()->user()->update(['locale' => $locale]);
                }
            }
        }

        // 2. Load locale from session or user profile
        if (session()->has('locale')) {
            App::setLocale(session('locale'));
        } elseif (auth()->check()) {
            $locale = auth()->user()->locale;
            App::setLocale($locale);
            session(['locale' => $locale]);
        }

        return $next($request);
    }
}
