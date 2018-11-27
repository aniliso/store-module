<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFulltextIndexTitleStoreProductTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store__product_translations', function (Blueprint $table) {

        });
        DB::statement('ALTER TABLE store__product_translations ADD FULLTEXT (title, description)');
        DB::statement('ALTER TABLE store__products ADD FULLTEXT (model, sku)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store__product_translations', function (Blueprint $table) {
            $table->dropIndex('title');
        });

        Schema::table('store__products', function (Blueprint $table) {
            $table->dropIndex(['model', 'sku']);
        });
    }
}
