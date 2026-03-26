<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('card_custom_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_card_id')->constrained()->cascadeOnDelete();
            $table->string('field_name');
            $table->string('field_value');
            $table->string('icon')->nullable();
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->timestamps();

            $table->index('business_card_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('card_custom_fields');
    }
};
