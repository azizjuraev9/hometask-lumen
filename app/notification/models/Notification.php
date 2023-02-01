<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 15:04
 */

namespace App\notification\models;


use App\notification\channels\IMessageChannel;
use App\notification\channels\MessageChannel;
use App\notification\events\DispatchFailedEvent;
use App\notification\events\NotificationCreated;
use App\notification\events\NotificationDispatched;
use App\notification\events\VerificationCreated;
use App\notification\requests\TemplateRequest;

class Notification
{

    const MAX_ATTEMPTS = 5;

    private string $id;
    private string $recipient;
    private string $channel;
    private int $code;
    private string $body;
    private bool $dispatched = false;
    private int $dispatchAttempts = 0;

    public function initFromVerificationEvent(VerificationCreated $event, TemplateRequest $request): void
    {
        $subject = $event->getSubject();
        $this->id = UUID::getUUID();
        $this->recipient = $subject['identity'];
        $this->channel = $subject['type'];
        $this->code = $event->getCode();
        $this->body = $request->requestTemplate($this->channel, $this->code);

        (new NotificationCreated(
            $this->id,
            $this->recipient,
            $this->channel,
            $this->code,
            $this->dispatchAttempts,
            time()
        ))->dispatch();
    }

    public function initFromFailedEvent(DispatchFailedEvent $event, TemplateRequest $request): void
    {
        $this->id = $event->getId();
        $this->recipient = $event->getRecipient();
        $this->channel = $event->getChannel();
        $this->code = $event->getCode();
        $this->dispatchAttempts = $event->getDispatchAttempts();
        $this->body = $request->requestTemplate($this->channel, $this->code);
    }

    public function dispatch(MessageChannel $channel)
    {
        $this->dispatchAttempts++;
        $this->dispatched = $channel->getChannel($this->channel)->send($this->recipient, $this->body);

        if(!$this->dispatched && $this->dispatchAttempts < self::MAX_ATTEMPTS){
            (new DispatchFailedEvent(
                $this->id,
                $this->recipient,
                $this->channel,
                $this->code,
                $this->dispatchAttempts,
                time()
            ))->dispatch();
        }

        (new NotificationDispatched(
            $this->id,
            $this->recipient,
            $this->channel,
            $this->code,
            $this->dispatchAttempts,
            time()
        ))->dispatch();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRecipient()
    {
        return $this->recipient;
    }

    public function getChannel()
    {
        return $this->channel;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getDispatched()
    {
        return $this->dispatched;
    }

    public function getDispatchAttempts()
    {
        return $this->dispatchAttempts;
    }

}
