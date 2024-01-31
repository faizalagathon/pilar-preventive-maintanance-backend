<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        $dataUser = User::where('username', $request->username)
                        ->first();

        // $dataUser = User::all();

        if($dataUser == null){
            return response()->json(['messages' => 'Tidak terdapat data yang cocok dengan username tersebut'], 401);
        }
        else{
            if (password_verify($request->password, $dataUser->password)) {
                return response()->json([
                    'messages' => 'Anda Berhasil Login',
                    'user' => new LoginResource($dataUser)
                ], 200);
            } else {
                return response()->json(['messages' => 'Tidak terdapat data yang cocok dengan password tersebut'], 401);
            }
        }

    }
}
