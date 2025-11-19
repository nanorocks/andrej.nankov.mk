<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Telegram Bot API Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Telegram Bot API credentials. These
    | credentials are used when sending notifications via the Telegram
    | notification channel.
    |
    */

    'bot_token' => env('TELEGRAM_BOT_TOKEN'),
    'default_chat_id' => env('TELEGRAM_CHAT_ID'),
];
