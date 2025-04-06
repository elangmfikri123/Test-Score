<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Category;
use App\Models\Peserta;
use App\Models\Question;
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
        $data = Course::with('category') // relasi ke kategori
            ->withCount('questions');    // hitung total pertanyaan

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

                    $html .= "<tr>
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
        // Validasi input
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
        $pesertaCourses = PesertaCourse::with('peserta')
            ->where('course_id', $id)
            ->get();

        return datatables()->of($pesertaCourses)
            ->addColumn('nama', fn($row) => $row->peserta->nama)
            ->addColumn('honda_id', fn($row) => $row->peserta->honda_id)
            ->addColumn('namacategory', fn($row) => $row->peserta->category ?? '-') // ubah sesuai relasi jika ada
            ->addColumn('durations', fn() => '90 menit') // sementara hardcode
            ->addColumn('action', fn($row) => '<button class="btn btn-danger btn-sm">Hapus</button>')
            ->rawColumns(['action'])
            ->make(true);
    }

    // Datatable JSON untuk peserta yang belum dienroll
    public function getNonEnrolledParticipantsJson($id)
    {
        $enrolledPesertaIds = PesertaCourse::where('course_id', $id)->pluck('peserta_id')->toArray();

        $peserta = Peserta::whereNotIn('id', $enrolledPesertaIds)->get();

        return datatables()->of($peserta)
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
