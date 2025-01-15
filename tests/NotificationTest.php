<?php

use Illuminate\Notifications\ChannelManager;
use Karlos3098\TelephoneExchangePlay\Models\TestClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Karlos3098\TelephoneExchangePlay\Notifications\TestNotification;
use Karlos3098\TelephoneExchangePlay\Services\PlayMessage;

//it('sends SMS with correct sender and recipient from User model', function () {
//
//    $user = TestClient::make(['phone_number' => '4811111111']);
//
//    logger(config('play_exchange.base_url')); // Sprawdź, czy poprawna wartość jest załadowana
//
//    Http::fake([
//        'https://example.com/oauth/token-jwt' => Http::response(['access_token' => 'fake-token'], 200),
//        'https://example.com/api/bramkasms/sendSms' => Http::response(null, 200),
//    ]);
//
//    Notification::fake();
//
//    $user->notify(new TestNotification());
//
//    Http::assertSent(function ($request) use ($user) {
//        return $request->url() === 'https://example.com/api/bramkasms/sendSms' &&
//            $request['from'] === '48456456456' &&
//            $request['to'] === [$user->phone_number] &&
//            $request['text'] === "testowa\nwiadomość";
//    });
//});
