<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuriPeserta extends Model
{
    use HasFactory;

    protected $table = 'juripeserta';
    protected $guarded = ['id'];

    public function juri()
    {
        return $this->belongsTo(Juri::class);
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }
}
