<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 01.02.2023
 * Time: 14:04
 */

namespace App\notification\events;


use Illuminate\Support\Facades\Redis;

abstract class NotificationEvent implements INotificationEvent
{

    public function __construct(
        protected string $id,
        protected string $recipient,
        protected string $channel,
        protected int    $code,
        protected int    $dispatchAttempts,
        protected int    $occurredOn
    )
    {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function dispatch(): void
    {
        Redis::rpush($this->type, json_encode([
            'id' => $this->id,
            'recipient' => $this->recipient,
            'channel' => $this->channel,
            'code' => $this->code,
            'dispatchAttempts' => $this->dispatchAttempts,
            'occurredOn' => $this->occurredOn,
        ]));
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getDispatchAttempts(): int
    {
        return $this->dispatchAttempts;
    }

    public function getOccurredOn(): int
    {
        return $this->occurredOn;
    }

}
