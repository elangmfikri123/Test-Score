<?php

namespace App\Http\Controllers;

use App\Models\JuriPeserta;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ResultScoreCardController extends Controller
{
    public function showResultsScoring()
    {
        return view('admin.admin-resultscorecard');
    }
    public function dataResultsScoringJson(Request $request)
    {
        $query = JuriPeserta::with([
            'peserta.user',
            'peserta.maindealer',
            'peserta.category',
            'juri',
            'formpenilaian'
        ])
            ->when($request->formpenilaian_id, function ($q) use ($request) {
                $q->where('formpenilaian_id', $request->formpenilaian_id);
            })
            ->when($request->category_id, function ($q) use ($request) {
                $q->whereHas('peserta', function ($c) use ($request) {
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
            ->addColumn('namaform', function ($row) {
                return $row->formpenilaian->namaform ?? '-';
            })
            ->addColumn('namajuri', function ($row) {
                return $row->juri->namajuri ?? '-';
            })
            ->addColumn('honda_id', function ($row) {
                return $row->peserta->honda_id ?? '-';
            })
            ->addColumn('nama', function ($row) {
                return $row->peserta->nama ?? '-';
            })
            ->addColumn('category', function ($row) {
                return $row->peserta->category->namacategory ?? '-';
            })
            ->addColumn('maindealer', function ($row) {
                return $row->peserta->maindealer->nama_md ?? '-';
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
}
