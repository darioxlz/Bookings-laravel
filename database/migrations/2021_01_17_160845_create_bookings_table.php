<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('bookid');
            $table->integer('facid')->unsigned()->nullable();
            $table->foreign('facid')->references('facid')->on('facilities')->onDelete('cascade');
            $table->integer('memid')->unsigned()->nullable();
            $table->foreign('memid')->references('memid')->on('members')->onDelete('cascade');
            $table->timestamp('starttime');
            $table->integer('slots')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
