<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('portal_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('action');
            $table->text('description');
            $table->timestamps();
            // relation
            $table->foreign('portal_id')
                  ->references('id')
                  ->on('portal')
                  ->onUpdate('cascade')
                  ->onDelete('no action');
             $table->foreign('user_id')
                  ->references('id')
                  ->on('user_login')
                  ->onUpdate('cascade')
                  ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
