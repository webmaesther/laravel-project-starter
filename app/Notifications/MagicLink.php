<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

final class MagicLink extends Notification
{
    use Queueable;

    public string $app_name;

    public string $url;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user)
    {
        $this->app_name = config()->string('app.name');
        $this->url = URL::temporarySignedRoute(
            'login.link.show', now()->addMinutes(15), ['user' => $this->user->id]
        );
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject('Magic Link')
            ->line("Welcome back {$this->user->name}!")
            ->line("Use the following link to login to {$this->app_name}.")
            ->action('Magic Link', $this->url)
            ->line('Good to see you again!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'app_name' => $this->app_name,
            'url' => $this->url,
        ];
    }
}
