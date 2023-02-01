<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 01.02.2023
 * Time: 17:45
 */

namespace App\notification\repositories;


use App\notification\models\Notification;

interface INotificationRepository
{

    public function saveNotification(Notification $notification): bool;

    public function updateNotification(Notification $notification): bool;

}
