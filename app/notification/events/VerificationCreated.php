<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 21:59
 */

namespace App\notification\events;

use Illuminate\Support\Facades\Redis;

class VerificationCreated
{

    public function __construct(
        private array $subject,
        private int $code
    )
    {
    }

    public function getSubject() : array
    {
        return $this->subject;
    }

    public function getCode() : int
    {
        return $this->code;
    }

}
