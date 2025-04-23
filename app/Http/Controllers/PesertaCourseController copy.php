<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesertaCourse;
use Vinkla\Hashids\Facades\Hashids;

class PesertaCourseController extends Controller
{
    public function showConfirmation($id)
    {
        $pesertaCourse = PesertaCourse::with('course.category')->findOrFail($id);

        return view('courses.confirmation', compact('pesertaCourse', 'id'));
    }
    public function showquiz($id, $questionNumber)
    {
        $pesertaCourse = PesertaCourse::with('course.questions.answers')->findOrFail($id);
        $questions = $pesertaCourse->course->questions;
    
        $questions = $questions->sortBy('id')->values();
    
        $index = max(0, min($questionNumber - 1, $questions->count() - 1));
        $question = $questions[$index];
    
        $totalQuestions = $questions->count();
    
        return view('courses.quiz', compact(
            'id', 'question', 'index', 'totalQuestions', 'questionNumber'
        ));
    }
}
