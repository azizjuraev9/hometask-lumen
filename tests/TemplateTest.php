<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 5:58
 */

namespace Tests;


use App\templates\exceptions\InvalidVariablesException;
use App\templates\exceptions\NotFoundException;
use App\templates\models\Template;
use App\templates\models\TemplateContent;

class TemplateTest extends TestCase
{

    public function test_template_not_fount()
    {
        $this->expectException(NotFoundException::class);

        TemplateContent::getContent('notExistingTemplate', ['some' => 'variable']);
    }

    public function test_invalid_variables()
    {
        $this->expectException(InvalidVariablesException::class);

        $template = new Template();
        $content = TemplateContent::getContent('mobile-verification', ['some' => 'variable']);
        $template->init($content);
    }

    public function test_template_rendered()
    {
        $template = new Template();
        $content = TemplateContent::getContent('mobile-verification', ['code' => 1234]);
        $template->init($content);
        $content = $template->render();

        $this->assertStringContainsString('1234',$content);
        $this->assertStringNotContainsString('}}',$content);
        $this->assertStringNotContainsString('{{',$content);
    }
}
