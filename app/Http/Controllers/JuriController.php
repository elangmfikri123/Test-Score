<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JuriController extends Controller
{
    public function pesertalist ()
    {
        return view('juri.juri-listpeserta');
    }
}
