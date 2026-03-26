<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('subscription_tier', ['free', 'pro', 'business'])->default('free')->after('email');
            $table->string('profile_photo_path')->nullable()->after('subscription_tier');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['subscription_tier', 'profile_photo_path']);
        });
    }
};
