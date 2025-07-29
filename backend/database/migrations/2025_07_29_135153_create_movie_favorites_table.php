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
        Schema::create('movie_favorites', function (Blueprint $table) {
            $table->id();
            $table->string('tmdb_id')->unique();
            $table->string('title');
            $table->string('poster_path')->nullable();
            $table->float('vote_average')->nullable();
            $table->json('genre_ids')->nullable();
            $table->text('genres')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_favorites');
    }
};
