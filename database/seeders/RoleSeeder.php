<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'jabatan_nama' => 'Manager',
                'pangkat' => 1,
                'gaji' => 15000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jabatan_nama' => 'Supervisor',
                'pangkat' => 2,
                'gaji' => 10000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jabatan_nama' => 'Staff',
                'pangkat' => 3,
                'gaji' => 7000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jabatan_nama' => 'Admin',
                'pangkat' => 4,
                'gaji' => 6000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jabatan_nama' => 'Magang',
                'pangkat' => 5,
                'gaji' => 2000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
