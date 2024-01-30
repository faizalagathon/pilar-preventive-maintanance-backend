<?php

namespace App\Http\Controllers;

use App\Http\Requests\PemeliharaanRequest;
use App\Http\Resources\PemeliharaanResource;
use App\Models\DaftarPemeliharaan;
use App\Models\GambarPemeliharaan;
use App\Models\Pemeliharaan;
use Carbon\Carbon;
// use DateTime;
use DB;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
// use Illuminate\Support\Facades\Storage;



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
     * Display a listing of the resource.
     */
    public function basedMonths()
    {

        $currentYear = Carbon::now()->year;

        // Query untuk mengambil data Pemeliharaan dan mengelompokkannya berdasarkan bulan untuk tahun sekarang
        $dataPemeliharaan = DB::table('pemeliharaan')
            ->select(DB::raw('MONTH(tanggal) as bulan'), DB::raw('COUNT(*) as jumlah'))
            ->whereYear('tanggal', $currentYear)
            ->groupBy('bulan')
            ->orderBy('bulan') // Menambahkan urutan berdasarkan bulan
            ->get();

        if ($dataPemeliharaan->isEmpty()) {
            return response()->json([
                ['bulan' => 1, 'jumlah' => 0],
                // ['bulan' => 2, 'jumlah' => 0],
                // ['bulan' => 3, 'jumlah' => 0],
                // ['bulan' => 4, 'jumlah' => 0],
                // ['bulan' => 5, 'jumlah' => 0],
                // ['bulan' => 6, 'jumlah' => 0],
                // ['bulan' => 7, 'jumlah' => 0],
                // ['bulan' => 8, 'jumlah' => 0],
                // ['bulan' => 9, 'jumlah' => 0],
                // ['bulan' => 10, 'jumlah' => 0],
                // ['bulan' => 11, 'jumlah' => 0],
                // ['bulan' => 12, 'jumlah' => 0],
            ]);
        } else {
            // return PemeliharaanResource::collection($dataPemeliharaan);
            return response()->json($dataPemeliharaan);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // mencari berapa kualifikasi yang dimasukan
        $keys = $request->request->keys();

        $indexTerakhir = key(array_slice($keys, -1, 1, true));

        // Mencocokkan pola angka dalam string
        preg_match('/\d+/', $keys[$indexTerakhir], $arrayAngka);
        // Mengambil angka dari hasil pencocokan
        $jumlah = $arrayAngka[0];


        $i = 1;
        do {
            $rules = [
                "kegiatan_$i" => 'required',
                "catatan" => 'required',
                'gambar' => "required",
                'gambar.*' => "required|mimes:jpeg,png,jpg|max:2048",
            ];

            $messages = [
                "kegiatan_$i.required" => "Kegiatan $i harus diisi.",
                "catatan.required" => "Catatan harus diisi.",
                "gambar.required" => "File gambar diperlukan.",
                "gambar.*.required" => "File gambar diperlukan.",
                'gambar.*.mimes' => 'harus berformat JPEG, PNG, JPG',
                "gambar.*.max" => "tidak boleh lebih dari 2 MB.",
            ];

            $i++;
        } while ($i <= $jumlah);

        $request->validate($rules, $messages);


        $uuidPemeliharaan = Uuid::uuid4()->toString();

        $dataPemeliharaan = new Pemeliharaan;
        $dataPemeliharaan->id = $uuidPemeliharaan;
        $dataPemeliharaan->id_barang_inventaris = $request->id_barang_inventaris;
        $dataPemeliharaan->tanggal = now();
        $dataPemeliharaan->catatan = $request->catatan;
        // $dataPemeliharaan->save();


        // memasukan multiple gambar pemeliharaan
        $gambarFIles = $request->file('gambar');

        foreach ($gambarFIles as $file) {
            $gambar_nama_asli = $file->getClientOriginalName();
            $gambar_nama = date('ymdhis') . '_' . $gambar_nama_asli;
            $file->storeAs('public/gambar_pemeliharaan', $gambar_nama);

            $uuidGambarPemeliharaan = Uuid::uuid4()->toString();
            $gambarDaftarPemeliharaan = new GambarPemeliharaan;
            $gambarDaftarPemeliharaan->id = $uuidGambarPemeliharaan;
            $gambarDaftarPemeliharaan->id_pemeliharaan = $uuidPemeliharaan;
            $gambarDaftarPemeliharaan->gambar = $gambar_nama;
            // $gambarDaftarPemeliharaan->save();
        }



        // tambah daftar pemeliharaan ke DB sesuai yang dimasukan di inputan
        for ($i = 1; $i <= $jumlah; $i++) {
            $uuidDaftarPemeliharaan = Uuid::uuid4()->toString();

            $dataDaftarPemeliharaan = new DaftarPemeliharaan;
            $dataDaftarPemeliharaan->id = $uuidDaftarPemeliharaan;
            $dataDaftarPemeliharaan->id_pemeliharaan = $uuidPemeliharaan;
            $dataDaftarPemeliharaan->id_kegiatan_pemeliharaan = $request['kegiatan_' . $i];
            // $dataDaftarPemeliharaan->save();
        }

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
