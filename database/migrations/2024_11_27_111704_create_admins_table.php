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
        Schema::connection('mongodb')->create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nom d'utilisateur unique
            $table->string('password'); // Mot de passe
            $table->enum('role', ['Admin', 'Agent'])->default('Agent'); // Rôle (Admin ou Agent)
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete(); // Lieu d'affectation (relation avec une table "locations")
            $table->json('assignment_history')->nullable(); // Historique des affectations
            $table->json('address')->nullable(); // Adresse (format JSON pour inclure plusieurs champs comme ville, rue, etc.)
            $table->string('email')->unique(); // Email unique
            $table->string('phone')->nullable(); // Numéro de téléphone
            $table->string('id_card_number')->nullable(); // Numéro de téléphone
            $table->date('birth_date')->nullable(); // Date de naissance
            $table->timestamps(); // Timestamps : created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('admins');
    }
};
