<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Peserta;
use App\Models\Category;
use App\Models\MainDealer;
use App\Models\RiwayatKlhn;
use App\Models\FilesPeserta;
use Illuminate\Http\Request;
use App\Models\SubmissionKlhr;
use App\Models\IdentitasAtasan;
use App\Models\IdentitasDealer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminMDController extends Controller
{
    public function index()
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
    
        return view('adminmd.adminmd-index', compact('categories'));
    }
    
    public function registrasiPeserta()
    {
        $mainDealers = MainDealer::select('id', 'kodemd', 'nama_md')->get();
        $categories = Category::select('id', 'namacategory')->get();
        return view('adminmd.adminmd-registrasipeserta', compact('mainDealers', 'categories'));
    }

    public function storeRegister(Request $request)
    {
        $request->validate([
            'file_lampiranklhn' => 'nullable|file|mimes:xlsx,xls|max:2048',
            'file_project' => 'nullable|file|mimes:pdf,ppt,pptx|max:5120',
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'ktp' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $peserta = Peserta::create([
                'user_id' => null,
                'category_id' => $request->category_id ?? null,
                'maindealer_id' => $request->maindealer_id,
                'jabatan' => $request->jabatan,
                'honda_id' => $request->honda_id,
                'nama' => $request->nama,
                'tanggal_hondaid' => $request->tanggal_hondaid,
                'tanggal_awalbekerja' => $request->tanggal_awalbekerja,
                'lamabekerja_honda' => $request->lamabekerja_honda,
                'lamabekerja_dealer' => $request->lamabekerja_dealer,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama' => $request->agama,
                'no_hp' => $request->no_hp,
                'no_hp_astrapay' => $request->no_hp_astrapay ?? null,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'email' => $request->email,
                'ukuran_baju' => $request->ukuran_baju,
                'pantangan_makanan' => $request->pantangan_makanan ?? null,
                'riwayat_penyakit' => $request->riwayat_penyakit ?? null,
                'link_facebook' => $request->link_facebook ?? null,
                'link_instagram' => $request->link_instagram ?? null,
                'link_tiktok' => $request->link_tiktok ?? null,
                'status_lolos' => 'Verified',
                'created_by' => auth()->user()->name ?? 'system',
            ]);

            $user = User::create([
                'username' => $request->honda_id,
                'password' => bcrypt($request->honda_id . 'klhn2025'),
                'role' => 'Peserta',
                'is_online' => false,
            ]);

            if ($request->has('riwayat_klhn') && is_array($request->riwayat_klhn)) {
                foreach ($request->riwayat_klhn as $riwayat) {
                    RiwayatKlhn::create([
                        'peserta_id' => $peserta->id,
                        'vcategory' => $riwayat['vcategory'] ?? null,
                        'tahun_keikutsertaan' => $riwayat['tahun_keikutsertaan'] ?? null,
                        'status_kepesertaan' => $riwayat['status_kepesertaan'] ?? null,
                    ]);
                }
            }

            $peserta->update(['user_id' => $user->id]);
            IdentitasAtasan::create([
                'peserta_id' => $peserta->id,
                'nama_lengkap_atasan' => $request->nama_lengkap_atasan,
                'jabatan' => $request->jabatan_atasan,
                'no_hp' => $request->no_hp_atasan,
                'no_hpalternatif' => $request->no_hpalternatif_atasan ?? null,
                'email' => $request->email_atasan ?? null,
            ]);
            
            IdentitasDealer::create([
                'peserta_id' => $peserta->id,
                'kode_dealer' => $request->kode_dealer,
                'nama_dealer' => $request->nama_dealer,
                'link_google_business' => $request->link_google_business ?? null,
                'kota' => $request->kota,
                'provinsi' => $request->provinsi,
                'tahun_menang_klhn' => $request->tahun_menang_klhn ?? null,
                'keikutsertaan_klhn_sebelumnya' => $request->keikutsertaan_klhn_sebelumnya ?? null,
                'no_telp_dealer' => $request->no_telp_dealer,
                'link_facebook' => $request->link_facebook_dealer ?? null,
                'link_instagram' => $request->link_instagram_dealer ?? null,
                'link_tiktok' => $request->link_tiktok_dealer ?? null,
            ]);

            $filesData = [
                'peserta_id' => $peserta->id,
                'judul_project' => $request->judul_project ?? null,
                'tahun_pembuatan_project' => $request->tahun_pembuatan_project ?? null,
            ];

            if ($request->hasFile('file_lampiranklhn')) {
                $filesData['file_lampiranklhn'] = $request->file('file_lampiranklhn')->store('files/lampiran_klhn', 'public');
            }

            if ($request->hasFile('file_project')) {
                $filesData['file_project'] = $request->file('file_project')->store('files/project', 'public');
            }

            if ($request->hasFile('foto_profil')) {
                $filesData['foto_profil'] = $request->file('foto_profil')->store('files/foto_profil', 'public');
            }

            if ($request->hasFile('ktp')) {
                $filesData['ktp'] = $request->file('ktp')->store('files/ktp', 'public');
            }

            FilesPeserta::create($filesData);

            DB::commit();

            return redirect()->route('list.peserta')->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($filesData)) {
                foreach ($filesData as $key => $file) {
                    if (in_array($key, ['file_lampiranklhn', 'file_project', 'foto_profil', 'ktp']) && $file) {
                        Storage::disk('public')->delete($file);
                    }
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data peserta',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function showSubmission()
    {
        return view('adminmd.adminmd-submissionklhr');
    }
    public function submissionJson(Request $request)
    {
        $admin = Admin::where('user_id', auth()->id())->first();
        $data = SubmissionKlhr::with('maindealer');

        if (auth()->user()->role === 'AdminMD' && $admin && $admin->maindealer_id) {
            $data->where('maindealer_id', $admin->maindealer_id);
        }

        if (auth()->user()->role === 'Admin') {
            $data = SubmissionKlhr::with('maindealer');
        }
        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $data->whereHas('maindealer', function ($query) use ($search) {
                $query->where('nama_md', 'like', '%' . $search . '%');
            });
        }

        $result = DataTables()->of($data)
            ->addIndexColumn()
            ->addColumn('maindealer', function ($row) {
                return $row->maindealer ? $row->maindealer->nama_md : '-';
            })
            ->addColumn('createdtime', function ($row) {
                return $row->created_at ? $row->created_at->format('d-F-Y H:i') : '-';
            })
            ->addColumn('action', function ($row) {
                $url = url('/submissionklhr/data/' . $row->id);
                return '<a href="' . $url . '" class="btn btn-sm btn-primary">Detail</a>';
            })
            ->rawColumns(['action'])
            ->toJson();

        return $result;
    }
    public function registerSubmission()
    {
        $mainDealers = MainDealer::select('id', 'kodemd', 'nama_md')->get();
        return view('adminmd.adminmd-registrasiklhr', compact('mainDealers'));
    }

    public function createSubmission(Request $request)
    {
        $request->validate([
            'maindealer_id' => 'required|exists:maindealer,id',
            'link_klhr1' => 'required|url',
            'link_klhr2' => 'nullable|url',
            'link_klhr3' => 'nullable|url',
            'file_submission' => 'required|file|mimes:xlsx,xls|max:2048',
            'file_ttdkanwil' => 'required|file|mimes:pdf|max:2048',
            'file_dokumpelaksanaan' => 'required|file|mimes:pdf|max:2048',
        ]);

        $fileSubmission = $request->file('file_submission')->store('public/submissions');
        $fileTtd = $request->file('file_ttdkanwil')->store('public/ttd');
        $fileEvidence = $request->file('file_dokumpelaksanaan')->store('public/evidence');
        SubmissionKlhr::create([
            'maindealer_id' => $request->maindealer_id,
            'link_klhr1' => $request->link_klhr1,
            'link_klhr2' => $request->link_klhr2,
            'link_klhr3' => $request->link_klhr3,
            'file_submission' => $fileSubmission,
            'file_ttdkanwil' => $fileTtd,
            'file_dokumpelaksanaan' => $fileEvidence,
        ]);

        return redirect()->route('submission.klhr')->with('success', 'Data submission KLHR berhasil disimpan!');
    }
}
