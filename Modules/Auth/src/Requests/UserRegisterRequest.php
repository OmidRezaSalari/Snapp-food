<?php

namespace Authenticate\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{

    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

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
            'full-name' => 'required|string|max:85',
            'username' => 'required|string|unique:users,username|alpha_dash|min:8',
            'password' => 'required|string|numeric|min:6',
        ];
    }

    public function attributes()
    {
        return [
            'full-name' => "نام و نام خانوادگی",
            "username" => "نام کاربری",
            "password" => "کلمه عبور"

        ];
    }

    public function messages()
    {
        return [
            'username.unique' => __("authService::client-error.username-is-exist")
        ];
    }
}
