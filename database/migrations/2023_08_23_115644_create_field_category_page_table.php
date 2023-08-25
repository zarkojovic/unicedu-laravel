<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('field_category_page', function (Blueprint $table) {
            $table->id('field_category_role_id');
            $table->unsignedBigInteger('field_category_id');
            $table->unsignedBigInteger('page_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_category_role');
    }
};
