<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard ()
    {
        return view('admin.admindashboard');
    }
    public function userlist ()
    {
        return view('admin.adminuserlist');
    }
    public function getusertable(Request $request)
    {
    // Query dengan join ke tabel peserta dan juri
        $data = User::query()
            ->leftJoin('peserta', 'users.peserta_id', '=', 'peserta.id')
            ->leftJoin('juri', 'users.juri_id', '=', 'juri.id')
            ->select(
                'users.id',
                'users.username',
                'users.role',
                'peserta.nama as peserta_nama',
                'peserta.email as peserta_email',
                'juri.namajuri as juri_nama',
                'users.username as admin_nama',
                'juri.jabatan as juri_jabatan'
            );

        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $data->where(function ($query) use ($search) {
                $query->where('users.id', 'like', '%' . $search . '%')
                    ->orWhere('users.username', 'like', '%' . $search . '%')
                    ->orWhere('users.role', 'like', '%' . $search . '%')
                    ->orWhere('peserta.nama', 'like', '%' . $search . '%')
                    ->orWhere('peserta.email', 'like', '%' . $search . '%')
                    ->orWhere('juri.namajuri', 'like', '%' . $search . '%')
                    ->orWhere('juri.jabatan', 'like', '%' . $search . '%'); 
            });
    }

        $result = DataTables()->of($data)
            ->addColumn('nama', function ($row) {
                if ($row->peserta_nama) {
                    return $row->peserta_nama;
                } elseif ($row->juri_nama) {
                    return $row->juri_nama;
                } else {
                    return $row->admin_nama;
                }
            })
            ->addColumn('email', function ($row) {
                return $row->peserta_email ?? '';
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
    public function pesertalist ()
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

    public function jurilist ()
    {
        return view('admin.adminjurilist');
    }
    
    public function managecourselist ()
    {
        return view('admin.admin-managecourse');
    }
    public function addnewcourse ()
    {
        return view('admin.admin-addnewcourse');
    }
    public function detailcourse ()
    {
        return view('admin.admin-detailcourse');
    }
    public function createquestion ()
    {
        return view('admin.admin-addnewquestions');
    }
    public function sessionslist ()
    {
        return view('admin.admin-managesession');
    }
    public function sessiondetail ()
    {
        return view('admin.admin-detailsessions');
    }
}
