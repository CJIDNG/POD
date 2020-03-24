<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGovernmentProjectsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('government_projects', function (Blueprint $table) {
      $table->increments('id');
      $table->text('description');
      $table->string('allocation');
      $table->unsignedInteger('agency_id')->nullable();
      $table->unsignedInteger('ministry_id')->nullable();
      $table->string('date_commissioned')->nullable();
      $table->string('location_type')->nullable();
      $table->unsignedInteger('location_id')->nullable();
      $table->unsignedInteger('status_id');
      $table->unsignedInteger('type_id');
      $table->unsignedInteger('user_id');
      $table->softDeletes();
      $table->timestamps();

      $table->engine = 'InnoDB';
    });

    DB::statement('ALTER TABLE government_projects ADD FULLTEXT search(description)');
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('government_projects');
  }
}
