<?php

namespace Karlos3098\TelephoneExchangePlay\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Karlos3098\TelephoneExchangePlay\Exceptions\GettingTokenFailed;

class TelephoneExchangePlayMessageService
{

    public function __construct()
    {

    }

    public function getBearerToken(): string
    {
        return Cache::remember("telephone-exchange-play-client-token:" . config('play_exchange.client.id'), config('play_exchange.client.token_validity_time'), function () {
            $jwtResponse = Http::baseUrl(config('play_exchange.base_url'))
                ->withBasicAuth(config('play_exchange.client.id'), config('play_exchange.client.secret'))
                ->post("/oauth/token-jwt");

            if($jwtResponse->failed()) {
                throw new GettingTokenFailed("Getting token failed", $jwtResponse->status());
            }

            return $jwtResponse->json('access_token');
        });
    }

    public function sendSms(array|string $recipients, string $text, string $from = null): void
    {
        $token = $this->getBearerToken();

        $response = Http::withToken($token)
            ->baseUrl(config('play_exchange.base_url'))
            ->accept('application/json')
            ->post('/api/bramkasms/sendSms', [
                'from' => $from ?? config('play_exchange.from'),
                'to' => is_array($recipients) ? $recipients : [$recipients],
                'text' => $text,
            ]);

        if ($response->failed()) {
            /**
             * Unfortunately, the play api does not return any answer what went wrong :)
             */
            throw new GettingTokenFailed("Message could not be sent", $response->status());
        }
    }

}
