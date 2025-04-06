<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'course';
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function peserta()
    {
        return $this->belongsToMany(Peserta::class, 'peserta_course');
    }
    
}
