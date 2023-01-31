<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 4:43
 */

namespace App\verification\models;


class Subject
{

    public function __construct(
        public string|null $identity,
        public string|null $type
    )
    {
    }

}
