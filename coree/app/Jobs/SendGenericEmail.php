<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Mail\GenericTemplateMail;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class SendGenericEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $user;
    protected $emailTemplate;
    protected $placeholders;

    public function __construct($user, $emailTemplate, $placeholders = [])
    {
        $this->user = $user;
        $this->emailTemplate = $emailTemplate;
        $this->placeholders = $placeholders;
    }


    /**
     * Execute the job.
     */
    protected function replacePlaceholders($content)
    {
        $replace = [];

        // Prepare replacement array from placeholders
        foreach ($this->placeholders as $key => $value) {
            $replace["{{{$key}}}"] = $value;
        }

        return str_replace(array_keys($replace), array_values($replace), $content);
    }

    public function handle()
    {
        $content = $this->replacePlaceholders($this->emailTemplate->content);

        Mail::to($this->user->email)
            ->send(new GenericTemplateMail($this->emailTemplate->subject, $content));
    }
}
