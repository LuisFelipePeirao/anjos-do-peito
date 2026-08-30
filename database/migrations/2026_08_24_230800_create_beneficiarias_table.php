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
        Schema::create('beneficiarias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf');
            $table->string('email');
            $table->string('telefone');
            $table->string('telefone_alternativo');
            $table->enum('situacao', ['ativo', 'inativo'])->default('inativo');
            $table->foreignId('id_endereco')->nullable()->constrained('enderecos');
            $table->string('origem_cadastro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiarias');
    }
};
