<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Models\BarangInventaris;
use App\Models\KategoriPemeliharaan;
use App\Models\KegiatanPemeliharaan;
use App\Http\Requests\KategoriPemeliharaanRequest;
use App\Http\Resources\KategoriPemeliharaanResource;

class KategoriPemeliharaanController extends Controller
{
    public function index()
    {
        $dataKategoriPemeliharaan = KategoriPemeliharaan::all();

        return KategoriPemeliharaanResource::collection($dataKategoriPemeliharaan);
    }

    public function basedBarang($id)
    {
        $dataKategoriPemeliharaan = KategoriPemeliharaan::with('barang_inventaris')->get();

        return response()->json(['data' => $dataKategoriPemeliharaan]);
    }

    public function count()
    {
        $kategoriCount = KategoriPemeliharaan::count();

        return response()->json(['jumlah_kategori' => $kategoriCount]);
    }

    public function store(KategoriPemeliharaanRequest $request)
    {
        $dataKategoriPemeliharaan = new KategoriPemeliharaan();
        $uuidKategoriPemeliharaan = Uuid::uuid4()->toString();

        $dataKategoriPemeliharaan->id = $uuidKategoriPemeliharaan;
        $dataKategoriPemeliharaan->nama = $request->nama;
        $dataKategoriPemeliharaan->save();

        return response()->json(['messages' => 'Kategori Pemeliharaan baru berhasil ditambahkan']);
    }

    public function show($id)
    {
        $dataKategoriPemeliharaan = KategoriPemeliharaan::where('id', $id)->first();

        if ($dataKategoriPemeliharaan == NULL) {
            return response()->json(['messages' => 'Tidak terdapat Kategori Pemeliharaan tersebut']);
        } else {
            return new KategoriPemeliharaanResource($dataKategoriPemeliharaan);
        }
    }

    public function update(KategoriPemeliharaanRequest $request, $id)
    {
        $dataKategoriPemeliharaan = KategoriPemeliharaan::where('id', $id)->first();

        $dataKategoriPemeliharaan->nama = $request->nama;
        $dataKategoriPemeliharaan->save();

        return response()->json(['messages' => 'Kategori Pemeliharaan berhasil diubah']);
    }

    public function destroy($id)
    {

        $dataKategoriPemeliharaan = KategoriPemeliharaan::where('id', $id)->first();

        if ($dataKategoriPemeliharaan != NULL) {
            $cekBarangInventaris = BarangInventaris::where('id_kategori_pemeliharaan', $id)->first();
            $cekKegiatanPemeliharaan = KegiatanPemeliharaan::where('id_kategori_pemeliharaan', $id)->first();

            if($cekBarangInventaris || $cekKegiatanPemeliharaan){
                $messages = 'Gagal menghapus, Kategori Barang tersebut terdapat pada';
                $isBarang = false;

                if ($cekBarangInventaris) {
                    $messages .= ' Barang Inventaris';
                    $isBarang = true;
                }

                if ($cekKegiatanPemeliharaan) {
                    $messages .= $isBarang ? ' dan Kegiatan Pemeliharaan' : ' Kegiatan Pemeliharaan';
                }

                return response()->json(['messages' => $messages], 500);
            }
            // else {
                // menghapus data lowongan
                $dataKategoriPemeliharaan->delete();

                return response()->json(['messages' => 'Berhasil menghapus data Kategori'], 200);
            // }

        }
    }
}
