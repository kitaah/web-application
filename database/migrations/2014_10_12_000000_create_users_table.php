<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', static function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('city', 50)->nullable();
            $table->string('email', 50)->unique();
            $table->string('mood', 50)->nullable();
            $table->integer('points')->nullable(false)->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->boolean('terms_accepted')->nullable()->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
