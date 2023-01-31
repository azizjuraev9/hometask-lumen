<?php

namespace App\verification\services;

use App\verification\exceptions\DuplicatedVerificationException;
use App\verification\exceptions\NotFoundException;
use App\verification\models\Verification;
use App\verification\repositories\IVerificationRepository;

/**
 * Class VerificationService
 * @property IVerificationRepository $repository
 */
class VerificationService implements IVerificationService
{

    public function __construct(
        public IVerificationRepository $repository
    )
    {

    }

    public function createVerification(array $subjectData, array $userInfo) : string
    {
        if($this->repository->hasPendingVerification($subjectData)){
            throw new DuplicatedVerificationException('Duplicated verification.');
        }

        $verification = new Verification();
        $verification->createNew($subjectData,$userInfo);
        $this->repository->saveVerification($verification);

        return $verification->getId();
    }

    public function confirmVerification(string $id, int $code, array $userInfo) : bool
    {
        $verification = $this->repository->getById($id);
        if(!$verification){
            throw new NotFoundException();
        }

        $verification->confirmVerification($code,$userInfo);
        $this->repository->updateVerification($verification);
        return $verification->getId();
    }

}
