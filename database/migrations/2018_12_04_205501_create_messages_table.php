<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('recipient_id')->unsigned()->nullable();
            $table->text('message')->nullable();
            $table->string('subject', 191)->nullable();
            $table->string('project_name', 191)->nullable();
            $table->string('email', 191)->nullable();
            $table->string('skype_id', 191)->nullable();
            $table->string('name', 191)->nullable();
            $table->enum('status', ['active', 'pending'])->default('active');
            $table->enum('type', ['feedback', 'contact', 'comment', 'question'])->default('feedback');
            $table->string('category')->nullable();
            $table->integer('hours')->nullable();
//            $table->string('others')->nullable();
            $table->text('others')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
