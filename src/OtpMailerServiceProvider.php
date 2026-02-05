<?php

declare(strict_types=1);

namespace Fekharmensour\OtpMailer;

use Illuminate\Support\ServiceProvider;

class OtpMailerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/otp-mailer.php', 'otp-mailer');

        $this->app->singleton('otpmailer', function ($app) {
            $config = $app['config']->get('otp-mailer', []);

            return new OtpMailerManager($config);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/otp-mailer.php' => config_path('otp-mailer.php'),
            ], 'config');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return ['otpmailer'];
    }
}
