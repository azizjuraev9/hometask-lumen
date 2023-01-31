<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 20:47
 */

namespace App\templates\repositories;


use App\templates\models\Template;

interface ITemplateRepository
{

    public function saveTemplate(Template $template) : bool;

}
