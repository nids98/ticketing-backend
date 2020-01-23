<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task', function (Blueprint $table) {
            $table->bigIncrements('task_id');
            $table->integer('subcategory_id');
            $table->mediumText('desc');
            $table->enum('status', array('pending', 'completed'));
            $table->integer('tech_id');
            $table->foreign('subcategory_id')->references('subcategory_id')->on('subcategory')->onDelete('cascade');
            $table->foreign('tech_id')->references('tech_id')->on('technician')->onDelete('cascade');
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
        Schema::dropIfExists('tasks');
    }
}
