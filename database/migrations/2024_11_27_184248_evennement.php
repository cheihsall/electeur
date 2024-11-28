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
        Schema::connection('mongodb')->create('youngs', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date');
            $table->string('id_card_number')->nullable();
            $table->boolean('is_elector')->default(false);
            $table->string('phone');
            $table->string('email');
            $table->json('address');
            $table->json('documents')->nullable(); // Stocke les URLs
            $table->foreignId('admin_id')->constrained(); // Association avec Admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
