<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 01.02.2023
 * Time: 13:40
 */

namespace Tests;


use App\notification\channels\MessageChannel;
use App\notification\events\VerificationCreated;
use App\notification\models\Notification;
use App\notification\requests\TemplateRequest;
use Illuminate\Support\Facades\Redis;

class NotificationTest extends TestCase
{

    private function queueClear($key){
        for($i = 0; $i < 1000; $i++){
            Redis::lpop($key);
        }
    }

    public function test_dispatch_sms()
    {
        $this->queueClear('NotificationCreated');
        $this->queueClear('NotificationDispatched');

        $event = new VerificationCreated([
            'identity' => '+37120000001',
            'type' => 'mobile_confirmation',
        ],1111);

        $notification = new Notification();
        $notification->initFromVerificationEvent($event, new TemplateRequest());

        $queueData = Redis::lpop('NotificationCreated');
        $queueData = json_decode($queueData);
        $this->assertEquals($queueData->id, $notification->getId());

        $notification->dispatch(new MessageChannel());

        $queueData = Redis::lpop('NotificationDispatched');
        $queueData = json_decode($queueData);
        $this->assertEquals($queueData->id, $notification->getId());
    }

    public function test_dispatch_email()
    {
        $this->queueClear('NotificationCreated');
        $this->queueClear('NotificationDispatched');

        $event = new VerificationCreated([
            'identity' => 'john.doe@abc.xyz',
            'type' => 'email_confirmation',
        ],1111);

        $notification = new Notification();
        $notification->initFromVerificationEvent($event, new TemplateRequest());

        $queueData = Redis::lpop('NotificationCreated');
        $queueData = json_decode($queueData);
        $this->assertEquals($queueData->id, $notification->getId());

        $notification->dispatch(new MessageChannel());

        $queueData = Redis::lpop('NotificationDispatched');
        $queueData = json_decode($queueData);
        $this->assertEquals($queueData->id, $notification->getId());
    }

}
