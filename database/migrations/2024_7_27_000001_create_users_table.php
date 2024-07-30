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
    Schema::create('roles', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique();
        $table->timestamps();
    });
    DB::table('roles')->insert([
        'name' => 'admin',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    DB::table('roles')->insert([
        'name' => 'guest',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->string('avatar')->default('');
        $table->unsignedBigInteger('role_id')->default(2);
        $table->rememberToken();
        $table->timestamps();
    });

    Schema::table('users', function (Blueprint $table) {
        $table->foreign('role_id')->references('id')->on('roles');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
