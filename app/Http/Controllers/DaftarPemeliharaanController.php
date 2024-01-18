<?php

namespace App\Http\Controllers;

use App\Http\Requests\DaftarPemeliharaanRequest;
use App\Http\Resources\DaftarPemeliharaanResource;
use App\Models\DaftarPemeliharaan;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class DaftarPemeliharaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataDaftarPemeliharaan = DaftarPemeliharaan::with(['pemeliharaan','kegiatan_pemeliharaan'])->get();

        if($dataDaftarPemeliharaan->isEmpty()){
            return response()->json(['messages' => 'Tidak terdapat data Pemeliharaan']);
        }
        else{
            return DaftarPemeliharaanResource::collection($dataDaftarPemeliharaan);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(DaftarPemeliharaanRequest $request)
    {
        $uuidDaftarPemeliharaan = Uuid::uuid4()->toString();

        $dataDaftarPemeliharaan = new DaftarPemeliharaan;
        $dataDaftarPemeliharaan->id = $uuidDaftarPemeliharaan;
        $dataDaftarPemeliharaan->id_pemeliharaan = $request->id_pemeliharaan;
        $dataDaftarPemeliharaan->id_kegiatan_pemeliharaan = $request->id_kegiatan_pemeliharaan;
        $dataDaftarPemeliharaan->save();

        return response()->json(['messages' => 'Data Pemeliharaan baru berhasil di tambahkan']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DaftarPemeliharaanRequest $request, $id)
    {
        $dataDaftarPemeliharaan = DaftarPemeliharaan::where('id', $id)->first();

        $dataDaftarPemeliharaan->id_pemeliharaan = $request->id_pemeliharaan;
        $dataDaftarPemeliharaan->id_kegiatan_pemeliharaan = $request->id_kegiatan_pemeliharaan;
        $dataDaftarPemeliharaan->save();

        return response()->json(['messages' => 'Data Daftar Pemeliharaan baru berhasil di ubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dataDaftarPemeliharaan = DaftarPemeliharaan::where('id', $id)->first();

        if($dataDaftarPemeliharaan == NULL){
            return response()->json(['messages' => 'Tidak terdapat data Kegiatan Pemeliharaan']);
        }
        else{
            $dataDaftarPemeliharaan->delete();

            return response()->json(['messages' => 'Data kegiatan Pemeliharaan berhasil di hapus']);
        }
    }
}
