<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 20:47
 */

namespace App\templates\repositories;


use App\templates\models\Template;
use App\Models\Template as DbModel;

class TemplateRepository implements ITemplateRepository
{

    public function saveTemplate(Template $template) : bool
    {
        $model = new DbModel();
        $model->id = $template->getId();
        $model->slug = $template->getTemplateContent()->getSlug();
        $model->variables = json_encode($template->getTemplateContent()->getOriginalVariables());
        return $model->save();
    }

}
