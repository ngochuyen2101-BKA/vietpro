<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('full'); // mặc định chiều dài là 255 nấu không khai báo, không ghi gì thì bắt buộc not null
            $table->string('address')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->decimal('total',18);// đơn vị tiền tệ 
            $table->tinyInteger('state')->unsigned();
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
        Schema::dropIfExists('orders');
    }
}
