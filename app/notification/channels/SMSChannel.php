<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 22:16
 */

namespace App\notification\channels;


use Illuminate\Support\Facades\Http;

class SMSChannel implements IMessageChannel
{
    public function send(string $recipient, string $body): bool
    {
        $url = env('GOTIFY_URL') . '/message?token=' . env('GOTIFY_TOKEN');
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=utf-8'
        ])
        ->withBody(json_encode([
            "title" => "Message to: " . $recipient,
            "message" => $body,
            "priority" => 5,
        ]), 'application/json')
        ->post($url);

        return $response->status() === 200;
    }
}
