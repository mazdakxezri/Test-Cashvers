<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSession;
use Jenssegers\Agent\Agent;

class TrackUserSession
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $this->trackSession($request);
        }

        return $next($request);
    }

    /**
     * Track user session data
     */
    private function trackSession(Request $request)
    {
        $user = Auth::user();
        $agent = new Agent();
        
        // Generate device fingerprint
        $fingerprint = $this->generateDeviceFingerprint($request, $agent);
        
        // Check if this exact session was already tracked (avoid duplicates)
        $recentSession = UserSession::where('user_id', $user->id)
            ->where('device_fingerprint', $fingerprint)
            ->where('login_at', '>=', now()->subMinutes(30))
            ->first();
        
        if ($recentSession) {
            return; // Already tracked this session
        }
        
        // Collect device info
        $deviceType = $this->getDeviceType($agent);
        $os = $agent->platform();
        $browser = $agent->browser();
        $browserVersion = $agent->version($browser);
        
        // Get timezone from request or estimate
        $timezone = $request->header('X-Timezone') ?? $this->estimateTimezone($request->ip());
        
        // Get location
        $countryCode = getCountryCode($request->ip());
        
        // Create session record
        UserSession::create([
            'user_id' => $user->id,
            'uid' => $user->uid,
            'ip_address' => $request->ip(),
            'country_code' => $countryCode,
            'city' => null, // Can add GeoIP city lookup if needed
            'timezone' => $timezone,
            'device_type' => $deviceType,
            'os' => $os,
            'browser' => $browser,
            'browser_version' => $browserVersion,
            'screen_width' => $request->header('X-Screen-Width'),
            'screen_height' => $request->header('X-Screen-Height'),
            'user_agent' => $request->header('User-Agent'),
            'device_fingerprint' => $fingerprint,
            'login_at' => now(),
        ]);
    }

    /**
     * Generate unique device fingerprint
     */
    private function generateDeviceFingerprint(Request $request, Agent $agent): string
    {
        $components = [
            $request->header('User-Agent'),
            $agent->platform(),
            $agent->browser(),
            $request->header('Accept-Language'),
            $request->header('Accept-Encoding'),
            $request->header('X-Screen-Width'),
            $request->header('X-Screen-Height'),
        ];
        
        return hash('sha256', implode('|', array_filter($components)));
    }

    /**
     * Determine device type
     */
    private function getDeviceType(Agent $agent): string
    {
        if ($agent->isMobile()) {
            return 'mobile';
        } elseif ($agent->isTablet()) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }

    /**
     * Estimate timezone from IP (rough estimate)
     */
    private function estimateTimezone(string $ip): ?string
    {
        // This is a rough estimate based on country
        // Can be enhanced with GeoIP city database
        try {
            $reader = new \GeoIp2\Database\Reader(storage_path('app/geoip/GeoLite2-Country.mmdb'));
            $record = $reader->country($ip);
            
            // Map common countries to timezones (simplified)
            $timezoneMap = [
                'US' => 'America/New_York',
                'GB' => 'Europe/London',
                'DE' => 'Europe/Berlin',
                'FR' => 'Europe/Paris',
                'IN' => 'Asia/Kolkata',
                'AU' => 'Australia/Sydney',
                'CA' => 'America/Toronto',
                'BR' => 'America/Sao_Paulo',
                'JP' => 'Asia/Tokyo',
                'CN' => 'Asia/Shanghai',
            ];
            
            return $timezoneMap[$record->country->isoCode] ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }
}

