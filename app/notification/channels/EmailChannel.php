<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 22:15
 */

namespace App\notification\channels;


use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Mail;

class EmailChannel implements IMessageChannel
{
    public function send(string $recipient, string $body): bool
    {
        $mail = new \App\Mail\Mail(
            env('MAIL_FROM_ADDRESS'),
            'Email verification',
            $body,
        );

        return (bool)Mail::to($recipient)
            ->send($mail);
    }
}
