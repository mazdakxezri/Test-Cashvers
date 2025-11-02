<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class AutoBanOnCountryChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (isCountryBanEnabled()) {
            $UserCountry = $user->country_code;
            $CurrentCountry = getCountryCode($request->ip());

            if ($UserCountry && $CurrentCountry && $UserCountry != $CurrentCountry) {
                $user->update(['status' => 'banned']);

                Auth::logout();

                return redirect()->route('home')->with('error', 'Your account has been automatically banned due to a change in country.');
            }
        }
        return $next($request);
    }
}
