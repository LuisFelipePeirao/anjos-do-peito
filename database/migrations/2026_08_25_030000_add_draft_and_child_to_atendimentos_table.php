<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('atendimentos', function (Blueprint $table) {
            $table->boolean('rascunho')->default(false)->after('situacao');
            $table->foreignId('id_crianca')->nullable()->after('id_beneficiaria')->constrained('criancas')->nullOnDelete();
            $table->dateTime('data_hora')->nullable()->change();
            $table->foreignId('id_usuario')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('atendimentos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('id_crianca');
            $table->dropColumn('rascunho');
            $table->dateTime('data_hora')->nullable(false)->change();
            $table->foreignId('id_usuario')->nullable(false)->change();
        });
    }
};
