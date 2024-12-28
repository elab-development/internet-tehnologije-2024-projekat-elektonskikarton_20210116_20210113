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
        Schema::create('ustanovas', function (Blueprint $table) {
            $table->id();

            $table->string('naziv');
            $table->string('ulica');
            $table->foreignIdFor(Mesto::class)->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ustanovas');
    }
};
