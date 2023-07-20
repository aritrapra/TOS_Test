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
        Schema::create('users', function (Blueprint $table) {
            $table->string('user_id',256);
            $table->string('email',256);
            $table->string('phone',20);
            $table->string('password',256);
            $table->string('first_name',100)->nullable();
            $table->string('last_name',100)->nullable();
            $table->string('role',10)->default('editor');
            $table->string('access_token',256);
            $table->dateTime('token_exp');
            $table->timestamps();
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
