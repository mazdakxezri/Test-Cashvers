<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\WithdrawalApproved;
use App\Mail\WithdrawalRejected;
use App\Mail\AccountVerified;
use App\Mail\AccountSuspended;
use App\Mail\WithdrawalHold;
use App\Mail\KYCRequest;
use App\Mail\OfferCompleted;
use App\Mail\WelcomeEmail;

class EmailService
{
    /**
     * Send withdrawal approved email
     */
    public function sendWithdrawalApproved(User $user, $withdrawal)
    {
        try {
            Mail::to($user->email)->send(new WithdrawalApproved($user, $withdrawal));
            return true;
        } catch (\Exception $e) {
            \Log::error('Email Service: Failed to send withdrawal approved email - ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send withdrawal rejected email
     */
    public function sendWithdrawalRejected(User $user, $withdrawal, $reason)
    {
        try {
            Mail::to($user->email)->send(new WithdrawalRejected($user, $withdrawal, $reason));
            return true;
        } catch (\Exception $e) {
            \Log::error('Email Service: Failed to send withdrawal rejected email - ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send account verified email
     */
    public function sendAccountVerified(User $user)
    {
        try {
            Mail::to($user->email)->send(new AccountVerified($user));
            return true;
        } catch (\Exception $e) {
            \Log::error('Email Service: Failed to send account verified email - ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send account suspended email
     */
    public function sendAccountSuspended(User $user, $reason)
    {
        try {
            Mail::to($user->email)->send(new AccountSuspended($user, $reason));
            return true;
        } catch (\Exception $e) {
            \Log::error('Email Service: Failed to send account suspended email - ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send withdrawal on hold email
     */
    public function sendWithdrawalHold(User $user, $withdrawal, $reason)
    {
        try {
            Mail::to($user->email)->send(new WithdrawalHold($user, $withdrawal, $reason));
            return true;
        } catch (\Exception $e) {
            \Log::error('Email Service: Failed to send withdrawal hold email - ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send KYC request email
     */
    public function sendKYCRequest(User $user)
    {
        try {
            Mail::to($user->email)->send(new KYCRequest($user));
            return true;
        } catch (\Exception $e) {
            \Log::error('Email Service: Failed to send KYC request email - ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send offer completed email
     */
    public function sendOfferCompleted(User $user, $offer)
    {
        try {
            Mail::to($user->email)->send(new OfferCompleted($user, $offer));
            return true;
        } catch (\Exception $e) {
            \Log::error('Email Service: Failed to send offer completed email - ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send welcome email
     */
    public function sendWelcomeEmail(User $user)
    {
        try {
            Mail::to($user->email)->send(new WelcomeEmail($user));
            return true;
        } catch (\Exception $e) {
            \Log::error('Email Service: Failed to send welcome email - ' . $e->getMessage());
            return false;
        }
    }
}

