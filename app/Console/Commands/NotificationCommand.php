<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 01.02.2023
 * Time: 17:18
 */

namespace App\Console\Commands;


use App\notification\services\NotificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class NotificationCommand extends Command
{

    public function __construct(
        public NotificationService $notificationService
    )
    {
        parent::__construct();
    }

    protected $signature = 'notification:consume';

    public function handle()
    {
        while (true) {
            $failedData = Redis::lpop('DispatchFailedEvent');
            if($failedData){
                $failedData = json_decode($failedData,true);
                $this->notificationService->consumeDispatchFailed($failedData);
            }

            $newNotification = Redis::lpop('VerificationCreated');
            if($newNotification){
                $newNotification = json_decode($newNotification,true);
                $this->notificationService->consumeVerificationCreated($newNotification['subject'],$newNotification['code']);
            }

            sleep(1);
        }
    }

}
