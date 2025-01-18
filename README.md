## Laravel package for integration with Play network telephone gateways.

##
#### To get started, you will need an account on this platform with a purchased phone number.
https://uslugidlafirm.play.pl/welcome/index.html


### Installing the package
```php
composer require karlos3098/telephone-exchange-play
```

```php
php artisan vendor:publish --provider="Karlos3098\TelephoneExchangePlay\PlayProvider" --tag=config
```


Then in the API Play tab generate Client Id and Client Secret and then put them in the configuration. The last variable is the key validity time. You can choose any time. Just enter the same in .env
```dotenv
TELEPHONE_EXCHANGE_PLAY_DEFAULT_SENDER=48123456789
TELEPHONE_EXCHANGE_PLAY_CLIENT_ID=xxxxxxxxxxxxxxxx
TELEPHONE_EXCHANGE_PLAY_CLIENT_SECRET=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TELEPHONE_EXCHANGE_PLAY_CLIENT_VALIDITY_TIME=10
```

Then add the appropriate implementation in the model used for notifications and the method. Here is an example model:
```php
<?php

namespace Karlos3098\TelephoneExchangePlay\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Karlos3098\TelephoneExchangePlay\Interfaces\HasDifferentPhoneNumberForTelephoneExchangePlay;

class TestClient extends Authenticatable implements HasDifferentPhoneNumberForTelephoneExchangePlay
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function routeNotificationForTelephoneExchangePlay(Notification $notification): array|string|null
    {
        return $this->phone_number;
    }
}

```

For everything! From now on you can report notifications. Here's an example


```php
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Karlos3098\TelephoneExchangePlay\Interfaces\TelephoneExchangePlayNotification;
use Karlos3098\TelephoneExchangePlay\Services\PlayMessage;

class TestNotification extends Notification implements TelephoneExchangePlayNotification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [
            'play-exchange',
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function toPlayTelephoneExchange($notifiable): PlayMessage
    {
        return (new PlayMessage)
            ->line("example")
            ->line("message");
    }
}

```


If your user model returns null or you just want to add more phone numbers you can do it like this:
```php
public function toPlayTelephoneExchange($notifiable): PlayMessage
    {
        return (new PlayMessage)
            ->phoneNumber("48123456789", "48987654321", ...)
            ->line("example")
            ->line("message");
    }
```
