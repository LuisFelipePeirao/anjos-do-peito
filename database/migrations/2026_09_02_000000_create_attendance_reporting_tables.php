<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procedimentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->text('descricao')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        Schema::create('categorias_atendimento', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->text('descricao')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        Schema::table('atendimentos', function (Blueprint $table) {
            $table->foreignId('id_categoria_atendimento')
                ->nullable()
                ->after('id_crianca')
                ->constrained('categorias_atendimento')
                ->nullOnDelete();
            $table->foreignId('id_procedimento')
                ->nullable()
                ->after('id_categoria_atendimento')
                ->constrained('procedimentos')
                ->nullOnDelete();
        });

        Schema::table('locais_atendimento', function (Blueprint $table) {
            if (! Schema::hasColumn('locais_atendimento', 'ativo')) {
                $table->boolean('ativo')->default(true)->after('descricao');
            }
        });
    }

    public function down(): void
    {
        Schema::table('atendimentos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('id_procedimento');
            $table->dropConstrainedForeignId('id_categoria_atendimento');
        });

        Schema::table('locais_atendimento', function (Blueprint $table) {
            if (Schema::hasColumn('locais_atendimento', 'ativo')) {
                $table->dropColumn('ativo');
            }
        });

        Schema::dropIfExists('categorias_atendimento');
        Schema::dropIfExists('procedimentos');
    }
};
