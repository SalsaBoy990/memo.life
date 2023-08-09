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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->enum('status', ['public', 'private'])->default('private');
            $table->string('title')->unique();
            $table->text('story');
            $table->string('cover_image');
            $table->string('thumbnail_image');
            $table->date('start');
            $table->date('end')->nullable();
            $table->string('location')->nullable();
            $table->double('latitude', 20, 14)->nullable();
            $table->double('longitude', 20, 14)->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
