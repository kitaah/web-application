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
        Schema::create('resources', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name', 50)->nullable(false)->unique();
            $table->string('slug', 50)->nullable(false)->unique();
            $table->string('description', 5000)->nullable(false);
            $table->string('url', 255)->nullable();
            $table->boolean('is_validated')->default(false);
            $table->string('status', 50)->nullable(false)->default('En attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
