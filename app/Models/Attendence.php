<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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

    public static function setCuti(LeaveApplication $leaveApplication)
    {
        Log::info('Set cuti called', [
            'employee_id' => $leaveApplication->employee->id ?? null,
            'leaveApplication_id' => $leaveApplication->id ?? null,
            'tgl_mulai' => $leaveApplication->tgl_mulai,
            'tgl_selesai' => $leaveApplication->tgl_selesai,
        ]);
        $start = \Carbon\Carbon::parse($leaveApplication->tgl_mulai);
        $end = \Carbon\Carbon::parse($leaveApplication->tgl_selesai);
        for ($date = $start; $date->lte($end); $date->addDay()) {
            if ($date->isWeekday()) {
                Log::info('Setting cuti for date', [
                    'date' => $date->format('Y-m-d'),
                    'employee_id' => $leaveApplication->employee->id,
                ]);
                $updated = self::where('pegawai_id', $leaveApplication->employee->id)
                    ->whereDate('tanggal', $date->format('Y-m-d'))
                    ->update([
                        'status' => 'Cuti',
                        'check_in' => null,
                        'check_out' => null,
                    ]);
                Log::info('Set cuti for date', [
                    'date' => $date->format('Y-m-d'),
                    'updated' => $updated,
                ]);
            }
        }
        Log::info('Set cuti completed', [
            'employee_id' => $leaveApplication->employee->id ?? null,
            'leaveApplication_id' => $leaveApplication->id ?? null,
        ]);
    }
}
