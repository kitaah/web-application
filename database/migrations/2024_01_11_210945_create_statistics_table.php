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
            $table->integer('total_associations')->default(0);
            $table->integer('total_competitions')->default(0);
            $table->integer('total_games')->default(0);
            $table->integer('total_resources')->default(0);
            $table->integer('total_users')->default(0);
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
