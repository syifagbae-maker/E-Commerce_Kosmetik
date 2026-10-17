<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'app:create-admin';

    protected $description = 'Membuat akun admin Aura';

    public function handle(): int
    {
        $nama = $this->ask('Nama admin');
        $email = $this->ask('Email admin');
        $password = $this->secret('Password admin');

        if (User::where('email', $email)->exists()) {
            $this->error('Email tersebut sudah terdaftar.');

            return self::FAILURE;
        }

        $user = new User();
        $user->nama = $nama;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->role = 'admin';
        $user->save();

        $this->info('Akun admin Aura berhasil dibuat!');

        return self::SUCCESS;
    }
}
