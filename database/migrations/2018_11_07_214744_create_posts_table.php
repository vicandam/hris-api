<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->text('description')->nullable();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('video', 255)->nullable();
            $table->integer('total_view')->default(1);
            $table->enum('type', ['photo', 'video', 'text'])->default('photo');
            $table->enum('status', ['public', 'private'])->default('public');

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
