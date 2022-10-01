<?php

namespace Armincms\NovaTranslation;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Console\Events\ArtisanStarting;
use Illuminate\Contracts\Support\DeferrableProvider;
use Laravel\Nova\Events\ServingNova;


class ServiceProvider extends LaravelServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        Gate::policy(\Spatie\TranslationLoader\LanguageLine::class, Policies\Translation::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Get the events that trigger this service provider to register.
     *
     * @return array
     */
    public function when()
    {
        return [
            ServingNova::class,
            ArtisanStarting::class,
        ];
    }
}
