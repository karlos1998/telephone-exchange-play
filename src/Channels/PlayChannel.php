<?php

namespace Karlos3098\TelephoneExchangePlay\Channels;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Karlos3098\TelephoneExchangePlay\Exceptions\CouldNotSentNotification;
use Karlos3098\TelephoneExchangePlay\Interfaces\HasDifferentPhoneNumberForTelephoneExchangePlay;
use Karlos3098\TelephoneExchangePlay\Services\PlayMessage;

class PlayChannel
{
    public function __construct()
    {
    }

    /**
     * @throws CouldNotSentNotification
     * @throws ConnectionException
     */
    public function send($notifiable, Notification $notification)
    {
        /**
         * @var PlayMessage $scNotification
         */
        $scNotification = $notification->toPlayTelephoneExchange($notifiable);

        ///////////////////////////////////
        $phoneNumbers = $scNotification->getPhoneNumbers();

        if (in_array(HasDifferentPhoneNumberForTelephoneExchangePlay::class, class_implements($notifiable::class))) {
            $userPhoneNumbers = $notifiable->routeNotificationForTelephoneExchangePlay($notification);
            if(is_array($userPhoneNumbers)) {
                $phoneNumbers = array_merge($userPhoneNumbers,$phoneNumbers);
            } else if(is_string($userPhoneNumbers)) {
                $phoneNumbers[] = $notifiable->routeNotificationForTelephoneExchangePlay($notification);
            }
        }

        $token = Cache::remember("telephone-exchange-play-client-token:" . config('play_exchange.client.id'), config('play_exchange.client.token_validity_time'), function () use ($scNotification) {
            $jwtResponse = Http::baseUrl(config('play_exchange.base_url'))
                ->withBasicAuth(config('play_exchange.client.id'), config('play_exchange.client.secret'))
                ->post("/oauth/token-jwt");
            return $jwtResponse->json('access_token');
        });

        $response = Http::withToken($token)
            ->baseUrl(config('play_exchange.base_url'))
            ->accept('application/json')
            ->post('/api/bramkasms/sendSms', [
                'from' => $scNotification->getFrom(),
                'to' => $phoneNumbers,
                'text' => $scNotification->getText(),
            ]);


        if ($response->failed()) {
            /**
             * Unfortunately, the play api does not return any answer what went wrong :)
             */
            throw new CouldNotSentNotification("Message could not be sent", $response->status(), []);
        }

    }
}
