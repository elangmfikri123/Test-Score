<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Answer;
use Illuminate\Http\Request;
use App\Models\PesertaAnswer;
use App\Models\PesertaCourse;
use Vinkla\Hashids\Facades\Hashids;

class PesertaCourseController extends Controller
{
    public function showConfirmation($id)
    {
        $pesertaCourse = PesertaCourse::with('course.category')->findOrFail($id);

        return view('courses.confirmation', compact('pesertaCourse', 'id'));
    }

    public function startExam(Request $request, $id)
    {
        $pesertaCourse = PesertaCourse::with('course')->findOrFail($id);

        $pesertaCourse->update([
            'status_pengerjaan' => 'sedang_dikerjakan',
            'start_exam' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'duration_minutes' => $pesertaCourse->course->duration_minutes,
            'start_time' => now()->timestamp,
        ]);
    }

    public function showQuiz($id)
    {
        $pesertaCourse = PesertaCourse::with(['peserta', 'course'])->findOrFail($id);
        return view('courses.quiz', compact('pesertaCourse'));
    }

    public function loadQuestion($id, $numberQuestion)
    {
        $pesertaCourse = PesertaCourse::with('course.questions.answers')->findOrFail($id);
        $questions = $pesertaCourse->course->questions()->with('answers')->get();
        $question = $questions[$numberQuestion - 1] ?? null;

        if (!$question) {
            return response()->json(['status' => 'error', 'message' => 'Soal tidak ditemukan'], 404);
        }
        $answer = PesertaAnswer::where('peserta_course_id', $pesertaCourse->id)
            ->where('question_id', $question->id)
            ->first();

        $allAnswersRaw = PesertaAnswer::where('peserta_course_id', $pesertaCourse->id)->get();
        $answeredNumbers = [];

        foreach ($questions as $index => $q) {
            $jawaban = $allAnswersRaw->firstWhere('question_id', $q->id);
            if ($jawaban) {
                $answeredNumbers[$index + 1] = $jawaban->answer_id; // index + 1 = question number
            }
        }

        return response()->json([
            'status' => 'success',
            'question_number' => $numberQuestion,
            'question_id' => $question->id,
            'pertanyaan' => $question->pertanyaan,
            'answers' => $question->answers->map(function ($a, $index) {
                return [
                    'id' => $a->id,
                    'text' => $a->jawaban,
                    'label' => chr(65 + $index)
                ];
            }),
            'answered_questions' => $answeredNumbers,
            'selected_answer' => $answer ? $answer->answer_id : null,
            'total_questions' => count($questions),
        ]);
    }

    public function storeAnswer(Request $request)
    {
        $validated = $request->validate([
            'peserta_course_id' => 'required|integer',
            'question_number' => 'required|integer',
            'answer_id' => 'required|integer',
        ]);

        $pesertaCourse = PesertaCourse::findOrFail($validated['peserta_course_id']);
        $questions = $pesertaCourse->course->questions()->get();
        $question = $questions[$validated['question_number'] - 1] ?? null;

        if (!$question) {
            return response()->json(['status' => 'error', 'message' => 'Soal tidak ditemukan'], 404);
        }

        $isCorrect = $this->checkIfAnswerIsCorrect($question->id, $validated['answer_id']);

        $answer = PesertaAnswer::updateOrCreate(
            [
                'peserta_course_id' => $pesertaCourse->id,
                'peserta_id' => $pesertaCourse->peserta_id,
                'question_id' => $question->id,
            ],
            [
                'answer_id' => $validated['answer_id'],
                'is_correct' => $isCorrect,
            ]
        );

        if ($answer) {
            return response()->json(['status' => 'success', 'message' => 'Jawaban disimpan']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan jawaban']);
        }
    }


    private function checkIfAnswerIsCorrect($questionId, $answerId)
    {
        $correctAnswer = Answer::where('question_id', $questionId)
            ->where('is_correct', true)
            ->first();

        return $correctAnswer && $correctAnswer->id == $answerId;
    }

    public function finished($id)
    {
        $pesertaCourse = PesertaCourse::with(['peserta', 'course', 'peserta.mainDealer'])
            ->findOrFail($id);

        return view('courses.examfinished', compact('pesertaCourse'));
    }

    public function finishExam(Request $request, $id)
    {
        $pesertaCourse = PesertaCourse::find($id);

        if (!$pesertaCourse) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
        }

        $pesertaCourse->update([
            'sisa_waktu' => $request->sisa_waktu ?? 0,
            'end_exam' => Carbon::now(),
            'status_pengerjaan' => 'selesai',
        ]);

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Ujian berhasil diakhiri.']);
        }

        return redirect()->route('exam.finished');
    }
}
