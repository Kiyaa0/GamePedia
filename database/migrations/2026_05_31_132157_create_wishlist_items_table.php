<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('wishlist_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('rawg_game_id');
            $table->string('game_title');
            $table->string('game_image')->nullable();
            $table->enum('status', ['want_to_buy', 'owned', 'playing'])->default('want_to_buy');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'rawg_game_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlist_items');
    }
};
