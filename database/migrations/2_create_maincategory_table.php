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
        Schema::create('main_category', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('status');
            $table->integer('position');
            $table->integer('type1');
            $table->integer('type2');
            $table->integer('homepage');
            $table->integer('sort_order');
            $table->string('data_query')->unique();
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
        Schema::dropIfExists('main_category');
    }
};
