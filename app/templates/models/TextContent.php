<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 15:41
 */

namespace App\templates\models;


class TextContent extends TemplateContent
{

    protected string $slug = 'mobile-verification';

    public array $contentVariables;

    protected array $availableVariables = ['code'];

    protected string $viewFile = 'mobile-verification.txt';

}
