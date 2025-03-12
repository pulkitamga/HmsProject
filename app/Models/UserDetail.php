<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table = 'user_details';
     protected $fillable=[
         'user_id','specialization', 'education', 'image', 'phone',
        'experience', 'joining_date', 'address', 'bio', 'status',
        'gender', 'dob', 'blood_group'
     ];

     public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
