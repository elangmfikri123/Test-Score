<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminMD extends Model
{
    use HasFactory;

    protected $table = 'adminmd';
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function maindealer()
    {
        return $this->belongsTo(Maindealer::class);
    }
}
