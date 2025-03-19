<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nurse extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['nurse_id'];

     // Relationship with User
     public function user()
     {
         return $this->belongsTo(User::class, 'nurse_id', 'id');
     }
     public function userDetails()
     {
         return $this->hasOne(UserDetail::class, 'user_id', 'nurse_id');
     }
}
