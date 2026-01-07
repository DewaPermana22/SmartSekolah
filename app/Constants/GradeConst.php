<?php

namespace App\Constants;

class GradeConst
{
    const SD = 1;

    const SMP = 2;

    const SMK = 3;


    public static function getGrades()
    {
        return [
            self::SD => 'SD',
            self::SMP => 'SMP',
            self::SMK => 'SMK',
        ];
    }
}
