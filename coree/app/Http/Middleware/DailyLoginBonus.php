<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\DailyLoginBonusService;
use Illuminate\Support\Facades\Auth;

class DailyLoginBonus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $bonusService = new DailyLoginBonusService();
            $user = Auth::user();

            // Check if user can claim today's bonus
            if ($bonusService->canClaimToday($user)) {
                $result = $bonusService->checkAndAwardBonus($user);
                
                if ($result['awarded']) {
                    // Store in session to show notification
                    session()->flash('daily_bonus_awarded', [
                        'amount' => $result['amount'],
                        'streak' => $result['current_streak'],
                    ]);
                }
            }
        }

        return $next($request);
    }
}

