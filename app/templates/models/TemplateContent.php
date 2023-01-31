<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 15:43
 */

namespace App\templates\models;


use App\templates\exceptions\NotFoundException;

class TemplateContent
{

    protected array $availableVariables;

    protected string $viewFile;

    protected array $originalVariables;

    public function __construct(
        protected string $slug,
        public array $contentVariables
    )
    {
        $this->originalVariables = $contentVariables;
    }

    private static array $availableTemplates = [
        'mobile-verification' => TextContent::class,
        'email-verification' => HtmlContent::class,
    ];

    public function getViewFile(): string
    {
        return dirname(__DIR__) . '/views/' . $this->viewFile;
    }

    public function getAvailableVariables() : array
    {
        return $this->availableVariables;
    }

    public function getSlug() : string
    {
        return $this->slug;
    }

    public function getOriginalVariables() : array
    {
        return $this->originalVariables;
    }

    public static function getContent(string $slug, array $variables) : TemplateContent
    {
        if( !isset(self::$availableTemplates[$slug]) ){
            throw new NotFoundException();
        }
        return new self::$availableTemplates[$slug]($slug,$variables);
    }
}
