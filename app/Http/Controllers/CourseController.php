<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Answer;
use App\Models\Course;
use App\Models\Peserta;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PesertaCourse;

class CourseController extends Controller
{
    public function managecourselist()
    {
        return view('admin.admin-managecourse');
    }
    public function addnewcourse()
    {
        $categories = Category::all();
        return view('admin.admin-addnewcourse', compact('categories'));
    }
    public function showcourselist(Request $request)
    {
        $data = Course::with('category')
            ->withCount('questions');

        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $data->where(function ($query) use ($search) {
                $query->where('namacourse', 'like', '%' . $search . '%');
            });
        }

        $result = DataTables()->of($data)
            ->addColumn('categoryname', function ($row) {
                return $row->category ? $row->category->namacategory : '-';
            })
            ->addColumn('totalquestion', function ($row) {
                return $row->questions_count ?? 0;
            })
            ->addColumn('action', function ($row) {
                return '
                    <a href="' . url('/admin/exams/' . $row->id . '/questions') . '" class="btn btn-sm btn-info">Add</a>
                    <a href="' . url('/admin/exams/' . $row->id . '/edit') . '" class="btn btn-sm btn-warning">Edit</a>
                    <a href="' . url('/admin/exams/' . $row->id) . '" class="btn btn-sm btn-danger">Hapus</a>
                ';
            })
            ->rawColumns(['action'])
            ->toJson();

