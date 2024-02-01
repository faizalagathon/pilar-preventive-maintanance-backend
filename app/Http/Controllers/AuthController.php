<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;

class AuthController extends Controller
{
    public function login(LoginRequest $request){

        $dataUser = User::where('username', $request->username)->first();

        if(empty($dataUser)){
            return response()->json(['messages' => ['username' => 'Tidak terdapat data yang cocok dengan username tersebut']], 203);
        }
        else{
            if (password_verify($request->password, $dataUser->password)) {
                return response()->json([
                    'messages' => 'Anda Berhasil Login',
                    'user' => new LoginResource($dataUser)
                ], 200);
            } else {
                return response()->json(['messages' => 'Data User tidak cocok dengan password tersebut'], 203);
            }
        }

    }
}
