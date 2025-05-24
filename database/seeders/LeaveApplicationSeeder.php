<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('leave_applications')->insert([
            [
                'pegawai_id' => 1,
                'tgl_mulai' => '2023-10-01',
                'tgl_selesai' => '2023-10-05',
                'jenis_cuti' => 'tahunan',
                'alasan' => 'Liburan keluarga',
                'status' => 'approved',
                'pemberi_persetujuan_id' => 2,
                'approved_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pegawai_id' => 2,
                'tgl_mulai' => '2023-10-10',
                'tgl_selesai' => '2023-10-12',
                'jenis_cuti' => 'sakit',
                'alasan' => 'Demam tinggi',
                'status' => 'pending',
                'pemberi_persetujuan_id' => null,
                'approved_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
