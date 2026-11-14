<?php

namespace App\Providers;

use App\Support\Visitor\EncryptedVisitor;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Azure\AzureExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        // Registrado no boot() porque o VisitorServiceProvider é carregado
        // depois deste provider e sobrescreveria o binding no register().
        $this->app->singleton('shetabit-visitor', function ($app) {
            return new EncryptedVisitor($app->make(Request::class), config('visitor'));
        });

        Event::listen(
            SocialiteWasCalled::class,
            AzureExtendSocialite::class.'@handle'
        );
    }
}
