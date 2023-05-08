<?php

namespace App\Http\Filters;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ClientFilter extends QueryFilter
{
    /**
     * @param  string  $category
     *
     * @return void
     */
    public function category(string $category): void
    {
        $this->builder->where('category', strtolower($category));
    }

    /**
     * @param  string  $gender
     *
     * @return void
     */
    public function gender(string $gender): void
    {
        $this->builder->where('gender', strtolower($gender));
    }

    /**
     * @param  string  $date
     *
     * @return void
     */
    public function birthDate(string $date): void
    {
        $this->builder->where('birth_date', $date);
    }

    /**
     * @param  int  $age
     *
     * @return void
     */
    public function age(int $age): void
    {
        $this->builder->whereDate(
            'birth_date',
            '>=',
            $this->getYearStartInPastFromAge($age)
        );
        $this->builder->whereDate(
            'birth_date',
            '<=',
            $this->getDateNowInPastFromAge($age)
        );
    }

    /**
     * @param  int  $age
     *
     * @return void
     */
    public function ageAfter(int $age): void
    {
        $this->builder->whereDate(
            'birth_date',
            '<=',
            $this->getDateNowInPastFromAge($age)
        );
    }

    /**
     * @param  int  $age
     *
     * @return void
     */
    public function ageBefore(int $age): void
    {
        $this->builder->whereDate(
            'birth_date',
            '>=',
            $this->getDateNowInPastFromAge($age)
        );
    }

    /**
     * @param  int  $age
     *
     * @return string
     */
    private function getDateNowInPastFromAge(int $age): string
    {
        return Carbon::createFromDate(
            now()->year - $age,
            now()->month,
            now()->day
        )->toDateString();
    }

    /**
     * @param  int  $age
     *
     * @return string
     */
    private function getYearStartInPastFromAge(int $age): string
    {
        return Carbon::createFromDate(
            now()->year - $age,
            1,
            1
        )->toDateString();
    }

    /**
     * @param  Builder|null  $builder
     * @param  array  $data
     *
     * @return Builder
     */
    public function getQueryFromData(Builder $builder = null, array $data = []): Builder
    {
        $this->builder = $builder ?: Client::query();

        if (isset($this->request)) {
            $data = $this->request->all();
        }

        foreach ($data as $field => $value) {
            $method = Str::camel($field);
            if (method_exists($this, $method)) {
                call_user_func_array([$this, $method], (array) $value);
            }
        }

        return $this->builder;
    }
}
