<?php

namespace App\Support\Visitor;

use App\Models\Visit;
use Illuminate\Database\Eloquent\Model;
use Shetabit\Visitor\Visitor;

/**
 * Substitui o Visitor do pacote para gravar os logs através de
 * App\Models\Visit, que cifra "request" e "headers".
 *
 * O pacote instancia Shetabit\Visitor\Models\Visit diretamente (e também
 * via relação visitLogs() do trait Visitable), por isso a gravação é
 * reimplementada aqui em vez de depender apenas da configuração.
 */
class EncryptedVisitor extends Visitor
{
    public function visit(?Model $model = null)
    {
        foreach ($this->except as $path) {
            if ($this->request->is($path)) {
                return;
            }
        }

        $visit = new Visit($this->prepareLog());

        if ($model !== null && method_exists($model, 'visitLogs')) {
            $visit->visitable()->associate($model);
        }

        $visit->save();

        return $visit;
    }
}
