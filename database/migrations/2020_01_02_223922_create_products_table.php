<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('action_id')->default(0);
            $table->string('sku')->nullable();
            $table->string('address')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('state')->nullable();
            $table->integer('type')->unsigned()->default(0); // tip: apartman, soba, kuća...
            $table->integer('target')->unsigned()->default(0); // (namjena), najam, prodaja
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price_regular', 15, 4)->default(0);
            $table->decimal('price_weekends', 15, 4)->default(0);
            $table->integer('price_per')->unsigned()->default(0);
            $table->integer('tax_id')->unsigned()->default(0);
            $table->decimal('special', 15, 4)->nullable();
            $table->timestamp('special_from')->nullable();
            $table->timestamp('special_to')->nullable();
            $table->integer('reservations')->unsigned()->default(0);
            $table->integer('viewed')->unsigned()->default(0);
            $table->integer('sort_order')->unsigned()->default(0);
            $table->boolean('featured')->default(false);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });


        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index();
            $table->string('lang', 2)->default(config('app.locale'));
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('slug');
            $table->string('url', 255);
            $table->string('tags')->nullable();
            $table->timestamps();

            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('cascade');
        });


        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index();
            $table->string('image');
            $table->boolean('default')->default(false);
            $table->boolean('published')->default(false);
            $table->integer('sort_order')->unsigned();
            $table->timestamps();

            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('cascade');
        });


        Schema::create('product_images_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_image_id')->index();
            $table->string('lang', 2)->default(config('app.locale'));
            $table->string('title')->nullable();
            $table->string('alt')->nullable();
            $table->timestamps();

            $table->foreign('product_image_id')
                  ->references('id')->on('product_images')
                  ->onDelete('cascade');
        });


        Schema::create('product_to_category', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('category_id')->index();

            $table->foreign('product_id')
                  ->references('id')->on('products');

            $table->foreign('category_id')
                  ->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_translations');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_images_translations');
        Schema::dropIfExists('product_to_category');
    }
}



