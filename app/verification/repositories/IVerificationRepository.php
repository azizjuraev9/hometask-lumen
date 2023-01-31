<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 4:27
 */

namespace App\verification\repositories;


use App\verification\models\Subject;
use App\verification\models\Verification;

interface IVerificationRepository
{

    public function hasPendingVerification(array $subjectData) : bool;

    public function saveVerification(Verification $verification): bool;

}
