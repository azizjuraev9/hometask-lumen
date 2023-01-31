<?php

namespace App\verification\events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;

class VerificationEvent implements IVerificationEvent
{

    const EVENT_VERIFICATION_CREATED = 'VerificationCreated';
    const EVENT_VERIFICATION_CONFIRMED = 'VerificationConfirmed';
    const EVENT_VERIFICATION_CONFIRMATION_FAILED = 'VerificationConfirmationFailed';

    public function __construct(
        private string $type,
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
