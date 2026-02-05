<?php

declare(strict_types=1);

namespace Fekharmensour\OtpMailer\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OtpNotification extends Notification
{
    protected string $code;

    protected int $ttl;

    public function __construct(string $code, int $ttl)
    {
        $this->code = $code;
        $this->ttl = $ttl;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     */
    public function toMail($notifiable): MailMessage
    {
        $minutes = (int) max(1, ceil($this->ttl / 60));

        return (new MailMessage())
            ->subject('Your verification code')
            ->line('Your verification code is: ' . $this->code)
            ->line("This code will expire in {$minutes} minute(s).")
            ->line('If you did not request this, please ignore this email.');
    }
}
