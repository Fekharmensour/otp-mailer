<?php

declare(strict_types=1);

namespace Fekharmensour\OtpMailer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Backwards compatibility facade name.
 *
 * Use `OtpMailer` facade instead. This class proxies to the same binding.
 *
 * @method static string generateAndSend(string $email)
 * @method static bool validate(string $email, string $code)
 */
class OtpAuth extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'otpmailer';
    }
}
