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
        Schema::create('statistics', static function (Blueprint $table) {
            $table->id();
            $table->integer('total_associations')->nullable(false);
            $table->integer('total_competitions')->nullable(false);
            $table->integer('total_games')->nullable(false);
            $table->integer('total_resources')->nullable(false);
            $table->integer('total_users')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};
