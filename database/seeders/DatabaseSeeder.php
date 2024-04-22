<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\KategoriPemeliharaan;
use App\Models\KegiatanPemeliharaan;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $idKategoriAC = Uuid::uuid4()->toString();
        // $categories = [
        //     ['id' => $idKategoriAC, 'nama' => 'AC'],
        //     ['id' => Uuid::uuid4()->toString(), 'nama' => 'Komputer'],
        //     ['id' => Uuid::uuid4()->toString(), 'nama' => 'Printer'],
        // ];
        // KategoriPemeliharaan::insert($categories);

        // $activity = [
        //     ['id' => Uuid::uuid4()->toString(), 'id_kategori_pemeliharaan' => $idKategoriAC, 'nama_kegiatan' => 'Cuci'],
        //     ['id' => Uuid::uuid4()->toString(), 'id_kategori_pemeliharaan' => $idKategoriAC, 'nama_kegiatan' => 'Isi Freon']
        // ];
        // KegiatanPemeliharaan::insert($activity);

        $this->call([
            AdminSeeder::class,
        ]);

    }
}
