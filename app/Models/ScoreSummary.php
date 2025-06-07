<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreSummary extends Model
{
        use HasFactory;

    protected $table = 'scoressummary';
    protected $guarded = ['id'];
}
