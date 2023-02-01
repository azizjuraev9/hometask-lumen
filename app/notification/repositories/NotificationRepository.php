<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 01.02.2023
 * Time: 17:33
 */

namespace App\notification\repositories;


use App\notification\models\Notification;
use App\Models\Notification as DbModel;

class NotificationRepository implements INotificationRepository
{

    public function saveNotification(Notification $notification) : bool
    {
        $model = new DbModel();
        $model->id = $notification->getId();
        $model->recipient = $notification->getRecipient();
        $model->channel = $notification->getChannel();
        $model->code = $notification->getCode();
        $model->dispatched = $notification->getDispatched();
        $model->dispatchAttempts = $notification->getDispatchAttempts();
        return $model->save();
    }

    public function updateNotification(Notification $notification) : bool
    {
        $model = DbModel::where('id',$notification->getId())->first();
        $model->id = $notification->getId();
        $model->recipient = $notification->getRecipient();
        $model->channel = $notification->getChannel();
        $model->code = $notification->getCode();
        $model->dispatched = $notification->getDispatched();
        $model->dispatchAttempts = $notification->getDispatchAttempts();
        return $model->save();
    }

}
