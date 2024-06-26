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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // this is the user id
            $table->unsignedBigInteger('post_id'); // this is the post id
            $table->text('body'); // this is the body of the comment
            $table->timestamps();

            // this is the foreign key constraint
            $table->foreign('user_id')->references('id')->on('users'); // this is the user id
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade'); // this is the post id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
