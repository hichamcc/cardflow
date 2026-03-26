<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('card_name'); // e.g., "Work", "Freelance"
            $table->string('full_name');
            $table->string('job_title')->nullable();
            $table->string('company_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('profile_photo_path')->nullable();
            $table->string('company_logo_path')->nullable();
            $table->text('bio')->nullable();
            $table->string('theme_color', 7)->default('#3B82F6');
            $table->string('layout_style')->default('classic');
            $table->boolean('is_active')->default(true);
            $table->string('slug')->unique();
            $table->unsignedInteger('view_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('is_active');
            $table->fullText(['full_name', 'job_title', 'company_name', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_cards');
    }
};
