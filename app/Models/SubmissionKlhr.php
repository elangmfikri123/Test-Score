<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionKlhr extends Model
{
    use HasFactory;

    protected $table = 'submission_klhrs';
    protected $guarded = ['id'];

    public function maindealer()
    {
        return $this->belongsTo(MainDealer::class);
    }

}
