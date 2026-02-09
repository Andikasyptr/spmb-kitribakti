<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

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
    // Paksa semua URL agar menggunakan https
    if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }

    // Register Brevo mail transport
    Mail::extend('brevo', function (array $config) {
        $factory = new BrevoTransportFactory();
        $dsn = Dsn::fromString("brevo+api://{$config['key']}@default");
        return $factory->create($dsn);
    });
}
}
