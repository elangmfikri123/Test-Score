<?php

namespace App\Http\Controllers;

use App\Support\AppDeadlineSettings;
use Illuminate\Http\Request;

class AdminDeadlineController extends Controller
{
    public function index()
    {
        $settings = AppDeadlineSettings::all();

        return view('admin.admin-deadline-settings', [
            'pesertaDeadline' => $settings['peserta_registration_deadline'],
            'klhrDeadline' => $settings['klhr_registration_deadline'],
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'peserta_registration_deadline' => 'required|date',
            'klhr_registration_deadline' => 'required|date',
        ]);

        AppDeadlineSettings::save($validated);

        return redirect()->back()
            ->with('success', 'Deadline berhasil diperbarui.')
            ->with('updated_at', now()->format('d M Y H:i:s'));
    }
}
