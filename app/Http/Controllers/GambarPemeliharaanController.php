<?php

namespace App\Http\Controllers;

use App\Http\Requests\GambarPemeliharaanRequest;
use App\Http\Resources\GambarPemeliharaanResource;
use App\Models\GambarPemeliharaan;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Storage;

class GambarPemeliharaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $dataGambarPemeliharaan = GambarPemeliharaan::with('pemeliharaan')->where('id_pemeliharaan', $id)->get();
        if ($dataGambarPemeliharaan == []) {
            return response()->json(['messages' => 'Tidak terdapat data Gambar']);
        } else {
            return GambarPemeliharaanResource::collection($dataGambarPemeliharaan);
        }
    }

    public function show($gambar)
    {
        return Storage::get('/public/images/' . $gambar);
        // if ($dataGambarPemeliharaan == []) {
        //     return response()->json(['messages' => 'Tidak terdapat data Gambar']);
        // } else {
        //     return GambarPemeliharaanResource::collection($dataGambarPemeliharaan);
        // }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(GambarPemeliharaanRequest $request)
    {
        foreach ($request->file('gambar') as $image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('images', $filename, 'public'); /* Di simpennya di storage/app/public/images */

            $uuidGambarPemeliharaan = Uuid::uuid4()->toString();

            // Save the image record to the database
            $dataGambarPemeliharaan = new GambarPemeliharaan;
            $dataGambarPemeliharaan->id = $uuidGambarPemeliharaan;
            $dataGambarPemeliharaan->id_pemeliharaan = $request->id_pemeliharaan;
            $dataGambarPemeliharaan->gambar = $filename;
            $dataGambarPemeliharaan->save();
        }

        return response()->json(['messages' => 'Data Pemeliharaan baru berhasil di tambahkan']);
    }

    /**
     * Display the specified resource.
     */
    // public function show(GambarPemeliharaan $gambarPemeliharaan)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(GambarPemeliharaanRequest $request, $id)
    {
        $gambarPemeliharaan = GambarPemeliharaan::findOrFail($id);

        // Validate the incoming request using the request class
        $request->validated();

        // Delete the existing image file
        $oldFilename = $gambarPemeliharaan->gambar;
        $this->deleteImage($oldFilename);

        // Upload the new image file
        $newImage = $request->file('gambar');
        $newFilename = time() . '_' . $newImage->getClientOriginalName();
        $newImage->storeAs('images', $newFilename, 'public');

        // Update the database record with the new filename
        $gambarPemeliharaan->update([
            'gambar' => $newFilename,
        ]);

        return response()->json(['messages' => 'Data Gambar Pemeliharaan berhasil di perbarui']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $gambarPemeliharaan = GambarPemeliharaan::findOrFail($id);

        // Delete the image file
        $filename = $gambarPemeliharaan->gambar;
        $this->deleteImage($filename);

        // Delete the database record
        $gambarPemeliharaan->delete();

        return response()->json(['messages' => 'Data Gambar Pemeliharaan berhasil dihapus']);
    }

    private function deleteImage($filename)
    {
        // Use the Storage facade to delete the old image file
        Storage::disk('public')->delete('images/' . $filename);
    }
}
