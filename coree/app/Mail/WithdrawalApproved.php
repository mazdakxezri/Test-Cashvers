<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WithdrawalApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $withdrawal;

    public function __construct(User $user, $withdrawal)
    {
        $this->user = $user;
        $this->withdrawal = $withdrawal;
    }

    public function build()
    {
        return $this->subject('✅ Withdrawal Approved - ' . siteName())
                    ->view('emails.withdrawal-approved');
    }
}

