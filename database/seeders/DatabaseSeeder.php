<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\KategoriPemeliharaan;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = [
            ['id' => Uuid::uuid4()->toString(), 'nama' => 'AC'],
            ['id' => Uuid::uuid4()->toString(), 'nama' => 'Komputer'],
            ['id' => Uuid::uuid4()->toString(), 'nama' => 'Printer'],
        ];

        KategoriPemeliharaan::insert($categories);
    }
}
