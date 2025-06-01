<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juri extends Model
{
    use HasFactory;

    protected $table = 'juri';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function peserta()
    {
        return $this->belongsToMany(Peserta::class, 'juripeserta');
    }
    public function juripeserta()
    {
        return $this->hasMany(Juripeserta::class);
    }
}
