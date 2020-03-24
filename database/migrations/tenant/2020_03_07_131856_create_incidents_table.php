<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('incidents', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('title');
      $table->text('description');
      $table->date('date');
      $table->unsignedBigInteger('type_id');
      $table->unsignedBigInteger('status_id');
      $table->unsignedBigInteger('health_facility_id');
      $table->string('address');
      $table->string('news_source_link')->nullable();
      $table->string('external_video_link')->nullable();
      $table->unsignedBigInteger('user_id');
      $table->softDeletes();
      $table->timestamps();
    });

    DB::statement(
      'ALTER TABLE incidents ADD FULLTEXT search(
        title, 
        description, 
        address
      )'
    );
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('incidents');
  }
}
