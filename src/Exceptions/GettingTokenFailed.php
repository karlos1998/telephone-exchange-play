<?php

namespace Karlos3098\TelephoneExchangePlay\Exceptions;

class GettingTokenFailed extends \Exception
{
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }
}
