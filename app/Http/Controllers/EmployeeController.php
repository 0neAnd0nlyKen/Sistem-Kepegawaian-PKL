<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Employee::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $employee = Employee::create($request->all());
        return response()->json($employee, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return response()->json($employee);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, Employee $employee)
    {
        $employee->update($request->all());
        return response()->json($employee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json(null, 204);
    }
    /**
     * Handle promotion of an employee to a higher role.
     */
    public function jabatanPangkatAtas(Employee $employee){
        return $employee->jabatanPangkatAtas();
    }
    public function naikPangkat(Employee $employee, \App\Models\Role $jabatanBaru)
    {
        Log::info('Attempting promotion', [
            'employee_id' => $employee->id,
            'employee_name' => $employee->nama_lengkap,
            'current_role_id' => $employee->role_id,
            'current_pangkat' => $employee->role ? $employee->role->pangkat : null,
            'target_role_id' => $jabatanBaru->id,
            'target_pangkat' => $jabatanBaru->pangkat,
        ]);

        if ($jabatanBaru->pangkat - $employee->role->pangkat !== -1) {
            Log::warning('Promotion failed: target role is not one level higher', [
                'employee_id' => $employee->id,
                'current_pangkat' => $employee->role ? $employee->role->pangkat : null,
                'target_pangkat' => $jabatanBaru->pangkat,
            ]);
            return response()->json(['message' => 'jabatan baru harus di atas satu level'], 400);
        }

        //patch agar jabatan_id employee kini menjadi jabatanBaru
        $employee->update([
            'jabatan_id' => $jabatanBaru->id,
        ]);

        Log::info('Promotion successful', [
            'employee_id' => $employee->id,
            'new_role_id' => $jabatanBaru->id,
            'new_pangkat' => $jabatanBaru->pangkat,
        ]);

        return response()->json(['message' => 'Employee promoted successfully', 'role' => $jabatanBaru], 200);
    }

}
