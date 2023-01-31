<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 19:19
 */

namespace App\templates\exceptions;


class NotFoundException extends TemplateException
{

    protected $code = 404;

    protected $message = 'Template not found.';

}
