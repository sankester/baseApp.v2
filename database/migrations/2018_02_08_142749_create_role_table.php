<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('portal_id')->unsigned();
            $table->string('role_nm');
            $table->string('role_prioritas');
            $table->string('role_desc');
            $table->string('default_page');
            $table->timestamps();
            // set relation
            $table->foreign('portal_id')
                  ->references('id')
                  ->on('portal')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
        // pivot table
        Schema::create('user_role', function(Blueprint $table){
            $table->integer('user_login_id')->unsigned()->index();
            $table->foreign('user_login_id')->references('id')->on('user_login')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('role_id')->unsigned()->index();
            $table->foreign('role_id')->references('id')->on('role')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('role');
        Schema::dropIfExists('user_role');
    }
}
