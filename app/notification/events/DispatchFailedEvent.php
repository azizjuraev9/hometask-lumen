<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 01.02.2023
 * Time: 13:46
 */

namespace App\notification\events;


use Illuminate\Support\Facades\Redis;

class DispatchFailedEvent extends NotificationEvent
{

    protected $type = 'DispatchFailedEvent';

}
