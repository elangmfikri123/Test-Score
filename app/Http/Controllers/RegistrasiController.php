<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MainDealer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegistrasiController extends Controller
{
    public function registrasi()
    {
        $mainDealers = MainDealer::select('id', 'kodemd', 'nama_md')->get();
        $categories = Category::select('id', 'namacategory')->get();
        
        return view('registerpeserta', compact('mainDealers', 'categories'));
    }
}
