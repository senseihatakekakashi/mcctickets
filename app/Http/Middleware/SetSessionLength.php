<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SetSessionLength
{
    const SESSION_LIFETIME_PARAM = 'sessionLifetime';
    const SESSION_LIFETIME_DEFAULT_MINS = 240;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $lifetimeMins = Cookie::get(self::SESSION_LIFETIME_PARAM, $request->input(self::SESSION_LIFETIME_PARAM)); //https://laravel.com/api/6.x/Illuminate/Support/Facades/Cookie.html#method_get
        if ($lifetimeMins) {
            Cookie::queue(self::SESSION_LIFETIME_PARAM, $lifetimeMins, $lifetimeMins); //https://laravel.com/docs/6.x/requests#cookies
            config(['session.lifetime' => $lifetimeMins]);
        }
        return $next($request);
    }
}
