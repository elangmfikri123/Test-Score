<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentitasAtasan extends Model
{
    use HasFactory;

    protected $table = 'identitas_atasans';
    protected $guarded = ['id'];
    
    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }
}
