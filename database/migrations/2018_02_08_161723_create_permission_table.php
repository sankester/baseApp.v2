<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('portal_id')->unsigned();
            $table->string('permission_nm');
            $table->string('permission_group');
            $table->string('permission_slug');
            $table->string('permission_desc');
            $table->timestamps();
            // set foreign key
            $table->foreign('portal_id')
                  ->references('id')
                  ->on('portal')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
        // create pivot table role permission
        Schema::create('role_permission', function (Blueprint $table){
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')
                  ->references('id')
                  ->on('role')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->integer('permission_id')->unsigned();
            $table->foreign('permission_id')
                  ->references('id')
                  ->on('permission')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->timestamps();
        });
        // create pivot table menu permission
        Schema::create('menu_permission', function (Blueprint $table){
            $table->integer('menu_id')->unsigned();
            $table->foreign('menu_id')
                ->references('id')
                ->on('menu')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('permission_id')->unsigned();
            $table->foreign('permission_id')
                ->references('id')
                ->on('permission')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('permission');
        // drop pivot table
        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('menu_permission');
    }
}
