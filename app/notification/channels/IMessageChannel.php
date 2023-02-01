<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 22:14
 */

namespace App\notification\channels;


interface IMessageChannel
{

    public function send(string $recipient, string $body) : bool;

}
