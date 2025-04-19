<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;
use App\Models\PesertaCourse;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PesertaController extends Controller
{
    public function index()
    {
        return view('peserta.indexpeserta');
    }
    public function showlistquiz()
    {
        return view('peserta.quizlist');
    }
    public function listJson()
    {
        $peserta = Peserta::where('user_id', Auth::id())->first();

        if (!$peserta) {
            return response()->json([]);
        }
        
        $pesertaCourses = PesertaCourse::with('course')
        ->where('peserta_id', $peserta->id)
        ->get();

        return DataTables::of($pesertaCourses)
            ->addIndexColumn()
            ->addColumn('nama', function ($row) {
                return $row->course->namacourse ?? '-';
            })
            ->addColumn('categori', function ($row) {
                return $row->course->category->namacategory ?? '-';
            })
            ->addColumn('start_date', function ($row) {
                return $row->course->start_date ? date('d-m-Y H:i', strtotime($row->course->start_date)) : '-';
            })
            ->addColumn('end_date', function ($row) {
                return $row->course->end_date ? date('d-m-Y H:i', strtotime($row->course->end_date)) : '-';
            })
            ->addColumn('action', function ($row) {
                $encodedId = Hashids::encode($row->id);
                return '<a href="' . url('/exam/confirmation/' . $encodedId) . '" class="btn btn-sm btn-primary">Mulai</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
