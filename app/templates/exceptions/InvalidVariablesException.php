<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 19:01
 */

namespace App\templates\exceptions;


class InvalidVariablesException extends TemplateException
{

    protected $code= 422;

    protected $message = 'Validation failed: invalid / missing variables supplied.';

}
