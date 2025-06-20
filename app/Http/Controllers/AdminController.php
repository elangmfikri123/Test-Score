<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Juri;
use App\Models\User;
use App\Models\Admin;
use App\Models\Peserta;
use App\Models\Category;
use App\Models\Course;
use App\Models\MainDealer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $admin = Admin::where('user_id', auth()->id())->first();
        $query = Peserta::query();
        if (auth()->user()->role === 'AdminMD' && $admin && $admin->maindealer_id) {
            $query->where('maindealer_id', $admin->maindealer_id);
        }
        $categories = $query->select('category_id')
            ->selectRaw('count(*) as total')
            ->groupBy('category_id')
            ->with('category')
            ->get();

        foreach ($categories as $category) {
            $latestPeserta = Peserta::where('category_id', $category->category_id)
                ->orderBy('created_at', 'desc')
                ->first();
            $category->latest_created_at = $latestPeserta ? $latestPeserta->created_at->format('H:i:s') : 'Tidak ada data';
        }
        return view('admin.admindashboard', compact('categories'));
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
                'users.login_token',
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
                    ->orWhere('users.login_token', 'like', '%' . $search . '%');
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
                $status = $row->login_token ? '<span class="badge bg-success" style="cursor:pointer" onclick="handleStatusClick(' . $row->id . ', this)">Online</span>'
                    : '<span class="badge bg-secondary">Offline</span>';
                return $status;
            })
            ->addColumn('action', function ($row) {
                $detail = '<button class="btn btn-sm btn-primary" onclick="showUserDetail(' . $row->id . ')">Detail</button>';
                $edit = '<button class="btn btn-sm btn-warning" onclick="editUser(' . $row->id . ')">Edit</button>';
                return $detail . ' ' . $edit;
            })
            ->rawColumns(['status', 'action'])
            ->toJson();

        return $result;
    }

    public function store(Request $request)
    {
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
            $user = User::create([
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'login_token' => null,
            ]);
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
    public function detail($id)
    {
        $user = User::with(['peserta', 'admin', 'juri'])->findOrFail($id);

        $response = [
            'id' => $user->id,
            'username' => $user->username,
            'role' => $user->role,
            'email' => $user->peserta->email ?? $user->admin->email ?? $user->juri->email ?? '',
            'nama' => $user->peserta->nama ?? $user->admin->nama_lengkap ?? $user->juri->namajuri ?? '',
            'maindealer' => $user->admin->mainDealer->nama_md ?? $user->peserta->mainDealer->nama_md ?? '-',
            'kodemd' => $user->admin->mainDealer->kodemd ?? $user->peserta->mainDealer->kodemd ?? '-',
            'jabatan' => $user->juri->jabatan ?? '-',
            'division' => $user->juri->division ?? '-',
            'status' => $user->login_token ? 'Online' : 'Offline',
            'created_at' => $user->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $user->updated_at->format('d-m-Y H:i:s')
        ];

        return response()->json($response);
    }
    public function edit($id)
    {
        $user = User::with(['peserta', 'admin', 'juri'])->findOrFail($id);

        $response = [
            'id' => $user->id,
            'username' => $user->username,
            'role' => $user->role,
            'email' => $user->peserta->email ?? $user->admin->email ?? $user->juri->email ?? '',
            'nama' => $user->peserta->nama ?? $user->admin->nama_lengkap ?? $user->juri->namajuri ?? '',
            'maindealer_id' => $user->admin->maindealer_id ?? $user->peserta->maindealer_id ?? null,
            'jabatan' => $user->juri->jabatan ?? null,
            'division' => $user->juri->division ?? null
        ];

        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email',
            'username' => 'required',
            'role' => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->role = $request->role;

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        if ($user->role == 'AdminMD') {
            $user->admin()->updateOrCreate(['user_id' => $id], [
                'nama_lengkap' => $request->nama,
                'email' => $request->email,
                'maindealer_id' => $request->maindealer_id,
            ]);
        } elseif ($user->role == 'Peserta') {
            $user->peserta()->updateOrCreate(['user_id' => $id], [
                'nama' => $request->nama,
                'email' => $request->email,
                'maindealer_id' => $request->maindealer_id,
            ]);
        } elseif ($user->role == 'Juri') {
            $user->juri()->updateOrCreate(['user_id' => $id], [
                'namajuri' => $request->nama,
                'email' => $request->email,
                'jabatan' => $request->jabatan,
                'division' => $request->division,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'User berhasil Diperbarui.'
        ]);
    }

    public function pesertalist()
    {
        if (auth()->user()->role === 'Admin') {
            return view('adminmd.adminmd-pesertalist');
        } elseif (auth()->user()->role === 'AdminMD') {
            return view('adminmd.adminmd-pesertalist');
        }

        abort(403, 'Unauthorized action.');
    }
    public function apiCourse()
    {
        $data = Course::select('id', 'namacourse')->get();
        return response()->json($data);
    }
    public function apiCategory()
    {
        $data = Category::select('id', 'namacategory')->get();
        return response()->json($data);
    }
    public function apiMaindealer()
    {
        $admin = Admin::where('user_id', auth()->id())->first();
        $query = MainDealer::select('id', 'kodemd', 'nama_md');
        if (auth()->user()->role === 'AdminMD' && $admin && $admin->maindealer_id) {
            $query->where('id', $admin->maindealer_id);
        }
        return response()->json($query->get());
    }

    public function getpesertatable(Request $request)
    {
        $admin = Admin::where('user_id', auth()->id())->first();
        $data = Peserta::with(['maindealer', 'category']);

        if (auth()->user()->role === 'AdminMD' && $admin && $admin->maindealer_id) {
            $data->where('maindealer_id', $admin->maindealer_id);
        }
        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $data->where(function ($query) use ($search) {
                $query->where('id', 'like', '%' . $search . '%')
                    ->orWhere('honda_id', 'like', '%' . $search . '%')
                    ->orWhere('nama', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('namacategory', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('maindealer', function ($q) use ($search) {
                        $q->where('kodemd', 'like', '%' . $search . '%');
                    });
            });
        }
        if ($request->filled('category_id')) {
            $data->where('category_id', $request->category_id);
        }
        if ($request->filled('maindealer_id')) {
            $data->where('maindealer_id', $request->maindealer_id);
        }
        $result = DataTables()->of($data)
            ->addIndexColumn()
            ->addColumn('category', function ($row) {
                return $row->category ? $row->category->namacategory : '-';
            })
            ->addColumn('maindealer', function ($row) {
                return $row->maindealer ? $row->maindealer->kodemd : '-';
            })
            ->addColumn('status', function ($row) {
                if (in_array(auth()->user()->role, ['Admin', 'AdminMD'])) {
                    return match ($row->status_lolos) {
                        'Terkirim'    => '<label class="label label-info">Terkirim</label>',
                        'Verified'  => '<label class="label label-warning">Verified</label>',
                        'Updated'  => '<label class="label label-warning">Updated</label>',
                        'Lolos'       => '<label class="label label-success">Lolos</label>',
                        'Tidak Lolos' => '<label class="label label-danger">Tidak Lolos</label>',
                        default       => '<label class="label label-warning">Belum Diverifikasi</label>',
                    };
                } else {
                    return $row->status_lolos ? $row->status_lolos : '-';
                }
            })
            ->addColumn('createdtime', function ($row) {
                return $row->created_at ? $row->created_at->format('d-F-Y H:i') : '-';
            })
            ->addColumn('action', function ($row) {
                $detail = '<a href="' . url('/datapeserta/detail/' . $row->id) . '" class="btn btn-sm btn-primary">Detail</a>';

                $user = auth()->user();
                $now = Carbon::now();
                $deadline = Carbon::create(2025, 5, 20, 01, 30, 0);

                if ($user->role === 'AdminMD' && $now->greaterThan($deadline)) {
                    $edit = '<button class="btn btn-sm btn-warning" onclick="alertEditDeadline()">Edit</button>';
                } else {
                    $edit = '<a href="' . url('/registrasidata/edit/' . $row->id) . '" class="btn btn-sm btn-warning">Edit</a>';
                }
                return $detail . ' ' . $edit;
            })
            ->rawColumns(['status', 'action'])
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

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_lolos' => 'required|string',
        ]);

        $peserta = Peserta::findOrFail($id);
        $peserta->status_lolos = $request->status_lolos;
        $peserta->save();

        return response()->json(['message' => 'Status berhasil diupdate.']);
    }
}
