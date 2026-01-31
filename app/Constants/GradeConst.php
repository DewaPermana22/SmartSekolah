<?php

namespace App\Constants;

class GradeConst
{
    const SD = 1;

    const MI = 2;

    const SMP = 3;

    const MTS = 4;

    const SMA = 5;

    const SMK = 6;

    const MA = 7;


    public static function getGrades()
    {
        return [
            self::SD => 'SD',
            self::MI => 'MI',
            self::SMP => 'SMP',
            self::MTS => 'MTS',
            self::SMA => 'SMA',
            self::SMK => 'SMK',
            self::MA => 'MA',
        ];
    }
}