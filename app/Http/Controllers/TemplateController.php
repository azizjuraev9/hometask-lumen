<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 21:06
 */

namespace App\Http\Controllers;


use App\templates\exceptions\TemplateException;
use App\templates\services\ITemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{

    public function __construct(
        public ITemplateService $templateService
    )
    {
    }

    public function render(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'variables.*' => 'required|string',
            'slug' => 'required|string',
        ]);

        if ($validator->fails() || !$request->isJson()) {
            return response('', 400);
        }

        try {
            [ $template , $contentType ] = $this->templateService->renderTemplate($request->get('slug'),$request->get('variables'));
            return response($template, 200)->header('Content-Type', $contentType);
        } catch (TemplateException $e) {
            return response('', $e->getCode());
        }
    }

}
