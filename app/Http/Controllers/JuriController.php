<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\Peserta;
use App\Models\JuriPeserta;
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
                    ->sum('score');
                return $score > 0 ? number_format($score, 2) : '-';
            })
            ->addColumn('action', function ($item) {
                return '<a href="' . url("/scorecard/scoring/" . $item->peserta_id) . '" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Mulai</a>';
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

    public function submitScoring(Request $request)
    {
        $validated = $request->validate([
            'peserta_id' => 'required|exists:pesertas,id',
            'score_1' => 'required|integer|min:1|max:6',
            'score_2' => 'required|integer|min:1|max:6',
            'notes' => 'nullable|string',
            'action' => 'required|string|in:draft,submit',
        ]);

        // Simpan data ke tabel skor (buat model Scorecard atau penilaian sesuai DB)
        FormPenilaian::updateOrCreate(
            ['peserta_id' => $validated['peserta_id']],
            [
                'score_1' => $validated['score_1'],
                'score_2' => $validated['score_2'],
                'notes' => $validated['notes'],
                'status' => $validated['action'] == 'submit' ? 'submitted' : 'draft',
                'scored_by' => auth()->user()->id, // jika login user sebagai juri
            ]
        );

        return redirect()->route('some.route')->with('success', 'Penilaian berhasil disimpan!');
    }
}
