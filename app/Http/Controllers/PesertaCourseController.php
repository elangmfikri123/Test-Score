<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesertaCourse;
use Vinkla\Hashids\Facades\Hashids;

class PesertaCourseController extends Controller
{
    public function showConfirmation($encodedId)
    {
        $id = Hashids::decode($encodedId);

        if (empty($id)) {
            abort(404);
        }
    
        $pesertaCourse = PesertaCourse::with('course.category')->findOrFail($id[0]);
    
        return view('courses.confirmation', compact('pesertaCourse'));
    }
    public function showquiz ()
    {
        return view('courses.quiz');
    }
}
