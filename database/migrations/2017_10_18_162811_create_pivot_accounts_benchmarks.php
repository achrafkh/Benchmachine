<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotAccountsBenchmarks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_benchmark', function (Blueprint $table) {
            $table->integer('account_id')->unsigned();
            $table->integer('benchmark_id')->unsigned();
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('benchmark_id')->references('id')->on('benchmarks')->onDelete('cascade');

            $table->primary(['account_id', 'benchmark_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_benchmark');
    }
}
