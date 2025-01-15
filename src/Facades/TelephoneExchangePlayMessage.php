<?php

namespace Karlos3098\TelephoneExchangePlay\Facades;

use Illuminate\Support\Facades\Facade;
use Karlos3098\TelephoneExchangePlay\Services\TelephoneExchangePlayMessageService;

/**
 * @method static void sendMessage(array|string $recipients, string $text, string $from = null)
 *
 * @see \Karlos3098\TelephoneExchangePlay\Services\TelephoneExchangePlayMessageService
 */
class TelephoneExchangePlayMessage extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TelephoneExchangePlayMessageService::class;
    }
}
