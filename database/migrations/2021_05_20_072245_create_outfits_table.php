<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutfitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outfits', function (Blueprint $table) {
            $table->id(); // id: int(11)
            $table->string('type', 50); // type: varchar(50)
            $table->string('color', 20); // color: varchar(20)
            $table->integer('size'); // size: tinyint(4) unsigned
            $table->text('about'); // about: text
            $table->unsignedBigInteger('master_id'); // master_id : int(11)
            $table->foreign('master_id')->references('id')->on('masters'); //author keiciam i master, o authors i masters
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
        Schema::dropIfExists('outfits');
    }
}
