<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTouchUpdatedFieldToBks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bks', function (Blueprint $table) {
            $table->bigInteger('sum_external')->nullable();
            $table->timestamp('touch_updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bks', function (Blueprint $table) {
            //
        });
    }
}
