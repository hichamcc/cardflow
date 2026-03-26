<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('saved_card_id')->constrained()->cascadeOnDelete();
            $table->enum('interaction_type', ['email', 'call', 'meeting', 'note']);
            $table->string('subject')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('interaction_date');
            $table->timestamps();

            $table->index(['user_id', 'saved_card_id']);
            $table->index('interaction_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interactions');
    }
};