        return $result;
    }
    public function store(Request $request)
    {
        Course::create([
            'category_id' => $request->category_id,
            'namacourse' => $request->namacourse,
            'description' => $request->description,
            'randomanswer' => $request->randomanswer,
            'randomquestion' => $request->randomquestion,
            'showscore' => $request->showscore,
            'duration_minutes' => $request->duration_minutes,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'created_by' => auth()->user()->username ?? 'SystemAdmin'
        ]);

        return redirect('/admin/exams')->with('success', 'Course berhasil ditambahkan!');
    }
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $categories = Category::all();
        return view('admin.admin-editcourse', compact('course', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $course->update([
            'category_id' => $request->category_id,
            'namacourse' => $request->namacourse,
            'description' => $request->description,
            'randomanswer' => $request->randomanswer,
            'randomquestion' => $request->randomquestion,
            'showscore' => $request->showscore,
            'duration_minutes' => $request->duration_minutes,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect('/admin/exams')->with('success', 'Course berhasil diperbarui!');
    }
    public function showquestionslist($id)
    {
        $course = Course::withCount('questions')->findOrFail($id);
        return view('admin.admin-questionslist', compact('course'));
    }
    public function dataquestionAnswerJson($id)
    {
        $questions = Question::with('answers')
            ->where('course_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        return datatables()->of($questions)
            ->addIndexColumn()
            ->addColumn('questions_answer', function ($question) {
                $html = '<div style="word-break: break-word; white-space: normal;">' . $question->pertanyaan . '</div>';
                $html .= '<table style="width: 100%;">';

                foreach ($question->answers as $index => $answer) {
                    $label = chr(65 + $index);
                    $isCorrect = $answer->is_correct;
                    $textColor = $isCorrect ? 'green' : 'black';
                    $fontWeight = $isCorrect ? 'bold' : 'normal';
                    $check = $isCorrect ? '<i class="ion-checkmark" style="color: green;"></i>' : '';
                    $bgColor = $isCorrect ? 'background-color: #D4EDDA;' : '';

                    $html .= "<tr style='$bgColor'>
                    <td style='width: 30px; color: $textColor; font-weight: $fontWeight;'>$label.</td>
                    <td style='color: $textColor; font-weight: $fontWeight; word-break: break-word; white-space: normal; max-width: 600px;'>{$answer->jawaban}</td>
                    <td style='width: 30px;'>$check</td>
                  </tr>";
                }

                $html .= '</table>';
                return $html;
            })
            ->addColumn('action', function ($question) {
                $editUrl = url("/admin/exams/question-edit/" . $question->id);
                $deleteUrl = url("/admin/exams/question-delete/" . $question->id);

                return '
                <a href="' . $editUrl . '" class="btn btn-sm btn-warning"><i class="ion-edit"></i> Edit</a>
                <button class="btn btn-sm btn-danger" onclick="deleteQuestion(' . $question->id . ')"><i class="ion-trash-b"></i> Hapus</button>
            ';
            })
            ->rawColumns(['questions_answer', 'action'])
            ->make(true);
    }

    public function createquestion($id)
    {
        $course = Course::withCount('questions')->findOrFail($id);
        return view('admin.admin-addnewquestions', compact('course'));
    }
    public function storequestion(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'jawaban' => 'required|array|min:1',
            'is_correct' => 'required|array',
        ]);

        $question = new Question();
        $question->course_id = $id;
        $question->pertanyaan = $request->deskripsi;
        $question->save();

        foreach ($request->jawaban as $index => $jawabanText) {
            $answer = new Answer();
            $answer->question_id = $question->id;
            $answer->jawaban = $jawabanText;
            $answer->is_correct = isset($request->is_correct[$index]) && $request->is_correct[$index] == 1 ? 1 : 0;
            $answer->save();
        }

        return redirect()->back()->with('success', 'Soal berhasil ditambahkan.');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = 'img_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalName();
            $path = $file->storeAs('uploadcourse', $filename, 'public');
            $url = asset('storage/uploadcourse/' . $filename);
            return response()->json(['location' => $url]);
        }

        return response()->json(['error' => 'Tidak ada file diunggah'], 400);
    }

    public function editquestion($id)
    {
        $question = Question::with('answers', 'course.category')->findOrFail($id);
        $course = $question->course;
        return view('admin.admin-editquestions', compact('question', 'course'));
    }

    public function updatequestion(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'jawaban' => 'required|array|min:1',
            'is_correct' => 'required|array',
        ]);

        $question = Question::findOrFail($id);
        $question->pertanyaan = $request->deskripsi;
        $question->save();
        Answer::where('question_id', $id)->delete();
        foreach ($request->jawaban as $index => $jawabanText) {
            $answer = new Answer();
            $answer->question_id = $question->id;
            $answer->jawaban = $jawabanText;
            $answer->is_correct = isset($request->is_correct[$index]) && $request->is_correct[$index] == 1 ? 1 : 0;
            $answer->save();
        }
        return redirect()->route('admin.exams.questions', ['id' => $question->course_id])
            ->with('success', 'Soal berhasil diperbarui.');
    }

    public function showCourseParticipants()
    {
        return view('admin.admin-managecourseparticipants');
    }

    public function JsonParticipantsCourse(Request $request)
    {
        $data = Course::with('category')
            ->select('id', 'category_id', 'namacourse', 'start_date', 'end_date');

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('categoryname', function ($row) {
                return $row->category->namacategory ?? '-';
            })
            ->addColumn('participant', function ($row) {
                return PesertaCourse::where('course_id', $row->id)->count();
            })
            ->addColumn('action', function ($row) {
                $url = url('/admin/manage-participants/' . $row->id);
                return '<a href="' . $url . '" class="btn btn-sm btn-primary">Manage</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function listParticipanstCourse($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.admin-monitoringparticipants', compact('course'));
    }

    public function addParticipants($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.admin-enrolledparticipants', compact('course'));
    }

    public function getEnrolledParticipantsJson($id)
    {
        $pesertaCourses = PesertaCourse::with(['peserta', 'course'])
            ->where('course_id', $id)
            ->get();

        return datatables()->of($pesertaCourses)
            ->addColumn('nama', fn($row) => $row->peserta->nama)
            ->addColumn('honda_id', fn($row) => $row->peserta->honda_id)
            ->addColumn('namacategory', fn($row) => $row->peserta->category->namacategory ?? '-')
            ->addColumn('duration_minutes', function ($row) {
                if ($row->status_pengerjaan === 'sedang_dikerjakan') {
                    $endTime = Carbon::parse($row->selesai_ujian);
                    $remaining = $endTime->diffInSeconds(now(), false);
                    return $remaining > 0 ? $remaining : 0;
                }
                if ($row->status_pengerjaan === 'belum_mulai') {
                    return $row->course->duration_minutes * 60;
                }
                if ($row->status_pengerjaan === 'selesai' && $row->sisa_waktu) {
                    $parts = explode(':', $row->sisa_waktu);
                    $seconds = ($parts[0] * 3600) + ($parts[1] * 60) + $parts[2];
                    return $seconds;
                }

                return 0;
            })
            ->addColumn('status_pengerjaan', function ($row) {
                $status = $row->status_pengerjaan ?? '-';
                $badge = match ($status) {
                    'belum_mulai' => '<label class="label label-warning">Belum Mulai</label>',
                    'sedang_dikerjakan' => '<label class="label label-info">On Progress</label>',
                    'selesai' => '<label class="label label-success">Selesai</label>',
                    default => '<label class="label label-default">-</label>',
                };
                return $badge;
            })
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">Hapus</button>';
            })
            ->rawColumns(['status_pengerjaan', 'action'])
            ->make(true);
    }

    public function deletePeserta($id)
    {
        $peserta = PesertaCourse::findOrFail($id);
        $peserta->delete();
        return response()->json(['status' => 'success']);
    }

    public function getNonEnrolledParticipantsJson($id)
    {
        $enrolledPesertaIds = PesertaCourse::where('course_id', $id)->pluck('peserta_id')->toArray();

        $peserta = Peserta::with(['category', 'maindealer'])
            ->whereNotIn('id', $enrolledPesertaIds)
            ->get();

        return datatables()->of($peserta)
            ->addIndexColumn()
            ->addColumn('namacategory', function ($row) {
                return $row->category->namacategory ?? '-';
            })
            ->addColumn('kodemd', function ($row) {
                return $row->maindealer->kodemd ?? '-';
            })
            ->addColumn('action', fn($row) => '<input type="checkbox" class="rowCheckbox" value="' . $row->id . '">')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function storeParticipants(Request $request, $id)
    {
        $request->validate([
            'peserta_ids' => 'required|array',
        ]);

        foreach ($request->peserta_ids as $pesertaId) {
            PesertaCourse::firstOrCreate([
                'course_id' => $id,
                'peserta_id' => $pesertaId,
            ]);
        }

        return redirect()->route('participants.monitoring', $id)->with('success', 'Peserta berhasil ditambahkan');
    }
}
