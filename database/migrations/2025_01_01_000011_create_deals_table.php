<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('saved_card_id')->constrained()->cascadeOnDelete();
            $table->string('deal_name');
            $table->decimal('deal_value', 12, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->enum('stage', ['lead', 'negotiation', 'closed_won', 'closed_lost'])->default('lead');
            $table->date('expected_close_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'stage']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
