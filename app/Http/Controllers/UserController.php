<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();

        // dd($user);

        if ($user->isEmpty()) {
            return response()->json(['messages' => 'user Tidak tersedia']);
        } else {
            return UserResource::collection($user);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        //

        // dd($request);

        try {
            // $cari_user = User::where('username', $request->username)->count();

            // if ($cari_user > 0) {
            //     return response()->json(['message' => 'Username sudah digunakan'], 500);
            // }

            User::create([
                'id' => Str::uuid(),
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->role
            ]);

            return response()->json([
                'message' => 'User berhasil dibuat'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'user Tidak Ditemukan'
            ], 404);
        }
        return response()->json([
            'user'=>$user
        ],501);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        //
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'message' => 'user Tidak Ditemukan'
                ], 404);
            }
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->save();
            return response()->json(['messages' => 'user berhasil Diubah'], 200);
        } catch (\Exception $e) {
            return response()->json(['messages' => 'Ada yang salah: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::find($id);

        $user->delete();

        return response()->json(['message' => 'User berhasil dihapus']);
    }
}
