<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bailleurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_utilisateur')->constrained('users')->onDelete('cascade');
            $table->decimal('capital', 15, 2);
            $table->decimal('montant_max_projet', 15, 2);
            $table->text('secteurs_preferes');
            $table->enum('types_bailleurs', ['particulier', 'institution', 'banque', 'ong']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bailleurs');
    }
};