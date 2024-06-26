<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use App\Mail\CustomVerifyEmail;
use Illuminate\Support\Facades\Mail;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // メール認証の設定
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new CustomVerifyEmail($url))->to($notifiable->email);
        });

        // メール認証リンクの有効期限を変更
        VerifyEmail::createUrlUsing(function ($notifiable) {
            return url("/email/verify/{$notifiable->getKey()}/" . urlencode($notifiable->getEmailForVerification()));
        });
    }
}
