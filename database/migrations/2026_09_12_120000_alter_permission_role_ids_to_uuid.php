<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $pivotPermission = $columnNames['permission_pivot_key'] ?? 'permission_id';
        $pivotRole = $columnNames['role_pivot_key'] ?? 'role_id';

        // Remover foreign keys que apontam para roles.id e permissions.id
        Schema::table($tableNames['role_has_permissions'], function (Blueprint $table) use ($pivotPermission, $pivotRole) {
            $table->dropForeign([$pivotPermission]);
            $table->dropForeign([$pivotRole]);
        });

        Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) use ($pivotPermission) {
            $table->dropForeign([$pivotPermission]);
        });

        Schema::table($tableNames['model_has_roles'], function (Blueprint $table) use ($pivotRole) {
            $table->dropForeign([$pivotRole]);
        });

        // Converter permissions.id de bigIncrements para uuid
        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();
        });
        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->dropPrimary();
        });
        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->uuid('id')->change();
        });
        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->primary('id');
        });

        // Converter roles.id de bigIncrements para uuid
        Schema::table($tableNames['roles'], function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();
        });
        Schema::table($tableNames['roles'], function (Blueprint $table) {
            $table->dropPrimary();
        });
        Schema::table($tableNames['roles'], function (Blueprint $table) {
            $table->uuid('id')->change();
        });
        Schema::table($tableNames['roles'], function (Blueprint $table) {
            $table->primary('id');
        });

        // Atualizar as colunas de pivot para uuid, para casar com os novos tipos
        Schema::table($tableNames['role_has_permissions'], function (Blueprint $table) use ($pivotPermission, $pivotRole) {
            $table->uuid($pivotPermission)->change();
            $table->uuid($pivotRole)->change();
        });

        Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) use ($pivotPermission) {
            $table->uuid($pivotPermission)->change();
        });

        Schema::table($tableNames['model_has_roles'], function (Blueprint $table) use ($pivotRole) {
            $table->uuid($pivotRole)->change();
        });

        // Recriar as foreign keys
        Schema::table($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames, $pivotPermission, $pivotRole) {
            $table->foreign($pivotPermission)
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign($pivotRole)
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');
        });

        Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $pivotPermission) {
            $table->foreign($pivotPermission)
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');
        });

        Schema::table($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $pivotRole) {
            $table->foreign($pivotRole)
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $pivotPermission = $columnNames['permission_pivot_key'] ?? 'permission_id';
        $pivotRole = $columnNames['role_pivot_key'] ?? 'role_id';

        Schema::table($tableNames['role_has_permissions'], function (Blueprint $table) use ($pivotPermission, $pivotRole) {
            $table->dropForeign([$pivotPermission]);
            $table->dropForeign([$pivotRole]);
        });

        Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) use ($pivotPermission) {
            $table->dropForeign([$pivotPermission]);
        });

        Schema::table($tableNames['model_has_roles'], function (Blueprint $table) use ($pivotRole) {
            $table->dropForeign([$pivotRole]);
        });

        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->dropPrimary();
        });
        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement()->change();
        });
        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->primary('id');
        });

        Schema::table($tableNames['roles'], function (Blueprint $table) {
            $table->dropPrimary();
        });
        Schema::table($tableNames['roles'], function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement()->change();
        });
        Schema::table($tableNames['roles'], function (Blueprint $table) {
            $table->primary('id');
        });

        Schema::table($tableNames['role_has_permissions'], function (Blueprint $table) use ($pivotPermission, $pivotRole) {
            $table->unsignedBigInteger($pivotPermission)->change();
            $table->unsignedBigInteger($pivotRole)->change();
        });

        Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) use ($pivotPermission) {
            $table->unsignedBigInteger($pivotPermission)->change();
        });

        Schema::table($tableNames['model_has_roles'], function (Blueprint $table) use ($pivotRole) {
            $table->unsignedBigInteger($pivotRole)->change();
        });

        Schema::table($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames, $pivotPermission, $pivotRole) {
            $table->foreign($pivotPermission)
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign($pivotRole)
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');
        });

        Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $pivotPermission) {
            $table->foreign($pivotPermission)
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');
        });

        Schema::table($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $pivotRole) {
            $table->foreign($pivotRole)
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');
        });
    }
};
