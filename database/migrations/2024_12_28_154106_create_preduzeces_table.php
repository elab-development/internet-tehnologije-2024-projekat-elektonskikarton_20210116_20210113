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
        Schema::create('preduzeces', function (Blueprint $table) {

            $table->integer('registarskiBroj')->primary();
            $table->string('naziv');
            $table->integer('sifraDelatnosti');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preduzeces');
    }
};
