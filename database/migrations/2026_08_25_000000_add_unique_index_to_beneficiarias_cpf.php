<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beneficiarias', function (Blueprint $table) {
            $table->unique('cpf');
        });
    }

    public function down(): void
    {
        Schema::table('beneficiarias', function (Blueprint $table) {
            $table->dropUnique(['cpf']);
        });
    }
};
