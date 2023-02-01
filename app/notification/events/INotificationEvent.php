<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 01.02.2023
 * Time: 13:52
 */

namespace App\notification\events;


interface INotificationEvent
{
    public function __construct(
        string $id,
        string $recipient,
        string $channel,
        int    $code,
        int    $dispatchAttempts,
        int    $occurredOn
    );

    public function getType() : string;

    public function dispatch(): void;

    public function getId(): string;

    public function getRecipient(): string;

    public function getChannel(): string;

    public function getCode(): int;

    public function getDispatchAttempts(): int;

    public function getOccurredOn(): int;

}
