<?php

namespace App\verification\events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;

abstract class VerificationEvent implements IVerificationEvent
{

    protected string $type;

    public function __construct(
        private string $id,
        private int    $code,
        private array  $subject,
        private int    $occurredOn
    )
    {
    }

    public function dispatch(): void
    {
        Redis::rpush($this->type, json_encode([
            'id' => $this->id,
            'code' => $this->code,
            'subject' => $this->subject,
            'occurredOn' => $this->occurredOn,
        ]));
    }

}
