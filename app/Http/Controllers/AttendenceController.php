<?php

namespace App\Http\Controllers;

use App\Models\Attendence;
use App\Http\Requests\StoreAttendenceRequest;
use App\Http\Requests\UpdateAttendenceRequest;
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
     * Custom: Find by employee_id and tanggal (composite key)
     */
    public function show($employee_id, $tanggal)
    {
        $attendence = Attendence::where('employee_id', $employee_id)
            ->where('tanggal', $tanggal)
            ->firstOrFail();
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
     * Custom: Find by employee_id and tanggal (composite key)
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
     * Custom: Find by employee_id and tanggal (composite key)
     */
    public function destroy($employee_id, $tanggal)
    {
        $attendence = Attendence::where('employee_id', $employee_id)
            ->where('tanggal', $tanggal)
            ->firstOrFail();
        $attendence->delete();
        return response()->json(null, 204);
    }
    public function setCuti(\App\Models\LeaveApplication $leaveApplication)
    {
        $start = \Carbon\Carbon::parse($leaveApplication->tgl_mulai);
        $end = \Carbon\Carbon::parse($leaveApplication->tgl_selesai);
        for ($date = $start; $date->lte($end); $date->addDay()) {
            if ($date->isWeekday()) {
                Attendence::findByEmployeeAndDate($leaveApplication->employee, $date->format('Y-m-d'))->first()
                ->update([
                    'status' => 'Cuti',
                    'jam_masuk' => null,
                    'jam_keluar' => null,
                ]);
            }
        }
        return response()->json(['message' => 'Cuti telah diatur untuk pegawai ' . $leaveApplication->employee->name], 200);
    }

    public function buatBulanBaru(\Illuminate\Http\Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        Attendence::buatBulanBaru($bulan, $tahun);
        return response()->json(['message' => 'Bulan baru telah dibuat untuk attendence'], 201);
    }
}
