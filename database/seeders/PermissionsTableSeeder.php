<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            /** ACL */
            'Acessar ACL',
            'Listar Permissões',
            'Criar Permissões',
            'Editar Permissões',
            'Excluir Permissões',
            'Listar Perfis',
            'Criar Perfis',
            'Editar Perfis',
            'Excluir Perfis',
            'Sincronizar Perfis',
            'Atribuir Perfis',

            /** Users */
            'Acessar Usuários',
            'Listar Usuários',
            'Criar Usuários',
            'Editar Usuário',
            'Editar Usuários',
            'Excluir Usuários',
        ];

        DB::table('permissions')->insert(array_map(fn ($name) => [
            'id' => (string) Str::uuid(),
            'name' => $name,
            'guard_name' => 'web',
            'created_at' => new DateTime('now'),
        ], $permissions));
    }
}
