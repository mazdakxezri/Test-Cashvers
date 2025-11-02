<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Services\VPNDetectionService;

class AutoBanVPN
{
    protected $vpnService;

    public function __construct(VPNDetectionService $vpnService)
    {
        $this->vpnService = $vpnService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (isVpnBanEnabled() && isVpnDetectionEnabled()) {
            $ip = $request->ip();

            if ($this->vpnService->isVPN($ip)) {
                if (Auth::check()) {
                    Auth::user()->update(['status' => 'banned']);
                    Auth::logout();
                }

                return redirect()->route('home')->with('error', 'Your account has been banned due to fraudulent activity.');
            }
        }
        return $next($request);
    }
}




