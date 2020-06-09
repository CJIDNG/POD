<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatatagsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('datatags', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('name')->unique();
      $table->softDeletes();
      $table->timestamps();
    });

    Schema::create('datatag_datatopic', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('datatag_id');
      $table->unsignedBigInteger('datatopic_id');
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
    Schema::dropIfExists('datatags');
  }
}
