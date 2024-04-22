<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => Uuid::uuid4()->toString(),
            'username' => 'admin123',
            'password' => bcrypt('admin'),
            'role' => 'admin'
        ]);
    }
}
