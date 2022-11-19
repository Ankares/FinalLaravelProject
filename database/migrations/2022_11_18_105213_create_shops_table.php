<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('itemName');
            $table->string('manufacturer');
            $table->integer('itemCost');
            $table->string('itemImage');
            $table->integer('created_year');
            $table->string('warrantyPeriod')->nullable();
            $table->integer('warrantyCost')->nullable();
            $table->string('deliveryPeriod')->nullable();
            $table->integer('deliveryCost')->nullable();
            $table->integer('itemSetupCost')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
};
