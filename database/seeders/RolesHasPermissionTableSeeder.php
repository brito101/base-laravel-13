<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class RolesHasPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = DB::table('roles')->pluck('id', 'name');
        $permissions = DB::table('permissions')->pluck('id', 'name');

        /** Permissões de ACL, exclusivas do Programador */
        $aclPermissions = [
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
        ];

        /** Permissões de Usuários, compartilhadas entre Programador e Administrador */
        $userPermissions = [
            'Acessar Usuários',
            'Listar Usuários',
            'Criar Usuários',
            'Editar Usuário',
            'Editar Usuários',
            'Excluir Usuários',
        ];

        $rows = [];

        foreach ($aclPermissions as $name) {
            $rows[] = ['permission_id' => $permissions[$name], 'role_id' => $roles['Programador']];
        }

        /* Atribuição de Perfis também liberada para o Administrador */
        $rows[] = ['permission_id' => $permissions['Atribuir Perfis'], 'role_id' => $roles['Administrador']];

        foreach ($userPermissions as $name) {
            $rows[] = ['permission_id' => $permissions[$name], 'role_id' => $roles['Programador']];
            $rows[] = ['permission_id' => $permissions[$name], 'role_id' => $roles['Administrador']];
        }

        DB::table('role_has_permissions')->insert($rows);
    }
}
