<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cl_no')->nullable();
            $table->string('MessageId')->nullable();
            $table->string('Phone')->nullable();
            $table->longText('Message')->nullable();
            $table->string('PartnerId')->nullable();
            $table->string('Telco')->nullable();
            $table->integer('IsSent')->default('0');
            $table->string('Error')->nullable();
            $table->string('ErrorDesc')->nullable();
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
        Schema::dropIfExists('sms_log');
    }
}
