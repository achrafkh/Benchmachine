<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->string('id')->primary();

            $table->integer('user_id')->index()->unsigned()->nullable();

            $table->integer('invited_id')->index()->unsigned()->nullable();
            $table->string('invited_email')->index()->nullable();

            $table->enum('type', ['once', 'manual', 'auto'])->index()->default('manual');
            $table->integer('max')->nullable();

            $table->dateTime('used_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('invited_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitations');
    }
}
