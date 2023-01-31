<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 19:28
 */

namespace App\templates\services;

use App\templates\models\Template;
use App\templates\models\TemplateContent;
use App\templates\repositories\ITemplateRepository;

class TemplateService implements ITemplateService
{

    public function __construct(private ITemplateRepository $templateRepository)
    {
    }

    public function renderTemplate(string $slug, array $variables) : array
    {
        $template = new Template();
        $content = TemplateContent::getContent($slug, $variables);
        $template->init($content);
        $this->templateRepository->saveTemplate($template);

        return [$template->render(), $this->getResponseType($slug)];
    }

    public function getResponseType(string $slug) : string
    {
        switch ($slug){
            case 'mobile-verification' :
                return 'text/plain';
            case 'email-verification' :
                return 'text/html';
        }
        return 'text/plain';
    }
}
