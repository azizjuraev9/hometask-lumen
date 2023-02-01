<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 01.02.2023
 * Time: 14:54
 */

namespace App\notification\exceptions;


class InvalidChannelException extends \Exception
{

    protected $code= 422;

    protected $message = 'Invalid channel';

}
