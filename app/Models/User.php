<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userDetails()
    {
        return $this->hasOne(UserDetail::class);
    }

    // User.php (Model)
public function doctor()
{
    return $this->hasOne(Doctor::class, 'doctor_id', 'id');
}

    public function role()
    {
        return $this->belongsTo(Role::class, "role_id");
    }


    public function hasPermission($permissionName)
    {
        if ($this->role && $this->role->permissions->isNotEmpty()) {
            return $this->role->permissions->contains('name', $permissionName);
        }
        return true; // Show button if no permissions are assigned
    }


}
