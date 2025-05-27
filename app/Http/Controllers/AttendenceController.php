<?php

namespace App\Http\Controllers;

use App\Models\Attendence;
use App\Http\Requests\StoreAttendenceRequest;
use App\Http\Requests\UpdateAttendenceRequest;
use App\Models\Employee;
use App\Models\LeaveApplication;
use Illuminate\Support\Facades\Log;

use function Illuminate\Log\log;

class AttendenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Attendence::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendenceRequest $request)
    {
        $attendence = Attendence::create($request->validated());
        return response()->json($attendence, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($pegawai_id, $tanggal)
    {
        $attendence = Attendence::findByEmployeeAndDate($pegawai_id, $tanggal);
        return response()->json($attendence);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendence $attendence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttendenceRequest $request, $employee_id, $tanggal)
    {
        $attendence = Attendence::where('employee_id', $employee_id)
            ->where('tanggal', $tanggal)
            ->firstOrFail();
        $attendence->update($request->validated());
        return response()->json($attendence);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendence $attendence)
    {
        //
    }
    public function setCuti(LeaveApplication $leaveApplication)
    {
        Log::info('Setting cuti for leave application: ' . $leaveApplication . ' for employee: ' . $leaveApplication->employee);

        if (!$leaveApplication->employee) {
            return response()->json(['message' => 'Pegawai tidak ditemukan'], 404);
        }
        if (!$leaveApplication->tgl_mulai || !$leaveApplication->tgl_selesai) {
            return response()->json(['message' => 'Tanggal mulai dan selesai cuti harus diisi'], 400);
        }
        if ($leaveApplication->status !== 'approved') {
            return response()->json(['message' => 'Cuti harus disetujui sebelum diatur'], 400);
        }

        Log::info('Setting cuti for employee: ' . $leaveApplication->employee["nama_lengkap"]);
        Attendence::setCuti($leaveApplication);
        Log::info('Cuti telah diatur untuk pegawai: ' . $leaveApplication->employee["nama_lengkap"]);
        return response()->json(['message' => 'Cuti telah diatur untuk pegawai ' . $leaveApplication->employee["nama_lengkap"]], 200);
    }

    public function buatBulanBaru(\Illuminate\Http\Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        Attendence::buatBulanBaru($bulan, $tahun);
        return response()->json(['message' => 'Bulan baru telah dibuat untuk attendence'], 201);
    }

    public function kehadiranBulananPegawai($employee_id, $bulan, $tahun)
    {
        $attendences = Attendence::KehadiranBulananPegawai($employee_id, $bulan, $tahun);
        return response()->json($attendences);
    }

    public function hadir($pegawai_id){
        // gunakan     public static function hadir($pegawai_id, $jam_masuk)
        $jam_masuk = now();
        Log::info('Hadir called for employee: ' . $pegawai_id . ' at ' . $jam_masuk);
        $attendence = Attendence::hadir($pegawai_id, $jam_masuk);
        if (!$attendence) {
            return response()->json(['message' => 'Attendence not found for employee'], 404);
        }
        Log::info('Hadir success for employee: ' . $pegawai_id);
        return response()->json($attendence, 200);
        
    }
}
