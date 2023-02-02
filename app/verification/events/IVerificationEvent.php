<?php

namespace App\verification\events;

interface IVerificationEvent
{

    public function __construct(
        string $id,
        int    $code,
        array  $subject,
        int    $occurredOn
    );

    public function dispatch() : void;
}
