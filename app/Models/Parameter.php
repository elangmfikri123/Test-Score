<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;

    protected $table = 'parameters';
    protected $guarded = ['id'];

    public function form()
    {
        return $this->belongsTo(FormPenilaian::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
