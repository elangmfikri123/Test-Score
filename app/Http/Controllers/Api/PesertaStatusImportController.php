<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PesertaStatusImportController extends Controller
{
    public function import(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $rows = $this->readSpreadsheetRows($request->file('file')->getRealPath());

        if (count($rows) < 2) {
            return response()->json([
                'message' => 'File Excel tidak berisi data.',
            ], 422);
        }

        $headerMap = $this->buildHeaderMap($rows[0]);
        $missingHeaders = $this->getMissingHeaders($headerMap);

        if ($missingHeaders !== []) {
            return response()->json([
                'message' => 'Header file tidak sesuai.',
                'required_headers' => ['Honda ID', 'Nama Peserta', 'Status'],
                'missing_headers' => $missingHeaders,
            ], 422);
        }

        $summary = [
            'total_rows' => 0,
            'updated' => 0,
            'not_found' => [],
            'invalid_rows' => [],
            'name_mismatches' => [],
        ];

        DB::beginTransaction();

        try {
            foreach (array_slice($rows, 1) as $index => $row) {
                $excelRow = $index + 2;

                $hondaId = $this->getCellValue($row, $headerMap['honda_id']);
                $namaPeserta = $this->getCellValue($row, $headerMap['nama_peserta']);
                $statusRaw = $this->getCellValue($row, $headerMap['status']);

                if ($hondaId === '' && $namaPeserta === '' && $statusRaw === '') {
                    continue;
                }

                $summary['total_rows']++;

                if ($hondaId === '') {
                    $summary['invalid_rows'][] = [
                        'row' => $excelRow,
                        'reason' => 'Honda ID kosong.',
                    ];
                    continue;
                }

                $status = $this->normalizeStatus($statusRaw);

                if ($status === null) {
                    $summary['invalid_rows'][] = [
                        'row' => $excelRow,
                        'honda_id' => $hondaId,
                        'reason' => 'Status harus bernilai 1/0 atau Lolos/Tidak Lolos.',
                    ];
                    continue;
                }

                $peserta = Peserta::where('honda_id', $hondaId)->first();

                if (!$peserta) {
                    $summary['not_found'][] = [
                        'row' => $excelRow,
                        'honda_id' => $hondaId,
                    ];
                    continue;
                }

                if ($namaPeserta !== '' && strcasecmp(trim((string) $peserta->nama), $namaPeserta) !== 0) {
                    $summary['name_mismatches'][] = [
                        'row' => $excelRow,
                        'honda_id' => $hondaId,
                        'excel_nama' => $namaPeserta,
                        'database_nama' => $peserta->nama,
                    ];
                }

                $peserta->status_lolos = $status;
                $peserta->save();

                $summary['updated']++;
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Gagal memproses file Excel.',
                'error' => $th->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Import status peserta selesai diproses.',
            'summary' => $summary,
        ]);
    }

    private function readSpreadsheetRows(string $path): array
    {
        $reader = IOFactory::createReaderForFile($path);
        $reader->setReadDataOnly(true);

        $spreadsheet = $reader->load($path);

        return $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
    }

    private function buildHeaderMap(array $headerRow): array
    {
        $map = [];

        foreach ($headerRow as $index => $header) {
            $normalized = $this->normalizeHeader($header);

            if (in_array($normalized, ['hondaid', 'honda_id'], true)) {
                $map['honda_id'] = $index;
            }

            if (in_array($normalized, ['namapeserta', 'nama_peserta', 'nama'], true)) {
                $map['nama_peserta'] = $index;
            }

            if ($normalized === 'status') {
                $map['status'] = $index;
            }
        }

        return $map;
    }

    private function getMissingHeaders(array $headerMap): array
    {
        $required = [
            'honda_id' => 'Honda ID',
            'nama_peserta' => 'Nama Peserta',
            'status' => 'Status',
        ];

        $missing = [];

        foreach ($required as $key => $label) {
            if (!array_key_exists($key, $headerMap)) {
                $missing[] = $label;
            }
        }

        return $missing;
    }

    private function getCellValue(array $row, int $index): string
    {
        return trim((string) ($row[$index] ?? ''));
    }

    private function normalizeHeader($header): string
    {
        $header = strtolower(trim((string) $header));
        $header = str_replace([' ', '-'], '_', $header);

        return preg_replace('/[^a-z0-9_]/', '', $header) ?? '';
    }

    private function normalizeStatus(string $status): ?string
    {
        $normalized = strtolower(trim($status));

        return match ($normalized) {
            '1', 'lolos' => 'Lolos',
            '0', 'tidak_lolos', 'tidak lolos' => 'Tidak Lolos',
            default => null,
        };
    }
}
