<?php

namespace App\Http\Controllers;

use App\Models\Juri;
use App\Models\User;
use App\Models\Admin;
use App\Models\Peserta;
use App\Models\MainDealer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.admindashboard');
    }
    public function userlist()
    {
        $mainDealers = MainDealer::select('id', 'kodemd', 'nama_md')->get();
        return view('admin.adminuserlist', compact('mainDealers'));
    }
    public function getusertable(Request $request)
    {
        $data = User::query()
            ->leftJoin('peserta', 'users.id', '=', 'peserta.user_id')
            ->leftJoin('juri', 'users.id', '=', 'juri.user_id')
            ->leftJoin('admin', 'users.id', '=', 'admin.user_id')
            ->leftJoin('maindealer as md_admin', 'admin.maindealer_id', '=', 'md_admin.id')
            ->leftJoin('maindealer as md_peserta', 'peserta.maindealer_id', '=', 'md_peserta.id')
            ->select(
                'users.id',
                'users.username',
                'users.role',
                'users.is_online',
                'peserta.nama as peserta_nama',
                'peserta.email as peserta_email',
                'juri.namajuri as juri_nama',
                'juri.email as juri_email',
                'admin.nama_lengkap as admin_nama',
                'admin.email as admin_email',
                'admin.maindealer_id as admin_maindealer_id',
                'md_admin.kodemd as admin_kodemd',
                'md_peserta.kodemd as peserta_kodemd'
            );
    
        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $data->where(function ($query) use ($search) {
                $query->where('users.username', 'like', '%' . $search . '%')
                    ->orWhere('users.role', 'like', '%' . $search . '%')
                    ->orWhere('peserta.nama', 'like', '%' . $search . '%')
                    ->orWhere('peserta.email', 'like', '%' . $search . '%')
                    ->orWhere('juri.namajuri', 'like', '%' . $search . '%')
                    ->orWhere('juri.email', 'like', '%' . $search . '%')
                    ->orWhere('admin.nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('admin.email', 'like', '%' . $search . '%')
                    ->orWhere('md_admin.kodemd', 'like', '%' . $search . '%')
                    ->orWhere('md_peserta.kodemd', 'like', '%' . $search . '%')
                    ->orWhere('users.is_online', 'like', '%' . $search . '%');
            });
        }
    
        $result = DataTables()->of($data)
            ->addIndexColumn()
            ->addColumn('nama', function ($row) {
                return $row->peserta_nama
                    ?? $row->juri_nama
                    ?? $row->admin_nama
                    ?? '-';
            })
            ->addColumn('email', function ($row) {
                return $row->peserta_email
                    ?? $row->juri_email
                    ?? $row->admin_email
                    ?? '-';
            })
            ->addColumn('maindealer', function ($row) {
                if ($row->role == 'AdminMD' && $row->admin_kodemd) {
                    return $row->admin_kodemd;
                } elseif ($row->role == 'Peserta' && $row->peserta_kodemd) {
                    return $row->peserta_kodemd;
                } else {
                    return '-';
                }
            })
            ->addColumn('status', function ($row) {
                $status = $row->is_online ? '<span class="badge bg-success" style="cursor:pointer" onclick="handleStatusClick(' . $row->id . ', this)">Online</span>'
                    : '<span class="badge bg-secondary">Offline</span>';
                return $status;
            })
            ->addColumn('action', function ($row) {
                $action = '<a href="' . url('/survey-awarenesshc/data/' . $row->id) . '" class="btn btn-sm btn-primary">Detail</a>';
                $edit = '<a href="' . url('/survey-awarenesshc/data/' . $row->id) . '" class="btn btn-sm btn-warning">Edit</a>';
                return $action . ' ' . $edit;
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    
        return $result;
    }
    

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'username' => 'required|unique:users|max:255',
            'password' => 'required|min:6',
            'role' => 'required|in:Admin,AdminMD,Juri',
            'nama' => 'required',
            'email' => 'required|email',
            'maindealer_id' => 'nullable|required_if:role,AdminMD|exists:maindealer,id',
            'jabatan' => 'required_if:role,Juri',
            'division' => 'required_if:role,Juri'
        ]);

        DB::beginTransaction();
        try {
            // Buat user baru
            $user = User::create([
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'is_online' => false
            ]);

            // Simpan data sesuai role
            if (in_array($validated['role'], ['Admin', 'AdminMD'])) {
                Admin::create([
                    'user_id' => $user->id,
                    'nama_lengkap' => $validated['nama'],
                    'email' => $validated['email'],
                    'maindealer_id' => $validated['role'] === 'AdminMD' ? $validated['maindealer_id'] : null,
                ]);
            } elseif ($validated['role'] == 'Juri') {
                Juri::create([
                    'user_id' => $user->id,
                    'namajuri' => $validated['nama'],
                    'email' => $validated['email'],
                    'jabatan' => $validated['jabatan'],
                    'division' => $validated['division']
                ]);
            }

            DB::commit();

            return redirect()->route('admin.userlist')
                ->with('success', 'User berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal membuat user: ' . $e->getMessage());
        }
    }

    public function pesertalist()
    {
        if (auth()->user()->role === 'Admin') {
            return view('admin.adminpesertalist');
        } elseif (auth()->user()->role === 'AdminMD') {
            return view('adminmd.adminmd-pesertalist');
        }

        abort(403, 'Unauthorized action.');
    }

