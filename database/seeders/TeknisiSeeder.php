<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class TeknisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => Uuid::uuid4()->toString(),
            'username' => 'faizal',
            'password' => Hash::make('123'),
            'role' => 'teknisi'
        ]);
        User::create([
            'id' => Uuid::uuid4()->toString(),
            'username' => 'rendi',
            'password' => Hash::make('123'),
            'role' => 'teknisi'
        ]);
    }
}
