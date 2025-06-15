<?php

namespace App\Http\Controllers;

use App\Models\MainDealer;
use Illuminate\Http\Request;

class MainDealerController extends Controller
{
    public function maindealerlist()
    {
        return view('admin.adminmaindealer');
    }
    public function getmaindealer(Request $request)
    {
        $data = MainDealer::query();
        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $data->where(function ($query) use ($search) {
                $query->where('id', 'like', '%' . $search . '%')
                    ->orWhere('kodemd', 'like', '%' . $search . '%')
                    ->orWhere('nama_md', 'like', '%' . $search . '%');
            });
        }

        $result = DataTables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $edit = '<button class="btn btn-sm btn-warning edit-button" data-id="' . $row->id . '">Edit</button>';
                $delete = '<form action="' . url('/maindealer/delete/' . $row->id) . '" method="POST" style="display:inline;">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger delete-button">Hapus</button>
                </form>';
                return $edit . ' ' . $delete;
            })
            ->rawColumns(['action'])
            ->toJson();

        return $result;
    }
    public function storemaindealer(Request $request)
    {
        $request->validate([
            'kodemd' => 'required|string|max:10',
            'nama_md' => 'required|string|max:255',
        ]);

        MainDealer::create([
            'kodemd' => $request->kodemd,
            'nama_md' => $request->nama_md,
        ]);

        return redirect()->back()->with('success', 'Main Dealer berhasil ditambahkan!');
    }

    public function editMainDealer($id)
    {
        $data = MainDealer::findOrFail($id);
        return response()->json($data);
    }

    public function updateMainDealer(Request $request, $id)
    {
        $request->validate([
            'kodemd' => 'required|string|max:10',
            'nama_md' => 'required|string|max:255',
        ]);

        $data = MainDealer::findOrFail($id);
        $data->kodemd = $request->kodemd;
        $data->nama_md = $request->nama_md;
        $data->save();

        return response()->json(['success' => 'Data berhasil diupdate!']);
    }

    public function deleteMainDealer($id)
    {
        try {
            $mainDealer = MainDealer::findOrFail($id);
            $mainDealer->delete();
            return response()->json(['success' => 'Data berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus data.'], 500);
        }
    }
}
