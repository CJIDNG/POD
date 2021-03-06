<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactchecksTable extends Migration
{
  /**
  * Run the migrations.
  */
  public function up()
  {
    Schema::create('factchecks', function (Blueprint $table) {
      $table->increments('id');
      $table->string('factcheckable_type');
      $table->string('factcheckable_id');
      $table->text('claim');
      $table->text('conclusion');
      $table->timestamp('submitted_at')->nullable();
      $table->timestamp('approved_at')->nullable();
      $table->timestamp('published_at')->nullable();
      $table->unsignedBigInteger('approved_by')->nullable();
      $table->unsignedBigInteger('user_id')->nullable();
      $table->timestamps();
    });
  }

  /**
  * Reverse the migrations.
  */
  public function down()
  {
    Schema::dropIfExists('factchecks');
  }
}