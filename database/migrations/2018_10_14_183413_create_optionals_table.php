<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('optionals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('price');
            $table->integer('type');
            $table->timestamps();
        });

        Schema::create('optionals_has_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('optionals_id');
            $table->unsignedInteger('menus_id');
            $table->timestamps();

            $table->foreign('optionals_id')
                ->references('id')->on('optionals')
                ->onDelete('cascade');

            $table->foreign('menus_id')
                ->references('id')->on('menus')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('optionals');
        Schema::dropIfExists('optionals_has_menu');
    }
}
