<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 01.02.2023
 * Time: 16:46
 */

namespace App\Mail;


use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class Mail extends Mailable
{

    public function __construct(
        public string $fromString,
        public string $subjectString,
        public string $htmlContent,
    )
    {

    }

    public function envelope()
    {
        return new Envelope(
            from: $this->fromString,
            subject: $this->subjectString
        );
    }

    public function content()
    {
        return new Content(
            htmlString: $this->htmlContent
        );
    }

}
