<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 01.02.2023
 * Time: 16:58
 */

namespace App\notification\services;


use App\notification\channels\MessageChannel;
use App\notification\events\DispatchFailedEvent;
use App\notification\events\VerificationCreated;
use App\notification\models\Notification;
use App\notification\repositories\INotificationRepository;
use App\notification\requests\TemplateRequest;

class NotificationService
{



    public function __construct(
        public INotificationRepository $notificationRepository
    )
    {
    }

    public function consumeVerificationCreated(array $subject, string $code) : void
    {
        $event = new VerificationCreated($subject,$code);

        $notification = new Notification();
        $notification->initFromVerificationEvent($event, new TemplateRequest());
        $notification->dispatch(new MessageChannel());
        $this->notificationRepository->saveNotification($notification);
    }

    public function consumeDispatchFailed(array $eventData) : void
    {
        $event = new DispatchFailedEvent(
            $eventData['id'],
            $eventData['recipient'],
            $eventData['channel'],
            $eventData['code'],
            $eventData['dispatchAttempts'],
            time()
        );

        $notification = new Notification();
        $notification->initFromFailedEvent($event, new TemplateRequest());
        $notification->dispatch(new MessageChannel());
        $this->notificationRepository->updateNotification($notification);
    }

}
