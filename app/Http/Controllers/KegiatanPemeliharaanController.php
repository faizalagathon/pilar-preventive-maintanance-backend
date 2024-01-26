<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Models\KegiatanPemeliharaan;
use App\Http\Requests\KegiatanPemeliharaanRequest;
use App\Http\Resources\KegiatanPemeliharaanResource;

class KegiatanPemeliharaanController extends Controller
{
    public function index($id){
        // id merupakan id kategori

        $dataKegiatanPemeliharaan = KegiatanPemeliharaan::with('kategori_pemeliharaan')->where('id_kategori_pemeliharaan', $id)->get();

        if($dataKegiatanPemeliharaan->isEmpty()){
            return response()->json(['messages' => 'Tidak terdapat data Kegiatan']);
        }
        else{
            return KegiatanPemeliharaanResource::collection($dataKegiatanPemeliharaan);
        }
    }

    public function store(KegiatanPemeliharaanRequest $request){
        $uuidKegiatanPemeliharaan = Uuid::uuid4()->toString();

        $dataKegiatanPemeliharaan = new KegiatanPemeliharaan;
        $dataKegiatanPemeliharaan->id = $uuidKegiatanPemeliharaan;
        $dataKegiatanPemeliharaan->id_kategori_pemeliharaan = $request->id_kategori_pemeliharaan;
        $dataKegiatanPemeliharaan->nama_kegiatan = $request->nama_kegiatan;
        $dataKegiatanPemeliharaan->save();

        return response()->json(['messages' => 'Data Kegiatan baru berhasil di tambahkan']);
    }

    public function show($id){
        $dataKegiatanPemeliharaan = KegiatanPemeliharaan::with('kategori_pemeliharaan')->where('id', $id)->first();

        if($dataKegiatanPemeliharaan == NULL){
            return response()->json(['messages' => 'Tidak terdapat data Kegiatan']);
        }
        else{
            return new KegiatanPemeliharaanResource($dataKegiatanPemeliharaan);
        }
    }

    public function update(KegiatanPemeliharaanRequest $request, $id){
        $dataKegiatanPemeliharaan = KegiatanPemeliharaan::where('id', $id)->first();

        // $dataKegiatanPemeliharaan->id_kategori_pemeliharaan = $request->id_kategori_pemeliharaan;
        $dataKegiatanPemeliharaan->nama_kegiatan = $request->nama_kegiatan;
        $dataKegiatanPemeliharaan->save();

        return response()->json(['messages' => 'Data Kegiatan berhasil di ubah']);
    }

    public function destroy($id){
        $dataKegiatanPemeliharaan = KegiatanPemeliharaan::where('id', $id)->first();

        if($dataKegiatanPemeliharaan == NULL){
            return response()->json(['messages' => 'Tidak terdapat data Kegiatan']);
        }
        else{
            $dataKegiatanPemeliharaan->delete();

            return response()->json(['messages' => 'Data kegiatan berhasil di hapus']);
        }
    }


}
