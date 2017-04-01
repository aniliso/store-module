<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreProductTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store__product_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your translatable fields
            $table->string('title');
            $table->string('slug');
            $table->text('description');

            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('og_title')->nullable();
            $table->string('og_description')->nullable();
            $table->string('og_type')->nullable();

            $table->integer('product_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['product_id', 'locale']);
            $table->foreign('product_id')->references('id')->on('store__products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store__product_translations', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });
        Schema::dropIfExists('store__product_translations');
    }
}
