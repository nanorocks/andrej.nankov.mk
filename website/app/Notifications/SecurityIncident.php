<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Services\IpIntelligenceService;
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
        private readonly array $incidentData,
    ) {
        $this->onQueue('notifications');
    }

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

    // -------------------------------------------------------------------------
    // Telegram
    // -------------------------------------------------------------------------

    public function toTelegram(mixed $notifiable): TelegramMessage
    {
        $d     = $this->incidentData;
        $type  = $d['type'];
        $ip    = $d['ip'];
        $geo   = $d['geo'] ?? [];
        $intel = app(IpIntelligenceService::class);

        $titleEmoji = match ($type) {
            'brute_force'         => '🚨',
            'failed_login'        => '⚠️',
            'suspicious_activity' => '🔍',
            default               => '🛡️',
        };

        $title = match ($type) {
            'brute_force'         => 'BRUTE FORCE ATTACK',
            'failed_login'        => 'MULTIPLE FAILED LOGINS',
            'suspicious_activity' => 'SUSPICIOUS ACTIVITY',
            default               => 'SECURITY INCIDENT',
        };

        $threatLevel = $d['threat_level'] ?? $intel->threatLevel($geo, (int) ($d['attempts'] ?? $d['requests_per_min'] ?? 0));
        $levelEmoji  = match ($threatLevel) {
            'CRITICAL' => '🔴',
            'HIGH'     => '🟠',
            'MEDIUM'   => '🟡',
            default    => '🟢',
        };

        $flag = ! empty($geo['country_code']) ? $intel->flag($geo['country_code']) : '🏳️';

        // ── Header ───────────────────────────────────────────────────────────
        $msg  = "{$titleEmoji} <b>{$title}</b> — andrej.nankov.mk\n";
        $msg .= "{$levelEmoji} Risk: <b>{$threatLevel}</b>\n";

        // ── Origin ───────────────────────────────────────────────────────────
        $msg .= "\n📍 <b>ORIGIN</b>\n";
        $msg .= "IP: <code>" . e($ip) . "</code>\n";

        if (! empty($geo['country'])) {
            $loc = $intel->locationLine($geo);
            $msg .= "Location: {$flag} {$loc}\n";

            if (! empty($geo['timezone']) && $geo['timezone'] !== 'Unknown') {
                $msg .= "Timezone: " . e($geo['timezone']) . "\n";
            }

            if (! empty($geo['isp']) && $geo['isp'] !== 'Unknown') {
                $msg .= "ISP: " . e($geo['isp']) . "\n";
            }

            if (! empty($geo['asn']) && $geo['asn'] !== 'Unknown') {
                $msg .= "ASN: " . e($geo['asn']) . "\n";
            }

            $tags = $intel->tags($geo);
            if ($tags) {
                $msg .= "Signals: " . implode(' · ', $tags) . "\n";
            }
        }

        // ── Attack details ────────────────────────────────────────────────────
        $msg .= "\n⚔️ <b>ATTACK</b>\n";

        if (! empty($d['method']) && ! empty($d['url'])) {
            $path = '/' . ltrim(parse_url($d['url'], PHP_URL_PATH) ?? '', '/');
            $msg .= "Target: <code>" . e($d['method'] . ' ' . $path) . "</code>\n";
        }

        if (! empty($d['email'])) {
            $msg .= "Account: <code>" . e($d['email']) . "</code>\n";
        }

        if (! empty($d['attempts'])) {
            $msg .= "Attempts: <b>" . (int) $d['attempts'] . "</b> (15-min window)\n";
        }

        if (! empty($d['requests_per_min'])) {
            $msg .= "Rate: <b>" . (int) $d['requests_per_min'] . "</b> req/min\n";
        }

        $targetedEmails = $d['targeted_emails'] ?? [];
        if (count($targetedEmails) > 1) {
            $msg .= "Accounts targeted: <b>" . count($targetedEmails) . "</b>\n";
        }

        if (! empty($d['pattern'])) {
            $msg .= "Pattern: " . e($d['pattern']) . "\n";
        }

        if (! empty($d['details'])) {
            $msg .= "Note: " . e($d['details']) . "\n";
        }

        $time = date('d M Y H:i', strtotime($d['timestamp'])) . ' UTC';
        $msg .= "Time: {$time}\n";

        // ── User agent ────────────────────────────────────────────────────────
        if (! empty($d['user_agent'])) {
            $ua  = substr($d['user_agent'], 0, 80);
            $msg .= "\n🖥️ <b>CLIENT</b>\n<code>" . e($ua) . (strlen($d['user_agent']) > 80 ? '…' : '') . "</code>\n";
        }

        // ── Investigation links ───────────────────────────────────────────────
        $encodedIp = urlencode($ip);
        $msg .= "\n🔗 <b>INVESTIGATE</b>\n";
        $msg .= "<a href=\"https://www.abuseipdb.com/check/{$encodedIp}\">AbuseIPDB</a>";
        $msg .= " · <a href=\"https://www.virustotal.com/gui/ip-address/{$encodedIp}\">VirusTotal</a>";
        $msg .= " · <a href=\"https://ipinfo.io/{$encodedIp}\">IPInfo</a>";

        return TelegramMessage::create()
            ->to(config('services.telegram.chat_id'))
            ->content($msg)
            ->token(config('services.telegram.bot_token'))
            ->options([
                'parse_mode'               => 'HTML',
                'disable_web_page_preview' => true,
            ]);
    }

    // -------------------------------------------------------------------------
    // Slack
    // -------------------------------------------------------------------------

    public function toSlack(mixed $notifiable): SlackMessage
    {
        $d    = $this->incidentData;
        $type = $d['type'];
        $geo  = $d['geo'] ?? [];

        $color = match ($type) {
            'brute_force'         => 'danger',
            'failed_login'        => 'warning',
            'suspicious_activity' => 'warning',
            default               => 'good',
        };

        $title = match ($type) {
            'brute_force'         => '🚨 Brute Force Attack',
            'failed_login'        => '⚠️ Multiple Failed Logins',
            'suspicious_activity' => '🔍 Suspicious Activity',
            default               => '🛡️ Security Incident',
        };

        $fields = [
            'Domain'       => 'andrej.nankov.mk',
            'IP'           => $d['ip'],
            'Location'     => ! empty($geo['city']) ? "{$geo['city']}, {$geo['country']}" : 'Unknown',
            'ISP'          => $geo['isp'] ?? 'Unknown',
            'Time'         => $d['timestamp'],
            'Threat Level' => $d['threat_level'] ?? 'UNKNOWN',
            'Details'      => $d['details'] ?? 'No details',
        ];

        if (! empty($d['email'])) {
            $fields['Account'] = $d['email'];
        }

        if (! empty($d['attempts'])) {
            $fields['Attempts'] = (string) $d['attempts'];
        }

        return (new SlackMessage)
            ->from('Security Bot', ':shield:')
            ->to('#security')
            ->attachment(function ($attachment) use ($title, $color, $fields) {
                $attachment
                    ->title($title)
                    ->color($color)
                    ->fields($fields)
                    ->footer('Security Alert — andrej.nankov.mk')
                    ->timestamp(now());
            });
    }

    // -------------------------------------------------------------------------
    // Mail
    // -------------------------------------------------------------------------

    public function toMail(mixed $notifiable): MailMessage
    {
        $d    = $this->incidentData;
        $type = $d['type'];
        $geo  = $d['geo'] ?? [];
        $ip   = $d['ip'];

        $subject = match ($type) {
            'brute_force'         => '[SECURITY ALERT] Brute Force Attack — andrej.nankov.mk',
            'failed_login'        => '[SECURITY ALERT] Multiple Failed Logins — andrej.nankov.mk',
            'suspicious_activity' => '[SECURITY ALERT] Suspicious Activity — andrej.nankov.mk',
            default               => '[SECURITY ALERT] Security Incident — andrej.nankov.mk',
        };

        $threatLevel = $d['threat_level'] ?? 'UNKNOWN';
        $location    = ! empty($geo['city'])
            ? "{$geo['city']}, {$geo['region']}, {$geo['country']}"
            : 'Unknown';

        $message = (new MailMessage)
            ->subject($subject)
            ->greeting('Security Alert!')
            ->line('A security incident has been detected on **andrej.nankov.mk**.')
            ->line('')
            ->line('**── SUMMARY ──**')
            ->line('**Type:** ' . ucwords(str_replace('_', ' ', $type)))
            ->line("**Risk Level:** {$threatLevel}")
            ->line('')
            ->line('**── ORIGIN ──**')
            ->line("**IP Address:** {$ip}")
            ->line("**Location:** {$location}")
            ->line('**ISP:** ' . ($geo['isp'] ?? 'Unknown'))
            ->line('**ASN:** ' . ($geo['asn'] ?? 'Unknown'));

        $tags = app(IpIntelligenceService::class)->tags($geo);
        if ($tags) {
            $message->line('**Signals:** ' . implode(', ', $tags));
        }

        $message->line('')->line('**── ATTACK ──**');

        if (! empty($d['email'])) {
            $message->line("**Target Account:** {$d['email']}");
        }

        if (! empty($d['attempts'])) {
            $message->line("**Attempts:** {$d['attempts']} (15-min window)");
        }

        if (! empty($d['requests_per_min'])) {
            $message->line("**Request Rate:** {$d['requests_per_min']} req/min");
        }

        $targetedEmails = $d['targeted_emails'] ?? [];
        if (count($targetedEmails) > 1) {
            $message->line('**Accounts Targeted:** ' . count($targetedEmails));
        }

        if (! empty($d['pattern'])) {
            $message->line("**Pattern:** {$d['pattern']}");
        }

        if (! empty($d['user_agent'])) {
            $message->line('**User Agent:** ' . substr($d['user_agent'], 0, 150));
        }

        return $message
            ->line('')
            ->line("**Time:** {$d['timestamp']}")
            ->line('')
            ->line('**Details:** ' . ($d['details'] ?? 'No additional details'))
            ->action('Check on AbuseIPDB', "https://www.abuseipdb.com/check/{$ip}")
            ->line('This is an automated security alert from your Laravel application.')
            ->salutation('Security Team — andrej.nankov.mk');
    }

    // -------------------------------------------------------------------------
    // Array (stored notifications / tests)
    // -------------------------------------------------------------------------

    public function toArray(mixed $notifiable): array
    {
        return $this->incidentData;
    }
}
