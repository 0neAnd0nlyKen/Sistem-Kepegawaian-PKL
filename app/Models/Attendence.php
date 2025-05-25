<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendence extends Model
{
    /** @use HasFactory<\Database\Factories\AttendenceFactory> */
    use HasFactory;
    protected $fillable = [
        'pegawai_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status',
    ];
    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
        'jam_keluar' => 'datetime',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'pegawai_id');
    }
    //metode mencari dengan input model Employee dan input tanggal
    public function scopeFindByEmployeeAndDate($query, Employee $employee, $date)
    {
        return $query->where('pegawai_id', $employee->id)
                     ->whereDate('tanggal', $date);
    }
    // buat bulan baru berdasarkan Route::post('attendences/bulan', 'App\\Http\\Controllers\\AttendenceController@buatBulanBaru');
    public static function buatBulanBaru($bulan, $tahun)
    {
        $startDate = \Carbon\Carbon::createFromDate($tahun, $bulan, 1);
        $endDate = $startDate->copy()->endOfMonth();
        $employees = Employee::all();

        foreach ($employees as $employee) {
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                //untuk hari kerja
                if ($date->isWeekday()) {
                    self::updateOrCreate(
                        ['employee_id' => $employee->id, 'tanggal' => $date],
                        ['status' => 'Hadir', 'jam_masuk' => null, 'jam_keluar' => null]
                    );
                }
            }
        }
    }
    public function scopeKehadiranBulananPegawai($query, Employee $employee, $bulan, $tahun)
    {
        return $query->where('employee_id', $employee->id)
                     ->whereYear('tanggal', $tahun)
                     ->whereMonth('tanggal', $bulan)
                     ->get();
    }
}
