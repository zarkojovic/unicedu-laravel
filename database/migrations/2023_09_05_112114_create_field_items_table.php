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

        Schema::create('field_items', function (Blueprint $table) {
            $table->id('field_item_id');
            $table->string("item_value");
            $table->string("item_id");
            $table->unsignedBigInteger('field_id');
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'FieldItemSeeder',
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_items');
    }
};
