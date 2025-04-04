<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function showlistquiz ()
    {
        return view('peserta.quizlist');
    }
}
