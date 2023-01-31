<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 6:29
 */

namespace App\verification\exceptions;


class InvalidSubjectException extends VerificationException
{

    protected $code = 422;

    protected $message = 'Validation failed: invalid subject supplied.';

}
