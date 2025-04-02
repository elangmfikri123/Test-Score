<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrasiController extends Controller
{
    public function registrasi()
    {
        return view('registerpeserta');
    }
    public function registrasi2()
    {
        return view('registerpeserta2');
    }
}
