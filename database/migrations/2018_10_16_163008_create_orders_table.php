<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('restaurants_id');
            $table->unsignedInteger('clients_id');
            $table->integer('table');
            $table->float('cost');
            $table->integer('status');
            $table->timestamps();

            $table->foreign('restaurants_id')
                ->references('id')->on('restaurants')
                ->onDelete('cascade');

            $table->foreign('clients_id')
                ->references('id')->on('clients')
                ->onDelete('cascade');
        });

        Schema::create('orders_options', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('optionals_id');
            $table->float('price');
            $table->timestamps();

            $table->foreign('optionals_id')
                ->references('id')->on('optionals')
                ->onDelete('cascade');
        });

        Schema::create('orders_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('menus_id');
            $table->float('price');
            $table->timestamps();

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
        Schema::dropIfExists('orders_options');
        Schema::dropIfExists('orders_menus');
        Schema::dropIfExists('orders');
    }
}
