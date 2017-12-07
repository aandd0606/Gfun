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
            $table->increments('id');//細項序號
            $table->integer('receipt_id');//工作項目
            $table->string('product');//品項
            $table->integer('price');//單價
            $table->integer('amount');//數量
            $table->integer('subtotal');//小計
            $table->integer('company_id');//製作廠商
            $table->integer('cost');//成本
            $table->string('detail');//製作細節
            $table->integer('user_id');//聚豐負責人員
            $table->string('closing');//是否結案
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
        Schema::dropIfExists('products');
    }
}
