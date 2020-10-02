<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function createUser(UserRequest $req) {
        // preprocess data
        $data = $req->processCreateUser();
        if (!$req->result['success']) return $req->result;
        
        app('App\User')->create($data);
        dd($data);
    }
}
