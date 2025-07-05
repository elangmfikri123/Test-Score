<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\PesertaAnswer;
use App\Models\PesertaCourse;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class ResultCourseController extends Controller
{
    public function showResults()
    {
        return view('admin.admin-resultscourse');
    }
    public function dataResultsJson(Request $request)
    {
        $query = PesertaCourse::with([
            'peserta.user',
            'peserta.maindealer',
            'peserta',
            'course.category'
        ])
            ->where('status_pengerjaan', 'selesai')
            ->when($request->status_pengerjaan, function ($q) use ($request) {
                $q->where('status_pengerjaan', $request->status_pengerjaan);
            })
            ->when($request->course_id, function ($q) use ($request) {
                $q->where('course_id', $request->course_id);
            })
            ->when($request->category_id, function ($q) use ($request) {
                $q->whereHas('course', function ($c) use ($request) {
                    $c->where('category_id', $request->category_id);
                });
            })
            ->when($request->maindealer_id, function ($q) use ($request) {
                $q->whereHas('peserta', function ($p) use ($request) {
                    $p->where('maindealer_id', $request->maindealer_id);
                });
            });
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('namacourse', function ($row) {
                return $row->course->namacourse ?? '-';
            })
            ->addColumn('honda_id', function ($row) {
                return $row->peserta->honda_id ?? '-';
            })
            ->addColumn('nama', function ($row) {
                return $row->peserta->nama ?? '-';
            })
            ->addColumn('category', function ($row) {
                return $row->course->category->namacategory ?? '-';
            })
            ->addColumn('maindealer', function ($row) {
                return $row->peserta->maindealer->nama_md ?? '-';
            })
            ->addColumn('status', function ($row) {
                return ucfirst(str_replace('_', ' ', $row->status_pengerjaan));
            })
            ->addColumn('createdtime', function ($row) {
                return $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-';
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . route('course.details', $row->id) . '" class="btn btn-sm btn-info">Detail</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function showDetails($id)
    {
        $pesertaCourse = PesertaCourse::with(['peserta.maindealer', 'course'])
            ->findOrFail($id);
        $courseId = $pesertaCourse->course_id;
        $questions = Question::where('course_id', $courseId)->get();
        $jawabanPeserta = PesertaAnswer::where('peserta_course_id', $id)->get()->keyBy('question_id');

        $resultDetails = [];
        $jumlahBenar = $jumlahSalah = $jumlahSkip = 0;

        foreach ($questions as $index => $question) {
            $jawaban = $jawabanPeserta->get($question->id);

            if (!$jawaban) {
                $status = 'Skip';
                $jumlahSkip++;
            } elseif ($jawaban->is_correct) {
                $status = 'Benar';
                $jumlahBenar++;
            } else {
                $status = 'Salah';
                $jumlahSalah++;
            }

            $resultDetails[] = [
                'nomor' => $index + 1,
                'question' => $question,
                'status' => $status,
            ];
        }

        $totalSoal = $questions->count();
        $score = $totalSoal > 0 ? round(($jumlahBenar / $totalSoal) * 100, 2) : 0;
        $start = $pesertaCourse->start_exam ? Carbon::parse($pesertaCourse->start_exam) : null;
        $end = $pesertaCourse->end_exam ? Carbon::parse($pesertaCourse->end_exam) : null;
        $durasi = null;

        if ($start && $end) {
            $durasiAsli = $start->diff($end);
            $durasiDalamMenit = $durasiAsli->h * 60 + $durasiAsli->i + ($durasiAsli->s >= 30 ? 1 : 0);
            $maksDurasi = $pesertaCourse->course->duration_minutes;
            if ($durasiDalamMenit > $maksDurasi) {
                $durasi = Carbon::createFromTime(0, 0, 0)->diff(Carbon::createFromTime(0, $maksDurasi, 0));
            } else {
                $durasi = $durasiAsli;
            }
        }

        return view('admin.admin-resultsdetails', [
            'pesertaCourse' => $pesertaCourse,
            'jumlahBenar' => $jumlahBenar,
            'jumlahSalah' => $jumlahSalah,
            'jumlahSkip' => $jumlahSkip,
            'score' => $score,
            'durasi' => $durasi,
            'waktuUjian' => $start,
            'status' => $pesertaCourse->status_pengerjaan,
            'resultDetails' => $resultDetails,
        ]);
    }

    public function showDetailsAnswers($id)
    {
        $pesertaCourse = PesertaCourse::with(['peserta.maindealer', 'course'])->findOrFail($id);
        $questions = Question::with(['answers', 'pesertaAnswer' => function ($query) use ($pesertaCourse) {
            $query->where('peserta_id', $pesertaCourse->peserta_id)
                ->where('peserta_course_id', $pesertaCourse->id);
        }])
            ->where('course_id', $pesertaCourse->course_id)
            ->get();
        $jumlahBenar = $jumlahSalah = $jumlahSkip = 0;

        foreach ($questions as $q) {
            $userAnswer = $q->pesertaAnswer->first();
            if (!$userAnswer) {
                $jumlahSkip++;
            } elseif ($userAnswer->is_correct) {
                $jumlahBenar++;
            } else {
                $jumlahSalah++;
            }
        }

        $totalSoal = $questions->count();
        $score = $totalSoal > 0 ? round(($jumlahBenar / $totalSoal) * 100, 2) : 0;

        $start = $pesertaCourse->start_exam ? Carbon::parse($pesertaCourse->start_exam) : null;
        $end = $pesertaCourse->end_exam ? Carbon::parse($pesertaCourse->end_exam) : null;
        $durasi = null;

        if ($start && $end) {
            $durasiAsli = $start->diff($end);
            $durasiDalamMenit = $durasiAsli->h * 60 + $durasiAsli->i + ($durasiAsli->s >= 30 ? 1 : 0);
            $maksDurasi = $pesertaCourse->course->duration_minutes;

            if ($durasiDalamMenit > $maksDurasi) {
                $durasi = Carbon::createFromTime(0, 0, 0)->diff(Carbon::createFromTime(0, $maksDurasi, 0));
            } else {
                $durasi = $durasiAsli;
            }
        }

        $formattedQuestions = $questions->map(function ($q) use ($pesertaCourse) {
            $userAnswer = $q->pesertaAnswer->first();
            $correctAnswer = $q->answers->firstWhere('is_correct', true);

            $options = [];
            foreach ($q->answers->values() as $i => $ans) {
                $label = chr(65 + $i);
                $options[$label] = [
                    'id' => $ans->id,
                    'text' => $ans->jawaban,
                    'is_correct' => $ans->is_correct
                ];
            }

            $userSelectedLabel = collect($options)->search(fn($val) => $val['id'] == optional($userAnswer)->answer_id);
            $correctLabel = collect($options)->search(fn($val) => $val['is_correct']);

            return [
                'question' => $q->pertanyaan,
                'options' => collect($options)->mapWithKeys(fn($opt, $key) => [$key => $opt['text']])->toArray(),
                'correct_answer' => $correctLabel,
                'user_answer' => $userSelectedLabel,
                'is_skipped' => is_null($userAnswer),
            ];
        });

        return view('admin.admin-resultsdetailsanswers', [
            'questions' => $formattedQuestions,
            'pesertaCourse' => $pesertaCourse,
            'jumlahBenar' => $jumlahBenar,
            'jumlahSalah' => $jumlahSalah,
            'jumlahSkip' => $jumlahSkip,
            'score' => $score,
            'durasi' => $durasi,
            'waktuUjian' => $start,
            'status' => $pesertaCourse->status_pengerjaan,
        ]);
    }
}
