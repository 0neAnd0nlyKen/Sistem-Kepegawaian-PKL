<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    protected $fillable = [
        'pegawai_id',
        'tgl_mulai',
        'tgl_selesai',
        'jenis_cuti',
        'alasan',
        'status',
        'pemberi_persetujuan_id',
        'approved_at'
    ];
    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
        'approved_at' => 'datetime',
    ];
    /**
     * Get the employee that owns the leave application.
     */
    public function employee()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'pegawai_id');
    }
    /**
     * Get the approver employee.
     */
    public function approver()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'pemberi_persetujuan_id');
    }

    public function setuju(\App\Models\Employee $pemberi_setuju)
    {
        $this->status = 'approved';
        $this->approved_at = now();
        $this->pemberi_persetujuan_id = $pemberi_setuju->id;
        $this->save();
    }
    public function tolak()
    {
        $this->status = 'rejected';
        $this->approved_at = now();
        $this->save();
    }
}
