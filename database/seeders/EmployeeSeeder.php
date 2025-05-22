<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            [
                'nip' => '230001',
                'nama_lengkap' => 'I Made Sastra Wiguna',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2002-01-01',
                'alamat' => 'Denpasar',
                'no_telp' => '081234567890',
                'email' => 'sastra@example.com',
                'role_id' => 5, // Magang
                'departemen' => 'IT',
                'tanggal_masuk' => '2024-05-01',
                'status_karyawan' => 'Aktif',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '230002',
                'nama_lengkap' => 'Kennardy Andrew Limartha',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2002-02-02',
                'alamat' => 'Surabaya',
                'no_telp' => '081234567891',
                'email' => 'kennardyl@example.com',
                'role_id' => 5, // Magang
                'departemen' => 'IT',
                'tanggal_masuk' => '2024-05-01',
                'status_karyawan' => 'Aktif',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '230003',
                'nama_lengkap' => 'Dewi Ayu Lestari',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '1998-03-15',
                'alamat' => 'Bandung',
                'no_telp' => '081234567892',
                'email' => 'dewiayu@example.com',
                'role_id' => 3, // Staff
                'departemen' => 'HRD',
                'tanggal_masuk' => '2020-01-10',
                'status_karyawan' => 'Aktif',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '230004',
                'nama_lengkap' => 'Budi Santoso',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '1995-07-20',
                'alamat' => 'Jakarta',
                'no_telp' => '081234567893',
                'email' => 'budi@example.com',
                'role_id' => 2, // Supervisor
                'departemen' => 'Keuangan',
                'tanggal_masuk' => '2018-06-15',
                'status_karyawan' => 'Aktif',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '230005',
                'nama_lengkap' => 'Siti Nurhaliza',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '1990-12-05',
                'alamat' => 'Yogyakarta',
                'no_telp' => '081234567894',
                'email' => 'siti@example.com',
                'role_id' => 1, // Manager
                'departemen' => 'Operasional',
                'tanggal_masuk' => '2015-03-01',
                'status_karyawan' => 'Aktif',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
