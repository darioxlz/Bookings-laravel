<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('memid');
            $table->string('surname');
            $table->string('firstname');
            $table->string('address');
            $table->integer('zipcode')->unsigned();
            $table->string('telephone');
            $table->integer('recommendedby')->unsigned()->nullable();
            $table->foreign('recommendedby')->references('memid')->on('members')->onDelete('set null');
            $table->timestamp('joindate')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
