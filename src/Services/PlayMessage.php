<?php

namespace Karlos3098\TelephoneExchangePlay\Services;

class PlayMessage
{
    private string $text = '';

    private string $from;

    private array $phoneNumbers = [];

    public function __construct()
    {
        $from = config('play_exchange.from');
        if ($from) {
            $this->from = $from;
        }
    }

    //getters
    public function getText(): string
    {
        return $this->text;
    }

    public function getFrom(): string
    {
        return $this->from ?? config('play_exchange.from');
    }
    public function getPhoneNumbers(): array
    {
        return $this->phoneNumbers;
    }

    /**
     * @param string $from
     * @return $this
     * From phone number (fromat: 48123456789)
     */
    public function from(string $from): static
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param string $text
     * @return $this
     * Text message
     */
    public function text(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function phoneNumber(string ...$phoneNumbers): static
    {
        $this->phoneNumbers = array_merge($this->phoneNumbers, $phoneNumbers);

        return $this;
    }

    public function line(string $line): static
    {
        if (! empty($this->text)) {
            $this->breakLine();
        }

        $this->text .= $line;

        return $this;
    }

    public function breakLine(): static
    {
        $this->text .= "\n";

        return $this;
    }
}
