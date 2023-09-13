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
        Schema::create('pages', function (Blueprint $table) {
            $table->id('page_id');
            $table->string('route');
            $table->string('title');
            $table->string('icon');
            $table->unsignedBigInteger('role_id');
            $table->boolean('is_editable')->default(true);
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'PageSeeder',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
