<?php

namespace App\verification\models;

use App\verification\events\VerificationEvent;
use App\verification\exceptions\ExpiredException;
use App\verification\exceptions\InvalidCodeException;
use App\verification\exceptions\NoPermissionToConfirmException;
use App\verification\validators\SubjectValidator;


class Verification implements IVerification
{

    const MAX_ATTEMPTS = 5;

    protected string $id;

    protected Subject $subject;

    protected bool $confirmed;

    protected int $expiresAt;

    protected int $code;

    protected array $userInfo;

    protected int $attempts = 0;

    public function init(array $data): void
    {
        $subject = new Subject(
            $data['subjectData']['identity'],
            $data['subjectData']['type'],
        );
        $validator = new SubjectValidator();
        $validator->validateSubject($subject);

        $this->id = $data['id'];
        $this->subject = $subject;
        $this->confirmed = $data['confirmed'];
        $this->expiresAt = $data['expiresAt'];
        $this->code = $data['code'];
        $this->userInfo = $data['userInfo'];
        $this->attempts = $data['attempts'] ?? 0;
    }

    public function createNew(array $subjectData, array $userInfo): void
    {
        $subject = new Subject(
            $subjectData['identity'],
            $subjectData['type'],
        );
        $validator = new SubjectValidator();
        $validator->validateSubject($subject);
        $this->id = UUID::getUUID();
        $this->subject = $subject;
        $this->confirmed = false;
        $this->expiresAt = time() + env('VERIFICATION_TIMEOUT', 300);
        $this->code = self::generateCode();
        $this->userInfo = $userInfo;
        $this->attempts = 0;

        (new VerificationEvent(
            VerificationEvent::EVENT_VERIFICATION_CREATED,
            $this->id,
            $this->code,
            $subjectData,
            time()
        ))->dispatch();
    }

    private static function generateCode()
    {
        $lengthMin = 10 ** (env('VERIFICATION_CODE_LENGTH', 4) - 1);
        $lengthMax = (10 ** env('VERIFICATION_CODE_LENGTH', 4)) - 1;
        return rand($lengthMin, $lengthMax);
    }

    public function confirmVerification($code, $userInfo): void
    {
        $this->attempts++;
        if ($this->attempts > self::MAX_ATTEMPTS) {
            $this->expiresAt = 1;
            $this->dispatchConfirmationFailedEvent();
            throw new ExpiredException();
        }

        if ($this->expiresAt <= time()) {
            $this->dispatchConfirmationFailedEvent();
            throw new ExpiredException();
        }

        if ($userInfo['IP'] !== $this->userInfo['IP'] || $userInfo['agent'] !== $this->userInfo['agent']) {
            $this->dispatchConfirmationFailedEvent();
            throw new NoPermissionToConfirmException();
        }

        if ($code !== $this->code) {
            $this->dispatchConfirmationFailedEvent();
            throw new InvalidCodeException();
        }

        $this->confirmed = true;

        (new VerificationEvent(
            VerificationEvent::EVENT_VERIFICATION_CONFIRMED,
            $this->id,
            $this->code,
            (array)$this->subject,
            time()
        ))->dispatch();
    }

    private function dispatchConfirmationFailedEvent()
    {
        (new VerificationEvent(
            VerificationEvent::EVENT_VERIFICATION_CONFIRMATION_FAILED,
            $this->id,
            $this->code,
            (array)$this->subject,
            time()
        ))->dispatch();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSubject(): Subject
    {
        return $this->subject;
    }

    public function getConfirmed(): bool
    {
        return $this->confirmed;
    }

    public function getExpiresAt(): int
    {
        return $this->expiresAt;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getUserInfo(): array
    {
        return $this->userInfo;
    }

    public function getAttempts(): int
    {
        return $this->attempts;
    }
}
