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
        Schema::create('reels_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('path');
            $table->text('thumbnail');
            $table->integer('views');
            $table->integer('duration')->nullable(); // Duration of the reel (optional)
            $table->boolean('is_featured')->default(false); // Optional: featured status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reels_uploads');
    }
};
