<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\Uuid;
use App\Models\BarangInventaris;
use App\Http\Requests\BarangInventarisRequest;
use App\Http\Resources\BarangInventarisResource;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarangInventarisController extends Controller
{
    public function index()
    {
        // Mendapatkan data Barang Inventaris dengan mengambil relasi kategori_pemeliharaan
        $dataBarangInventaris = BarangInventaris::with('kategori_pemeliharaan')->get();

        if ($dataBarangInventaris->isEmpty()) {
            return response()->json(['status' => false, 'messages' => 'Tidak ada data Barang Inventaris']);
        } else {
            // Mengelompokkan data berdasarkan kategori
            $groupedData = $dataBarangInventaris->groupBy('kategori_pemeliharaan');

            // Mengubah hasil pengelompokkan menjadi bentuk yang sesuai dengan kebutuhan
            $groupedDataFormatted = $groupedData->map(function ($group, $kategori) {
                $sortedData = $group->sortBy('nama');
                return [
                    'status' => true,
                    'id_kategori' => json_decode($kategori)->id,
                    'nama_kategori' => json_decode($kategori)->nama,
                    'data' => BarangInventarisResource::collection($group),
                ];
            })->values();

            return response()->json($groupedDataFormatted);
        }
    }

    public function withoutKategori()
    {

        // Mendapatkan data Barang Inventaris dengan mengambil relasi kategori_pemeliharaan
        $dataBarangInventaris = BarangInventaris::orderBy('nama')->get(['id', 'nama']);

        if ($dataBarangInventaris->isEmpty()) {
            return response()->json(['messages' => 'Tidak ada data Barang Inventaris']);
        } else {
            return response()->json($dataBarangInventaris);
        }
    }

    public function count()
    {
        $barangCount = BarangInventaris::count();

        return response()->json(['jumlah_barang' => $barangCount]);
    }

    public function store(BarangInventarisRequest $request)
    {
        $uuidBarangInventaris = Uuid::uuid4()->toString();

        $dataBarangInventaris = new BarangInventaris;
        $dataBarangInventaris->id = $uuidBarangInventaris;
        $dataBarangInventaris->id_kategori_pemeliharaan = $request->id_kategori_pemeliharaan;
        $dataBarangInventaris->nama = $request->nama;
        $dataBarangInventaris->save();

        $this->generateQrCode($uuidBarangInventaris);

        return response()->json(['messages' => 'Barang Inventaris berhasil di tambahkan']);
    }

    public function show($id)
    {
        $dataBarangInventaris = BarangInventaris::with('pemeliharaan')->where('id', $id)->first();

        if ($dataBarangInventaris == NULL) {
            return response()->json(['messages' => 'Tidak terdapat data Barang Inventaris']);
        } else {
            return new BarangInventarisResource($dataBarangInventaris);
        }
    }

    public function update(BarangInventarisRequest $request, $id)
    {
        $dataBarangInventaris = BarangInventaris::where('id', $id)->first();

        $dataBarangInventaris->id_kategori_pemeliharaan = $request->id_kategori_pemeliharaan;
        $dataBarangInventaris->nama = $request->nama;
        $dataBarangInventaris->save();

        return response()->json(['messages' => 'Barang Inventaris baru berhasil di ubah']);
    }

    public function destroy($id)
    {
        $dataBarangInventaris = BarangInventaris::where('id', $id)->first();

        if ($dataBarangInventaris == NULL) {
            return response()->json(['messages' => 'Tidak terdapat data Barang tersebut']);
        } else {

            $dataBarangInventaris->delete();

            return response()->json(['messages' => 'Data Barang berhasil di hapus']);
        }
    }

    private function generateQrCode($uuidBarangInventaris)
    {
        // $uuidBarangInventaris = '0eb9391c-4a63-421c-857b-84e3827ff987';

        $namaHost = '127.0.0.1'; /* Nanti tinggal diganti aja */

        $url = 'http://' . $namaHost . ':8000/api/barang/show/';

        // Generate QR code data (customize based on your requirements)
        // $qrCodeData = $url . $uuidBarangInventaris . '.svg';
        $qrCodeData = $url . $uuidBarangInventaris;

        // Generate and save the QR code image
        $qrCodePath = $uuidBarangInventaris . '.svg';

        QrCode::format('svg')->size(500)->generate($qrCodeData, storage_path("/app/public/qr_code/" . $qrCodePath));
    }

    public function showQrCode($uuidBarangInventaris)
    {
        // dd(Storage::get('/storage/app/public/qr_code/' . $uuidBarangInventaris . '.svg'));
        // dd(storage_path('app/public/qr_code/' . $uuidBarangInventaris . '.svg'));
        return Storage::get('/public/qr_code/' . $uuidBarangInventaris . '.svg');
        // return storage_path('app/public/qr_code/' . $uuidBarangInventaris . '.svg');
    }
}
