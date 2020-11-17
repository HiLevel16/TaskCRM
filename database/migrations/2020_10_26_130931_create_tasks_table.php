<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Tasks table

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('projectId')->default(1)->unsigned();
            $table->foreign('projectId')->references('id')->on('projects');
            $table->integer('fromId')->default(1)->unsigned(); // The user who created this task
            $table->foreign('fromId')->references('id')->on('users');
            $table->integer('paymentSystemId')->default(1)->unsigned(); // The user who created this task
            $table->foreign('paymentSystemId')->references('id')->on('payment_systems');
            $table->integer('category')->default(1)->unsigned(); // The user who created this task
            $table->foreign('category')->references('id')->on('task_category');
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('amount');
            $table->string('status')->default('pending');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('tasks');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
