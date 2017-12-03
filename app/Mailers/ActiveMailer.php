<?php

namespace App\Mailers;

use App\Models\User;
use Naux\Mail\SendCloudTemplate;

class ActiveMailer
{
    public static function send(User $user)
    {
        $user->resetActiveToken();

        $template  = new SendCloudTemplate(config('mail.templates.register'), ['link' => 'http://localhost:8080/active/' . $user->active_token]);

        \Mail::raw($template, function($message) use ($user) {
            $message->to($user->email);
        });
    }
}