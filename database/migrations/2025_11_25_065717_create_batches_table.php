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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('category_id')->constrained();
            $table->foreignId('trainer_id')->constrained('users');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('zoom_link')->nullable();
            $table->integer('min_quota')->default(0);
            $table->integer('max_quota')->default(10);
            $table->enum('status', ['Scheduled', 'Ongoing', 'Completed'])->default('Scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
