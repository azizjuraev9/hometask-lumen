<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 14:38
 */

namespace App\verification\exceptions;


class NotFoundException extends VerificationException
{

    protected $code = 404;

    protected $message = 'Verification not found.';

}
