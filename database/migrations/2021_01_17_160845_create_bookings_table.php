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
            $table->foreign('facid')->references('facid')->on('facilities')->onDelete('set null');
            $table->integer('memid')->unsigned()->nullable();
            $table->foreign('memid')->references('memid')->on('members')->onDelete('set null');
            $table->timestamp('starttime');
            $table->integer('slots')->unsigned();
            $table->integer('createdby')->unsigned();
            $table->foreign('createdby')->references('userid')->on('users')->onDelete('cascade');
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
