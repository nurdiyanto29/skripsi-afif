<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // dd(1);
        $user = User::create([
            // 'username' => 'superadmin',
            'name' => 'super admin',
            'email' => 'admin@admin.com',
            'status' => 'aktif',
            'guard_name' => 'admin',
            'password' => bcrypt('12345')
        ]);
        // dd($user);
    }
}
