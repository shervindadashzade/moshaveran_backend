<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCounselorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counselors', function (Blueprint $table) {
            $table->id();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->unique();
            $table->string('photo')->nullable();
            $table->string('description')->nullable();
            $table->integer('charge')->default(0);
            $table->boolean('isOnline')->default(false);
            $table->string('cv')->nullable();
            $table->boolean('isValid')->default(true);
            $table->float('rate')->default(0);
            $table->string('api_token',60)->nullable();
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
        Schema::dropIfExists('counselors');
    }
}
