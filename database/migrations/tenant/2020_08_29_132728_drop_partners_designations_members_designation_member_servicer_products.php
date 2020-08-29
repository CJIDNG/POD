<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPartnersDesignationsMembersDesignationMemberServicerProducts extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::dropIfExists('partners');
    Schema::dropIfExists('products');
    Schema::dropIfExists('services');
    Schema::dropIfExists('designations');
    Schema::dropIfExists('members');
    Schema::dropIfExists('designation_member');
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    //
  }
}
