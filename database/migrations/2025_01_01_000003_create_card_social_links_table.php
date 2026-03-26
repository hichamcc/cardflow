<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('card_social_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_card_id')->constrained()->cascadeOnDelete();
            $table->string('platform'); // linkedin, twitter, instagram, github, etc.
            $table->string('url');
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->timestamps();

            $table->index('business_card_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('card_social_links');
    }
};
