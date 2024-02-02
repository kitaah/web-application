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
        Schema::create('create_competitions', static function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable(false)->unique();
            $table->string('slug', 50)->nullable(false)->unique();
            $table->foreignId('association_id')->constrained()->onDelete('cascade');
            $table->foreignId('association_id_second')->constrained()->onDelete('cascade');
            $table->foreignId('association_id_third')->constrained()->onDelete('cascade');
            $table->foreignId('competition_id')->constrained()->onDelete('cascade');
            $table->boolean('is_published')->default(false);
            $table->string('status', 50)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('create_competitions');
    }
};
