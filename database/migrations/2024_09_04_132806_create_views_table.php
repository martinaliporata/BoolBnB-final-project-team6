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
        Schema::create('views', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');  // Usa string per l'IP
            $table->unsignedBigInteger('apartment_id'); // Relazione con l'appartamento
            $table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('cascade');
            $table->timestamps();  // Includi le colonne created_at e updated_at
            $table->unique(['ip_address', 'apartment_id']);  // IP unico per appartamento
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('views');
    }
};
