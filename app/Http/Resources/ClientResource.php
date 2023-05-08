<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'category'   => $this->getCategory(),
            'first_name' => $this->getFirstName(),
            'last_name'  => $this->getLastName(),
            'email'      => $this->getEmail(),
            'gender'     => $this->getGender(),
            'birth_date' => $this->getBirthDate(),
            'age'        => $this->getAge(),
        ];
    }
}
