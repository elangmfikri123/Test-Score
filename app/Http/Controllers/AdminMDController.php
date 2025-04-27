<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MainDealer;
use Illuminate\Http\Request;

class AdminMDController extends Controller
{
    public function index ()
    {
        return view('adminmd.adminmd-index');
    }
    public function registrasiPeserta ()
    {
        $mainDealers = MainDealer::select('id', 'kodemd', 'nama_md')->get();
        $categories = Category::select('id', 'namacategory')->get();
        return view('adminmd.adminmd-registrasipeserta', compact('mainDealers', 'categories'));
    }
}
