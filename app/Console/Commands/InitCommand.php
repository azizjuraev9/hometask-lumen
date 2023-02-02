<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 02.02.2023
 * Time: 12:52
 */

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class InitCommand extends Command
{


    protected $signature = 'app:init';

    public function handle()
    {
        $envContent = file_get_contents(base_path() . '/.env');

        if (strstr($envContent, 'GOTIFY_TOKEN')) {
            return;
        }

        $url = env('GOTIFY_URL') . '/application';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=utf-8'
        ])
            ->withBasicAuth(env('GOTIFY_USER'), env('GOTIFY_PASS'))
            ->withBody(json_encode([
                "name" => env('GOTIFY_APP_NAME'),
            ]), 'application/json')
            ->post($url);

        $token = $response->json('token');
        $token = "\nGOTIFY_TOKEN=" . $token;
        file_put_contents(base_path() . '/.env', $token,FILE_APPEND);
    }

}
