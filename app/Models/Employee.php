<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    protected $fillable = [
        'nip',
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_telp',
        'email',
        'jabatan_id',
        'departemen',
        'tanggal_masuk',
        'status_karyawan',
        'foto',
    ];
    //jabatan_id dari tabel roles (jabatan)
    public function role()
    {
        return $this->belongsTo(Role::class, 'jabatan_id');
    }
}
