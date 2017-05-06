<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFieldsToCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupon', function (Blueprint $table) {
            $table->unsignedSmallInteger('type')->default(0); //0 : decrease by money, 1 : decrease by percent but not more then xx money, 2 : decrease by percent x if total order money < xx and percent y if total order money > yy.
            $table->unsignedInteger('primary_percent')->default(0); // for type=2
            $table->unsignedInteger('secondary_percent')->default(0); // for type=2
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupon', function (Blueprint $table) {
            $table->dropColumn(['type', 'primary_percent', 'secondary_percent']);
        });
    }
}
