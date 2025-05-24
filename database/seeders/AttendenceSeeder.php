<?php

namespace Database\Seeders;

use App\Models\Attendence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // setiap hari kerja (monday,tuesday,wednesday,thursday,friday) untuk bulan mei 2024 untuk pegawai id 1 dan 2
        $startDate = '2024-05-01';
        $endDate = '2024-05-31';
        $dates = [];
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $dayOfWeek = date('l', strtotime($currentDate));
            if (in_array($dayOfWeek, ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'])) {
                $dates[] = $currentDate;
            }
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }
        foreach ($dates as $date) {
            Attendence::create([
                'pegawai_id' => 1,
                'tanggal' => $date,
            ]);
            Attendence::create([
                'pegawai_id' => 2,
                'tanggal' => $date,
            ]);
        }
        
    }
}
