<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class SecurityIncident extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private array $incidentData
    ) {
        $this->onQueue('notifications');
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(mixed $notifiable): array
    {
        $channels = ['mail'];

        if (config('services.telegram.bot_token') && config('services.telegram.chat_id')) {
            $channels[] = TelegramChannel::class;
        }

        if (config('services.slack.webhook_url')) {
            $channels[] = 'slack';
        }

        return $channels;
    }

    /**
     * Get the Telegram representation of the notification.
     */
    public function toTelegram(mixed $notifiable): TelegramMessage
    {
        $type = $this->incidentData['type'];
        $ip = $this->incidentData['ip'];
        $email = $this->incidentData['email'] ?? 'Unknown';
        $timestamp = $this->incidentData['timestamp'];
        $details = $this->incidentData['details'] ?? 'No additional details';

        $emoji = match ($type) {
            'brute_force' => '🚨',
            'failed_login' => '⚠️',
            'suspicious_activity' => '🔍',
            default => '🛡️'
        };

        $title = match ($type) {
            'brute_force' => 'BRUTE FORCE ATTACK DETECTED',
            'failed_login' => 'MULTIPLE FAILED LOGINS',
            'suspicious_activity' => 'SUSPICIOUS ACTIVITY DETECTED',
            default => 'SECURITY INCIDENT'
        };

        $message = "{$emoji} *{$title}*\n\n";
        $message .= "🌐 *Domain:* andrej.nankov.mk\n";
        $message .= "📍 *IP Address:* `{$ip}`\n";
        $message .= "👤 *Email:* `{$email}`\n";
        $message .= "🕐 *Time:* {$timestamp}\n";
        $message .= "📝 *Details:* {$details}\n\n";

        if (isset($this->incidentData['attempts'])) {
            $message .= "🔢 *Attempts:* {$this->incidentData['attempts']}\n";
        }

        if (isset($this->incidentData['user_agent'])) {
            $userAgent = substr($this->incidentData['user_agent'], 0, 100);
            $message .= "🌐 *User Agent:* `{$userAgent}`\n";
        }

        $message .= "\n🛡️ *Recommended Actions:*\n";
        $message .= "• Monitor IP address for further activity\n";
        $message .= "• Consider blocking IP if pattern continues\n";
        $message .= "• Review server logs for additional context\n";

        return TelegramMessage::create()
            ->to(config('services.telegram.chat_id'))
            ->content($message)
            ->token(config('services.telegram.bot_token'))
            ->options([
                'parse_mode' => 'Markdown',
                'disable_web_page_preview' => true,
            ]);
    }

    /**
     * Get the Slack representation of the notification.
     */
    public function toSlack(mixed $notifiable): SlackMessage
    {
        $type = $this->incidentData['type'];
        $ip = $this->incidentData['ip'];
        $email = $this->incidentData['email'] ?? 'Unknown';

        $color = match ($type) {
            'brute_force' => 'danger',
            'failed_login' => 'warning',
            'suspicious_activity' => 'warning',
            default => 'good'
        };

        $title = match ($type) {
            'brute_force' => '🚨 Brute Force Attack Detected',
            'failed_login' => '⚠️ Multiple Failed Logins',
            'suspicious_activity' => '🔍 Suspicious Activity',
            default => '🛡️ Security Incident'
        };

        return (new SlackMessage)
            ->from('Security Bot', ':shield:')
            ->to('#security')
            ->attachment(function ($attachment) use ($title, $color, $ip, $email) {
                $attachment
                    ->title($title)
                    ->color($color)
                    ->fields([
                        'Domain' => 'andrej.nankov.mk',
                        'IP Address' => $ip,
                        'Email' => $email,
                        'Time' => $this->incidentData['timestamp'],
                        'Details' => $this->incidentData['details'] ?? 'No details',
                    ])
                    ->footer('Security Alert System')
                    ->timestamp(now());
            });
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        $type = $this->incidentData['type'];
        $ip = $this->incidentData['ip'];
        $email = $this->incidentData['email'] ?? 'Unknown';

        $subject = match ($type) {
            'brute_force' => '[SECURITY ALERT] Brute Force Attack - andrej.nankov.mk',
            'failed_login' => '[SECURITY ALERT] Multiple Failed Logins - andrej.nankov.mk',
            'suspicious_activity' => '[SECURITY ALERT] Suspicious Activity - andrej.nankov.mk',
            default => '[SECURITY ALERT] Security Incident - andrej.nankov.mk'
        };

        return (new MailMessage)
            ->subject($subject)
            ->greeting('Security Alert!')
            ->line("A security incident has been detected on andrej.nankov.mk")
            ->line("**Incident Type:** " . ucwords(str_replace('_', ' ', $type)))
            ->line("**IP Address:** {$ip}")
            ->line("**Email:** {$email}")
            ->line("**Time:** {$this->incidentData['timestamp']}")
            ->line("**Details:** " . ($this->incidentData['details'] ?? 'No additional details'))
            ->when(
                isset($this->incidentData['attempts']),
                fn($message) => $message->line("**Failed Attempts:** {$this->incidentData['attempts']}")
            )
            ->when(
                isset($this->incidentData['user_agent']),
                fn($message) => $message->line("**User Agent:** " . substr($this->incidentData['user_agent'], 0, 100))
            )
            ->line('Please review your server logs and take appropriate action if necessary.')
            ->action('View Server Logs', url('/'))
            ->line('This is an automated security alert from your Laravel application.')
            ->salutation('Security Team - andrej.nankov.mk');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(mixed $notifiable): array
    {
        return $this->incidentData;
    }
}
