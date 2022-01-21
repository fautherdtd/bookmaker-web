<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('country_id');
            $table->string('drop');
            $table->string('email');
            $table->string('password');
            $table->string('address');
            $table->string('document');
            $table->string('info');
            $table->string('drop_guide');
            $table->bigInteger('bet_id');
            $table->bigInteger('sum');
            $table->string('currency');
            $table->foreign('currency')
                ->references('code')
                ->on('currencies');
            $table->string('status')->default('waiting');
            $table->bigInteger('responsible')->nullable();
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
        Schema::dropIfExists('bks');
    }
}
