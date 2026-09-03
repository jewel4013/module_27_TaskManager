<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends ApiFormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255', 
            'email' => [
                'sometimes', 
                'required', 
                'string', 
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user()->id),
            ],
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
