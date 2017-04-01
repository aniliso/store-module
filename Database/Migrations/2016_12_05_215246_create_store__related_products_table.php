<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreRelatedProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store__related_products', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('store__products')->onDelete('cascade');

            $table->integer('related_id')->unsigned();
            $table->foreign('related_id')->references('id')->on('store__products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store__related_products', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['related_id']);
        });
        Schema::drop('store__related_products');
    }

}
