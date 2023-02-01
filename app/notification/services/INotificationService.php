<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 01.02.2023
 * Time: 17:46
 */

namespace App\notification\services;


use App\notification\repositories\INotificationRepository;

interface INotificationService
{

    public function __construct(INotificationRepository $notificationRepository);

    public function consumeVerificationCreated(array $subject, string $code) : void;

    public function consumeDispatchFailed(array $eventData) : void;

}
