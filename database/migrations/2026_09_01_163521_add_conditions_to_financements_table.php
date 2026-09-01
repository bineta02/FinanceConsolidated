<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('financements', function (Blueprint $table) {
            // Remplacer 'montant' par 'montant_accorde' ou retirer ->after()
            $table->text('conditions')->nullable()->after('montant_accorde');
        });
    }

    public function down(): void
    {
        Schema::table('financements', function (Blueprint $table) {
            $table->dropColumn('conditions');
        });
    }
};