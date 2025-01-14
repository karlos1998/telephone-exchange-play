<?php

namespace Karlos3098\TelephoneExchangePlay\Exceptions;

class CouldNotSentNotification extends \Exception
{
    public function __construct(string $message, int $code, protected array $errors)
    {
        parent::__construct($message, $code);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
