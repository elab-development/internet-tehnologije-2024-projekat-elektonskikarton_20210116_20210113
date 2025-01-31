<?php

use App\Models\Doktor;
use App\Models\Karton;
use App\Models\Sestra;
use App\Models\Terapija;
use App\Models\Dijagnoza;
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
        Schema::create('pregleds', function (Blueprint $table) {
            $table->unsignedBigInteger('redniBroj', true);
            $table->date('datum');
            $table->primary('redniBroj', 'datum');

            $table->foreignIdFor(Doktor::class)->constrained();
            $table->foreignIdFor(Sestra::class)->constrained();
            $table->foreignIdFor(Terapija::class)->constrained();
            $table->foreignIdFor(Dijagnoza::class)->constrained();
            $table->foreignIdFor(Karton::class)->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregleds');
    }
};
