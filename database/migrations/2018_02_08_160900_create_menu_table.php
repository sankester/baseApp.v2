<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('portal_id')->unsigned();
            $table->integer('parent_id')->unsigned();
            $table->string('menu_title');
            $table->string('menu_desc');
            $table->string('menu_url');
            $table->string('menu_group')->nullable();
            $table->integer('menu_nomer');
            $table->enum('active_st',['yes','no']);
            $table->enum('display_st',['yes','no']);
            $table->string('menu_st');
            $table->string('menu_icon')->nullable();
            $table->enum('menu_target',['self','blank']);
            $table->timestamps();
            // sert relation
            $table->foreign('portal_id')
                  ->references('id')
                  ->on('portal')
                  ->onUpdate('cascade')
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
        Schema::dropIfExists('menu');
    }
}
