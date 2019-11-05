<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 100);
            $table->string('name');
            $table->double('price', 18);
            $table->tinyInteger('qty');
            $table->string('img');

            //tạo khóa ngoại
            $table->bigInteger('order_id')->unsigned();
            // tạo liên kết khóa ngoại
            // onDelete('cascade') giúp xóa khóa chính liên kết với khóa ngoại
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_order');
    }
}
