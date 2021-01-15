<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\SmsLog;

class SendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SendSms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command SendSms';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $SmsLog = SmsLog::where('IsSent', 0)->where('Error',null)->get();
        foreach ($SmsLog as $key => $value) {
            switch ($value->PAYMENT_METHOD) {
                case 'CL_PAY_METHOD_TT':
                    $message = $value->SCMA_OID_COUNTRY_ISSUE == 'vn' ? 
                    "TT bao hiem cho {$value->MEMB_NAME} : {$value->TF_AMT} VND se duoc chuyen vao TK {$value->ACCT_NO} tai {$value->BANK_NAME}" :
                    "Claim payment for  {$value->MEMB_NAME} : VND {$value->TF_AMT} will be transferred to bank acc {$value->ACCT_NO} at  {$value->BANK_NAME} ";
                    break;
                case 'CL_PAY_METHOD_CA':
                    $message = $value->SCMA_OID_COUNTRY_ISSUE == 'vn' ? 
                    "TT bao hiem cho {$value->MEMB_NAME} : {$value->TF_AMT} VND se duoc chuyen cho CMND {$value->PP_NO} tai {$value->BANK_NAME} , {$value->BANK_BRANCH} ,{$value->BANK_CITY}" :
                    "Claim payment for {$value->MEMB_NAME} : VND {$value->TF_AMT} will be transferred to ID# {$value->PP_NO} at {$value->BANK_NAME} , {$value->BANK_BRANCH} ,{$value->BANK_CITY}";
                    break;

                default:
                $message = $value->SCMA_OID_COUNTRY_ISSUE == 'vn' ? 
                "TT bao hiem cho {$value->MEMB_NAME} co the nhan tai Pacific Cross VN, Vp HCM (028-73069669) hoac Vp Hanoi (024-73086699) trong gio lam viec. Neu quy khach da nhan duoc khoan boi thuong tren, vui long bo qua tin nhan nay" :
                "Claim payment for {$value->MEMB_NAME} : can be collected at Pacific Cross VN, HCM (028-73069669) or Hanoi (024-73086699) during office hours. If reimbursement has been collected already, please ignore this message";
                break;
            }
            $sendSms = sendSms($value->Phone, $message);
            var_dump($sendSms);
            // if(isset($sendSms->error)){
            //     $value->error = $sendSms->error;
            //     $value->ErrorDesc = $sendSms->error_description;
            // }else{
                // $value->MessageId = $sendSms->MessageId;
                // $value->Phone = $sendSms->Phone;
                // $value->BrandName = $sendSms->BrandName;
                // $value->Message = $sendSms->Message;
                // $value->PartnerId = $sendSms->PartnerId;
                // $value->Telco = $sendSms->Telco;
                // $value->IsSent = $sendSms->IsSent;
            // }
            // $value->save();
        }
    }
}
