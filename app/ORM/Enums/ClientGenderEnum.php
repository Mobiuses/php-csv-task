<?php
namespace App\ORM\Enums;

enum ClientGenderEnum:string
{
    case MALE = 'male';
    case FEMALE = 'female';

    /**
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
