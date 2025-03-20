<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
         'patient_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'dob',
        'gender',
        'address',
        'blood_group',
        'emergency_contact',
     ];

     public static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            $lastPatient = self::latest()->first();
            $number = $lastPatient ? ((int) substr($lastPatient->patient_id, 3)) + 1 : 101;
            $patient->patient_id = 'PAT' . $number;
        });
    }
    // Relationships
    // public function department()
    // {
    //     return $this->belongsTo(Department::class);
    // }
}
