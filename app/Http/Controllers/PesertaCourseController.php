<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PesertaCourseController extends Controller
{
    public function showconfirmation ()
    {
        return view('courses.confirmation');
    }
    public function showquiz ()
    {
        return view('courses.quiz');
    }
}
