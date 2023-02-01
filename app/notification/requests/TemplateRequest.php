<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 23:56
 */

namespace App\notification\requests;


use Illuminate\Support\Facades\Http;

class TemplateRequest
{

    private $chanelTemplateMap = [
        'email_confirmation' => 'email-verification',
        'mobile_confirmation' => 'mobile-verification',
    ];

    public function requestTemplate(string $channel, string $code) : string
    {
        $url = env('APP_URL') . '/templates/render';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=utf-8'
        ])
            ->withBody(json_encode([
                "slug" => $this->chanelTemplateMap[$channel],
                "variables" => ['code' => $code],
            ]), 'application/json')
            ->post($url);
        return $response->body();
    }

}
