<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function maindealer()
    {
        return $this->belongsTo(MainDealer::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'peserta_course');
    }
    public function answers()
    {
        return $this->hasMany(PesertaAnswer::class);
    }
    public function juri()
    {
        return $this->belongsToMany(Juri::class, 'juripeserta');
    }
    public function identitasAtasan()
    {
        return $this->hasOne(IdentitasAtasan::class);
    }
    public function identitasDealer()
    {
        return $this->hasOne(IdentitasDealer::class);
    }
    public function filesPeserta()
    {
        return $this->hasOne(FilesPeserta::class);
    }

    public function riwayatKlhn()
    {
        return $this->hasMany(RiwayatKlhn::class);
    }
}
