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
        Schema::create('associations', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name', 50)->nullable(false)->unique();
            $table->string('slug', 50)->nullable(false)->unique();
            $table->text('description')->nullable(false);
            $table->text('project')->nullable(false);
            $table->string('siret', 14)->nullable(false)->unique();
            $table->string('department', 50)->nullable(false);
            $table->string('address', 50)->nullable(false)->unique();
            $table->string('url', 255)->nullable(false)->unique();
            $table->json('contact_information')->nullable(false);
            $table->integer('points')->default(0);
            $table->boolean('is_winner')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('associations');
    }
};
