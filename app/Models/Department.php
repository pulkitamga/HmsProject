<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'status'];

    /**
     * Get the doctor assigned to the department.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class, 'department_id');
    }
}
