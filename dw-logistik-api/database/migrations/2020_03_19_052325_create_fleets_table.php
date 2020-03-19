<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFleetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fleets', function (Blueprint $table) {
            $table->id('id');
            $table->string('plate_number')->unique();
            $table->char('type', 1)->comment('0: car, 1: motorcycle');
            $table->string('photo');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            //MEMBUAT RELASI KE TABLE USERS DENGAN FOREIGN KEY USER_ID DAN TERHUBUNG DENGAN ID YANG ADA DI USERS
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fleets');
    }
}