<?php

namespace App\Http\Requests;

use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Request extends BaseRequest
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

    public function rules()
    {
        return [];
    }

    /**
     * Laravel 5.4的方式
     */
    // public function response(array $errors)
    // {
    //     $arr = ["success" => false];
    //     $msg = array_first($errors)[0];
    //     $arr["err_msg"] = $msg . "fuck";
    //     $arr["err_code"] = PARAM_IS_WRONG;
    //     return Response::json($arr);
    // }

    /**
     * Laravel 5.5的方式
     */
    protected function failedValidation(Validator $validator){
        $arr = ["success" => false];
        $msg = array_first($validator->errors()->toArray())[0];
        $arr["err_code"] = "1000";
        $arr["err_msg"] = $msg;
        $arr["data"] = null;
        throw new HttpResponseException(response()->json($arr, 200));
    }

    public function forbiddenResponse()
    {
        return redirect("noprivilage");
    }
}
