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
        Schema::create('galleries_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('gallery_id')->nullable();
            $table->unsignedBigInteger('tag_id')->nullable();

            $table->foreign('gallery_id')
                ->references('id')->on('galleries')
                ->cascadeOnDelete();

            $table->foreign('tag_id')
                ->references('id')->on('tags')
                ->cascadeOnDelete();

            $table->primary(['gallery_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries_tags');
    }
};
