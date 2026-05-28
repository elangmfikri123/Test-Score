<?php

namespace App\Console\Commands;

use App\Models\Peserta;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GeneratePesertaUsers extends Command
{
    protected $signature = 'peserta:generate-users
        {--dry-run : Tampilkan data yang akan diproses tanpa menyimpan perubahan}
        {--status= : Filter status_lolos, pisahkan dengan koma. Contoh: --status=Verified,Draft}';

    protected $description = 'Generate user login untuk peserta yang belum memiliki user_id.';

    public function handle(): int
    {
        $isDryRun = (bool) $this->option('dry-run');
        $statuses = $this->parseStatuses($this->option('status'));

        $query = Peserta::query()
            ->whereNull('user_id')
            ->whereNotNull('honda_id')
            ->where('honda_id', '!=', '');

        if (!empty($statuses)) {
            $query->whereIn('status_lolos', $statuses);
        }

        $created = 0;
        $linked = 0;
        $skipped = 0;

        $this->info(($isDryRun ? '[DRY RUN] ' : '') . 'Mulai generate user peserta...');

        $query->orderBy('id')->chunkById(100, function ($pesertas) use ($isDryRun, &$created, &$linked, &$skipped) {
            foreach ($pesertas as $peserta) {
                $username = trim((string) $peserta->honda_id);

                if ($username === '') {
                    $skipped++;
                    $this->warn("Skip peserta #{$peserta->id}: Honda ID kosong.");
                    continue;
                }

                $existingUser = User::where('username', $username)->first();

                if ($existingUser) {
                    if ($existingUser->role !== 'Peserta') {
                        $skipped++;
                        $this->warn("Skip peserta #{$peserta->id}: username {$username} sudah dipakai role {$existingUser->role}.");
                        continue;
                    }

                    $linkedPeserta = Peserta::where('user_id', $existingUser->id)
                        ->where('id', '!=', $peserta->id)
                        ->first();

                    if ($linkedPeserta) {
                        $skipped++;
                        $this->warn("Skip peserta #{$peserta->id}: username {$username} sudah terhubung ke peserta #{$linkedPeserta->id}.");
                        continue;
                    }

                    if (!$isDryRun) {
                        $peserta->update(['user_id' => $existingUser->id]);
                    }

                    $linked++;
                    $this->line("Link peserta #{$peserta->id} ke user existing #{$existingUser->id} ({$username}).");
                    continue;
                }

                if (!$isDryRun) {
                    DB::transaction(function () use ($peserta, $username) {
                        $user = User::create([
                            'username' => $username,
                            'password' => Hash::make($username . 'klhn2026'),
                            'role' => 'Peserta',
                            'login_token' => false,
                        ]);

                        $peserta->update(['user_id' => $user->id]);
                    });
                }

                $created++;
                $this->line("Create user untuk peserta #{$peserta->id} ({$username}).");
            }
        });

        $this->newLine();
        $this->info("Selesai. Created: {$created}, linked existing: {$linked}, skipped: {$skipped}.");

        return self::SUCCESS;
    }

    private function parseStatuses(?string $value): array
    {
        if (!$value) {
            return [];
        }

        return array_values(array_filter(array_map(
            fn ($status) => trim($status),
            explode(',', $value)
        )));
    }
}
