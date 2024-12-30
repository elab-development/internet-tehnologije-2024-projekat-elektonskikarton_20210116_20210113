<?php

use App\Models\Karton;
use App\Models\Preduzece;
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
        Schema::create('zaposlenjes', function (Blueprint $table) {
            $table->unsignedBigInteger('redniBroj', true);

            $table->foreignIdFor(Preduzece::class)->constrained();
            $table->foreignIdFor(Karton::class)->constrained();
            $table->primary(['redniBroj','karton_id']);
            $table->string('posao');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zaposlenjes');
    }
};
