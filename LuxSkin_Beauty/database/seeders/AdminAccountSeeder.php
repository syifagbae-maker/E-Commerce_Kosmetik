<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class AdminAccountSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@luxskinbeauty.test'],
            ['nama' => 'LuxSkin Administrator', 'password' => Hash::make('Admin123!'), 'role' => 'admin', 'no_hp' => null, 'updated_at' => now(), 'created_at' => now()]
        );
    }
}
