<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinistriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ministries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('hq')->nullable();
            $table->string('head')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->engine = 'InnoDB';
        });

        DB::statement('ALTER TABLE ministries ADD FULLTEXT search(name, hq, head, email, phone, website, description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ministries');
    }
}
