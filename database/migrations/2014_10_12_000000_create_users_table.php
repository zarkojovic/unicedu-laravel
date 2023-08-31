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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('password');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('profile_image')->default('profile.jpg');
            $table->string('phone');
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->unsignedBigInteger('role_id')->default('1');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedBigInteger('agency_id')->nullable();
            $table->unsignedBigInteger('responsible_id')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->timestamps();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
