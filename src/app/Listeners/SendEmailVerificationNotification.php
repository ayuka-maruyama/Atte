<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VerifyEmailNotification; // 通知のクラス

class SendEmailVerificationNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $event->user->notify(new VerifyEmailNotification); // VerifyEmailNotificationを送信する
    }
}
