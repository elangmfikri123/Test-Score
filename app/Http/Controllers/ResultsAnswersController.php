<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Peserta;
use App\Models\Question;
use App\Models\PesertaCourse;
use App\Models\PesertaAnswer;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ResultsAnswersController extends Controller
{
    public function showResultsDetails()
    {
        $courses = Course::all();
        return view('admin.admin-resultsanswers', compact('courses'));
    }

    public function downloadExamResults(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:course,id'
        ]);

        $course = Course::with('questions')->find($request->course_id);
        $pesertaCourses = PesertaCourse::with([
            'peserta',
            'peserta.category',
            'peserta.maindealer',
            'pesertaAnswers' => function($query) {
                $query->with(['question', 'answer']);
            }
        ])->where('course_id', $course->id)
          ->where('status_pengerjaan', 'selesai')
          ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = [
            'Nama Quiz',
            'Honda ID',
            'Nama Peserta',
            'Kategori',
            'Kode MD'
        ];
        foreach ($course->questions as $index => $question) {
            $cleanQuestion = $this->cleanQuestionText($question->pertanyaan);
            $headers[] = 'Q'.($index+1).': '.$cleanQuestion;
        }
        $sheet->fromArray([$headers], null, 'A1');
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ];
        $sheet->getStyle('A1:'.$sheet->getHighestColumn().'1')->applyFromArray($headerStyle);

        $row = 2;
        foreach ($pesertaCourses as $pc) {
            $data = [
                $course->namacourse,
                $pc->peserta->honda_id,
                $pc->peserta->nama,
                $pc->peserta->category->namacategory ?? '-',
                $pc->peserta->maindealer->kodemd ?? '-'
            ];

            foreach ($course->questions as $question) {
                $answer = $pc->pesertaAnswers->where('question_id', $question->id)->first();
                $data[] = $answer ? ($answer->is_correct ? 1 : 0) : '-';
            }

            $sheet->fromArray([$data], null, 'A'.$row);
            $sheet->getStyle('A'.$row.':'.$sheet->getHighestColumn().$row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
                
            $row++;
        }

        $sheet->getColumnDimension('A')->setWidth(20); 
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(25); 
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        
        foreach (range('F', $sheet->getHighestColumn()) as $column) {
            $sheet->getColumnDimension($column)->setWidth(15);
            $sheet->getStyle($column.'1:'.$column.$sheet->getHighestRow())
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Freeze header row
        $sheet->freezePane('A2');
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Hasil_Ujian_'.str_replace(' ', '_', $course->namacourse).'_'.now()->format('Ymd_His').'.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
    private function cleanQuestionText($text)
    {
        $text = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $text));
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\bMsoNormal\b|\bstyle=[\'"][^\'"]*[\'"]/', '', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }
}