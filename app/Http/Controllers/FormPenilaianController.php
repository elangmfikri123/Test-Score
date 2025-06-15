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
                    <a href="' . url('/admin/scorecard/' . $row->id . '/jurilist') . '" class="btn btn-sm btn-primary"><i class="fa fa-user-plus"></i> Manage</a>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = url('/admin/scorecard/' . $row->id . '/edit');
                $deleteUrl = route('scorecard.delete', $row->id);

                return '
        <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
        <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '" data-name="' . $row->namaform . '">Hapus</button>
        <form id="form-delete-' . $row->id . '" action="' . $deleteUrl . '" method="POST" style="display: none;">
            ' . csrf_field() . method_field('DELETE') . '
        </form>
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
        $validated = $request->validate([
            'namaform' => 'required|string',
            'category_id' => 'required|exists:category,id',
            'maxscore' => 'required|numeric',
            'parameter.*' => 'required|string',
            'keterangan.*' => 'required|string',
            'bobot.*' => 'required|numeric|min:0|max:100',
        ]);
        $form = FormPenilaian::create([
            'namaform' => $request->namaform,
            'category_id' => $request->category_id,
            'maxscore' => $request->maxscore,
        ]);
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
    public function edit($id)
    {
        $scorecard = FormPenilaian::with('parameters')->findOrFail($id);
        $categories = Category::all();

        return view('admin.admin-editscorecard', compact('scorecard', 'categories'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'namaform' => 'required',
            'category_id' => 'required',
            'maxscore' => 'required|numeric',
            'parameter.*' => 'required|string',
            'deskripsi.*' => 'required|string',
            'bobot.*' => 'required|numeric|min:0|max:100',
        ]);

        $form = FormPenilaian::findOrFail($id);
        $form->namaform = $request->namaform;
        $form->category_id = $request->category_id;
        $form->maxscore = $request->maxscore;
        $form->save();
        Parameter::where('formpenilaian_id', $id)->delete();
        foreach ($request->parameter as $index => $param) {
            Parameter::create([
                'formpenilaian_id' => $form->id,
                'parameter' => $param,
                'deskripsi' => $request->deskripsi[$index],
                'bobot' => $request->bobot[$index],
            ]);
        }

        return redirect()->route('scorecard.adminlist')->with('success', 'Data berhasil diperbarui!');
    }
    public function delete($id)
    {
        $form = FormPenilaian::findOrFail($id);
        $form->delete();
        return redirect()->route('scorecard.adminlist')->with('success', 'Scorecard berhasil dihapus.');
    }
}
