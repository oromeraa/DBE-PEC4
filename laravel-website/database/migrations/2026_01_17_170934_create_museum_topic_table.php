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
        Schema::create('museum_topic', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('museum_id');
            $table->unsignedBigInteger('topic_id');
            // $table->primary(['museum_id', 'topic_id']);
            $table->foreign('museum_id')->references('id')->on('museums')->onDelete('cascade');
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('museum_topic');
    }
};
