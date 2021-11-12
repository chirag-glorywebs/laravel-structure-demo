<?php

namespace App\Http\Requests\Admin\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Config;

class LoginRequest extends FormRequest
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
    public function rules(){
        return [
            'email' => 'required|email',
            'password' => 'required|min:5',
        ];
    }

    public function messages(){
        return [
            'email.required' => 'Email address field is required.',
            'password.required' => 'Password Field is required.',
            'password.min' => 'The password must be at least 5 characters!'
        ];
    }

}
