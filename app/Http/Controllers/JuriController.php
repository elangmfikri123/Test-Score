<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JuriController extends Controller
{
    public function index ()
    {
        return view('juri.juri-index');
    }
    public function pesertalist ()
    {
        return view('juri.juri-listpeserta');
    }
    public function showScoring ()
    {
        return view('juri.juri-scorecard');
    }
}
