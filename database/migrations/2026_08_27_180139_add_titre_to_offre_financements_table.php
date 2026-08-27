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
    Schema::table('offre_financements', function (Blueprint $table) {
        $table->string('titre')->after('id_bailleur');
    });
}

public function down(): void
{
    Schema::table('offre_financements', function (Blueprint $table) {
        $table->dropColumn('titre');
    });
}
};
