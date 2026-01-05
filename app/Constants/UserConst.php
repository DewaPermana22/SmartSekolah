<?php

namespace App\Constants;

class UserConst
{
    const ADMIN = 1;

    const USER = 2;

    const GURU = 3;

    const SISWA = 4;

    public static function getAccessTypes()
    {
        return [
            self::ADMIN => 'Super Admin',
            self::USER => 'Admin Sekolah',
            self::GURU => 'Guru',
            self::SISWA => 'Siswa',
        ];
    }
}
