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
        Schema::table('apartments', function (Blueprint $table) {

            $table->unsignedBigInteger('consumer_id')->after('id')->nullable();

            $table->foreign('consumer_id')->references('id')->on('consumers')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apartments', function (Blueprint $table) {

            $table->dropForeign('apartments_consumer_id_foreign');

            $table->dropColumn('consumer_id');
        });
    }
};
