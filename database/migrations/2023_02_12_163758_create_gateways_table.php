<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('currency')->nullable();
            $table->string('logo')->nullable();
            $table->double('charge')->default(0); //payment gateway charge
            $table->double('multiply')->default(1.0); //multiply from base currency
            $table->string('namespace');
            $table->double('min_amount')->default(1);
            $table->double('max_amount')->default(1000);
            $table->integer('is_auto')->default(0);
            $table->integer('image_accept')->nullable();
            $table->integer('test_mode')->default(0);
            $table->integer('status')->default(1);
            $table->integer('phone_required')->default(0);
            $table->text('data')->nullable();
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('gateways');
    }
};
