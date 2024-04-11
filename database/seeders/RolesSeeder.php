<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super =Role::create([ 'name' => 'Super Admin', 'guard_name' => 'admin' ]);
        Role::create([ 'name' => 'Admin', 'guard_name' => 'admin' ]);
        Role::create([ 'name' => 'BOD', 'guard_name' => 'admin' ]);

        Role::create([ 'name' => 'Owner', 'guard_name' => 'web' ]);
        Role::create([ 'name' => 'Surpervisor', 'guard_name' => 'web' ]);
        Role::create([ 'name' => 'Admin', 'guard_name' => 'web' ]);
        Role::create([ 'name' => 'Kepala Toko', 'guard_name' => 'web' ]);
        Role::create([ 'name' => 'Kasir', 'guard_name' => 'web' ]);

        $user = User::create([
            'name' => 'super admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345')
        ])->assignRole($super);
    }
}
