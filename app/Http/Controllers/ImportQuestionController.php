<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CategoryQuestion;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ImportQuestionController extends Controller
{
    public function uploadQuestion($id)
    {
        $course = Course::withCount('questions')->findOrFail($id);
        $categories = CategoryQuestion::where('course_id', $id)->get();
        return view('admin.admin-questionsupload', compact('course', 'categories'));
    }

    public function downloadTemplate($id): BinaryFileResponse
    {
        $course = Course::findOrFail($id);
        $categories = CategoryQuestion::where('course_id', $id)->pluck('vnamacategory');
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header with styling
        $headers = ['No Soal', 'Kategori', 'Pertanyaan'];
        foreach (range('A', 'D') as $option) {
            $headers[] = 'Pilihan ' . $option;
            $headers[] = 'Koreksi ' . $option;
        }
        $sheet->fromArray($headers, null, 'A1');

        // Style header
        $headerStyle = [
            'font' => ['bold' => true],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
        ];
        $sheet->getStyle('A1:K1')->applyFromArray($headerStyle);

        // Set dropdown for categories
        $validation = $sheet->getDataValidation('B2:B1000');
        $validation->setType(DataValidation::TYPE_LIST);
        $validation->setErrorStyle(DataValidation::STYLE_STOP);
        $validation->setAllowBlank(false);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setFormula1('"' . implode(',', $categories->toArray()) . '"');

        // Sample data
        $sampleData = [
            [1, $categories->first(), 'Contoh pertanyaan?', 'Jawaban benar', 1, 'Jawaban salah', 0, '', 0, '', 0]
        ];
        $sheet->fromArray($sampleData, null, 'A2');

        // Auto size columns
        foreach (range('A', 'K') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Save temporary file
        $writer = new Xlsx($spreadsheet);
        $tempPath = tempnam(sys_get_temp_dir(), 'template_');
        $writer->save($tempPath);

        return response()->download($tempPath, 'Template_Soal_' . $course->namacourse . '.xlsx')
            ->deleteFileAfterSend(true);
    }

    public function importQuestions(Request $request, $id)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);

        $course = Course::findOrFail($id);
        
        try {
            $imported = $this->processExcelImport($request->file('file'), $course->id);
            
            return back()->with([
                'success' => 'Berhasil mengimpor ' . $imported . ' soal!',
                'imported_count' => $imported
            ]);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor: ' . $e->getMessage());
        }
    }

    private function processExcelImport($file, $courseId)
    {
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file->getRealPath());
        $spreadsheet = $reader->load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->rangeToArray('A1:O' . $sheet->getHighestDataRow(), null, true, true, false);
        
        array_shift($rows); // Remove header
        
        $importedCount = 0;
        
        foreach ($rows as $row) {
            if (empty(trim((string)($row[2] ?? '')))) continue;
            
            $category = CategoryQuestion::where('vnamacategory', trim((string)($row[1] ?? '')))
                        ->where('course_id', $courseId)
                        ->first();
            
            if (!$category) continue;
            
            $question = Question::create([
                'course_id' => $courseId,
                'categoryquestion_id' => $category->id,
                'pertanyaan' => $row[2],
                'created_by' => auth()->id()
            ]);
            
            $answers = [];
            for ($columnIndex = 3; $columnIndex <= 13; $columnIndex += 2) {
                $answers[] = [
                    'text' => trim((string)($row[$columnIndex] ?? '')),
                    'correct' => $this->isCorrectValue($row[$columnIndex + 1] ?? 0)
                ];
            }
            
            foreach ($answers as $answer) {
                if (!empty($answer['text'])) {
                    Answer::create([
                        'question_id' => $question->id,
                        'jawaban' => $answer['text'],
                        'is_correct' => $answer['correct']
                    ]);
                }
            }
            
            $importedCount++;
        }
        
        return $importedCount;
    }

    private function isCorrectValue($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        $value = strtolower(trim((string)$value));

        return in_array($value, ['1', 'true', 'yes', 'ya', 'benar'], true);
    }
}
