<?php

namespace App\Http\Requests;

use App\ORM\Enums\ClientGenderEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category'   => 'alpha:ascii|string|nullable',
            'age'        => 'numeric|min:1|max:200|prohibits:age_after,age_before',
            'age_after'  => 'required_with:age_before|numeric|min:1|max:200|lt:age_before',
            'age_before' => 'required_with:age_after|numeric|min:1|max:200',
            'gender'     => ['string', Rule::in(ClientGenderEnum::values()), 'nullable'],
            'birth_date' => 'nullable|date_format:Y-m-d',
        ];
    }
}
