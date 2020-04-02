<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackerItemsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tracker_items', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('tracker_id');
      $table->string('title');
      $table->unsignedBigInteger('location_id')->nullable();
      $table->string('location_type')->nullable();
      $table->json('meta');
      $table->boolean('confirmed');
      $table->unsignedBigInteger('user_id');
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
    Schema::dropIfExists('tracker_items');
  }
}
