<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portal', function (Blueprint $table) {
            $table->increments('id');
            $table->string('portal_nm');
            $table->string('site_title');
            $table->string('site_name');
            $table->string('site_favicon');
            $table->string('site_logo');
            $table->string('meta_keyword');
            $table->text('meta_desc');
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
        Schema::dropIfExists('portal');
    }
}
