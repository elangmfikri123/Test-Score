<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categorylist()
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
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $edit = '<button class="btn btn-sm btn-warning" onclick="editCategory(' . $row->id . ')">Edit</button>';
                $delete = '<button class="btn btn-sm btn-danger" onclick="deleteCategory(' . $row->id . ')">Hapus</button>';
                return $edit . ' ' . $delete;
            })
            ->rawColumns(['action'])
            ->toJson();

        return $result;
    }
    public function storecategory(Request $request)
    {
        $request->validate([
            'namacategory' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
        ]);
        Category::create([
            'namacategory' => $request->namacategory,
            'keterangan' => $request->keterangan,
        ]);
        return redirect()->back()->with('success', 'Category berhasil ditambahkan!');
    }
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'namacategory' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->namacategory = $request->namacategory;
        $category->keterangan = $request->keterangan;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diupdate',
            'data' => $category
        ]);
    }
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus']);
    }
}
