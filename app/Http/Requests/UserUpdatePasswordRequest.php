<?php

namespace App\Http\Requests;

use App\Rules\MatchCurrentPassword;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current_password' => ['required', new MatchCurrentPassword()],
            'new_password'     => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'same:new_password'],
        ];
    }
}
