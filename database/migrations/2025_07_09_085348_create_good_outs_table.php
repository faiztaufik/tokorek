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
        Schema::create('good_outs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('good_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->date('date_out');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('good_outs');
    }
};
