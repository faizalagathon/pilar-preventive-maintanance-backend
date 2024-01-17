<?php

namespace App\Http\Controllers;

use App\Http\Requests\PemeliharaanRequest;
use App\Http\Resources\PemeliharaanResource;
use App\Models\Pemeliharaan;
use DateTime;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;


class PemeliharaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataPemeliharaan = Pemeliharaan::with('barang_inventaris')->get();

        if ($dataPemeliharaan->isEmpty()) {
            return response()->json(['messages' => 'Tidak terdapat data Pemeliharaan']);
        } else {
            return PemeliharaanResource::collection($dataPemeliharaan);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PemeliharaanRequest $request)
    {
        $uuidPemeliharaan = Uuid::uuid4()->toString();

        $dataPemeliharaan = new Pemeliharaan;
        $dataPemeliharaan->id = $uuidPemeliharaan;
        $dataPemeliharaan->id_barang_inventaris = $request->id_barang_inventaris;
        $dataPemeliharaan->tanggal = new DateTime;
        $dataPemeliharaan->catatan = $request->catatan;
        $dataPemeliharaan->save();

        return response()->json(['messages' => 'Data Pemeliharaan baru berhasil di tambahkan']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dataPemeliharaan = Pemeliharaan::with('barang_inventaris')->where('id', $id)->first();

        if ($dataPemeliharaan == NULL) {
            return response()->json(['messages' => 'Tidak terdapat data Pemeliharaan']);
        } else {
            return new PemeliharaanResource($dataPemeliharaan);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PemeliharaanRequest $request, $id)
    {
        $dataPemeliharaan = Pemeliharaan::where('id', $id)->first();

        $dataPemeliharaan->id_barang_inventaris = $request->id_barang_inventaris;
        $dataPemeliharaan->catatan = $request->catatan;
        $dataPemeliharaan->save();

        return response()->json(['messages' => 'Data Pemeliharaan baru berhasil di ubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dataPemeliharaan = Pemeliharaan::where('id', $id)->first();

        if ($dataPemeliharaan == NULL) {
            return response()->json(['messages' => 'Tidak terdapat data Kegiatan Pemeliharaan']);
        } else {
            $dataPemeliharaan->delete();

            return response()->json(['messages' => 'Data kegiatan Pemeliharaan berhasil di hapus']);
        }
    }

}
