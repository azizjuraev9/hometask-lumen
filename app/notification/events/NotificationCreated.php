<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 21:57
 */

namespace App\notification\events;


use Illuminate\Support\Facades\Redis;

class NotificationCreated extends NotificationEvent
{

    protected $type = 'NotificationCreated';

}
