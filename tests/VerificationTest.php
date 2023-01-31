<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 5:58
 */

namespace Tests;


use App\verification\events\VerificationEvent;
use App\verification\exceptions\ExpiredException;
use App\verification\exceptions\InvalidCodeException;
use App\verification\exceptions\InvalidSubjectException;
use App\verification\exceptions\NoPermissionToConfirmException;
use App\verification\models\Subject;
use App\verification\models\Verification;
use Illuminate\Support\Facades\Redis;

class VerificationTest extends TestCase
{

    private function queueClear($key){
        for($i = 0; $i < 1000; $i++){
            Redis::lpop($key);
        }
    }

    private function generateIdentity(bool $email = true) : string
    {
        if($email){
            return uniqid() . '@' . 'test.com';
        }
        return '+' . rand(1000000000,99999999999);
    }

    public function test_invalid_subject()
    {
        $this->expectException(InvalidSubjectException::class);

        $verification = new Verification();
        $verification->init([
            'id' => 'asdasd',
            'subjectData' => [
                'identity' => '+(99999)9999999',
                'type' => 'mobile_confirmation',
            ],
            'confirmed' => false,
            'expiresAt' => 15555555555,
            'code' => 1111,
            'userInfo' => ['someData', 'someData'],
            'attempts' => 0,
        ]);
        $verification->init([
            'id' => 'asdasd',
            'subjectData' => [
                'identity' => 'invalidEmail',
                'type' => 'email_confirmation',
            ],
            'confirmed' => false,
            'expiresAt' => 15555555555,
            'code' => 1111,
            'userInfo' => ['someData', 'someData'],
            'attempts' => 0,
        ]);
        $verification->init([
            'id' => 'asdasd',
            'subjectData' => [
                'identity' => 'invalidEmail',
                'type' => 'invalidType',
            ],
            'confirmed' => false,
            'expiresAt' => 15555555555,
            'code' => 1111,
            'userInfo' => ['someData', 'someData'],
            'attempts' => 0,
        ]);
    }

    public function test_create_new_event()
    {
        $this->queueClear(VerificationEvent::EVENT_VERIFICATION_CREATED);
        $verification = new Verification();
        $verification->createNew([
            'identity' => $this->generateIdentity(),
            'type' => 'email_confirmation',
        ], ['someData', 'someData']);
        $queueData = Redis::lpop(VerificationEvent::EVENT_VERIFICATION_CREATED);
        $queueData = json_decode($queueData);
        $this->assertEquals($queueData->id, $verification->getId());
    }

    public function test_confirm_max_attempts()
    {
        $this->expectException(ExpiredException::class);
        $verification = new Verification();
        $verification->init([
            'id' => 'asdasd',
            'subjectData' => [
                'identity' => $this->generateIdentity(),
                'type' => 'email_confirmation',
            ],
            'confirmed' => false,
            'expiresAt' => strtotime("+1 week"),
            'code' => 1111,
            'userInfo' => ['IP' => 'someData', 'agent' => 'someData'],
            'attempts' => 5,
        ]);
        $verification->confirmVerification(1111,['IP' => 'someData', 'agent' => 'someData']);
    }

    public function test_confirm_expired()
    {
        $this->expectException(ExpiredException::class);
        $verification = new Verification();
        $verification->init([
            'id' => 'asdasd2',
            'subjectData' => [
                'identity' => $this->generateIdentity(),
                'type' => 'email_confirmation',
            ],
            'confirmed' => false,
            'expiresAt' => time(),
            'code' => 1111,
            'userInfo' => ['IP' => 'someData', 'agent' => 'someData'],
            'attempts' => 0,
        ]);
        $verification->confirmVerification(1111,['IP' => 'someData', 'agent' => 'someData']);
    }

    public function test_confirm_no_permission()
    {
        $this->expectException(NoPermissionToConfirmException::class);
        $verification = new Verification();
        $verification->init([
            'id' => 'asdasd3',
            'subjectData' => [
                'identity' => $this->generateIdentity(),
                'type' => 'email_confirmation',
            ],
            'confirmed' => false,
            'expiresAt' => strtotime("+1 week"),
            'code' => 1111,
            'userInfo' => ['IP' => 'someData', 'agent' => 'someData'],
            'attempts' => 0,
        ]);
        $verification->confirmVerification(1111,['IP' => 'someData', 'agent' => 'otherData']);
    }

    public function test_confirmation_failed_event()
    {
        $this->queueClear(VerificationEvent::EVENT_VERIFICATION_CONFIRMATION_FAILED);
        $this->expectException(NoPermissionToConfirmException::class);
        $verification = new Verification();
        $verification->init([
            'id' => 'asdasd3',
            'subjectData' => [
                'identity' => $this->generateIdentity(),
                'type' => 'email_confirmation',
            ],
            'confirmed' => false,
            'expiresAt' => strtotime("+1 week"),
            'code' => 1111,
            'userInfo' => ['IP' => 'someData', 'agent' => 'someData'],
            'attempts' => 0,
        ]);
        $verification->confirmVerification(1111,['IP' => 'someData', 'agent' => 'otherData']);

        $queueData = Redis::lpop(VerificationEvent::EVENT_VERIFICATION_CONFIRMATION_FAILED);
        $queueData = json_decode($queueData);
        $this->assertEquals($queueData->id, $verification->getId());
    }

    public function test_confirm_success()
    {
        $this->queueClear(VerificationEvent::EVENT_VERIFICATION_CONFIRMED);
        $verification = new Verification();
        $verification->init([
            'id' => 'asdasd4',
            'subjectData' => [
                'identity' => $this->generateIdentity(),
                'type' => 'email_confirmation',
            ],
            'confirmed' => false,
            'expiresAt' => strtotime("+1 week"),
            'code' => 1111,
            'userInfo' => ['IP' => 'someData', 'agent' => 'someData'],
            'attempts' => 0,
        ]);
        $verification->confirmVerification(1111,['IP' => 'someData', 'agent' => 'someData']);


        $queueData = Redis::lpop(VerificationEvent::EVENT_VERIFICATION_CONFIRMED);
        $queueData = json_decode($queueData);
        $this->assertEquals($queueData->id, $verification->getId());
    }

}
