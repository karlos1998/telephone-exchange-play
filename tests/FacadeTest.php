<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Karlos3098\TelephoneExchangePlay\Facades\TelephoneExchangePlayMessage;
use Karlos3098\TelephoneExchangePlay\Exceptions\GettingTokenFailed;

it('sends an SMS successfully', function () {
    Http::fake([
        '*/oauth/token-jwt' => Http::response(['access_token' => 'fake-token'], 200),
        '*/api/bramkasms/sendSms' => Http::response(null, 200),
    ]);

    Cache::shouldReceive('remember')
        ->once()
        ->andReturn('fake-token');

    TelephoneExchangePlayMessage::sendSms('48123456789', 'fasada');

    Http::assertSent(function ($request) {
        return $request->url() === config('play_exchange.base_url') . '/api/bramkasms/sendSms' &&
            $request['to'] === ['48123456789'] &&
            $request['text'] === 'fasada';
    });
});

it('throws an exception when token retrieval fails', function () {
    Http::fake([
        '*/oauth/token-jwt' => Http::response(null, 401),
    ]);

    expect(fn() => TelephoneExchangePlayMessage::sendSms('48123456789', 'fasada'))
        ->toThrow(GettingTokenFailed::class, 'Getting token failed');
});

it('throws an exception when SMS sending fails', function () {
    Http::fake([
        '*/oauth/token-jwt' => Http::response(['access_token' => 'fake-token'], 200),
        '*/api/bramkasms/sendSms' => Http::response(null, 500),
    ]);

    Cache::shouldReceive('remember')
        ->once()
        ->andReturn('fake-token');

    expect(fn() => TelephoneExchangePlayMessage::sendSms('48123456789', 'fasada'))
        ->toThrow(GettingTokenFailed::class, 'Message could not be sent');
});
