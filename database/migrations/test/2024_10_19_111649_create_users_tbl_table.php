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
        Schema::create('users_tbl', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid_user_id')->unique();

            $table->longText('email')->nullable();
            $table->longText('email_hash')->nullable();

            $table->longText('password');

            $table->longText('verification_number_register')->nullable();

            $table->timestamp('phone_number_verified_at')->nullable();

            $table->timestamp('account_verified_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_tbl');
    }
};
