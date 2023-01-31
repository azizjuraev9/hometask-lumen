<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 15:10
 */

namespace App\templates\models;


use App\templates\exceptions\InvalidVariablesException;

class Template
{
    private string $id;

    private string $content;

    private TemplateContent $templateContent;

    public function init(TemplateContent $content)
    {
        $this->id = UUID::getUUID();
        $this->templateContent = $content;
        $this->validateContent();
    }

    public function render()
    {
        $this->prepareVariables();
        $this->content = file_get_contents($this->templateContent->getViewFile());
        $this->content = strtr($this->content, $this->templateContent->contentVariables);

        return $this->content;
    }

    public function prepareVariables()
    {
        $variables = $this->templateContent->contentVariables;
        $newVariables = [];
        foreach ($variables as $key => $value) {
            $newVariables['{{' . $key . '}}'] = $value;
        }
        $this->templateContent->contentVariables = $newVariables;
    }

    public function validateContent(): void
    {
        if (array_diff_key(array_flip($this->templateContent->getAvailableVariables()), $this->templateContent->contentVariables) !== []) {
            throw new InvalidVariablesException();
        }
    }

    public function getAvailableTemplates(): array
    {
        return $this->availableTemplates;
    }

    public function getTemplateContent(): TemplateContent
    {
        return $this->templateContent;
    }

    public function getId() : string
    {
        return $this->id;
    }
}
