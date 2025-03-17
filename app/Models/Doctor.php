<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['doctor_id'];

    // Relationship with User

    public function user()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    public function userDetails()
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'doctor_id');
    }


}
