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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger("Stanze");
            $table->tinyInteger("Letti");
            $table->tinyInteger("Bagni");
            $table->smallInteger("Metri_quadrati");
            $table->text("Indirizzo");
            $table->decimal("Latitudine");
            $table->decimal("Longitudine");
            $table->text("Img");
            $table->boolean("Visibilità");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
