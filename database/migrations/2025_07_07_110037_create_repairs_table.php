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
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            // Identification
            $table->string('receipt_code')->unique();

            // Date Information
            $table->date('date_in');
            $table->date('date_taken_back')->nullable();

            // Service Details
            $table->string('customer_name');
            $table->string('customer_phone_number');
            $table->text('customer_complaint');
            $table->text('problem')->nullable();
            $table->enum('service_state', ['checking', 'in progress', 'done', 'taken back'])->default('checking');

            // Relationships
            $table->foreignId('technician_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('laptop_id')->constrained()->cascadeOnDelete();
            $table->string('model');

            // Financial
            $table->decimal('total_price', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
