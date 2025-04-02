<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainDealer extends Model
{
    use HasFactory;

    protected $table = 'maindealer';
    protected $guarded = ['id'];
}
