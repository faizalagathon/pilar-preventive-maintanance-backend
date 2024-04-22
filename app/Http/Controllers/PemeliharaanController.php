<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use App\Models\Pemeliharaan;
use Illuminate\Http\Request;
// use DateTime;
use App\Models\DaftarPemeliharaan;
use App\Models\GambarPemeliharaan;
use App\Http\Requests\PemeliharaanRequest;
use App\Http\Resources\PemeliharaanResource;
use App\Models\BarangInventaris;
use App\Models\KegiatanPemeliharaan;
use Illuminate\Support\Facades\DB;

// use Illuminate\Support\Facades\Storage;



class PemeliharaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $dataPemeliharaan = Pemeliharaan::with('barang_inventaris')->get();

        $dataPemeliharaan = DaftarPemeliharaan::with(['kegiatan_pemeliharaan', 'pemeliharaan'])->groupBy('pemeliharaan.id')->get();

        if ($dataPemeliharaan->isEmpty()) {
            return response()->json(['messages' => 'Tidak terdapat data Pemeliharaan']);
        } else {
            // return PemeliharaanResource::collection($dataPemeliharaan);
            return response()->json($dataPemeliharaan);
        }

        // [
        //     {
        //         'id_pemeliharaan': '',
        //         'kegiatan': [
        //             'nama_kegiatan':'',
        //             'nama_kegiatan':'',
        //             'nama_kegiatan':'',
        //         ],
        //         'catatan': '',
        //         'tanggal': '',
        //     }
        // ]
    }

    public function indexAdmin()
    {
        // $dataPemeliharaan = Pemeliharaan::with('barang_inventaris')->get();
        $dataPemeliharaan = Pemeliharaan::with('barang_inventaris')->get();

        if ($dataPemeliharaan->isEmpty()) {
            return response()->json(['messages' => 'Tidak terdapat data Pemeliharaan']);
        } else {
            $dataPemeliharaan = $dataPemeliharaan->map(function ($pemeliharaan) {
                return [
                    'id' => $pemeliharaan->id,
                    'nama_barang' => $pemeliharaan->barang_inventaris->nama,
                    'tanggal' => $pemeliharaan->tanggal
                ];
            });
            // return PemeliharaanResource::collection($dataPemeliharaan);
            return response()->json($dataPemeliharaan);
        }
    }

    public function getData()
    {
        // Get the latest 5 pemeliharaan data based on created_at timestamp
        $latestPemeliharaan = Pemeliharaan::orderBy('created_at', 'desc')->take(5)->get();

        if ($latestPemeliharaan->isEmpty()) {
            return response()->json(['messages' => 'Tidak terdapat data Pemeliharaan']);
        }

        // You can customize the data format as needed
        $formattedData = $latestPemeliharaan->map(function ($pemeliharaan) {
            return [
                'id' => $pemeliharaan->id,
                'nama_barang' => $pemeliharaan->barang_inventaris->nama,
                'tanggal' => Carbon::parse($pemeliharaan->tanggal)->translatedFormat('d F Y'),
            ];
        });

        return response()->json($formattedData);
    }


    public function indexTeknisi($id)
    {
        $dataPemeliharaan = Pemeliharaan::where('id_barang_inventaris', $id)
            ->with(['barang_inventaris', 'daftar_pemeliharaan.kegiatan_pemeliharaan'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($dataPemeliharaan->isEmpty()) {
            return response()->json(['status' => false, 'messages' => 'Tidak terdapat data Pemeliharaan']);
        } else {
            $formattedData =
                [
                    'status' => true,
                    'data' =>
                        $dataPemeliharaan->map(function ($pemeliharaan) {
                            $namaKegiatan = $pemeliharaan->daftar_pemeliharaan->map(function ($item) {
                                return [
                                    'kegiatan' => $item->kegiatan_pemeliharaan->nama_kegiatan,
                                ];
                            });

                            return [
                                'id_pemeliharaan' => $pemeliharaan->id,
                                'catatan' => $pemeliharaan->catatan,
                                'tanggal' => $pemeliharaan->tanggal,
                                'nama_kegiatan' => $namaKegiatan->toArray(),
                            ];
                        }),
                ];

            return response()->json($formattedData);
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
        $dataPemeliharaan->pembuat_user = $request->pembuat_user;
        $dataPemeliharaan->save();


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
            $gambarDaftarPemeliharaan->save();
        }



        // tambah daftar pemeliharaan ke DB sesuai yang dimasukan di inputan
        for ($i = 1; $i <= $jumlah; $i++) {
            $uuidDaftarPemeliharaan = Uuid::uuid4()->toString();

            $dataDaftarPemeliharaan = new DaftarPemeliharaan;
            $dataDaftarPemeliharaan->id = $uuidDaftarPemeliharaan;
            $dataDaftarPemeliharaan->id_pemeliharaan = $uuidPemeliharaan;
            $dataDaftarPemeliharaan->id_kegiatan_pemeliharaan = $request['kegiatan_' . $i];
            $dataDaftarPemeliharaan->save();
        }

        return response()->json(['messages' => 'Data Pemeliharaan baru berhasil di tambahkan']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dataPemeliharaan = Pemeliharaan::with(['barang_inventaris', 'gambar_pemeliharaan', 'daftar_pemeliharaan.kegiatan_pemeliharaan'])
            ->where('id', $id)->first();

        if ($dataPemeliharaan == NULL) {
            return response()->json(['messages' => 'Tidak terdapat data Pemeliharaan']);
        } else {
            $dataPemeliharaan = [
                'id_barang' => $dataPemeliharaan->id_barang_inventaris,
                'nama_barang' => $dataPemeliharaan->barang_inventaris->nama,
                'tanggal' => $dataPemeliharaan->tanggal,
                'catatan' => $dataPemeliharaan->catatan,
                'daftar_kegiatan' => $dataPemeliharaan
                    ->daftar_pemeliharaan->map(function ($daftarPemeliharaan) {
                        return [
                            'id_kegiatan' => $daftarPemeliharaan
                                ->kegiatan_pemeliharaan->id,
                            'nama_kegiatan' => $daftarPemeliharaan
                                ->kegiatan_pemeliharaan->nama_kegiatan,
                        ];
                    }),
                'daftar_gambar' => $dataPemeliharaan
                    ->gambar_pemeliharaan->pluck('gambar'), // Menggunakan pluck untuk mengambil kolom gambar
            ];

            return response()->json($dataPemeliharaan);
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
            DaftarPemeliharaan::where('id_pemeliharaan', $id)->delete();
            $dataPemeliharaan->delete();

            return response()->json(['messages' => 'Data kegiatan Pemeliharaan berhasil di hapus']);
        }
    }
}
