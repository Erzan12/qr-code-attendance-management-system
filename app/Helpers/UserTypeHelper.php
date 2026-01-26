<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class UserTypeHelper
{
    public static function getPrettyType(int $type)
    {
        if ($type == 2) {
            return Str::title('student');
        }

        return Str::title('faculty');
    }
}
