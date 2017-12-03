<?php

namespace App\Listeners;

use App\Events\UserRegisterd;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendActiveMail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegisterd $event
     * @return void
     */
    public function handle(UserRegisterd $event)
    {
        app(\App\Mailers\ActiveMailer::class)->send($event->user);
    }
}
