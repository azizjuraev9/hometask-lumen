<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 4:54
 */

namespace App\verification\exceptions;


class DuplicatedVerificationException extends VerificationException
{

    protected $code = 409;

    protected $message = 'Duplicated verification.';

}
