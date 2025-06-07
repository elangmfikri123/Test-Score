<?php

namespace App\Http\Controllers;

use App\Models\Juri;
use App\Models\Peserta;
use App\Models\JuriPeserta;
use Illuminate\Http\Request;
use App\Models\FormPenilaian;

class EnrolledJuriPesertaController extends Controller
{
    public function listJuriScoring($id)
    {
        $data = FormPenilaian::findOrFail($id);
        return view('admin.admin-jurilistscorecard', compact('data'));
    }

    public function getEnrolledJuriTable($id)
    {
        $juri = Juri::whereIn('id', function ($query) use ($id) {
            $query->select('juri_id')
                ->from('juripeserta')
                ->where('formpenilaian_id', $id);
        })->get();

        return datatables()->of($juri)
            ->addIndexColumn()
            ->addColumn('countpeserta', function ($row) use ($id) {
                return JuriPeserta::where('formpenilaian_id', $id)
                    ->where('juri_id', $row->id)
                    ->whereNotNull('peserta_id')
                    ->count();
            })
            ->addColumn('action', function ($row) use ($id) {
                return
                    '<a href="' . url('/admin/scorecard/' . $id . '/' . $row->id . '/addpeserta') . '" class="btn btn-sm btn-primary">Add Peserta</a>
                     <button class="btn btn-info btn-sm btn-detail" data-id="' . $row->id . '" data-formid="' . $id . '"><i class="fa fa-eye"></i> Detail</button>
                     <button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '" data-formid="' . $id . '"><i class="fa fa-trash-o"></i> Hapus</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function addJuri($id)
    {
        $data = FormPenilaian::findOrFail($id);
        return view('admin.admin-enrolledjuri', compact('data'));
    }

    public function getNonEnrolledJuriJson($id)
    {
        $enrolledJuriIds = JuriPeserta::where('formpenilaian_id', $id)->pluck('juri_id')->toArray();

        $juri = Juri::whereNotIn('id', $enrolledJuriIds)->get();

        return datatables()->of($juri)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<input type="checkbox" class="rowCheckbox" name="juri_ids[]" value="' . $row->id . '">';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function storeJuri(Request $request, $id)
    {
        $request->validate([
            'juri_ids' => 'required|array'
        ]);

        foreach ($request->juri_ids as $juri_id) {
            JuriPeserta::create([
                'formpenilaian_id' => $id,
                'juri_id' => $juri_id
            ]);
        }

        return redirect()->route('scorecard.jurilist', $id)->with('success', 'Juri berhasil di-enroll.');
    }

    //MULAI UNTUK GET PESERTA YANG SUDAH DI-ENROLL KE JURI
    public function addPesertaToJuri($form_id, $juri_id)
    {
        if (request()->ajax()) {
            $peserta = JuriPeserta::where('formpenilaian_id', $form_id)
                ->where('juri_id', $juri_id)
                ->with('peserta:id,honda_id,nama')
                ->get()
                ->pluck('peserta');

            return response()->json($peserta);
        }

        $form = FormPenilaian::findOrFail($form_id);
        $juri = Juri::findOrFail($juri_id);
        return view('admin.admin-enrolledpesertascoring', compact('form', 'juri'));
    }

    public function getNonEnrolledPeserta($form_id, $juri_id)
    {
        $enrolledPesertaIds = JuriPeserta::where('formpenilaian_id', $form_id)
            ->where('juri_id', $juri_id)
            ->whereNotNull('peserta_id')
            ->pluck('peserta_id')
            ->toArray();
        $peserta = Peserta::with(['category', 'maindealer'])
            ->whereNotIn('id', $enrolledPesertaIds)
            ->get();

        return datatables()->of($peserta)
            ->addIndexColumn()
            ->addColumn('namacategory', function ($row) {
                return $row->category ? $row->category->namacategory : '-';
            })
            ->addColumn('kodemd', function ($row) {
                return $row->maindealer ? $row->maindealer->kodemd : '-';
            })
            ->addColumn('action', function ($row) {
                return '<input type="checkbox" class="rowCheckbox" name="peserta_id[]" value="' . $row->id . '">';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function storePesertaToJuri(Request $request, $form_id, $juri_id)
    {
        $request->validate([
            'peserta_id' => 'required|array',
        ]);

        foreach ($request->peserta_id as $pesertaId) {
            $existing = JuriPeserta::where('formpenilaian_id', $form_id)
                ->where('juri_id', $juri_id)
                ->whereNull('peserta_id')
                ->first();

            if ($existing) {
                $existing->update(['peserta_id' => $pesertaId]);
            } else {
                JuriPeserta::firstOrCreate([
                    'formpenilaian_id' => $form_id,
                    'juri_id' => $juri_id,
                    'peserta_id' => $pesertaId,
                ]);
            }
        }

        return redirect()->route('scorecard.jurilist', $form_id)
            ->with('success', 'Peserta berhasil ditambahkan ke juri.');
    }

    public function getDetailPeserta($form_id, $juri_id)
    {
        $peserta = JuriPeserta::with('peserta.mainDealer')
            ->where('formpenilaian_id', $form_id)
            ->where('juri_id', $juri_id)
            ->whereNotNull('peserta_id')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $peserta->map(function ($item, $index) {
                return [
                    'no' => $index + 1,
                    'nama' => $item->peserta->nama ?? '-',
                    'honda_id' => $item->peserta->honda_id ?? '-',
                    'namacategory' => $item->peserta->category->namacategory ?? '-',
                    'nama_md' => $item->peserta->mainDealer->nama_md ?? '-',
                ];
            })
        ]);
    }

    public function deleteJuri($juri_id, $form_id)
    {
        try {
            $deleted = JuriPeserta::where('juri_id', $juri_id)
                ->where('formpenilaian_id', $form_id)
                ->delete();

            if ($deleted === 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan atau sudah dihapus.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Juri dan data peserta berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus juri. ' . $e->getMessage(),
            ], 500);
        }
    }
}
