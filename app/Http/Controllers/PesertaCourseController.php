<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use App\Models\PesertaAnswer;
use App\Models\PesertaCourse;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\Question;

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
        $questions = $pesertaCourse->course->questions->sortBy('id')->values();
        $question = $questions[$questionNumber - 1];

        // Cek jawaban peserta
        $selectedAnswer = PesertaAnswer::where('peserta_id', $pesertaCourse->peserta_id)
            ->where('question_id', $question->id)
            ->first();

        // Jika request dari AJAX (AJAX = JSON), return response json
        if (request()->ajax()) {
            return response()->json([
                'question_id' => $question->id,
                'question_number' => $questionNumber,
                'pertanyaan' => $question->pertanyaan,
                'answers' => $question->answers,
                'selected_answer_id' => $selectedAnswer->answer_id ?? null,
                'total_questions' => $questions->count(),
            ]);
        }

        // Jika bukan AJAX, render view blade quiz.blade.php
        return view('courses.quiz', [
            'questionNumber' => $questionNumber,
            'question' => $question,
            'questions' => $questions,
            'totalQuestions' => $questions->count(),
            'id' => $id,
            'pesertaCourse' => $pesertaCourse,
        ]);
    }

    public function getQuestionAjax($id, $questionNumber)
    {
        $peserta = auth()->user();
        $pesertaCourse = PesertaCourse::with('course')->findOrFail($id);
        $questions = Question::where('course_id', $pesertaCourse->course_id)->get();
        $question = $questions[$questionNumber - 1] ?? null;

        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }

        $answers = $question->answers->map(function ($answer) {
            return [
                'id' => $answer->id,
                'question_id' => $answer->question_id,
                'jawaban' => $answer->jawaban,
                'created_at' => $answer->created_at,
                'updated_at' => $answer->updated_at,
            ];
        });
        $selectedAnswer = PesertaAnswer::where('peserta_id', $peserta->id)
            ->where('question_id', $question->id)
            ->first();

        return response()->json([
            'question_id' => $question->id,
            'question_number' => $questionNumber,
            'pertanyaan' => $question->pertanyaan,
            'answers' => $answers,
            'selected_answer_id' => $selectedAnswer->answer_id ?? null,
            'totalQuestions' => count($questions),
        ]);
    }

    public function getAnsweredStatus($pesertaId, $courseId)
    {
        // Ambil status soal yang sudah dijawab oleh peserta berdasarkan course_id
        $answeredStatus = PesertaAnswer::where('peserta_id', $pesertaId)
        ->whereHas('question', function ($query) use ($courseId) {
            $query->where('course_id', $courseId);
        })
        ->get()
        ->map(function ($answer) {
            return [
                'nomor' => $answer->question_id,
                'is_answered' => true,
            ];
        });
    
    
        // Mengembalikan status soal yang sudah dijawab
        return response()->json($answeredStatus);
    }
    
    public function submitAnswerAjax(Request $request)
    {
        $request->validate([
            'peserta_id' => 'required',
            'question_id' => 'required',
            'answer_id' => 'required',
        ]);

        $answer = Answer::find($request->answer_id);

        $isCorrect = $answer && $answer->is_correct;

        PesertaAnswer::updateOrCreate(
            [
                'peserta_id' => $request->peserta_id,
                'question_id' => $request->question_id,
            ],
            [
                'answer_id' => $request->answer_id,
                'is_correct' => $isCorrect
            ]
        );

        return response()->json(['status' => 'success']);
    }
}
