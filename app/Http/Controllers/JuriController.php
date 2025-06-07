<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\Peserta;
use App\Models\Parameter;
use App\Models\JuriPeserta;
use App\Models\ScoreSummary;
use Illuminate\Http\Request;
use App\Models\FormPenilaian;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class JuriController extends Controller
{
    public function index()
    {
        return view('juri.juri-index');
    }
    public function pesertalist()
    {
        return view('juri.juri-listpeserta');
    }
    public function getPesertaListData(Request $request)
    {
        $juriId = Auth::user()->juri->id;

        $query = JuriPeserta::with(['peserta.category', 'peserta.maindealer'])
            ->where('juri_id', $juriId)
            ->join('peserta', 'juripeserta.peserta_id', '=', 'peserta.id')
            ->leftJoin('category', 'peserta.category_id', '=', 'category.id')
            ->leftJoin('maindealer', 'peserta.maindealer_id', '=', 'maindealer.id')
            ->select(
                'juripeserta.*',
                'peserta.nama as peserta_nama',
                'category.namacategory as kategori_nama',
                'maindealer.kodemd',
                'maindealer.nama_md'
            );

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('nama', function ($item) {
                $nama = $item->peserta_nama;
                if ($item->kodemd || $item->nama_md) {
                    $nama .= '<br><small>' . $item->kodemd . ' - ' . $item->nama_md . '</small>';
                }
                return $nama;
            })
            ->addColumn('namacategory', function ($item) {
                return $item->kategori_nama ?? '-';
            })
            ->addColumn('score', function ($item) use ($juriId) {
                $score = Score::where('juri_id', $juriId)
                    ->where('peserta_id', $item->peserta_id)
                    ->sum('total_score');
                return $score > 0 ? number_format($score, 2) : '-';
            })
            ->addColumn('action', function ($item) {
                return '<a href="' . url("/scorecard/scoring/" . $item->id) . '" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Mulai</a>';
            })
            ->rawColumns(['nama', 'action'])
            ->filterColumn('nama', function ($query, $keyword) {
                $query->where('peserta.nama', 'like', "%{$keyword}%");
            })
            ->filterColumn('namacategory', function ($query, $keyword) {
                $query->where('category.namacategory', 'like', "%{$keyword}%");
            })
            ->make(true);
    }
    public function showScoring($id)
    {
        $juripeserta = JuriPeserta::with(['peserta.maindealer', 'peserta.category', 'formpenilaian'])->find($id);

        if (!$juripeserta || !$juripeserta->peserta) {
            return redirect()->back()->with('error', 'Data juri peserta tidak ditemukan');
        }

        $peserta = $juripeserta->peserta;
        $formId = $juripeserta->formpenilaian_id;

        return view('juri.juri-scorecard', compact('peserta', 'formId'));
    }

    public function getParameters($id)
    {
        $form = Formpenilaian::with('parameters')->find($id);
        if (!$form) {
            return response()->json(['message' => 'Form tidak ditemukan'], 404);
        }

        return response()->json([
            'maxscore' => $form->maxscore,
            'parameters' => $form->parameters->map(function ($param) {
                return [
                    'id' => $param->id,
                    'nama' => $param->parameter, // perbaiki di sini
                    'deskripsi' => $param->deskripsi,
                    'bobot' => $param->bobot,
                ];
            }),
        ]);
    }

    public function submitScore(Request $request)
    {
        $request->validate([
            'peserta_id' => 'required|exists:peserta,id',
            'parameter_id' => 'required|array',
            'parameter_id.*' => 'required|exists:parameters,id',
            'score' => 'required|array',
            'score.*' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $pesertaId = $request->peserta_id;
        $parameterIds = $request->parameter_id;
        $scores = $request->score;
        $notes = $request->notes;
        $juriId = auth()->user()->juri->id ?? null;
        $juripesertaId = JuriPeserta::where('peserta_id', $pesertaId)->where('juri_id', $juriId)->first()?->id;
        $formpenilaianId = JuriPeserta::where('peserta_id', $pesertaId)->where('juri_id', $juriId)->first()?->formpenilaian_id;

        if (!$juriId || !$juripesertaId || !$formpenilaianId) {
            return back()->with('error', 'Gagal menyimpan, data juri atau peserta tidak valid.');
        }

        // Hapus data lama jika ingin replace
        Score::where('juripeserta_id', $juripesertaId)->delete();

        $totalScore = 0;
        foreach ($parameterIds as $index => $parameterId) {
            $score = floatval($scores[$index]);
            $bobot = Parameter::find($parameterId)?->bobot ?? 0;
            $maxScore = FormPenilaian::find($formpenilaianId)?->maxscore ?? 1;

            $weightedScore = ($score / $maxScore) * $bobot;
            $totalScore += $weightedScore;

            Score::create([
                'juripeserta_id' => $juripesertaId,
                'formpenilaian_id' => $formpenilaianId,
                'juri_id' => $juriId,
                'peserta_id' => $pesertaId,
                'parameter_id' => $parameterId,
                'score' => $score,
                'total_score' => $weightedScore,
            ]);
        }

        // Simpan catatan juri
        ScoreSummary::updateOrCreate(
            [
                'formpenilaian_id' => $formpenilaianId,
                'juri_id' => $juriId,
                'peserta_id' => $pesertaId,
            ],
            [
                'noted' => $notes,
            ]
        );

        $msg = $request->action === 'draft' ? 'Draft tersimpan.' : 'Score berhasil disubmit.';
        return redirect()->route('scorecard.list')->with('success', $msg);
    }
}
