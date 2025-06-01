<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $table = 'scores';
    protected $guarded = ['id'];

    public function form()
    {
        return $this->belongsTo(FormPenilaian::class);
    }

    public function juri()
    {
        return $this->belongsTo(Juri::class);
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }
    public function juripeserta()
    {
        return $this->belongsTo(JuriPeserta::class);
    }
}
