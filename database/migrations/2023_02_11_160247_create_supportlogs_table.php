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
        Schema::create('supportlogs', function (Blueprint $table) {
            $table->id();
            $table->integer('is_admin')->default(0); // 0 = user 1 = support admin
            $table->integer('seen')->default(0); // 0 = not seen 1 = seen
            $table->text('comment');
            $table->foreignId('support_id')->constrained('supports')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
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
        Schema::dropIfExists('supportlogs');
    }
};
