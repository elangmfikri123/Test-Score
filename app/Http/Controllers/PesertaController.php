<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Models\PesertaCourse;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;

class PesertaController extends Controller
{
    // public function index()
    // {
    //     $peserta = Peserta::where('user_id', Auth::id())->first();
    //     return view('peserta.indexpeserta', compact('peserta'));
    // }

    public function index()
{
    $peserta = Peserta::where('user_id', Auth::id())->first();

    $loginSessions = Session::where('user_id', Auth::id())
        ->orderBy('last_activity', 'desc')
        ->take(10)
        ->get();

    return view('peserta.indexpeserta', compact('peserta', 'loginSessions'));
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

        $query = PesertaCourse::with(['course.category'])
            ->where('peserta_id', $peserta->id);

        return DataTables::of($query)
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
            ->addColumn('status_pengerjaan', function ($row) {
                return $row->status_pengerjaan ?? 'belum_mulai';
            })
            ->addColumn('action', function ($row) {
                if ($row->status_pengerjaan === 'selesai') {
                    return '<a href="' . route('exam.finished', $row->id) . '" class="btn btn-sm btn-success">Selesai</a>';
                } elseif ($row->status_pengerjaan === 'sedang_dikerjakan') {
                    return '<a href="' . url('/exam/' . $row->id) . '" class="btn btn-sm btn-info">Lanjutkan</a>';
                } else {
                    return '<a href="' . url('/exam/confirmation/' . $row->id) . '" class="btn btn-sm btn-primary">Mulai</a>';
                }
            })
            ->filter(function ($query) {
                if (request()->has('search') && request()->search['value'] != '') {
                    $search = request()->search['value'];
                    $query->whereHas('course', function (Builder $q) use ($search) {
                        $q->where('namacourse', 'like', "%{$search}%")
                            ->orWhereHas('category', function (Builder $q2) use ($search) {
                                $q2->where('namacategory', 'like', "%{$search}%");
                            });
                    });
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
