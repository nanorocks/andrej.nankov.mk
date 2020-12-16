<?php

namespace App\Helpers;

use Ramsey\Uuid\Uuid;

class GenerateUniqueId
{
    public static function uuid()
    {
        return Uuid::uuid4();
    }
}
