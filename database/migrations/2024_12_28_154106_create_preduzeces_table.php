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
            $table->integer('mesto_postanskiBroj');
            $table->foreign('mesto_postanskiBroj')->references('postanskiBroj')->on('mestos');

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
