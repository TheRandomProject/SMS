<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorestudentRequest extends FormRequest
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
            'firstname'             => 'required|min:2|max:255' ,
            'lastname'              => 'required|min:2|max:255' ,
            'middlename'            => 'nullable|max:255' ,
            'gender'                => 'required' ,
            'birthdate'             => 'required' ,
            'mobile_no'             => 'required' ,
            'username'              => 'required' ,
            'email'                 => 'required|unique:students|email',
            'password'              => 'required|min:8' ,
            'password_confirmation' => 'required|same:password' ,
        ];
    }
}
