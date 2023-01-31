<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 8:00
 */

namespace App\verification\exceptions;


class ExpiredException extends VerificationException
{

    protected $code = 410;

    protected $message = 'Verification expired.';

}
