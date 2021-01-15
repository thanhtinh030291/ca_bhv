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
            $table->string('CL_NO')->nullable();
            $table->string('MEMB_NAME')->nullable();
            $table->string('PAYMENT_METHOD')->nullable();
            $table->string('TF_AMT')->nullable();
            $table->string('ACCT_NAME')->nullable();
            $table->string('ACCT_NO')->nullable();
            $table->string('BANK_NAME')->nullable();
            $table->string('BANK_CITY')->nullable();
            $table->string('BANK_BRANCH')->nullable();
            $table->string('BENEFICIARY_NAME')->nullable();
            $table->string('PP_DATE')->nullable();
            $table->string('PP_PLACE')->nullable();
            $table->string('PP_NO')->nullable();
            $table->string('SCMA_OID_COUNTRY_ISSUE')->nullable();
            $table->string('MessageId')->nullable();
            $table->string('Phone')->nullable();
            $table->string('BrandName')->nullable();
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
