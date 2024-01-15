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
        Schema::create('competitions', static function (Blueprint $table) {
            $table->id();
            $table->string('identification', 50)->nullable(false)->unique();
            $table->string('slug', 50)->nullable(false)->unique();
            $table->decimal('budget', 8, 2)->nullable(false)->default(0);
            $table->string('status', 50)->nullable(false);
            $table->date('start_date')->nullable(false);
            $table->date('end_date')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
