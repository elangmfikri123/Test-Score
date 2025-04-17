<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index ()
    {
        return view('peserta.indexpeserta');
    }
    public function showlistquiz ()
    {
        return view('peserta.quizlist');
    }
}
