<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('card_tag_saved_card', function (Blueprint $table) {
            $table->foreignId('saved_card_id')->constrained()->cascadeOnDelete();
            $table->foreignId('card_tag_id')->constrained()->cascadeOnDelete();

            $table->primary(['saved_card_id', 'card_tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('card_tag_saved_card');
    }
};
