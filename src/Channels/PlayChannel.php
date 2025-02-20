<?php

namespace Karlos3098\TelephoneExchangePlay\Channels;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Karlos3098\TelephoneExchangePlay\Exceptions\GettingTokenFailed;
use Karlos3098\TelephoneExchangePlay\Interfaces\HasDifferentPhoneNumberForTelephoneExchangePlay;
use Karlos3098\TelephoneExchangePlay\Services\PlayMessage;
use Karlos3098\TelephoneExchangePlay\Services\TelephoneExchangePlayMessageService;

class PlayChannel
{
    private TelephoneExchangePlayMessageService $messageService;

    public function __construct()
    {
          $this->messageService = new TelephoneExchangePlayMessageService();
    }

    /**
     * @throws GettingTokenFailed
     * @throws ConnectionException
     */
    public function send($notifiable, Notification $notification)
    {
        /**
         * @var PlayMessage $scNotification
         */
        $scNotification = $notification->toPlayTelephoneExchange($notifiable);

        $phoneNumbers = $scNotification->getPhoneNumbers() ?? [];

        if (in_array(HasDifferentPhoneNumberForTelephoneExchangePlay::class, class_implements($notifiable::class))) {
            $userPhoneNumbers = $notifiable->routeNotificationForTelephoneExchangePlay($notification);
            if(is_array($userPhoneNumbers)) {
                $phoneNumbers = array_merge($userPhoneNumbers,$phoneNumbers);
            } else if(is_string($userPhoneNumbers) && $userPhoneNumbers != '') {
                $phoneNumbers[] = $notifiable->routeNotificationForTelephoneExchangePlay($notification);
            }
        }

        if(count($phoneNumbers) > 0) {
            $this->messageService->sendSms(
                recipients: $phoneNumbers,
                text: $scNotification->getText(),
                from: $scNotification->getFrom()
            );
        }

    }
}
