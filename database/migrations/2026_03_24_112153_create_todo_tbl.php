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
        Schema::create('todo_tbl', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid_todo_id')->unique();

            $table->unsignedBigInteger('created_by_number_user_id')->nullable();
            $table->uuid('created_by_uuid_user_id')->nullable();

            $table->string('title');
            $table->text('description');
            $table->enum('status', ['todo', 'in_progress', 'done']);

            $table->timestamp('expired_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by_number_user_id')
                ->references('id')
                ->on('users_account_tbl')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo_tbl');
    }
};
