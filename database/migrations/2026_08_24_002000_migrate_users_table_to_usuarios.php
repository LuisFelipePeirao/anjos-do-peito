<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('usuarios') && Schema::hasTable('users')) {
            Schema::rename('users', 'usuarios');
        }

        if (! Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->id();
                $table->string('nome');
                $table->string('email')->unique();
                $table->timestamp('email_verificado_em')->nullable();
                $table->string('senha');
                $table->enum('perfil', ['administrador', 'atendente', 'enfermeira']);
                $table->rememberToken();
                $table->timestamps();
                $table->softDeletes();
            });

            return;
        }

        if (Schema::hasColumn('usuarios', 'name') && ! Schema::hasColumn('usuarios', 'nome')) {
            DB::statement('ALTER TABLE usuarios CHANGE name nome VARCHAR(255) NOT NULL');
        }

        if (Schema::hasColumn('usuarios', 'email_verified_at') && ! Schema::hasColumn('usuarios', 'email_verificado_em')) {
            DB::statement('ALTER TABLE usuarios CHANGE email_verified_at email_verificado_em TIMESTAMP NULL');
        }

        if (Schema::hasColumn('usuarios', 'password') && ! Schema::hasColumn('usuarios', 'senha')) {
            DB::statement('ALTER TABLE usuarios CHANGE password senha VARCHAR(255) NOT NULL');
        }

        Schema::table('usuarios', function (Blueprint $table) {
            if (! Schema::hasColumn('usuarios', 'perfil')) {
                $table->enum('perfil', ['administrador', 'atendente', 'enfermeira'])
                    ->default('atendente')
                    ->after('senha');
            }

            if (! Schema::hasColumn('usuarios', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('usuarios')) {
            return;
        }

        Schema::table('usuarios', function (Blueprint $table) {
            if (Schema::hasColumn('usuarios', 'deleted_at')) {
                $table->dropSoftDeletes();
            }

            if (Schema::hasColumn('usuarios', 'perfil')) {
                $table->dropColumn('perfil');
            }
        });

        if (Schema::hasColumn('usuarios', 'nome') && ! Schema::hasColumn('usuarios', 'name')) {
            DB::statement('ALTER TABLE usuarios CHANGE nome name VARCHAR(255) NOT NULL');
        }

        if (Schema::hasColumn('usuarios', 'email_verificado_em') && ! Schema::hasColumn('usuarios', 'email_verified_at')) {
            DB::statement('ALTER TABLE usuarios CHANGE email_verificado_em email_verified_at TIMESTAMP NULL');
        }

        if (Schema::hasColumn('usuarios', 'senha') && ! Schema::hasColumn('usuarios', 'password')) {
            DB::statement('ALTER TABLE usuarios CHANGE senha password VARCHAR(255) NOT NULL');
        }

        if (! Schema::hasTable('users')) {
            Schema::rename('usuarios', 'users');
        }
    }
};
