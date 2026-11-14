<?php

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Cifra (APP_KEY) as colunas "request" e "headers" dos logs de visita já
 * existentes. Novos registros são cifrados por App\Models\Visit.
 *
 * "headers" passa a mediumText porque o payload cifrado (base64 + IV + MAC)
 * é maior que o JSON original e pode estourar o limite de 64KB do TEXT.
 */
return new class extends Migration
{
    private const COLUMNS = ['request', 'headers'];

    public function up(): void
    {
        $table = config('visitor.table_name', 'shetabit_visits');

        Schema::table($table, function (Blueprint $blueprint) {
            $blueprint->mediumText('headers')->nullable()->change();
        });

        $this->transform($table, function (string $value): ?string {
            return $this->isEncrypted($value) ? null : Crypt::encryptString($value);
        });
    }

    public function down(): void
    {
        $table = config('visitor.table_name', 'shetabit_visits');

        $this->transform($table, function (string $value): ?string {
            return $this->isEncrypted($value) ? Crypt::decryptString($value) : null;
        });

        // "headers" é mantido como mediumText: reduzir para TEXT poderia
        // truncar registros gravados após esta migration.
    }

    /**
     * Aplica $callback a cada valor não nulo; retorno null = manter como está.
     */
    private function transform(string $table, callable $callback): void
    {
        DB::table($table)
            ->select(array_merge(['id'], self::COLUMNS))
            ->orderBy('id')
            ->chunkById(500, function ($rows) use ($table, $callback) {
                foreach ($rows as $row) {
                    $changes = [];

                    foreach (self::COLUMNS as $column) {
                        if ($row->{$column} === null || $row->{$column} === '') {
                            continue;
                        }

                        $new = $callback($row->{$column});

                        if ($new !== null) {
                            $changes[$column] = $new;
                        }
                    }

                    if ($changes) {
                        DB::table($table)->where('id', $row->id)->update($changes);
                    }
                }
            });
    }

    private function isEncrypted(string $value): bool
    {
        try {
            Crypt::decryptString($value);

            return true;
        } catch (DecryptException) {
            return false;
        }
    }
};
