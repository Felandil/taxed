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
        Schema::table('moveable_assets', function (Blueprint $table) {
            $table->foreignId('asset_category_id')
                ->nullable()
                ->constrained('asset_categories')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('moveable_assets', function (Blueprint $table) {
            $table->dropForeign(['asset_category_id']);
            $table->dropColumn('asset_category_id');
        });
    }
};
