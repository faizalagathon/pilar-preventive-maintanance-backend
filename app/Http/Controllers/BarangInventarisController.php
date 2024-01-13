<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Models\BarangInventaris;
use App\Http\Requests\BarangInventarisRequest;
use App\Http\Resources\BarangInventarisResource;

class BarangInventarisController extends Controller
{
    public function index(){
        $dataBarangInventaris = BarangInventaris::with('kategori_pemeliharaan')->get();

        if($dataBarangInventaris->isEmpty()){
            return response()->json(['messages' => 'Tidak ada data Barang Inventaris']);
        }
        else{
            return BarangInventarisResource::collection($dataBarangInventaris);
        }
    }

    public function store(BarangInventarisRequest $request){
        $uuidBarangInventaris = Uuid::uuid4()->toString();

        $dataBarangInventaris = new BarangInventaris;
        $dataBarangInventaris->id = $uuidBarangInventaris;
        $dataBarangInventaris->id_kategori_pemeliharaan = $request->id_kategori_pemeliharaan;
        $dataBarangInventaris->nama = $request->nama;
        $dataBarangInventaris->save();

        return response()->json(['messages' => 'Barang Inventaris berhasil di tambahkan']);
    }

    public function show($id){
        $dataBarangInventaris = BarangInventaris::where('id', $id)->first();

        if($dataBarangInventaris == NULL){
            return response()->json(['messages' => 'Tidak terdapat data Barang Inventaris']);
        }
        else{
            return new BarangInventarisResource($dataBarangInventaris);
        }
    }

    public function update(BarangInventarisRequest $request, $id){
        $dataBarangInventaris = BarangInventaris::where('id', $id)->first();

        $dataBarangInventaris->id_kategori_pemeliharaan = $request->id_kategori_pemeliharaan;
        $dataBarangInventaris->nama = $request->nama;
        $dataBarangInventaris->save();

        return response()->json(['messages' => 'Barang Inventaris baru berhasil di ubah']);
    }

    public function destroy($id){
        $dataBarangInventaris = BarangInventaris::where('id', $id)->first();

        if($dataBarangInventaris == NULL){
            return response()->json(['messages' => 'Tidak terdapat data Barang tersebut']);
        }
        else{
            $dataBarangInventaris->delete();

            return response()->json(['messages' => 'Data Barang berhasil di hapus']);
        }
    }
}
