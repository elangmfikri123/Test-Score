<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';
    protected $guarded = ['id'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    public function peserta()
    {
        return $this->hasMany(Peserta::class);
    }
    public function forms()
    {
        return $this->hasMany(FormPenilaian::class);
    }
}
