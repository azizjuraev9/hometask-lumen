<?php

namespace App\verification\services;

use App\verification\models\Subject;
use App\verification\repositories\IVerificationRepository;

interface IVerificationService
{

    public function __construct(IVerificationRepository $repository);

    public function createVerification(array $subjectData, array $userInfo) : string;

}
