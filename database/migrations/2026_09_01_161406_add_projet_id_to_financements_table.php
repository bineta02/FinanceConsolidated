<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('financements', function (Blueprint $table) {
            // Ajoute la relation vers la table projets
            $table->foreignId('id_projet')->nullable()->after('id_bailleur')->constrained('projets')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('financements', function (Blueprint $table) {
            $table->dropForeign(['id_projet']);
            $table->dropColumn('id_projet');
        });
    }
};