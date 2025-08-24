<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Model::preventLazyLoading();
        ResetPassword::createUrlUsing(fn (object $notifiable, string $token): string => config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}");

    }
}
