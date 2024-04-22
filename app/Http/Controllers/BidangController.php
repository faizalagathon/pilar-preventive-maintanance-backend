<?php

namespace App\Http\Controllers;

use App\Http\Resources\BidangAllResource;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BidangController extends Controller
{
    // Menampilkan daftar resource
    public function index()
    {
        $data = Bidang::with('user')->get();

        if ($data->isEmpty())
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);

    return response()->json(['status' => true, 'data' => BidangAllResource::collection($data)]);
    }

    // Menyimpan resource baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kepala_bidang' => 'required|string|exists:user,id',
            'nama' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $bidang = new Bidang($request->all());
        $bidang->id = Str::uuid(); // Generate UUID
        $bidang->save();

        return response()->json(['status' => true, 'message' => 'Data berhasil disimpan']);
    }

    // Menampilkan resource tertentu
    public function show($id)
    {
        $bidang = Bidang::find($id);

        if (!$bidang)
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);

        return response()->json(['status' => true, 'data' => $bidang], 200);
    }

    // Memperbarui resource tertentu
    public function update(Request $request, $id)
    {
        $bidang = Bidang::find($id);

        if (!$bidang)
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);

        $validator = Validator::make($request->all(), [
            'id_kepala_bidang' => 'required|string|exists:user,id',
            'nama' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $bidang->update($request->all());

        return response()->json(['status' => true, 'message' => 'Bidang berhasil diperbarui']);
    }

    // Menghapus resource tertentu
    public function destroy($id)
    {
        $bidang = Bidang::find($id);

        if (!$bidang)
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);

        $bidang->delete();

        return response()->json(['status' => true, 'message' => 'Bidang berhasil dihapus']);
    }
}

