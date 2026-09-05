<?php

namespace App\Http\Requests\Api\V1\GroupUser;

use App\Http\Requests\Api\V1\ApiFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GruopUserStoreRequest extends ApiFormRequest
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
            'user_id' => 'nullable|exists:users,id|required_without:user_ids',
            'user_ids' => 'nullable|array|required_without:user_id',
            'user_ids.*' => 'integer|exists:users,id'
        ];
    }
}
