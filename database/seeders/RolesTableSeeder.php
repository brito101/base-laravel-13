<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = ['Programador', 'Administrador', 'Usuário'];

        DB::table('roles')->insert(array_map(fn ($name) => [
            'id' => (string) Str::uuid(),
            'name' => $name,
            'guard_name' => 'web',
            'created_at' => new DateTime('now'),
        ], $roles));
    }
}
