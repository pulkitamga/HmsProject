<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['room_number', 'room_type', 'capacity', 'status'];

    public function beds()
    {
        return $this->hasMany(Bed::class);
    }
}
