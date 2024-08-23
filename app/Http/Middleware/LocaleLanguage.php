<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LocaleLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(Cookie::get('dynacore_locale') != null){
            App::setLocale(Cookie::get('dynacore_locale'));
        } else {
            $default_locale = config('app.locale');
            App::setLocale($default_locale);
            Cookie::queue('dynacore_locale', $default_locale, 15768000); // 6 monthes
        }

        $locale_ar = (Cookie::get('dynacore_locale') === 'ar');
        view()->share('locale_ar', $locale_ar);




        return $next($request);
    }
}
