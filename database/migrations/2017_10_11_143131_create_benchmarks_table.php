<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenchmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benchmarks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->unsigned()->nullable();
            $table->string('title')->defaul('My benchmark');
            $table->string('temp_id')->nullable();
            $table->integer('status')->index();
            $table->date('since')->index();
            $table->date('until')->index();
            $table->timestamps();

            $table->index(['created_at', 'status']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('benchmarks');
    }
}
