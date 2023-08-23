<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'user_name'     => 'required|max:150',
            'user_email'    => 'required|email|unique:users,email',
            'user_type'     => 'required',
            'mobile_no'     => 'required|unique:users,mobile_no,max:15',
        ];
    }


    public function attributes()
    {
        return [
            'user_name' => 'Name',
            'user_email' => 'Email',
            'mobile_no' => 'Mobile Number',
        ];
    }
}
