<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bk_wait')->nullable();
            $table->bigInteger('bk_on_verification')->nullable();
            $table->bigInteger('bk_on_withdrawn')->nullable();
            $table->bigInteger('bk_withdrawn')->nullable();
            $table->bigInteger('bk_preparing_documents')->nullable();
            $table->bigInteger('bk_waiting_drop')->nullable();
            $table->bigInteger('bk_trouble')->nullable();
            $table->bigInteger('bk_debiting')->nullable();
            $table->bigInteger('responsible');
            $table->foreign('responsible')
                ->references('id')
                ->on('users');
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
        Schema::dropIfExists('statistics');
    }
}
