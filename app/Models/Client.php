<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    private const BASE_FIELDS = [
        'category',
        'first_name',
        'last_name',
        'email',
        'gender',
        'birth_date'
    ];

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @return string
     */
    public function getBirthDate(): string
    {
        return $this->birth_date;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return Carbon::parse($this->getBirthDate())->age;
    }

    /**
     * @return string[]
     */
    public static function getBaseFields(): array
    {
        return self::BASE_FIELDS;
    }
}
