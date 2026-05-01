<?php

namespace SohrabAzinfar\Language;

use SohrabAzinfar\Language\Services\LanguageManager;
use Illuminate\Support\ServiceProvider;

class LanguageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LanguageManager::class);
        $this->mergeConfigFrom(
            __DIR__.'/../config/language.php',
            'language'
        );
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../config/language.php' => config_path('language.php'),
        ], 'language-config');
    }
}