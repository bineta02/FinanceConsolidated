<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financement_id')->constrained('financements')->onDelete('cascade');
            $table->timestamp('date_signature')->nullable();
            $table->string('fichier_url');
            $table->text('contenu');
            $table->enum('statut', ['brouillon', 'signe', 'annule'])->default('brouillon');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contrats');
    }
};