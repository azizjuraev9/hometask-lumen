<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 19:29
 */

namespace App\templates\services;


use App\templates\repositories\ITemplateRepository;

interface ITemplateService
{

    public function __construct( ITemplateRepository $templateRepository);

    public function renderTemplate(string $slug, array $variables) : array;

}
