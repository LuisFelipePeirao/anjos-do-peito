<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beneficiarias', function (Blueprint $table) {
            if (! Schema::hasColumn('beneficiarias', 'data_nascimento')) {
                $table->date('data_nascimento')->nullable()->after('telefone_alternativo');
            }

            if (! Schema::hasColumn('beneficiarias', 'observacao')) {
                $table->text('observacao')->nullable()->after('origem_cadastro');
            }
        });

        if (! Schema::hasTable('doadores')) {
            Schema::create('doadores', function (Blueprint $table) {
                $table->id();
                $table->string('nome');
                $table->string('telefone')->nullable();
                $table->string('email')->nullable();
                $table->text('observacao')->nullable();
            });
        }

        if (! Schema::hasTable('categorias_materiais')) {
            Schema::create('categorias_materiais', function (Blueprint $table) {
                $table->id();
                $table->string('nome');
                $table->boolean('ativo')->default(true);
            });
        }

        if (! Schema::hasTable('materiais')) {
            Schema::create('materiais', function (Blueprint $table) {
                $table->id();
                $table->string('nome');
                $table->foreignId('id_categoria')->constrained('categorias_materiais');
                $table->string('unidade_medida');
                $table->integer('estoque_minimo')->default(0);
            });
        }

        if (! Schema::hasTable('doacoes')) {
            Schema::create('doacoes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_doador')->constrained('doadores');
                $table->foreignId('id_usuario')->constrained('usuarios');
                $table->dateTime('data_doacao');
                $table->text('observacao')->nullable();
                $table->enum('situacao', ['recebida', 'cancelada'])->default('recebida');
            });
        }

        if (! Schema::hasTable('doacoes_itens')) {
            Schema::create('doacoes_itens', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_doacao')->constrained('doacoes')->cascadeOnDelete();
                $table->foreignId('id_material')->constrained('materiais');
                $table->integer('quantidade');
                $table->text('observacao')->nullable();
            });
        }

        if (! Schema::hasTable('distribuicoes')) {
            Schema::create('distribuicoes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_beneficiaria')->constrained('beneficiarias');
                $table->foreignId('id_usuario')->constrained('usuarios');
                $table->dateTime('data_hora');
                $table->enum('situacao', ['pendente', 'entregue', 'cancelada'])->default('pendente');
                $table->text('observacao')->nullable();
            });
        }

        if (! Schema::hasTable('distribuicoes_itens')) {
            Schema::create('distribuicoes_itens', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_distribuicao')->constrained('distribuicoes')->cascadeOnDelete();
                $table->foreignId('id_material')->constrained('materiais');
                $table->integer('quantidade');
                $table->text('observacao')->nullable();
            });
        }

        if (! Schema::hasTable('estoque_movimentacoes')) {
            Schema::create('estoque_movimentacoes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_material')->constrained('materiais');
                $table->enum('tipo', ['entrada', 'saida', 'ajuste']);
                $table->integer('quantidade');
                $table->dateTime('data_hora');
                $table->foreignId('id_usuario')->constrained('usuarios');
                $table->foreignId('id_doacao_item')->nullable()->constrained('doacoes_itens')->nullOnDelete();
                $table->foreignId('id_distribuicao_item')->nullable()->constrained('distribuicoes_itens')->nullOnDelete();
                $table->text('observacao')->nullable();
            });
        }

        if (! Schema::hasTable('modelos_bombas')) {
            Schema::create('modelos_bombas', function (Blueprint $table) {
                $table->id();
                $table->string('fabricante');
                $table->string('modelo');
                $table->text('descricao')->nullable();
            });
        }

        if (! Schema::hasTable('bomba_leite')) {
            Schema::create('bomba_leite', function (Blueprint $table) {
                $table->id();
                $table->string('codigo')->unique();
                $table->foreignId('id_modelo')->constrained('modelos_bombas');
                $table->string('num_serie')->nullable();
                $table->enum('situacao', ['disponivel', 'alugada', 'manutencao', 'baixada'])->default('disponivel');
                $table->date('data_aquisicao')->nullable();
                $table->enum('origem', ['compra', 'doacao', 'emprestimo'])->default('doacao');
                $table->foreignId('id_doador')->nullable()->constrained('doadores')->nullOnDelete();
                $table->text('acessorios')->nullable();
            });
        }

        if (! Schema::hasTable('cessoes_bombas')) {
            Schema::create('cessoes_bombas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_bomba')->constrained('bomba_leite');
                $table->foreignId('id_beneficiaria')->constrained('beneficiarias');
                $table->foreignId('id_usuario_retirada')->constrained('usuarios');
                $table->foreignId('id_usuario_devolucao')->nullable()->constrained('usuarios')->nullOnDelete();
                $table->enum('tipo', ['gratuita', 'aluguel'])->default('gratuita');
                $table->decimal('valor_mensalidade', 10, 2)->nullable();
                $table->dateTime('data_retirada');
                $table->date('data_prevista_devolucao')->nullable();
                $table->dateTime('data_devolucao')->nullable();
                $table->enum('situacao', ['ativa', 'finalizada', 'cancelada', 'atrasada'])->default('ativa');
                $table->text('observacao_retirada')->nullable();
                $table->text('observacao_devolucao')->nullable();
            });
        }

        if (! Schema::hasTable('pagamentos_alugueis')) {
            Schema::create('pagamentos_alugueis', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_cessao')->constrained('cessoes_bombas')->cascadeOnDelete();
                $table->date('competencia');
                $table->decimal('valor', 10, 2);
                $table->date('data_vencimento');
                $table->date('data_pagamento')->nullable();
                $table->enum('situacao', ['pendente', 'pago', 'cancelado', 'atrasado'])->default('pendente');
                $table->text('observacao')->nullable();
            });
        }

        if (! Schema::hasTable('manutencoes_bombas')) {
            Schema::create('manutencoes_bombas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_bomba')->constrained('bomba_leite');
                $table->foreignId('id_usuario')->constrained('usuarios');
                $table->dateTime('data_inicio');
                $table->dateTime('data_fim')->nullable();
                $table->enum('tipo', ['preventiva', 'corretiva', 'higienizacao']);
                $table->text('descricao');
                $table->enum('situacao', ['aberta', 'em_andamento', 'concluida', 'cancelada'])->default('aberta');
                $table->text('observacao')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('manutencoes_bombas');
        Schema::dropIfExists('pagamentos_alugueis');
        Schema::dropIfExists('cessoes_bombas');
        Schema::dropIfExists('bomba_leite');
        Schema::dropIfExists('modelos_bombas');
        Schema::dropIfExists('estoque_movimentacoes');
        Schema::dropIfExists('distribuicoes_itens');
        Schema::dropIfExists('distribuicoes');
        Schema::dropIfExists('doacoes_itens');
        Schema::dropIfExists('doacoes');
        Schema::dropIfExists('materiais');
        Schema::dropIfExists('categorias_materiais');
        Schema::dropIfExists('doadores');

        Schema::table('beneficiarias', function (Blueprint $table) {
            if (Schema::hasColumn('beneficiarias', 'observacao')) {
                $table->dropColumn('observacao');
            }

            if (Schema::hasColumn('beneficiarias', 'data_nascimento')) {
                $table->dropColumn('data_nascimento');
            }
        });
    }
};
