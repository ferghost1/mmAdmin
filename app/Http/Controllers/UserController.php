<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function createUser(UserRequest $req) {
        // preprocess data
        $req->agency_id = session('agency')->id  ?? $req->agency_id;
        $data = $req->processCreateUser();
        if (!$req->result['success']) return $req->result;
        
        $data['password'] = bcrypt($data['password']);
        $member = app('App\User')->create($data);
        app('App\UserDetail')->create([
            'user_id'           => $member->id,
            'account_banlance'  => $data['account_banlance'] ?? 0,
            'promotion_balance' => $data['promotion_balance'] ?? 0,
            'agency_id'         => $data['agency_id']
        ]);
        
        return array_merge($req->result, ['success' => true, 'message' => 'created successfully']);
    }

    public function updateMember(UserRequest $req) {

    }

    public function login(UserRequest $req) {
        // preprocess data
        $data = $req->processLogin();
        if (!$req->result['success']) return $req->result;

        if (auth()->attempt($data)) {
            $user = auth()->user();
            $user->api_token = Str::random(128);
            $user->save();
        }

        return array_merge($req->result, ['success' => true, 'data' => $user]);
    }

    public function loginMember(UserRequest $req) {
        // preprocess data
        $data = $req->processLogin('member');
        if (!$req->result['success']) return $req->result;
        
        $req->result['success'] = false;
        $agency = session('agency');

        // authenicate member
        $conditions = [
            'users.role_id'     => 4,
            'users.user_name'   => $data['user_name']
        ];
        $member = app('App\User')->getUsers($conditions)[0];
        $checkPass = $member ? Hash::check($data['password'], $member->password) : false;

        if (!$member || !$checkPass) {
            $req->result['errors'][0] = 'Wrong username or password';
            return $req->result;
        }

        // get price for using pc
        $conditions = [
            'agency_pcs.agency_id'  => $agency->id,
            'agency_pcs.pc_num'     => $req->pc_num
        ];
        $pcPrice = app('App\AgencyPc')->getPcPrice($conditions)[0];
        if (!$pcPrice) {
            $req->result['errors'][0] = 'Do not have this pc at agency';
            return $req->result;
        }

        // insert member to db to trace online member
        try {
            app('App\OnlineMember')->create([
                'user_id'   => $member->id,
                'agency_id' => $agency->id,
                'price_per_second' => $pcPrice->price_per_hour / 3600,
                'pc_num'    => $req->pc_num
            ]);
        } catch (\Throwable $th) {
            $req->result['errors'][0] = 'This member is online';
            return $req->result;
        }

        $req->result['success'] = true;
        $req->result['message'] = 'Login success';
        $req->result['data'] = array_merge($member->toArray(), $pcPrice->toArray()); 
        return $req->result;
    }
}
