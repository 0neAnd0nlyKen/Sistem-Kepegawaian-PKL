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
        'check_in',
        'check_out',
        'status',
    ];
    protected $casts = [
        'tanggal' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];
    public $incrementing = false;
    protected $primaryKey = null;
    protected $keyType = 'string';
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
                        ['status' => 'Hadir', 'check_in' => null, 'check_out' => null]
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

    //static function untuk hadir input pegawai_id dan timestamp check_in
    public static function hadir($pegawai_id, $check_in)
    {
        Log::info('Hadir called', [
            'pegawai_id' => $pegawai_id,
            'check_in' => $check_in,
        ]);
        //insert new row today and pegawai_id
        $attendence = self::firstOrCreate(
            ['pegawai_id' => $pegawai_id, 'tanggal' => now()->format('Y-m-d')],
            ['check_in' => null, 'check_out' => null, 'status' => 'pending']
        );
        //if already exists, update check_in and status to hadir
        if ($attendence->check_in) {
            Log::warning('Attendence already exists for today', ['pegawai_id' => $pegawai_id]);
            throw new \Exception('Attendence already exists for today');
        }
        //if not exists, set check_in and status to hadir
        Log::info('Creating new attendence for today', [
            'pegawai_id' => $pegawai_id,
            'tanggal' => now()->format('Y-m-d'),
        ]);
        // update langsung via query builder agar tidak error primary key
        self::where('pegawai_id', $pegawai_id)
            ->whereDate('tanggal', now()->format('Y-m-d'))
            ->update([
                'check_in' => $check_in,
                'status' => 'hadir',
            ]);
        Log::info('Hadir completed', [
            'pegawai_id' => $pegawai_id,
            'check_in' => $check_in,
        ]);
        // return attendence terbaru
        return self::where('pegawai_id', $pegawai_id)
            ->whereDate('tanggal', now()->format('Y-m-d'))
            ->first();
    }
    public static function keluar($pegawai_id, $check_out)
    {
        Log::info('Keluar called', [
            'pegawai_id' => $pegawai_id,
            'check_out' => $check_out,
        ]);
        $attendence = self::where('pegawai_id', $pegawai_id)
            ->whereDate('tanggal', now()->format('Y-m-d'))
            ->first();

        if (!$attendence) {
            Log::error('Attendence not found for employee', ['pegawai_id' => $pegawai_id]);
            throw new \Exception('Attendence not found');
        }

        $attendence->check_out = $check_out;
        $attendence->status = 'Selesai';
        $attendence->save();

        Log::info('Keluar completed', [
            'pegawai_id' => $pegawai_id,
            'check_out' => $check_out,
        ]);
    }
}
