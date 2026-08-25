<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::connection()->getDriverName() !== 'mysql') {
            return;
        }

        $legacyPendingReturn = 'retorno'.'_pendente';

        DB::table('atendimentos')
            ->where('situacao', $legacyPendingReturn)
            ->update(['situacao' => 'agendado']);

        DB::statement("ALTER TABLE atendimentos MODIFY situacao ENUM('agendado', 'em_atendimento', 'realizado', 'cancelado') NOT NULL DEFAULT 'agendado'");
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE atendimentos MODIFY situacao ENUM('agendado', 'realizado', 'cancelado') NOT NULL DEFAULT 'agendado'");
    }
};
