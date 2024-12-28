<?php

use App\Models\Mesto;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pacijents', function (Blueprint $table) {

            $table->string('jmbg')->primary();

            $table->string('email')->unique();
            $table->string('password');
            $table->string('imePrezime');
            $table->string('imePrezimeNZZ');
            $table->date('datumRodjenja');
            $table->string('ulicaBroj');
            $table->string('telefon');
            $table->enum('pol',['muski','zenski']);
            $table->enum('bracniStatus',['u braku','nije u braku']);
            $table->foreignIdFor(Mesto::class)->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacijents');
    }
};
