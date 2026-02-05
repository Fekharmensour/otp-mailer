<?php

declare(strict_types=1);

return [
    /**
     * Time to live for OTP codes (in seconds).
     */
    'ttl' => env('OTP_AUTH_TTL', 300),

    /**
     * The notification class used to send OTPs. You may replace this with your own class
     * that implements the same constructor signature (string $code, int $ttl).
     */
    'notification' => \Fekharmensour\OtpMailer\Notifications\OtpNotification::class,

    /**
     * Cache key prefix.
     */
    'cache_prefix' => 'otp_mailer:',

    /**
     * Optional cache store name. Null uses default store.
     */
    'cache_store' => null,
];
