<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categorylist ()
    {
        return view('admin.admincategory');
    }
    public function getcategory(Request $request)
    {
        $data = Category::query();
        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $data->where(function ($query) use ($search) {
                $query->where('id', 'like', '%' . $search . '%')
                    ->orWhere('namacategory', 'like', '%' . $search . '%')
                    ->orWhere('keterangan', 'like', '%' . $search . '%');
            });
        }
    
        $result = DataTables()->of($data)
            ->addColumn('action', function ($row) {
                $edit = '<a href="' . url('/category/edit/' . $row->id) . '" class="btn btn-sm btn-warning">Edit</a>';
                $delete = '<a href="' . url('/category/delete/' . $row->id) . '" class="btn btn-sm btn-danger">Hapus</a>';
                return $edit . ' ' . $delete;
            })
            ->rawColumns(['action'])
            ->toJson();
    
        return $result;
    }
    public function storecategory(Request $request)
    {
        // Validasi input
        $request->validate([
            'namacategory' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
        ]);
    
        // Simpan data ke database
        Category::create([
            'namacategory' => $request->namacategory,
            'keterangan' => $request->keterangan,
        ]);
    
        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Category berhasil ditambahkan!');
    }    
}
