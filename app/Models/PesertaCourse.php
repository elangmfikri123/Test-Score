<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaCourse extends Model
{
    use HasFactory;

    protected $table = 'peserta_course';
    protected $guarded = ['id'];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
