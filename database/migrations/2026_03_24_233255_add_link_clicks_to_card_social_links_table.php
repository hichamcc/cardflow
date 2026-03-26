<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('card_social_links', function (Blueprint $table) {
            $table->unsignedInteger('link_clicks')->default(0)->after('display_order');
        });
    }

    public function down(): void
    {
        Schema::table('card_social_links', function (Blueprint $table) {
            $table->dropColumn('link_clicks');
        });
    }
};
