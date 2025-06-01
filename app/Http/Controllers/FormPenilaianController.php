<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Parameter;
use Illuminate\Http\Request;
use App\Models\FormPenilaian;

class FormPenilaianController extends Controller
{
    public function show()
    {
        return view('admin.admin-scorecardlist');
    }
    public function listScoreCardJson()
    {
        $data = FormPenilaian::with('category', 'parameters');

        $result = DataTables()->of($data)
            ->addIndexColumn()
            ->addColumn('category', function ($row) {
                return $row->category ? $row->category->namacategory : '-';
            })
            ->addColumn('parameter', function ($row) {
                return $row->parameters->count();
            })
            ->addColumn('jurilist', function ($row) {
                return '
                    <a href="' . url('/admin/scorecard/' . $row->id . '/jurilist') . '" class="btn btn-sm btn-primary"><i class="fa fa-user-plus"></i></a>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <a href="' . url('/admin/scorecard/' . $row->id . '/edit') . '" class="btn btn-sm btn-warning">Edit</a>
                    <a href="' . url('/admin/scorecard/' . $row->id . '/delete'). '" class="btn btn-sm btn-danger">Hapus</a>
                ';
            })
            ->rawColumns(['jurilist', 'action'])
            ->make(true);

        return $result;
    }

    public function createdScoring()
    {
        $categories = Category::orderBy('namacategory')->get();
        return view('admin.admin-addscorecard', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'namaform' => 'required|string',
            'category_id' => 'required|exists:category,id',
            'maxscore' => 'required|numeric',
            'parameter.*' => 'required|string',
            'keterangan.*' => 'required|string',
            'bobot.*' => 'required|numeric|min:0|max:100',
        ]);

        // Simpan form penilaian
        $form = FormPenilaian::create([
            'namaform' => $request->namaform,
            'category_id' => $request->category_id,
            'maxscore' => $request->maxscore,
        ]);

        // Simpan parameter
        foreach ($request->parameter as $i => $param) {
            Parameter::create([
                'formpenilaian_id' => $form->id,
                'parameter' => $param,
                'deskripsi' => $request->deskripsi[$i],
                'bobot' => $request->bobot[$i],
            ]);
        }

        return redirect()->route('scorecard.store')->with('success', 'Scorecard berhasil disimpan.');
    }
}
