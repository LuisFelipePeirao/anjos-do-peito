<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beneficiarias', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void
    {
        if (DB::table('beneficiarias')->whereNull('email')->exists()) {
            throw new \RuntimeException('Não é possível reverter: há beneficiárias sem e-mail.');
        }

        Schema::table('beneficiarias', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
        });
    }
};
