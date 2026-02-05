<?php

declare(strict_types=1);

namespace Fekharmensour\OtpMailer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string generateAndSend(string $email)
 * @method static bool validate(string $email, string $code)
 */
class OtpMailer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'otpmailer';
    }
}
