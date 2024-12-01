<?php

namespace App\Listeners;

use App\Events\newUserCreated;
use App\Mail\sendEmailVerfication;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailVerify
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(newUserCreated $event): void
    {
        Mail::to($event->user->email)->send(new sendEmailVerfication($event->user));
    }
}
