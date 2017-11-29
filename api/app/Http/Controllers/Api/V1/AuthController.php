<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\User;

class AuthController extends ApiController
{
    function passwordLogin(Request $request)
    {
        $req = $request->all();
        if (Validator::make($req, ['username' => 'required'])->fails()) return $this->failed(400000);
        if (Validator::make($req, ['password' => 'required'])->fails()) return $this->failed(400001);
        if (Validator::make($req, ['username' => 'string'])->fails()) return $this->failed(400002);
        if (Validator::make($req, ['password' => 'string'])->fails()) return $this->failed(400003);
        if (Validator::make($req, ['username' => 'exists:users,username'])->fails()) return $this->failed(400004);

        $user = User::where('username', $req['username'])->first();
        if (!Hash::check($req['password'], $user->password)) {
            return $this->failed(401000, 401);
        }
        return $this->fetch_access_token(
            'http://api.mrdaisite.com/oauth/token',
            "grant_type=" . env('grant_type') . "&client_id=" . env('client_id') . "&client_secret=" . env('client_secret') . "&username=" . $user->email . "&password=" . $req['password'] . "&scope="
        );
    }

    function codeLogin(Request $request)
    {

    }

    private function fetch_access_token($url, $post_data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
