<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cessoes_bombas', function (Blueprint $table) {
            $table->unsignedTinyInteger('dia_vencimento')->nullable()->after('valor_mensalidade');
            $table->string('forma_cobranca', 20)->nullable()->after('dia_vencimento');
            $table->date('primeira_cobranca_em')->nullable()->after('forma_cobranca');
            $table->date('proxima_cobranca_em')->nullable()->after('primeira_cobranca_em');
        });

        Schema::table('pagamentos_alugueis', function (Blueprint $table) {
            $table->unique(['id_cessao', 'competencia'], 'pagamentos_alugueis_cessao_competencia_unique');
        });
    }

    public function down(): void
    {
        Schema::table('pagamentos_alugueis', function (Blueprint $table) {
            $table->dropUnique('pagamentos_alugueis_cessao_competencia_unique');
        });

        Schema::table('cessoes_bombas', function (Blueprint $table) {
            $table->dropColumn(['dia_vencimento', 'forma_cobranca', 'primeira_cobranca_em', 'proxima_cobranca_em']);
        });
    }
};
