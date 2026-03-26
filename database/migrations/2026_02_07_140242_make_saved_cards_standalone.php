<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('saved_cards', function (Blueprint $table) {
            // Make business_card_id nullable for manual clients
            $table->foreignId('business_card_id')->nullable()->change();

            // Add direct contact fields for manual clients
            $table->string('full_name')->nullable()->after('business_card_id');
            $table->string('email')->nullable()->after('full_name');
            $table->string('phone')->nullable()->after('email');
            $table->string('company_name')->nullable()->after('phone');
            $table->string('job_title')->nullable()->after('company_name');
            $table->string('website')->nullable()->after('job_title');
            $table->string('profile_photo_path')->nullable()->after('website');
        });
    }

    public function down(): void
    {
        Schema::table('saved_cards', function (Blueprint $table) {
            $table->dropColumn(['full_name', 'email', 'phone', 'company_name', 'job_title', 'website', 'profile_photo_path']);
        });
    }
};
