<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 7:54
 */

namespace App\verification\exceptions;


class NoPermissionToConfirmException extends VerificationException
{

    protected $code = 403;

    protected $message = 'No permission to confirm verification.';

}
