<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Colunas introduzidas pelo shetabit/visitor v5.
 *
 * "route_name" é gravado em toda visita (obrigatória). "extra_attributes"
 * é opcional (visit($model, [...])). As migrations do pacote não são
 * publicadas porque posicionam "extra_attributes" após "geo_raw", coluna
 * que esta tabela não possui.
 */
return new class extends Migration
{
    public function up(): void
    {
        $table = config('visitor.table_name', 'shetabit_visits');

        Schema::table($table, function (Blueprint $blueprint) use ($table) {
            if (! Schema::hasColumn($table, 'route_name')) {
                $blueprint->string('route_name')->nullable()->after('url')->index();
            }

            if (! Schema::hasColumn($table, 'extra_attributes')) {
                $blueprint->json('extra_attributes')->nullable()->after('ip');
            }
        });
    }

    public function down(): void
    {
        $table = config('visitor.table_name', 'shetabit_visits');

        Schema::table($table, function (Blueprint $blueprint) use ($table) {
            if (Schema::hasColumn($table, 'route_name')) {
                $blueprint->dropIndex(['route_name']);
                $blueprint->dropColumn('route_name');
            }

            if (Schema::hasColumn($table, 'extra_attributes')) {
                $blueprint->dropColumn('extra_attributes');
            }
        });
    }
};
