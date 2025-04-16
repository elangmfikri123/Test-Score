<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.admindashboard');
    }
    public function userlist()
    {
        return view('admin.adminuserlist');
    }
    public function getusertable(Request $request)
    {
        $data = User::query()
            ->leftJoin('peserta', 'users.id', '=', 'peserta.user_id')
            ->leftJoin('juri', 'users.id', '=', 'juri.user_id')
            ->leftJoin('admin', 'users.id', '=', 'admin.user_id')
            ->leftJoin('adminmd', 'users.id', '=', 'adminmd.user_id')
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
                'adminmd.nama_lengkap as adminmd_nama',
                'adminmd.email as adminmd_email'
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
                    ->orWhere('adminmd.nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('adminmd.email', 'like', '%' . $search . '%')
                    ->orWhere('users.is_online', 'like', '%' . $search . '%');
            });
        }
    
        $result = DataTables()->of($data)
            ->addIndexColumn() 
            ->addColumn('nama', function ($row) {
                return $row->peserta_nama
                    ?? $row->juri_nama
                    ?? $row->admin_nama
                    ?? $row->adminmd_nama
                    ?? '-';
            })
            ->addColumn('email', function ($row) {
                return $row->peserta_email
                    ?? $row->juri_email
                    ?? $row->admin_email
                    ?? $row->adminmd_email
                    ?? '-';
            })
            ->addColumn('status', function ($row) {
                return $row->is_online ? '<span class="badge bg-success">Online</span>' : '<span class="badge bg-secondary">Offline</span>';
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

    public function pesertalist()
    {
        return view('admin.adminpesertalist');
    }
    public function getpesertatable(Request $request)
    {
        $data = Peserta::with('maindealer');
        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $data->where(function ($query) use ($search) {
                $query->where('id', 'like', '%' . $search . '%')
                    ->orWhere('honda_id', 'like', '%' . $search . '%')
                    ->orWhere('nama', 'like', '%' . $search . '%');
            });
        }

        $result = DataTables()->of($data)
            ->addColumn('maindealer', function ($row) {
                return $row->maindealer ? $row->maindealer->nama_md : '-'; // Tampilkan nama main dealer
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
}
