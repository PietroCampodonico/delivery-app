<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentDetailsColumnsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string("customer_name")->after("id");
            $table->string("customer_phone_number")->after("customer_name");
            $table->string("payment_amount")->after("customer_mail");
            $table->string("payment_status")->after("payment_amount");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn("customer_name");
            $table->dropColumn("customer_phone_number");
            $table->dropColumn("payment_amount");
            $table->dropColumn("payment_status");
        });
    }
}
