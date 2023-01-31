<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 8:38
 */

namespace App\templates\models;

use Ramsey\Uuid\Uuid as base;

class UUID
{

    public static function getUUID(): string
    {
        return base::uuid4();
    }

}
