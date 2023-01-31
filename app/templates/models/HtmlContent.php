<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 15:41
 */

namespace App\templates\models;


class HtmlContent extends TemplateContent
{

    protected string $slug = 'email-verification';

    public array $contentVariables;

    protected array $availableVariables = ['code'];

    protected string $viewFile = 'email-verification.html';

}
