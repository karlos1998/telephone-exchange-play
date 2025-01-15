<?php

namespace Karlos3098\TelephoneExchangePlay\Interfaces;
use Karlos3098\TelephoneExchangePlay\Services\PlayMessage;

interface TelephoneExchangePlayNotification
{
    public function toPlayTelephoneExchange(object $notifiable): PlayMessage;
}
