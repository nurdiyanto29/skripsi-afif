<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=PermissionTableSeeder
     */
    public function run(): void
    {
        $data = config('nxconfig.permission') ?: [];
         foreach ($data as $guard_name => $names){
            foreach($names as $name){
                foreach(['C','R','U','D'] as $val){
                    $dt = ['name' => $name.'-'.$val , 'guard_name' => $guard_name];
                    $cek = Permission::where($dt)->first();
                    if(!$cek) Permission::create($dt);
                }

            }
            
         }

    }
}
