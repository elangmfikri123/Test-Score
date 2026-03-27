<?php

namespace App\Support;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AppDeadlineSettings
{
    private const STORAGE_PATH = 'settings/deadlines.json';

    private const DEFAULTS = [
        'peserta_registration_deadline' => '2026-04-08 23:59:00',
        'klhr_registration_deadline' => '2026-04-08 23:59:00',
    ];

    public static function all(): array
    {
        $settings = self::DEFAULTS;

        if (Storage::exists(self::STORAGE_PATH)) {
            $raw = json_decode(Storage::get(self::STORAGE_PATH), true);
            if (is_array($raw)) {
                $settings = array_merge($settings, array_intersect_key($raw, self::DEFAULTS));
            }
        }

        foreach ($settings as $key => $value) {
            try {
                $settings[$key] = Carbon::parse($value)->format('Y-m-d H:i:s');
            } catch (\Throwable $th) {
                $settings[$key] = self::DEFAULTS[$key];
            }
        }

        return $settings;
    }

    public static function pesertaRegistrationDeadline(): Carbon
    {
        return Carbon::parse(self::all()['peserta_registration_deadline']);
    }

    public static function klhrRegistrationDeadline(): Carbon
    {
        return Carbon::parse(self::all()['klhr_registration_deadline']);
    }

    public static function save(array $data): void
    {
        $settings = self::all();
        $settings['peserta_registration_deadline'] = Carbon::parse($data['peserta_registration_deadline'])->format('Y-m-d H:i:s');
        $settings['klhr_registration_deadline'] = Carbon::parse($data['klhr_registration_deadline'])->format('Y-m-d H:i:s');

        Storage::put(self::STORAGE_PATH, json_encode($settings, JSON_PRETTY_PRINT));
    }
}
