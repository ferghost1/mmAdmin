<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserRequest extends FormRequest
{
    const ATTRIBUTES = [];
    const MESSAGES = [];

    public function __construct() {
        $this->result = [
            'success'   => false,
            'data'      => [],
            'message'   => '',
            'errors'     => []
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

    public const CREATE_USER = [
        'user_name'     =>  'required|unique:users',
        'password'      =>  "required",
        'role_id'       =>  'required',
        'name'          =>  'required',
        'email'         =>  'email|unique:users',
        'phone'         =>  'digits_between:9,12',
        'agency_id'     =>  'required',
        'account_balance' => 'numeric'
    ];

    public function processCreateUser() {
        if ($this->role_id <= auth()->user()->role_id) { // check role
            $this->result['errors'] = 'You dont have permission to create this role';
            return;
        }

        // validate
        $validate = Validator::make($this->all(), self::CREATE_USER, self::MESSAGES, self::ATTRIBUTES);
        if ($validate->fails()) {
            $this->result['errors'] = $validate->errors()->all();
            return;
        }

        $this->result['success'] = true;
        
        return array_merge($this->only(array_keys(self::CREATE_USER)), []);
    }

    public const LOGIN = [
        'user_name'     =>  'required',
        'password'      =>  'required'
    ];
    
    public function processLogin($type = 'user') {
        $validateData = self::LOGIN;
        if ($type != 'user') {
            $validateData['pc_num'] = 'required';
        }

        $validate = Validator::make($this->all(), $validateData, self::MESSAGES, self::ATTRIBUTES);
        
        if ($validate->fails()) {
            $this->result['errors'] = $validate->errors()->all();
        }

        $this->result['success'] = true;
        return array_merge($this->only(array_keys($validateData)), []);
    }
}
