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
        return $this->hasOne(User::class);
    }
    public function maindealer()
    {
        return $this->belongsTo(MainDealer::class);
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
}
