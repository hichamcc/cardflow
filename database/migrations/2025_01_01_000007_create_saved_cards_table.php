<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('business_card_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('saved_from_user_id')->nullable();
            $table->text('custom_note')->nullable();
            $table->foreignId('folder_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('last_contacted_at')->nullable();
            $table->enum('contact_frequency', ['never', 'low', 'medium', 'high'])->default('never');
            $table->enum('relationship_status', ['lead', 'prospect', 'client', 'partner', 'other'])->default('lead');
            $table->timestamps();

            $table->foreign('saved_from_user_id')->references('id')->on('users')->nullOnDelete();
            $table->index(['user_id', 'business_card_id']);
            $table->index('folder_id');
            $table->index('relationship_status');
            $table->unique(['user_id', 'business_card_id']); // prevent duplicate saves
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_cards');
    }
};
