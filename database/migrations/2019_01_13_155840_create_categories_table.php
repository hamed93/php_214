<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('article_category', function (Blueprint $table) {
            $table->integer('article_id')->unsigned()->default(0);
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->primary(['article_id' , 'category_id']);
        });

        Schema::create('category_course', function (Blueprint $table) {

            $table->integer('course_id')->unsigned()->default(0);
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->primary(['category_id' , 'course_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_course');
        Schema::dropIfExists('article_category');
        Schema::dropIfExists('categories');
    }
}
