<?php

namespace App\Http\Requests\Admin\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Hash;
class RegisterRequest extends FormRequest
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
            'name' => 'required',
            /* 'last_name' => 'required',
            'phone' => 'required', */
            'email' => 'required|email',
            'password' => 'required|same:confirm_password',
            'confirm_password' => 'required',
        ];
    }
    protected function getValidatorInstance(){
        $validator = parent::getValidatorInstance();
        $validator->after(function ($validator) {
            $data = $this->all();
            $data['user_type'] = "SuperAdmin";
            if($data['password'] && $data['password']!=''){
                $data['password'] = Hash::make($data['password']);
            }else{
                unset($data['password']);
            }
            $this->getInputSource()->replace($data);
        });
        return $validator;
    }
}
