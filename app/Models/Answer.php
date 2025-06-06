<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answer';
    protected $guarded = ['id'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
