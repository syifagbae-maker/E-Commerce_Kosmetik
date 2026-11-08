<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    protected $signature = 'admin:reset-password';

    protected $description = 'Reset password admin LuxSkin';

    public function handle()
    {
        $email = 'syifagbae@gmail.com';
        $password = '111111';

        $user = DB::table('users')
            ->where('email', $email)
            ->where('role', 'admin')
            ->first();

        if (!$user) {
            $this->error('Akun admin tidak ditemukan.');

            return self::FAILURE;
        }

        DB::table('users')
            ->where('id_user', $user->id_user)
            ->update([
                'password' => Hash::make($password),
            ]);

        $this->info('Password admin berhasil diperbarui.');

        return self::SUCCESS;
    }
}
