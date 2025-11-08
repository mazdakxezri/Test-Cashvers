<?php

namespace App\Services;

use App\Models\User;
use App\Models\PushSubscription;
use Illuminate\Support\Facades\Log;

class PushNotificationService
{
    /**
     * Send push notification to user
     */
    public function sendToUser(User $user, string $title, string $body, array $data = []): bool
    {
        $subscriptions = PushSubscription::where('user_id', $user->id)->get();

        if ($subscriptions->isEmpty()) {
            return false;
        }

        $success = false;
        foreach ($subscriptions as $subscription) {
            if ($this->sendPush($subscription, $title, $body, $data)) {
                $success = true;
            }
        }

        return $success;
    }

    /**
     * Send push notification to multiple users
     */
    public function sendToMultiple(array $userIds, string $title, string $body, array $data = []): int
    {
        $subscriptions = PushSubscription::whereIn('user_id', $userIds)->get();
        $sent = 0;

        foreach ($subscriptions as $subscription) {
            if ($this->sendPush($subscription, $title, $body, $data)) {
                $sent++;
            }
        }

        return $sent;
    }

    /**
     * Send push to all users
     */
    public function sendToAll(string $title, string $body, array $data = []): int
    {
        $subscriptions = PushSubscription::all();
        $sent = 0;

        foreach ($subscriptions as $subscription) {
            if ($this->sendPush($subscription, $title, $body, $data)) {
                $sent++;
            }
        }

        return $sent;
    }

    /**
     * Send push notification via Web Push Protocol
     */
    private function sendPush(PushSubscription $subscription, string $title, string $body, array $data = []): bool
    {
        try {
            $payload = json_encode([
                'title' => $title,
                'body' => $body,
                'icon' => asset('assets/images/logo.png'),
                'badge' => asset('assets/images/logo.png'),
                'data' => array_merge($data, [
                    'url' => url('/earn'),
                    'timestamp' => time(),
                ]),
            ]);

            // Note: In production, you'd use a proper Web Push library like minishlink/web-push
            // For now, we'll log it as this requires VAPID keys setup
            
            Log::info("Push notification prepared for user {$subscription->user_id}: {$title}");
            
            // In production, use:
            // $webPush = new WebPush(['VAPID' => [...]);
            // $webPush->sendOneNotification($subscription, $payload);
            
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send push notification: " . $e->getMessage());
            
            // Remove invalid subscription
            if (str_contains($e->getMessage(), '410')) {
                $subscription->delete();
            }
            
            return false;
        }
    }

    /**
     * Subscribe user to push notifications
     */
    public function subscribe(User $user, array $subscriptionData): PushSubscription
    {
        return PushSubscription::updateOrCreate(
            ['endpoint' => $subscriptionData['endpoint']],
            [
                'user_id' => $user->id,
                'public_key' => $subscriptionData['keys']['p256dh'],
                'auth_token' => $subscriptionData['keys']['auth'],
                'content_encoding' => $subscriptionData['contentEncoding'] ?? 'aesgcm',
            ]
        );
    }

    /**
     * Unsubscribe user from push notifications
     */
    public function unsubscribe(User $user, string $endpoint): bool
    {
        return PushSubscription::where('user_id', $user->id)
            ->where('endpoint', $endpoint)
            ->delete() > 0;
    }
}

