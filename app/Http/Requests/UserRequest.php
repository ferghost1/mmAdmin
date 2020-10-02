<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class UserRequest extends FormRequest
{
    const ATTRIBUTES = [];
    const MESSAGES = [];

    public function __construct() {
        $this->result = [
            'success'   => false,
            'data'      => null,
            'message'   => []
        ];
    }
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
            //
        ];
    }

    public const CREATEUSER = [
        'user_name'     =>  'required',
        'password'      =>  "required",
        'role_id'       =>  'required',
        'name'          =>  'required',
        'email'         =>  'email|unique:users,email',
        'phone'         =>  'digits_between:9,12'
    ];
    public function processCreateUser() {
        // if ($this->role_id < auth()->user()->role_id) { // check role
        //     $this->result['message'][] = 'You dont have this permission';
        // }

        // validate
        $validate = Validator::make($this->all(), self::CREATEUSER, self::MESSAGES, self::ATTRIBUTES);
        if ($validate->fails()) {
            $this->result['message'] = $validate->errors()->all();
        }

        $this->result['success'] = true;
        return $this->only(array_merge(array_keys(self::CREATEUSER), []));
    }
}
