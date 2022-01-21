<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.3
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('country_id');
            $table->string('drop');
            $table->bigInteger('type_id');
            $table->foreign('type_id')
                ->references('id')
                ->on('payment_types');
            $table->bigInteger('sum');
            $table->string('currency');
            $table->foreign('currency')
                ->references('code')
                ->on('currencies');
            $table->string('status');
            $table->bigInteger('bk_id');
            $table->foreign('bk_id')
                ->references('id')
                ->on('bks');
            $table->jsonb('histories')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
