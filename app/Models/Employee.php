<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use Illuminate\Support\Facades\Log;

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
        $role = Role::find($this->jabatan_id);
        if (!$role) {
            //return exception
            Log::error('Role not found for employee', ['jabatan_id' => $this->jabatan_id]);
            throw new \Exception('Role not found');
        }
        return $this->belongsTo(Role::class, 'jabatan_id');
    }

    public function jabatanPangkatAtas()
    {
        $higherRoles = Role::where('pangkat', '=', $this->role->pangkat - 1)->get();
        return response()->json($higherRoles);
    }

}
