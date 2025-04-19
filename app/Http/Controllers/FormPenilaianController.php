<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormPenilaianController extends Controller
{
    public function show()
    {
        return view('admin.admin-scorecardlist');
    }
    public function listScoreCardJson()
    {
        return view('admin.admin-scorecardlist');
    }
}
