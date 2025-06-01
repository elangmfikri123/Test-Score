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

    public function getDisplayNameAttribute()
    {
        switch ($this->role) {
            case 'Peserta':
                return $this->peserta->nama ?? $this->namalengkap;
            case 'Juri':
                return $this->juri->namajuri ?? $this->namalengkap;
            case 'Admin':
                return $this->admin->nama_lengkap ?? $this->namalengkap;
            case 'AdminMD':
                return $this->admin->nama_lengkap ?? $this->namalengkap;
            default:
                return $this->namalengkap;
        }
    }
    public function getInitialsAttribute()
    {
        $name = $this->display_name;
        $words = explode(' ', trim($name));
        $initials = '';

        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(mb_substr($word, 0, 1));
            }
            if (strlen($initials) >= 2) break;
        }

        return substr($initials, 0, 2); // pastikan maksimal 2 huruf
    }
}
