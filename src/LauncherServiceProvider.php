<?php

namespace TheAgency2627\SocialiteLauncher;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;

class LauncherServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Socialite::extend('launcher', fn () => Socialite::buildProvider(
            LauncherProvider::class,
            config('services.launcher'),
        ));
    }
}
