<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'username',
        'password',
        'role',
        'login_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    

    public function peserta()
    {
        return $this->hasOne(Peserta::class);
    }
    
    public function juri()
    {
        return $this->hasOne(Juri::class);
    }
    
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
}
