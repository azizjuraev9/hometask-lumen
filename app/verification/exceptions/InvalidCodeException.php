<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 8:03
 */

namespace App\verification\exceptions;


class InvalidCodeException extends VerificationException
{

    protected $code = 422;

    protected $message = 'Validation failed: invalid code supplied.';

}
