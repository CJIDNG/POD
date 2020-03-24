<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatformSubapp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_subapp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('platform_id');
            $table->unsignedBigInteger('subapp_id');
            $table->timestamps();

            $table->foreign('platform_id')->references('id')->on('platforms');
            $table->foreign('subapp_id')->references('id')->on('subapps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('platform_subapp');
    }
}
