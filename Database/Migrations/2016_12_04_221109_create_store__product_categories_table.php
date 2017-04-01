<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreProductCategoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store__product_categories', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('store__products')->onDelete('cascade');

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('store__categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store__product_categories', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['category_id']);
        });
        Schema::drop('store__product_categories');
    }

}
