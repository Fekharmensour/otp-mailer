<?php

declare(strict_types=1);

namespace Fekharmensour\OtpMailer;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use Illuminate\Support\Str;

class OtpMailerManager
{
    /**
     * Configuration array.
     *
     * @var array<string, mixed>
     */
    protected array $config;

    /**
     * Cache repository instance.
     */
    protected CacheRepository $cache;

    /**
     * Constructor.
     *
     * @param array<string, mixed> $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
        $store = $config['cache_store'] ?? null;
        $this->cache = app('cache')->store($store);
    }

    /**
     * Generate a 6-digit OTP, store it in cache keyed by email and send it.
     *
     * @param string $email
     * @return string The generated OTP code
     */
    public function generateAndSend(string $email): string
    {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $key = $this->cacheKey($email);
        $ttl = (int) ($this->config['ttl'] ?? 300);

        $this->cache->put($key, $code, $ttl);

        $notificationClass = $this->config['notification'] ?? Notifications\OtpNotification::class;

        NotificationFacade::route('mail', $email)->notify(new $notificationClass($code, $ttl));

        return $code;
    }

    /**
     * Validate an OTP for the given email.
     *
     * @param string $email
     * @param string $code
     */
    public function validate(string $email, string $code): bool
    {
        $key = $this->cacheKey($email);
        $cached = $this->cache->get($key);

        if ($cached === null) {
            return false;
        }

        if (hash_equals((string) $cached, (string) $code)) {
            $this->cache->forget($key);

            return true;
        }

        return false;
    }

    /**
     * Build cache key for email.
     */
    protected function cacheKey(string $email): string
    {
        $prefix = $this->config['cache_prefix'] ?? 'otp_mailer:';

        return $prefix . sha1(Str::lower(trim($email)));
    }
}
