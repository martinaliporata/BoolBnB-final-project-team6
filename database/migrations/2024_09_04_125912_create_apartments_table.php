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
            $table->string("Nome");
            $table->tinyInteger("Stanze");
            $table->tinyInteger("Letti");
            $table->tinyInteger("Bagni");
            $table->smallInteger("Metri_quadrati");
            $table->mediumInteger("Prezzo");
            $table->text("Indirizzo");
            $table->decimal("Latitudine", 10,6);
            $table->decimal("Longitudine", 10,6);
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
