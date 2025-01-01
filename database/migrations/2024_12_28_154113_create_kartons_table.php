<?php

use App\Models\Pacijent;
use App\Models\Ustanova;
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
        Schema::create('kartons', function (Blueprint $table) {
            $table->id();

            $table->string('brojKnjizice')->unique();
            $table->text('napomene');
            $table->foreignIdFor(Ustanova::class)->constrained();
            $table->string('pacijent_jmbg');

            $table->foreign('pacijent_jmbg')->references('jmbg')->on('pacijents');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartons');
    }
};
