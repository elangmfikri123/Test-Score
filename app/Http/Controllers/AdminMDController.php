<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Peserta;
use App\Models\Category;
use App\Models\MainDealer;
use App\Models\RiwayatKlhn;
use App\Models\FilesPeserta;
use App\Support\AppDeadlineSettings;
use Illuminate\Http\Request;
use App\Models\SubmissionKlhr;
use App\Models\IdentitasAtasan;
use App\Models\IdentitasDealer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
        $pesertaDeadline = AppDeadlineSettings::pesertaRegistrationDeadline();

        return view('adminmd.adminmd-index', compact('categories', 'pesertaDeadline'));
    }

    public function registrasiPeserta()
    {
        $user = Auth::user();

        if ($user->role === 'AdminMD') {
            $deadline = AppDeadlineSettings::pesertaRegistrationDeadline();
            if (now()->greaterThanOrEqualTo($deadline)) {
                return redirect()->back()->with('error', 'Waktu pendaftaran sudah ditutup.');
            }

            $admin = Admin::where('user_id', $user->id)->first();
            $mainDealers = MainDealer::where('id', $admin->maindealer_id)->get();
        } else {
            $mainDealers = MainDealer::all();
        }

        $categories = Category::select('id', 'namacategory')->get();
        return view('adminmd.adminmd-registrasipeserta', compact('mainDealers', 'categories'));
    }

    public function storeRegister(Request $request)
    {
        $pesertaId = $request->input('peserta_id');
        $uniqueHondaRule = Rule::unique('peserta', 'honda_id');
        $uniqueEmailRule = Rule::unique('peserta', 'email');
        if ($pesertaId) {
            $uniqueHondaRule->ignore($pesertaId);
            $uniqueEmailRule->ignore($pesertaId);
        }

        $request->validate([
            'file_lampiranklhn' => 'nullable|file|mimes:xlsx,xls|max:51200',
            'file_project' => 'nullable|file|mimes:pdf,ppt,pptx|max:51200',
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'ktp' => 'required|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'honda_id' => ['required', $uniqueHondaRule],
            'email' => ['required', 'email', $uniqueEmailRule],
        ]);

        DB::beginTransaction();

        try {
            $pesertaData = [
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
            ];

            if ($pesertaId) {
                $peserta = Peserta::findOrFail($pesertaId);
                $peserta->update($pesertaData);
            } else {
                $pesertaData['created_by'] = auth()->user()->username ?? 'system';
                $peserta = Peserta::create($pesertaData);
            }

            if (!$peserta->user_id) {
                $user = User::create([
                    'username' => $request->honda_id,
                    'password' => bcrypt($request->honda_id . 'klhn2026'),
                    'role' => 'Peserta',
                    'login_token' => false,
                ]);
                $peserta->update(['user_id' => $user->id]);
            }

            if ($request->has('riwayat_klhn') && is_array($request->riwayat_klhn)) {
                RiwayatKlhn::where('peserta_id', $peserta->id)->delete();
                foreach ($request->riwayat_klhn as $riwayat) {
                    RiwayatKlhn::create([
                        'peserta_id' => $peserta->id,
                        'vcategory' => $riwayat['vcategory'] ?? null,
                        'tahun_keikutsertaan' => $riwayat['tahun_keikutsertaan'] ?? null,
                        'status_kepesertaan' => $riwayat['status_kepesertaan'] ?? null,
                    ]);
                }
            }

            IdentitasAtasan::updateOrCreate(
                ['peserta_id' => $peserta->id],
                [
                    'nama_lengkap_atasan' => $request->nama_lengkap_atasan,
                    'jabatan' => $request->jabatan_atasan,
                    'no_hp' => $request->no_hp_atasan,
                    'no_hpalternatif' => $request->no_hpalternatif_atasan ?? null,
                    'email' => $request->email_atasan ?? null,
                ]
            );

            IdentitasDealer::updateOrCreate(
                ['peserta_id' => $peserta->id],
                [
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
                ]
            );

            $files = FilesPeserta::firstOrNew(['peserta_id' => $peserta->id]);
            $files->judul_project = $request->judul_project ?? null;
            $files->tahun_pembuatan_project = $request->tahun_pembuatan_project ?? null;
            $files->validasi = $request->validasi ?? null;

            $timestamp = now()->format('Ymd_His');

            if ($request->hasFile('file_lampiranklhn')) {
                $file = $request->file('file_lampiranklhn');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $newFileName = $filename . '_' . $timestamp . '.' . $extension;

                $files->file_lampiranklhn = $file->storeAs('files/lampiran_klhn', $newFileName, 'public');
            }

            if ($request->hasFile('file_project')) {
                $file = $request->file('file_project');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $newFileName = $filename . '_' . $timestamp . '.' . $extension;

                $files->file_project = $file->storeAs('files/project', $newFileName, 'public');
            }

            if ($request->hasFile('foto_profil')) {
                $file = $request->file('foto_profil');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $newFileName = $filename . '_' . $timestamp . '.' . $extension;

                $files->foto_profil = $file->storeAs('files/foto_profil', $newFileName, 'public');
            }

            if ($request->hasFile('ktp')) {
                $file = $request->file('ktp');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $newFileName = $filename . '_' . $timestamp . '.' . $extension;

                $files->ktp = $file->storeAs('files/ktp', $newFileName, 'public');
            }

            $files->save();

            DB::commit();

            return redirect()->route('list.peserta')
                ->with('success', 'Data berhasil disimpan.')
                ->with('honda_id', $request->honda_id)
                ->with('action_type', 'create');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data peserta',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function saveDraftRegister(Request $request)
    {
        $pesertaId = $request->input('peserta_id');
        $uniqueHondaRule = Rule::unique('peserta', 'honda_id');
        $uniqueEmailRule = Rule::unique('peserta', 'email');
        if ($pesertaId) {
            $uniqueHondaRule->ignore($pesertaId);
            $uniqueEmailRule->ignore($pesertaId);
        }

        $request->validate([
            'peserta_id' => 'nullable|exists:peserta,id',
            'file_lampiranklhn' => 'nullable|file|mimes:xlsx,xls|max:51200',
            'file_project' => 'nullable|file|mimes:pdf,ppt,pptx|max:51200',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'ktp' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'honda_id' => ['nullable', $uniqueHondaRule],
            'email' => ['nullable', 'email', $uniqueEmailRule],
        ]);

        DB::beginTransaction();

        try {
            $draftFields = [
                'category_id',
                'maindealer_id',
                'jabatan',
                'honda_id',
                'nama',
                'tanggal_hondaid',
                'tanggal_awalbekerja',
                'lamabekerja_honda',
                'lamabekerja_dealer',
                'jenis_kelamin',
                'tempat_lahir',
                'tanggal_lahir',
                'agama',
                'no_hp',
                'no_hp_astrapay',
                'pendidikan_terakhir',
                'email',
                'ukuran_baju',
                'pantangan_makanan',
                'riwayat_penyakit',
                'link_facebook',
                'link_instagram',
                'link_tiktok',
            ];

            $pesertaData = [];
            foreach ($draftFields as $field) {
                $value = $request->input($field);
                if ($value !== null && $value !== '') {
                    $pesertaData[$field] = $value;
                }
            }

            if ($pesertaId) {
                $peserta = Peserta::findOrFail($pesertaId);
                if (!in_array($peserta->status_lolos, ['Verified', 'Lolos', 'Tidak Lolos'], true)) {
                    $pesertaData['status_lolos'] = 'Draft';
                }
                if (!empty($pesertaData)) {
                    $peserta->update($pesertaData);
                }
            } else {
                $pesertaData['status_lolos'] = 'Draft';
                $pesertaData['created_by'] = auth()->user()->username ?? 'system';
                $peserta = Peserta::create($pesertaData);
            }

            $atasanData = [
                'nama_lengkap_atasan' => $request->input('nama_lengkap_atasan'),
                'jabatan' => $request->input('jabatan_atasan'),
                'no_hp' => $request->input('no_hp_atasan'),
                'no_hpalternatif' => $request->input('no_hpalternatif_atasan'),
                'email' => $request->input('email_atasan'),
            ];
            $atasanData = array_filter($atasanData, fn($value) => $value !== null && $value !== '');
            if (!empty($atasanData)) {
                IdentitasAtasan::updateOrCreate(
                    ['peserta_id' => $peserta->id],
                    $atasanData
                );
            }

            $dealerData = [
                'kode_dealer' => $request->input('kode_dealer'),
                'nama_dealer' => $request->input('nama_dealer'),
                'link_google_business' => $request->input('link_google_business'),
                'kota' => $request->input('kota'),
                'provinsi' => $request->input('provinsi'),
                'tahun_menang_klhn' => $request->input('tahun_menang_klhn'),
                'keikutsertaan_klhn_sebelumnya' => $request->input('keikutsertaan_klhn_sebelumnya'),
                'no_telp_dealer' => $request->input('no_telp_dealer'),
                'link_facebook' => $request->input('link_facebook_dealer'),
                'link_instagram' => $request->input('link_instagram_dealer'),
                'link_tiktok' => $request->input('link_tiktok_dealer'),
            ];
            $dealerData = array_filter($dealerData, fn($value) => $value !== null && $value !== '');
            if (!empty($dealerData)) {
                IdentitasDealer::updateOrCreate(
                    ['peserta_id' => $peserta->id],
                    $dealerData
                );
            }

            if ($request->has('riwayat_klhn') && is_array($request->riwayat_klhn)) {
                $hasRiwayatData = false;
                foreach ($request->riwayat_klhn as $riwayat) {
                    if (!empty(array_filter($riwayat, fn($value) => $value !== null && $value !== ''))) {
                        $hasRiwayatData = true;
                        break;
                    }
                }
                if ($hasRiwayatData) {
                    RiwayatKlhn::where('peserta_id', $peserta->id)->delete();
                    foreach ($request->riwayat_klhn as $riwayat) {
                        RiwayatKlhn::create([
                            'peserta_id' => $peserta->id,
                            'vcategory' => $riwayat['vcategory'] ?? null,
                            'tahun_keikutsertaan' => $riwayat['tahun_keikutsertaan'] ?? null,
                            'status_kepesertaan' => $riwayat['status_kepesertaan'] ?? null,
                        ]);
                    }
                }
            }

            $files = FilesPeserta::firstOrNew(['peserta_id' => $peserta->id]);
            $filesData = [
                'judul_project' => $request->input('judul_project'),
                'tahun_pembuatan_project' => $request->input('tahun_pembuatan_project'),
                'validasi' => $request->input('validasi'),
            ];
            $filesData = array_filter($filesData, fn($value) => $value !== null && $value !== '');
            foreach ($filesData as $key => $value) {
                $files->{$key} = $value;
            }

            $timestamp = now()->format('Ymd_His');
            if ($request->hasFile('file_lampiranklhn')) {
                $file = $request->file('file_lampiranklhn');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $newFileName = $filename . '_' . $timestamp . '.' . $extension;
                $files->file_lampiranklhn = $file->storeAs('files/lampiran_klhn', $newFileName, 'public');
            }
            if ($request->hasFile('file_project')) {
                $file = $request->file('file_project');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $newFileName = $filename . '_' . $timestamp . '.' . $extension;
                $files->file_project = $file->storeAs('files/project', $newFileName, 'public');
            }
            if ($request->hasFile('foto_profil')) {
                $file = $request->file('foto_profil');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $newFileName = $filename . '_' . $timestamp . '.' . $extension;
                $files->foto_profil = $file->storeAs('files/foto_profil', $newFileName, 'public');
            }
            if ($request->hasFile('ktp')) {
                $file = $request->file('ktp');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $newFileName = $filename . '_' . $timestamp . '.' . $extension;
                $files->ktp = $file->storeAs('files/ktp', $newFileName, 'public');
            }

            $files->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'peserta_id' => $peserta->id,
                'message' => 'Draft tersimpan.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan draft',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function checkHondaIdEmail(Request $request)
    {
        $query = Peserta::query();

        if ($request->honda_id) {
            $query->orWhere(function ($q) use ($request) {
                $q->where('honda_id', $request->honda_id);
            });
        }

        if ($request->email) {
            $query->orWhere(function ($q) use ($request) {
                $q->where('email', $request->email);
            });
        }

        $peserta = $query->get();

        $hondaIdExists = false;
        $emailExists = false;

        foreach ($peserta as $item) {
            if ($item->id != $request->peserta_id) {
                if ($item->honda_id == $request->honda_id) {
                    $hondaIdExists = true;
                }
                if ($item->email == $request->email) {
                    $emailExists = true;
                }
            }
        }

        return response()->json([
            'honda_id_exists' => $hondaIdExists,
            'email_exists' => $emailExists,
        ]);
    }

    public function detailPeserta($id)
    {
        $peserta = Peserta::with([
            'user',
            'identitasAtasan',
            'identitasDealer',
            'filesPeserta',
            'category',
            'maindealer',
            'riwayatKlhn'
        ])->findOrFail($id);

        if (auth()->user()->role === 'AdminMD') {
            $admin = Admin::where('user_id', auth()->id())->first();
            if (!$admin || $admin->maindealer_id !== $peserta->maindealer_id) {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses ke data ini.');
            }
            $mainDealers = MainDealer::where('id', $admin->maindealer_id)->get();
        } else {
            $mainDealers = MainDealer::all();
        }

        $categories = Category::select('id', 'namacategory')->get();
        $riwayat_klhn = $peserta->riwayatKlhn->map(function ($item) {
            return [
                'tahun_keikutsertaan' => $item->tahun_keikutsertaan,
                'vcategory' => $item->vcategory,
                'status_kepesertaan' => $item->status_kepesertaan,
            ];
        })->toArray();
        return view('adminmd.adminmd-detailprofile', compact(
            'peserta',
            'categories',
            'mainDealers',
            'riwayat_klhn'
        ));
    }

    public function editPeserta($id)
    {
        $peserta = Peserta::with([
            'user',
            'identitasAtasan',
            'identitasDealer',
            'filesPeserta',
            'category',
            'maindealer',
            'riwayatKlhn'
        ])->findOrFail($id);

        $now = Carbon::now();
        $deadline = AppDeadlineSettings::pesertaRegistrationDeadline();

        if (auth()->user()->role === 'AdminMD') {
            if ($now->greaterThan($deadline)) {
                return redirect()->back()->with('error', 'Akses edit ditutup setelah ' . $deadline->format('d M Y H:i') . '.');
            }

            $admin = Admin::where('user_id', auth()->id())->first();
            if (!$admin || $admin->maindealer_id !== $peserta->maindealer_id) {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses ke data ini.');
            }

            $mainDealers = MainDealer::where('id', $admin->maindealer_id)->get();
        } else {
            $mainDealers = MainDealer::all();
        }

        $categories = Category::select('id', 'namacategory')->get();
        $riwayat_klhn = $peserta->riwayatKlhn->map(function ($item) {
            return [
                'tahun_keikutsertaan' => $item->tahun_keikutsertaan,
                'vcategory' => $item->vcategory,
                'status_kepesertaan' => $item->status_kepesertaan,
            ];
        })->toArray();

        return view('adminmd.adminmd-editregistrasi', compact(
            'peserta',
            'categories',
            'mainDealers',
            'riwayat_klhn'
        ));
    }

    public function updatePeserta(Request $request, $id)
    {
        $peserta = Peserta::findOrFail($id);

        $request->validate([
            'file_lampiranklhn' => 'nullable|file|mimes:xlsx,xls|max:51200',
            'file_project' => 'nullable|file|mimes:pdf,ppt,pptx|max:51200',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'ktp' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'honda_id' => 'required|unique:peserta,honda_id,' . $peserta->id,
            'email' => 'required|email|unique:peserta,email,' . $peserta->id,
        ]);

        DB::beginTransaction();

        try {
            $peserta->update([
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
            ]);

            if ($peserta->user) {
                $peserta->user->update([
                    'username' => $request->honda_id,
                    'role' => 'Peserta',
                ]);
            }
            IdentitasAtasan::updateOrCreate(
                ['peserta_id' => $peserta->id],
                [
                    'nama_lengkap_atasan' => $request->nama_lengkap_atasan,
                    'jabatan' => $request->jabatan_atasan,
                    'no_hp' => $request->no_hp_atasan,
                    'no_hpalternatif' => $request->no_hpalternatif_atasan ?? null,
                    'email' => $request->email_atasan ?? null,
                ]
            );

            IdentitasDealer::updateOrCreate(
                ['peserta_id' => $peserta->id],
                [
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
                ]
            );
            RiwayatKlhn::where('peserta_id', $peserta->id)->delete();
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

            $files = FilesPeserta::firstOrNew(['peserta_id' => $peserta->id]);
            $files->judul_project = $request->judul_project ?? null;
            $files->tahun_pembuatan_project = $request->tahun_pembuatan_project ?? null;
            $files->validasi = $request->validasi ?? null;


            if ($request->hasFile('file_lampiranklhn')) {
                Storage::disk('public')->delete($files->file_lampiranklhn);
                $originalName = $request->file('file_lampiranklhn')->getClientOriginalName();
                $timestampedName = time() . '_' . $originalName;
                $files->file_lampiranklhn = $request->file('file_lampiranklhn')->storeAs('files/lampiran_klhn', $timestampedName, 'public');
            }

            if ($request->hasFile('file_project')) {
                Storage::disk('public')->delete($files->file_project);
                $originalName = $request->file('file_project')->getClientOriginalName();
                $timestampedName = time() . '_' . $originalName;
                $files->file_project = $request->file('file_project')->storeAs('files/project', $timestampedName, 'public');
            }

            if ($request->hasFile('foto_profil')) {
                Storage::disk('public')->delete($files->foto_profil);
                $originalName = $request->file('foto_profil')->getClientOriginalName();
                $timestampedName = time() . '_' . $originalName;
                $files->foto_profil = $request->file('foto_profil')->storeAs('files/foto_profil', $timestampedName, 'public');
            }

            if ($request->hasFile('ktp')) {
                Storage::disk('public')->delete($files->ktp);
                $originalName = $request->file('ktp')->getClientOriginalName();
                $timestampedName = time() . '_' . $originalName;
                $files->ktp = $request->file('ktp')->storeAs('files/ktp', $timestampedName, 'public');
            }

            $files->save();

            DB::commit();
            return redirect()->route('list.peserta')
                ->with('success', 'Data peserta berhasil diperbarui.')
                ->with('honda_id', $request->honda_id)
                ->with('action_type', 'update');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data peserta: ' . $e->getMessage());
        }
    }

    public function showSubmission()
    {
        $klhrDeadline = AppDeadlineSettings::klhrRegistrationDeadline();
        return view('adminmd.adminmd-submissionklhr', compact('klhrDeadline'));
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
                $detail = '<a href="' . url('/submissionklhr/detail/' . $row->id) . '" class="btn btn-sm btn-primary">Detail</a>';

                $user = auth()->user();
                $now = Carbon::now();
                $deadline = AppDeadlineSettings::klhrRegistrationDeadline();

                if ($user->role === 'AdminMD' && $now->greaterThan($deadline)) {
                    $edit = '<button class="btn btn-sm btn-warning" onclick="alertEditDeadline()">Edit</button>';
                } else {
                    $edit = '<a href="' .  url('/submissionklhr/edit/' . $row->id) . '" class="btn btn-sm btn-warning">Edit</a>';
                }

                return $detail . ' ' . $edit;
            })
            ->rawColumns(['action'])
            ->toJson();

        return $result;
    }
    public function registerSubmission()
    {
        $user = Auth::user();
        if ($user->role === 'AdminMD') {
            $deadline = AppDeadlineSettings::klhrRegistrationDeadline();
            if (now()->greaterThanOrEqualTo($deadline)) {
                return redirect()->back()->with('error', 'Waktu pendaftaran sudah ditutup.');
            }

            $admin = Admin::where('user_id', $user->id)->first();
            $mainDealers = MainDealer::where('id', $admin->maindealer_id)->get();
        } else {
            $mainDealers = MainDealer::all();
        }
        return view('adminmd.adminmd-registrasiklhr', compact('mainDealers'));
    }

    public function createSubmission(Request $request)
    {
        $request->validate([
            'maindealer_id' => 'required|exists:maindealer,id',
            'link_klhr1' => 'required|url',
            'link_klhr2' => 'nullable|url',
            'link_klhr3' => 'nullable|url',
            'file_submission' => 'required|file|mimes:xlsx,xls|max:15360',
            'file_ttdkanwil' => 'required|file|mimes:pdf|max:15360',
            'file_dokumpelaksanaan' => 'required|file|mimes:pdf|max:15360',
        ]);

        $fileSubmission = $request->file('file_submission')->storeAs(
            'submissions',
            $request->file('file_submission')->getClientOriginalName(),
            'public'
        );
        $fileTtd = $request->file('file_ttdkanwil')->storeAs(
            'ttd',
            $request->file('file_ttdkanwil')->getClientOriginalName(),
            'public'
        );
        $fileEvidence = $request->file('file_dokumpelaksanaan')->storeAs(
            'evidence',
            $request->file('file_dokumpelaksanaan')->getClientOriginalName(),
            'public'
        );
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

    public function submissionDetail($id)
    {
        $submissiondetail = SubmissionKlhr::findOrFail($id);
        $user = Auth::user();
        if ($user->role === 'AdminMD') {
            $admin = Admin::where('user_id', $user->id)->first();
            $mainDealers = MainDealer::where('id', $admin->maindealer_id)->get();
        } else {
            $mainDealers = MainDealer::all();
        }
        return view('adminmd.adminmd-detailregistrasiklhr', compact('mainDealers', 'submissiondetail'));
    }

    public function submissionEdit($id)
    {
        $submission = SubmissionKlhr::findOrFail($id);
        $user = Auth::user();
        if ($user->role === 'AdminMD') {
            $admin = Admin::where('user_id', $user->id)->first();
            $mainDealers = MainDealer::where('id', $admin->maindealer_id)->get();
        } else {
            $mainDealers = MainDealer::all();
        }
        return view('adminmd.adminmd-editregistrasiklhr', compact('mainDealers', 'submission'));
    }

    public function submissionUpdate(Request $request, $id)
    {
        $submission = SubmissionKlhr::findOrFail($id);
        $request->validate([
            'maindealer_id' => 'required|exists:maindealer,id',
            'link_klhr1' => 'required|url',
            'link_klhr2' => 'nullable|url',
            'link_klhr3' => 'nullable|url',
            'file_submission' => 'nullable|file|mimes:xlsx,xls|max:15360',
            'file_ttdkanwil' => 'nullable|file|mimes:pdf|max:15360',
            'file_dokumpelaksanaan' => 'nullable|file|mimes:pdf|max:15360',
        ]);

        $data = [
            'maindealer_id' => $request->maindealer_id,
            'link_klhr1' => $request->link_klhr1,
            'link_klhr2' => $request->link_klhr2,
            'link_klhr3' => $request->link_klhr3,
        ];
        if ($request->hasFile('file_submission')) {
            $data['file_submission'] = $request->file('file_submission')->storeAs(
                'submissions',
                $request->file('file_submission')->getClientOriginalName(),
                'public'
            );
        }

        if ($request->hasFile('file_ttdkanwil')) {
            $data['file_ttdkanwil'] = $request->file('file_ttdkanwil')->storeAs(
                'ttd',
                $request->file('file_ttdkanwil')->getClientOriginalName(),
                'public'
            );
        }

        if ($request->hasFile('file_dokumpelaksanaan')) {
            $data['file_dokumpelaksanaan'] = $request->file('file_dokumpelaksanaan')->storeAs(
                'evidence',
                $request->file('file_dokumpelaksanaan')->getClientOriginalName(),
                'public'
            );
        }

        $submission->update($data);
        return redirect()->route('submission.klhr')->with('success', 'Data submission KLHR berhasil diperbarui!');
    }

    public function lampiranFile()
    {
        return view('adminmd.adminmd-lampiran');
    }
}
