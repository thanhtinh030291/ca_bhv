<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTokenSmsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('token_sms')->nullable();
            $table->dateTime('created_token_sms_at', 0)->nullable();
            $table->dateTime('created_token_cps_at', 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->dropColumn('token_sms');
            $table->dropColumn('created_token_sms_at');
            $table->dropColumn('created_token_cps_at');
        });
    }
}