public function getpesertatable(Request $request)
{
    // Ambil data admin yang sedang login
    $admin = Admin::where('user_id', auth()->id())->first();
    
    // Ambil data peserta dengan relasi maindealer
    $data = Peserta::with('maindealer');

    // Jika role AdminMD, filter peserta berdasarkan maindealer_id
    if (auth()->user()->role === 'AdminMD' && $admin && $admin->maindealer) {
        $data->whereHas('maindealer', function ($query) use ($admin) {
            $query->where('id', $admin->maindealer_id); // Pastikan menggunakan maindealer_id yang benar
        });
    }

    // Jika role Admin, tidak perlu filter apapun
    if (auth()->user()->role === 'Admin') {
        // Pastikan tidak ada filter berdasarkan maindealer_id
        $data = Peserta::with('maindealer'); // Ambil semua data peserta
    }
    
    // Jika ada pencarian, tambahkan filter pencarian
    if ($request->has('search') && !empty($request->search['value'])) {
        $search = $request->search['value'];
        $data->where(function ($query) use ($search) {
            $query->where('id', 'like', '%' . $search . '%')
                ->orWhere('honda_id', 'like', '%' . $search . '%')
                ->orWhere('nama', 'like', '%' . $search . '%');
        });
    }

    // Ambil data peserta dengan DataTables dan tambahkan kolom action
    $result = DataTables()->of($data)
        ->addColumn('maindealer', function ($row) {
            return $row->maindealer ? $row->maindealer->nama_md : '-'; // Tampilkan nama maindealer jika ada
        })
        ->addColumn('action', function ($row) {
            $action = '<a href="' . url('/survey-awarenesshc/data/' . $row->id) . '" class="btn btn-sm btn-primary">Detail</a>';
            $edit = '<a href="' . url('/survey-awarenesshc/data/' . $row->id) . '" class="btn btn-sm btn-warning">Edit</a>';
            return $action . ' ' . $edit;
        })
        ->rawColumns(['action'])
        ->toJson();

    return $result;
}

    

    public function jurilist()
    {
        return view('admin.adminjurilist');
    }

    public function juriJson()
    {
        $data = Juri::with('user')->select('id', 'namajuri', 'jabatan', 'division');
        $result = DataTables()->of($data)
            ->addIndexColumn()
            ->addColumn('nama', function ($row) {
                return $row->namajuri ?? $row->user->name ?? '-';
            })
            ->addColumn('action', function ($row) {
                $action = '<a href="' . url('/survey-awarenesshc/data/' . $row->id) . '" class="btn btn-sm btn-primary">Detail</a>';
                $edit = '<a href="' . url('/survey-awarenesshc/data/' . $row->id) . '" class="btn btn-sm btn-warning">Edit</a>';
                return $action . ' ' . $edit;
            })
            ->rawColumns(['action'])
            ->toJson();

        return $result;
    }
}
