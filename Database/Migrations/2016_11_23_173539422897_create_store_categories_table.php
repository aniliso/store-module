<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store__categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your Categories
            $table->integer('parent_id')->nullable();
            $table->integer('lft')->nullable();
            $table->integer('rgt')->nullable();
            $table->integer('depth')->nullable();

            $table->integer('ordering')->default(1);
            $table->boolean('status')->default(1);

            $table->boolean('sitemap_include')->default(1);
            $table->enum('meta_robot_no_index', ['index', 'noindex'])->default('index');
            $table->enum('meta_robot_no_follow', ['follow', 'nofollow'])->default('follow');
            $table->enum('sitemap_priority', ['0.0', '0.1', '0.2', '0.3', '0.4', '0.5', '0.6', '0.7', '0.8', '0.9', '1.0'])->default('0.9');
            $table->enum('sitemap_frequency', ['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'])->default('weekly');

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
        Schema::dropIfExists('store__categories');
    }
}
