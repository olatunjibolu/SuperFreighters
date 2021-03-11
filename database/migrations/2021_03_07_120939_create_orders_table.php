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
            $table->id();
            $table->integer('user_id');
            $table->integer('product_id');
            $table->integer('country_id');
            $table->integer('transportation_id');
            $table->integer('transport_charge');
            $table->integer('weight_charge');
            $table->integer('countryoforigin_charge');
            $table->integer('total_charge');
            $table->integer('tax');
            $table->integer('total_payable');
            $table->integer('pay_status')->default(0);
            $table->date('delivery_date');
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
