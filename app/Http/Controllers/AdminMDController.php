<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminMDController extends Controller
{
    public function index ()
    {
        return view('adminmd.adminmd-index');
    }
}
