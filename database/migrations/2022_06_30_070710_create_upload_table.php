<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->string('Event_Name', 255)->nullable();
            $table->string('Type', 255)->nullable();
            $table->string('Parent_Event', 255)->nullable();
            $table->string('Organiser', 255)->nullable();
            $table->string('Start_Date', 255)->nullable();
            $table->string('Start_Time', 255)->nullable();
            $table->string('End_Date', 255)->nullable();
            $table->string('End_Time', 255)->nullable();
            $table->string('Description', 255)->nullable();
            $table->string('Featured', 255)->nullable();
            $table->string('Active', 255)->nullable();
            $table->string('Event_Link', 255)->nullable();
            $table->string('Venue_Name', 255)->nullable();
            $table->string('Address', 255)->nullable();
            $table->string('Town', 255)->nullable();
            $table->string('PostCode', 255)->nullable();
            $table->string('County', 255)->nullable();
            $table->string('Country', 255)->nullable();
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
        Schema::dropIfExists('uploads');
    }
}