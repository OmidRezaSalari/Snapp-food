<?php

namespace Authenticate\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
            'username' => 'required|string|exists:users,username|alpha_dash|min:8',
            'password' => 'required|string|numeric|min:6'
        ];
    }

    public function attributes()
    {
        return [
            "username" => "نام کاربری",
            "password" => "کلمه عبور"
        ];
    }

    public function messages()
    {
        return [
            'username.exists' => __(
                "authService::client-error.user-access-denied",
                ['username' => $this->username]
            )
        ];
    }
}
