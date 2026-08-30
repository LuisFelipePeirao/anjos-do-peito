<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locais_atendimento', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->foreignId('id_endereco')->nullable()->constrained('enderecos');
            $table->text('descricao')->nullable();
            $table->timestamps();
        });

        Schema::create('atendimentos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('data_hora');
            $table->time('duracao_prevista')->nullable();
            $table->enum('modalidade', ['presencial', 'remota'])->default('presencial');
            $table->foreignId('id_local')->nullable()->constrained('locais_atendimento');
            $table->enum('situacao', ['agendado', 'em_atendimento', 'realizado', 'cancelado'])->default('agendado');
            $table->foreignId('id_beneficiaria')->constrained('beneficiarias');
            $table->foreignId('id_usuario')->constrained('usuarios');
            $table->timestamps();
        });

        Schema::create('atendimento_detalhes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_atendimento')->constrained('atendimentos')->cascadeOnDelete();
            $table->string('resumo')->nullable();
            $table->text('objetivo')->nullable();
            $table->text('queixa')->nullable();
            $table->text('avaliacao')->nullable();
            $table->text('conduta')->nullable();
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atendimento_detalhes');
        Schema::dropIfExists('atendimentos');
        Schema::dropIfExists('locais_atendimento');
    }
};
