<?php

namespace LoiPham\Language;

use Illuminate\Support\ServiceProvider;
class LanguageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('language', function () {
            return true;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/language.php', 'language');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php', 'language');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'language');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'language');
        $this->publishes([
            __DIR__.'/../public' => public_path('app-assets/language'),
        ], 'language_public');
    }
}
