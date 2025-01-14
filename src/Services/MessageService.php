<?php

namespace Karlos3098\TelephoneExchangePlay\Services;

use Illuminate\Support\Facades\Http;

class MessageService
{
    private string $token;

    public function __construct()
    {
        $this->setBearerToken(config('simply_connect.api_key'));
    }

    public function setBearerToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getBearerToken(): string
    {
        return $this->token;
    }

}
