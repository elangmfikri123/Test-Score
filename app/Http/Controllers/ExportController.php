<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Peserta;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\PesertaAnswer;
use App\Models\PesertaCourse;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ExportController extends Controller
{
    public function downloadPeserta(Request $request)
    {
        $category_id = $request->input('category_id');
        $maindealer_id = $request->input('maindealer_id');

        $admin = Admin::where('user_id', auth()->id())->first();
        $query = Peserta::with([
            'identitasAtasan',
            'identitasDealer',
            'filesPeserta',
            'category',
            'maindealer',
            'riwayatKlhn'
        ]);

        if (auth()->user()->role === 'AdminMD' && $admin && $admin->maindealer_id) {
            $query->where('maindealer_id', $admin->maindealer_id);
        }
        if ($category_id) {
            $query->where('category_id', $category_id);
        }
        if ($maindealer_id) {
            $query->where('maindealer_id', $maindealer_id);
        }

        $data = $query->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Honda ID');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Kategori');
        $sheet->setCellValue('E1', 'Main Dealer');
        $sheet->setCellValue('F1', 'Jabatan');
        $sheet->setCellValue('G1', 'Tanggal Mendapat Honda ID');
        $sheet->setCellValue('H1', 'Tanggal Awal Bekerja');
        $sheet->setCellValue('I1', 'Lama Bekerja di Dealer Saat Ini');
        $sheet->setCellValue('J1', 'Jenis Kelamin');
        $sheet->setCellValue('K1', 'Tempat Lahir');
        $sheet->setCellValue('L1', 'Tanggal Lahir');
        $sheet->setCellValue('M1', 'Agama');
        $sheet->setCellValue('N1', 'No HP');
        $sheet->setCellValue('O1', 'No HP (Astra Pay)');
        $sheet->setCellValue('P1', 'Pendidikan Terakhir');
        $sheet->setCellValue('Q1', 'Email');
        $sheet->setCellValue('R1', 'Ukuran Baju');
        $sheet->setCellValue('S1', 'Pantangan Makan');
        $sheet->setCellValue('T1', 'Riwayat Penyakit');
        $sheet->setCellValue('U1', 'Link Facebook');
        $sheet->setCellValue('V1', 'Link Instagram');
        $sheet->setCellValue('W1', 'Link Tiktok');
        $sheet->setCellValue('X1', 'Riwayat KLHN Tahun 1');
        $sheet->setCellValue('Y1', 'Status Kepesertaan 1');
        $sheet->setCellValue('Z1', 'Kategory 1');
        $sheet->setCellValue('AA1', 'Riwayat KLHN Tahun 2');
        $sheet->setCellValue('AB1', 'Status Kepesertaan 2');
        $sheet->setCellValue('AC1', 'Kategory 2');
        $sheet->setCellValue('AD1', 'Riwayat KLHN Tahun 3');
        $sheet->setCellValue('AE1', 'Status Kepesertaan 3');
        $sheet->setCellValue('AF1', 'Kategory 3');
        $sheet->setCellValue('AG1', 'Nama Atasan');
        $sheet->setCellValue('AH1', 'Jabatan');
        $sheet->setCellValue('AI1', 'No HP Atasan');
        $sheet->setCellValue('AJ1', 'Kode Dealer');
        $sheet->setCellValue('AK1', 'Nama Dealer');
        $sheet->setCellValue('AL1', 'No HP Dealer');
        $sheet->setCellValue('AM1', 'Link GBP');
        $sheet->setCellValue('AN1', 'Kota Dealer');
        $sheet->setCellValue('AO1', 'Provinsi Dealer');
        $sheet->setCellValue('AP1', 'Tahun Dealer Meraih Juara di KLHN Sebelumnya');
        $sheet->setCellValue('AQ1', 'Kategori Juara');
        $sheet->setCellValue('AR1', 'Sosial Media Facebook');
        $sheet->setCellValue('AS1', 'Sosial Media Instagram');
        $sheet->setCellValue('AT1', 'Sosial Media Tiktok');
        $sheet->setCellValue('AU1', 'Judul Project');
        $sheet->setCellValue('AV1', 'Tahun Project');
        $sheet->setCellValue('AW1', 'Status');
        $sheet->setCellValue('AX1', 'Created Time');
        $sheet->setCellValue('AY1', 'Link Foto Profil');
        // Mengatur Format Header
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ];

        $sheet->getStyle('A1:AY1')->applyFromArray($headerStyle);

        // Data
        $row = 2;
        $no = 1;
        foreach ($data as $peserta) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValueExplicit('B' . $row, $peserta->honda_id, DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $row, $peserta->nama);
            $sheet->setCellValue('D' . $row, $peserta->category->namacategory ?? '');
            $sheet->setCellValue('E' . $row, $peserta->maindealer ? "{$peserta->maindealer->kodemd} - {$peserta->maindealer->nama_md}" : '');
            $sheet->setCellValue('F' . $row, $peserta->jabatan);
            $sheet->setCellValue('G' . $row, $peserta->tanggal_hondaid ? date('d-M-Y', strtotime($peserta->tanggal_hondaid)) : '');
            $sheet->setCellValue('H' . $row, $peserta->tanggal_awalbekerja ? date('d-M-Y', strtotime($peserta->tanggal_awalbekerja)) : '');
            $sheet->setCellValue('I' . $row, $peserta->lamabekerja_dealer);
            $sheet->setCellValue('J' . $row, $peserta->jenis_kelamin);
            $sheet->setCellValue('K' . $row, $peserta->tempat_lahir);
            $sheet->setCellValue('L' . $row, $peserta->tanggal_lahir);
            $sheet->setCellValue('M' . $row, $peserta->agama);
            $sheet->setCellValue('N' . $row, $peserta->no_hp);
            $sheet->setCellValue('O' . $row, $peserta->no_hp_astrapay);
            $sheet->setCellValue('P' . $row, $peserta->pendidikan_terakhir);
            $sheet->setCellValue('Q' . $row, $peserta->email);
            $sheet->setCellValue('R' . $row, $peserta->ukuran_baju);
            $sheet->setCellValue('S' . $row, $peserta->pantangan_makanan);
            $sheet->setCellValue('T' . $row, $peserta->riwayat_penyakit);
            $sheet->setCellValue('U' . $row, $peserta->link_facebook);
            $sheet->setCellValue('V' . $row, $peserta->link_instagram);
            $sheet->setCellValue('W' . $row, $peserta->link_tiktok);

            $riwayats = $peserta->riwayatKlhn ?? [];
            for ($i = 0; $i < 3; $i++) {
                $tahun = '';
                $status = '';
                $kategori = '';
                if (isset($riwayats[$i])) {
                    $tahun = $riwayats[$i]->tahun_keikutsertaan ?? '';
                    $status = $riwayats[$i]->status_kepesertaan ?? '';
                    $kategori = $riwayats[$i]->vcategory ?? '';
                }
                $colIndex = 24 + ($i * 3);
                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                $sheet->setCellValue($colLetter . $row, $tahun);
                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
                $sheet->setCellValue($colLetter . $row, $status);
                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 2);
                $sheet->setCellValue($colLetter . $row, $kategori);
            }

            $sheet->setCellValue('AG' . $row, $peserta->identitasAtasan->nama_lengkap_atasan ?? '');
            $sheet->setCellValue('AH' . $row, $peserta->identitasAtasan->jabatan ?? '');
            $sheet->setCellValue('AI' . $row, $peserta->identitasAtasan->no_hp ?? '');
            $sheet->setCellValue('AJ' . $row, $peserta->identitasDealer->kode_dealer ?? '');
            $sheet->setCellValue('AK' . $row, $peserta->identitasDealer->nama_dealer ?? '');
            $sheet->setCellValue('AL' . $row, $peserta->identitasDealer->no_telp_dealer ?? '');
            $sheet->setCellValue('AM' . $row, $peserta->identitasDealer->link_google_business ?? '');
            $sheet->setCellValue('AN' . $row, $peserta->identitasDealer->kota ?? '');
            $sheet->setCellValue('AO' . $row, $peserta->identitasDealer->provinsi ?? '');
            $sheet->setCellValue('AP' . $row, $peserta->identitasDealer->tahun_menang_klhn ?? '');
            $sheet->setCellValue('AQ' . $row, $peserta->identitasDealer->kategori_juara_klhn ?? '');
            $sheet->setCellValue('AR' . $row, $peserta->identitasDealer->link_facebook);
            $sheet->setCellValue('AS' . $row, $peserta->identitasDealer->link_instagram);
            $sheet->setCellValue('AT' . $row, $peserta->identitasDealer->link_tiktok);
            $sheet->setCellValue('AU' . $row, $peserta->filesPeserta->judul_project);
            $sheet->setCellValue('AV' . $row, $peserta->filesPeserta->tahun_pembuatan_project);
            $sheet->setCellValue('AW' . $row, $peserta->status_lolos);
            $sheet->setCellValue('AX' . $row, $peserta->created_at ? $peserta->created_at->format('d-M-Y H:i:s') : '');
            $linkFoto = '';
            if ($peserta->filesPeserta && $peserta->filesPeserta->foto_profil) {
                $linkFoto = url(Storage::url($peserta->filesPeserta->foto_profil));
            }
            $sheet->setCellValue('AY' . $row, $linkFoto);

            $row++;
            $no++;
        }
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle('A1:AY' . ($row - 1))->applyFromArray($styleArray);

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data_PesertaKLHN' . now()->format('Ymd_His') . '.xlsx';
        $filePath = storage_path("app/public/{$fileName}");

        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function downloadResultsExams(Request $request)
    {
        $query = PesertaCourse::with([
            'peserta.maindealer',
            'peserta.category',
            'course'
        ])->where('status_pengerjaan', 'selesai');

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('category_id')) {
            $query->whereHas('peserta', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        if ($request->filled('maindealer_id')) {
            $query->whereHas('peserta', function ($q) use ($request) {
                $q->where('maindealer_id', $request->maindealer_id);
            });
        }

        $pesertaCourses = $query->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'No',
            'Honda ID',
            'Nama',
            'Main Dealer',
            'Kategori',
            'Nama Course',
            'Jumlah Soal',
            'Jumlah Benar',
            'Jumlah Salah',
            'Jumlah Terlewati',
            'Total Scores',
            'Durasi',
            'Time Start Date',
            'Time Submit Date'
        ];

        $sheet->fromArray([$headers], null, 'A1');
        $sheet->getStyle('A1:N1')->getFont()->setBold(true);
        $sheet->getStyle('A1:N1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:N1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $row = 2;
        foreach ($pesertaCourses as $index => $pc) {
            $questions = Question::where('course_id', $pc->course_id)->get();
            $jawabanPeserta = PesertaAnswer::where('peserta_course_id', $pc->id)->get()->keyBy('question_id');

            $jumlahBenar = 0;
            $jumlahSalah = 0;
            $jumlahSkip  = 0;

            if ($questions->count() > 0) {
                foreach ($questions as $q) {
                    $jawaban = $jawabanPeserta->get($q->id);
                    if (!$jawaban) {
                        $jumlahSkip++;
                    } elseif ($jawaban->is_correct) {
                        $jumlahBenar++;
                    } else {
                        $jumlahSalah++;
                    }
                }
            }

            $totalSoal = $questions->count();
            $score = $totalSoal > 0 ? number_format(($jumlahBenar / $totalSoal) * 100, 2) : '0.00';

            $start = $pc->start_exam ? Carbon::parse($pc->start_exam) : null;
            $end = $pc->end_exam ? Carbon::parse($pc->end_exam) : null;

            $durasi = '';
            if ($start && $end) {
                $selisih = $start->diff($end);
                $durasi = $selisih->format('%H:%I:%S');
            }

            // Format tanggal
            $startFormatted = $start ? $start->format('d-M-Y') : '';
            $endFormatted   = $end ? $end->format('d-M-Y') : '';

            // Data row
            $data = [
                $index + 1,
                "'" . $pc->peserta->honda_id,
                $pc->peserta->nama,
                ($pc->peserta->maindealer->kodemd ?? '') . ' - ' . ($pc->peserta->maindealer->nama_md ?? ''),
                $pc->peserta->category->namacategory ?? '',
                $pc->course->namacourse ?? '',
                $totalSoal,
                $jumlahBenar ?? '0',
                $jumlahSalah ?? '0',
                $jumlahSkip ?? '0',
                $score,
                $durasi,
                $startFormatted,
                $endFormatted
            ];

            $sheet->fromArray([$data], null, 'A' . $row);
            $sheet->setCellValueExplicit('B' . $row, $pc->peserta->honda_id, DataType::TYPE_STRING);

            $row++;
        }

        $sheet->getStyle("A1:N" . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $filename = 'hasil_ujian_' . now()->format('Ymd_His') . '.xlsx';
        $filePath = storage_path("app/public/{$filename}");
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
