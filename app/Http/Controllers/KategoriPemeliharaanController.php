<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Models\KategoriPemeliharaan;
use App\Http\Requests\KategoriPemeliharaanRequest;
use App\Http\Resources\KategoriPemeliharaanResource;

class KategoriPemeliharaanController extends Controller
{
    public function index(){
        $dataKategoriPemeliharaan = KategoriPemeliharaan::all();

        return KategoriPemeliharaanResource::collection($dataKategoriPemeliharaan);
    }

    public function store(KategoriPemeliharaanRequest $request){
        $dataKategoriPemeliharaan = new KategoriPemeliharaan();
        $uuidKategoriPemeliharaan = Uuid::uuid4()->toString();

        $dataKategoriPemeliharaan->id = $uuidKategoriPemeliharaan;
        $dataKategoriPemeliharaan->nama = $request->nama;
        $dataKategoriPemeliharaan->save();

        return response()->json(['messages' => 'Kategori Pemeliharaan baru berhasil ditambahkan']);
    }

    public function show($id){
        $dataKategoriPemeliharaan = KategoriPemeliharaan::where('id', $id)->first();

        if($dataKategoriPemeliharaan == NULL){
            return response()->json(['messages' => 'Tidak terdapat Kategori Pemeliharaan tersebut']);
        }
        else{
            return new KategoriPemeliharaanResource($dataKategoriPemeliharaan);
        }
    }

    public function update(KategoriPemeliharaanRequest $request, $id){
        $dataKategoriPemeliharaan = KategoriPemeliharaan::where('id', $id)->first();

        $dataKategoriPemeliharaan->nama = $request->nama;
        $dataKategoriPemeliharaan->save();

        return response()->json(['messages' => 'Kategori Pemeliharaan berhasil diubah']);
    }

    public function destroy($id){
        $dataKategoriPemeliharaan = KategoriPemeliharaan::where('id', $id)->first();

        if($dataKategoriPemeliharaan != NULL){
            // menghapus data lowongan
            $dataKategoriPemeliharaan->delete();

            return response()->json(['messages' => 'Berhasil menghapus data Kategori']);
        }
        else{
            return response()->json(['messages' => 'Tidak Berhasil menghapus data Kategori']);
        }

    }

}
