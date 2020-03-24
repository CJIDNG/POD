<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthFacilitiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('health_facilities', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('unique_id');
      $table->unsignedInteger('local_government_id');
      $table->string('ward')->nullable();
      $table->string('code')->nullable();
      $table->string('name');
      $table->string('registration_no')->nullable();
      $table->date('start_date')->default('2000-01-01');
      $table->string('ownership')->nullable();
      $table->string('facility_level')->nullable();
      $table->decimal('latitude', 10, 6)->nullable();
      $table->decimal('longitude', 10, 6)->nullable();
      $table->string('operation_status')->nullable();
      $table->string('registration_status')->nullable();
      $table->string('license_status')->nullable();
      $table->softDeletes();
      $table->timestamps();

      $table->engine = 'InnoDB';
    });

    DB::statement(
      'ALTER TABLE health_facilities ADD FULLTEXT search(
        unique_id, 
        ward, 
        code, 
        name, 
        registration_no,
        ownership,
        facility_level,
        operation_status,
        registration_status,
        license_status
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
    Schema::dropIfExists('health_facilities');
  }
}
