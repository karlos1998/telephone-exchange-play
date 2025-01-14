<?php

namespace Karlos3098\TelephoneExchangePlay\Interfaces;

use Illuminate\Notifications\Notification;

interface HasDifferentPhoneNumberForTelephoneExchangePlay
{
    /**
     * Route notifications for the 'Play' telephone exchange channel.
     *
     * @return  array<string>|string|null
     */
    public function routeNotificationForTelephoneExchangePlay(Notification $notification): array|string|null;
}
