<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'department_id',
        'room_no',
        'admission_date',
        'discharge_date',
        'status',
    ];

    // Patient relation
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Doctor relation (Assuming doctor info is stored in the users table)
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    // Department relation
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
