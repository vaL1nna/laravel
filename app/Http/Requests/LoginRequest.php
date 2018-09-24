<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
    public function rules()
    {
        return [
            "username" => "required|string|min:1|max:5",
            "password" => "required",
        ];
    }

    public function messages()
    {
        return [
            "username.required" => "用户名不能为空",
            "username.string" => "用户名类型不正确",
            "username.min" => "用户名不能低于1位",
            "username.max" => "用户名不能超过5位",
            "password.required" => "密码不能为空",
        ];
    }
}
