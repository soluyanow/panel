<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Clients extends Migration
{
    const TABLE = 'clients';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('period_update')->default('86400');
            $table->string('period_update_measure')->default('s');
            $table->integer('period_execute')->default('86400');
            $table->string('period_execute_measure')->default('s');
            $table->integer('period_copy')->default('86400');
            $table->string('period_copy_measure')->default('s');
            $table->unsignedInteger('period_update_type')->nullable();
            $table->foreign('types_id')->references('id')->on('types');
            $table->unsignedInteger('period_execute_type')->nullable();
            $table->foreign('types_id')->references('id')->on('types');
            $table->unsignedInteger('period_copy_type')->nullable();
            $table->foreign('types_id')->references('id')->on('types');
            $table->boolean('active');
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
        Schema::dropIfExists(self::TABLE);
    }
}
