<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store__category_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your translatable fields
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->text('description');

            // SEO fields
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('og_title')->nullable();
            $table->string('og_description')->nullable();
            $table->string('og_type')->nullable();

            $table->integer('category_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['category_id', 'locale']);
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
        Schema::table('store__category_translations', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
        Schema::dropIfExists('store__category_translations');
    }
}
