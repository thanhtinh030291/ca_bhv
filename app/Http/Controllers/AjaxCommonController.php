<?php

namespace App\Http\Controllers;
use App\HBS_CL_CLAIM;
use App\HBS_MR_POLICY_PLAN;
use App\HBS_PV_PROVIDER;
use App\HBS_RT_DIAGNOSIS;
use App\HBS_MR_MEMBER;
use App\HBS_CL_LINE;
use App\ExportLetter;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Claim;
use App\PaymentHistory;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class AjaxCommonController extends Controller
{
    
    //ajax load ID claim auto complate 
    public function dataAjaxHBSClaim(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $datas = HBS_CL_CLAIM::where('cl_no','LIKE',"%$search%")
                    ->select('clam_oid as id', 'cl_no as text')
                    ->limit(20)->get();
            return response()->json($datas);
        }
        return response()->json($data);
    }

    public function dataAjaxHBSGOPClaim(Request $request)
    {
        $data = [];
        $conditionGOP = function($q) {
            $q->where('SCMA_OID_CL_TYPE', 'CL_TYPE_P');
        };
        if($request->has('q')){
            $search = $request->q;
            $datas = HBS_CL_CLAIM::where('cl_no','LIKE',"%$search%")
                    ->whereHas('HBS_CL_LINE' ,$conditionGOP)
                    ->select('clam_oid as id', 'cl_no as text')
                    ->limit(20)->get();
            return response()->json($datas);
        }
        return response()->json($data);
    }

    public function dataAjaxHBSDiagnosis(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = mb_strtolower($request->q);
            $datas = HBS_RT_DIAGNOSIS::where('diag_desc','LIKE',"%$search%")->orWhere('diag_code','LIKE',"%$search%")
                    ->select(DB::raw("diag_oid  as id, diag_code ||'-'|| diag_desc as text"))
                    ->limit(100)->get();
            
            
            return response()->json($datas);
        }
        return response()->json($data);
    }

    public function dataAjaxHBSProvByClaim($claim_oid){
        $data = HBS_CL_CLAIM::findOrFail($claim_oid)->provider;
        return response()->json($data);
    }

    //ajax load provider
    public function dataAjaxHBSProv(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = mb_strtoupper($request->q);
            $datas = HBS_PV_PROVIDER::where('prov_name','LIKE',"%$search%")
                    ->select('prov_oid as id', 'prov_name as text')
                    ->limit(50)->get();
            return response()->json($datas);
        }
        return response()->json($data);
    }
    
    // jax load info of claim
    public function loadInfoAjaxHBSClaim(Request $request)
    {  
        
        $data = [];
        if($request->has('search')){
            $search = $request->search;
            $datas = HBS_CL_CLAIM::findOrFail($search);
            return response()->json(['member' => $datas->member , 'claim' =>$datas ]);
        }
        return response()->json($data);
    }

    //ajax load ID claim auto complate HAVE benhead is RB
    public function dataAjaxHBSClaimRB(Request $request)
    {
        
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $conditionBenHead = function($q) {
                $q->where('BEN_HEAD', 'RB');
            };
            $condition = function($q) use ($conditionBenHead){
                $q->whereHas('PD_BEN_HEAD', $conditionBenHead);
            };
            $datas = HBS_CL_CLAIM::where('cl_no','LIKE',"%$search%")
                    ->whereHas("HBS_CL_LINE", $condition)
                    ->select('clam_oid as id', 'cl_no as text')
                    ->limit(20)->get();
            return response()->json($datas);
        }
        return response()->json($data);
    }
    // jax load info of claim RB
    public function loadInfoAjaxHBSClaimRB(Request $request)
    {  
        
        $data = [];
        if($request->has('search')){
            $search = $request->search;
            $datas = HBS_CL_CLAIM::findOrFail($search)->member;
            
            $conditionBenHead = function($q) {
                $q->where('BEN_HEAD', 'RB');
            };
            $condition = function($q) use ($conditionBenHead){
                $q->whereHas('PD_BEN_HEAD', $conditionBenHead);
                $q->where('scma_oid_cl_line_status','!=','CL_LINE_STATUS_RV');
            };
            $data2 = HBS_CL_CLAIM::with(['HBS_CL_LINE' => $condition])->findOrFail($search)->HBS_CL_LINE->toArray();
            foreach ($data2 as $key => $value) {
                $incurDate = Carbon::parse($value['incur_date_from'])->format('d/m/Y') .' 00:00 - '. Carbon::parse($value['incur_date_to'])->format('d/m/Y') . " 23:59";
                $data2[$key]['incur_date'] = $incurDate;
            }
            $data['HBS_CL_CLAIM'] = $datas;
            $data['HBS_CL_LINE'] = $data2;
            return response()->json($data);
        }
        return response()->json($data);
    }

    // checkRoomBoard
    public function checkRoomBoard(Request $request){
        $data = [];
        if($request->has('search')){
            $search = $request->search;
            $conditionHasBenHead = function($q) {
                $q->where('scma_oid_ben_type', 'BENEFIT_TYPE_IP');
                $q->where('ben_head', 'RB');
            };

            $conditionPlanLimit = function($q) use ($conditionHasBenHead){
                $q->whereHas('PD_BEN_HEAD',$conditionHasBenHead);
            };

            $condition = function($q) use ($conditionPlanLimit){
                $q->with(['PD_PLAN_LIMIT' => $conditionPlanLimit]);
            };
            $datas = HBS_MR_POLICY_PLAN::with(['PD_PLAN' => $condition])
            ->findOrFail($search);
            return response()->json($datas->PD_PLAN->PD_PLAN_LIMIT[0]);
        }
        return response()->json($data);
    }

    // getPaymentHistory mantic
    public static function getPaymentHistory($cl_no){
        $data = GetApiMantic('api/rest/plugins/apimanagement/issues/'. $cl_no);
        $claim = Claim::where('code_claim_show',  $cl_no)->first();
        $HBS_CL_CLAIM = HBS_CL_CLAIM::IOPDiag()->findOrFail($claim->code_claim);
        $approve_amt = $HBS_CL_CLAIM->sumAppAmt;
        return response()->json([ 'data' => $data, 'approve_amt' => $approve_amt]);
    }
    // get  payment of claim  CPS

    public static function getPaymentHistoryCPS($cl_no){
        $token = getTokenCPS();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
        ];

        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'get_payment/'. $cl_no , ['form_params'=>$body]);
        
        $response =  json_decode($response->getBody()->getContents());
        $response_full = collect($response)->where('TF_STATUS_NAME','!=', "NEW")->where('TF_STATUS_NAME','!=', "DELETED");
        $response = collect($response)->where('TF_STATUS_NAME','!=', "NEW")->where('TF_STATUS_NAME','!=', "DELETED");
            
        $claim = Claim::where('code_claim_show',  $cl_no)->first();
        $HBS_CL_CLAIM = HBS_CL_CLAIM::IOPDiag()->findOrFail($claim->code_claim);
        $approve_amt = $HBS_CL_CLAIM->sumAppAmt;
        $present_amt = $HBS_CL_CLAIM->sumPresAmt;
        $payment_method = str_replace("CL_PAYMENT_METHOD_","",$HBS_CL_CLAIM->payMethod);
        $payment_method = $payment_method == 'CA' ? "CH" : $payment_method;
        $pocy_no = $HBS_CL_CLAIM->Police->pocy_no;
        $memb_no = $HBS_CL_CLAIM->member->mbr_no;
        $member_name = $HBS_CL_CLAIM->memberNameCap;
        return response()->json([ 'data' => $response,
                                'data_full' => $response_full,
                                'approve_amt' => round($approve_amt) , 
                                'present_amt' => round($present_amt) ,
                                'payment_method' => $payment_method,
                                'pocy_no' => $pocy_no,
                                'memb_no' => $memb_no,
                                'member_name' => $member_name,
                            ]);
    }
    // get  Balance of claim  CPS 
    public static function getBalanceCPS($mem_ref_no , $cl_no){
        $token = getTokenCPS();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
        ];

        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'get_client_debit/'. $mem_ref_no , ['form_params'=>$body]);
        $response =  json_decode($response->getBody()->getContents());
        /*
            There are 4 types:
            -	1: nợ được đòi lại
            -	2: nợ nhưng đã cấn trừ qua Claim khác
            -	3: nợ nhưng khách hàng đã gửi trả lại
            -	4: nợ không được đòi lại
        */
        if (empty($response)){
            $data =[
                'PCV_EXPENSE' => 0,
                'DEBT_BALANCE' => 0
            ];
            $data_full =[];
        }else{
            $colect_data = collect($response);
            $data =[
                'PCV_EXPENSE' => $colect_data->where('DEBT_CL_NO', $cl_no)->sum('PCV_EXPENSE'),
                'DEBT_BALANCE' => $colect_data->sum('DEBT_BALANCE')
            ];
            $data_full = collect($response);
        }

        return response()->json([ 'data' => $data , 'data_full' =>  $data_full]);
    }
    
    
    public static function setPcvExpense($paym_id, $pcv_expense){
        $token = getTokenCPS();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
            'pcv_expense' => $pcv_expense,
            'username'    => Auth::user()->name
        ];

        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'set_pcv_expense/'. $paym_id , ['form_params'=>$body]);
        $response =  json_decode($response->getBody()->getContents());
        return $response;
    }

    public static function sendPayment($request, $id_claim){
        $token = getTokenCPS();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
            'memb_name' => $request->memb_name,
            'pocy_no' => $request->pocy_no,
            'memb_no' => $request->memb_no,
            'pres_amt' => $request->pres_amt,
            'app_amt' => $request->app_amt,
            'tf_amt' => $request->tf_amt,
            'deduct_amt' => $request->deduct_amt,
            'payment_method' => $request->payment_method,
            'mantis_id' => $request->mantis_id,
            //'mantis_id' => "",
            'username'    => 'claimassistant'
        ];
        
        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'send_payment/'. $request->cl_no , ['form_params'=>$body]);
        $response =  json_decode($response->getBody()->getContents());
        $rs=data_get($response,'code');
        if(data_get($response,'code') == "00" && data_get($response,'data') != null){
            try {
                DB::beginTransaction();
                PaymentHistory::updateOrCreate([
                    'PAYM_ID' => data_get($response, "data.PAYM_ID"),
                    'CL_NO' => data_get($response, "data.CL_NO"),
                ], [
                    'ACCT_NAME' => data_get($response, "data.ACCT_NAME"),
                    'ACCT_NO' => data_get($response, "data.ACCT_NO"),
                    'BANK_NAME' => data_get($response, "data.BANK_NAME"),
                    'BANK_CITY' => data_get($response, "data.BANK_CITY"),
                    'BANK_BRANCH' => data_get($response, "data.BANK_BRANCH"),
                    'BENEFICIARY_NAME' => data_get($response, "data.BENEFICIARY_NAME"),
                    'PP_DATE' => data_get($response, "data.PP_DATE"),
                    'PP_PLACE' => data_get($response, "data.PP_PLACE"),
                    'PP_NO' => data_get($response, "data.PP_NO"),
                    'CL_TYPE' => data_get($response, "data.CL_TYPE"),
                    'BEN_TYPE' => data_get($response, "data.BEN_TYPE"),
                    'PAYMENT_TIME' => data_get($response, "data.PAYMENT_TIME"),
                    'TF_STATUS' => data_get($response, "data.TF_STATUS_ID"),
                    'TF_DATE' => data_get($response, "data.TF_DATE"),
                    
                    'VCB_SEQ' => data_get($response, "data.VCB_SEQ"),
                    'VCB_CODE' => data_get($response, "data.VCB_CODE"),

                    'MEMB_NAME' => data_get($response, "data.MEMB_NAME"),
                    'POCY_REF_NO' => data_get($response, "data.POCY_REF_NO"),
                    'MEMB_REF_NO' => data_get($response, "data.MEMB_REF_NO"),
                    'PRES_AMT' => data_get($response, "data.PRES_AMT"),
                    'APP_AMT' => data_get($response, "data.APP_AMT"),
                    'TF_AMT' => data_get($response, "data.TF_AMT"),
                    'DEDUCT_AMT' => data_get($response, "data.DEDUCT_AMT"),
                    'PAYMENT_METHOD' => data_get($response, "data.PAYMENT_METHOD"),
                    'PAYMENT_METHOD' => data_get($response, "data.PAYMENT_METHOD"),
                    'MANTIS_ID' => data_get($response, "data.MANTIS_ID"),

                    'update_file' => 0,
                    'update_hbs' => 0,
                    'updated_user' => Auth::user()->id,
                    'created_user' => Auth::user()->id,
                    'notify_renew' => 0,
                    'reason_renew' => null,
                    'claim_id' => $id_claim,
                ]);
                DB::commit();
            } catch (Exception $e) {
                Log::error(generateLogMsg($e));
                DB::rollback();
            }
        }
        return $response;
    }

    public static function setDebt($debt_id){
        $token = getTokenCPS();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
            'username'    => Auth::user()->name
        ];
        
        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'set_debt/'. $debt_id , ['form_params'=>$body]);
        $response =  json_decode($response->getBody()->getContents());
        return $response;
    }

    public static function payDebt($request , $paid_amt){
        $token = getTokenCPS();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
            'paid_amt' => $paid_amt,
            'username'    => Auth::user()->name,
            'cl_no' => $request->cl_no,
            'memb_name' => $request->memb_name,
        ];
        
        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'pay_debt/'. $request->memb_ref_no , ['form_params'=>$body]);
        $response =  json_decode($response->getBody()->getContents());
        return $response;
    }

    public function renderEmailProv(Request $request){
        $user = Auth::User();
        $claim_id = $request->claim_id;
        $id = $request->export_letter_id;
        $export_letter = ExportLetter::findOrFail($id);
        $claim  = Claim::itemClaimReject()->findOrFail($claim_id);
        $HBS_CL_CLAIM = HBS_CL_CLAIM::IOPDiag()->findOrFail($claim->code_claim);
        $diag_code = $HBS_CL_CLAIM->HBS_CL_LINE->pluck('diag_oid')->unique()->toArray();
        $match_form_gop = preg_match('/(FORM GOP)/', $export_letter->letter_template->name , $matches);
        $template = $match_form_gop ? 'templateEmail.sendProviderTemplate_input' : 'templateEmail.sendProviderTemplate_output';
        
        $data['diag_text'] = implode(",",$HBS_CL_CLAIM->HBS_CL_LINE->pluck('RT_DIAGNOSIS.diag_desc')->unique()->toArray());
        $incurDateTo = Carbon::parse($HBS_CL_CLAIM->FirstLine->incur_date_to);
        $incurDateFrom = Carbon::parse($HBS_CL_CLAIM->FirstLine->incur_date_from);
        $data['incurDateTo'] = $incurDateTo->format('d-m-Y');
        $data['incurDateFrom'] = $incurDateFrom->format('d-m-Y');
        $data['diffIncur'] =  $incurDateTo->diffInDays($incurDateFrom);
        $data['email_reply'] = $user->email;
        //benifit
        $request2 = new Request([
            'diag_code' => $diag_code,
            'id_claim' => $claim->code_claim
        ]);

        $data['HBS_CL_CLAIM'] = $HBS_CL_CLAIM;
        $data['Diagnosis'] = data_get($claim->hospital_request,'diagnosis',null) ?  data_get($claim->hospital_request,'diagnosis') : $HBS_CL_CLAIM->FirstLine->RT_DIAGNOSIS->diag_desc;
        $html = view($template, compact('data'))->render();
        return response()->json([ 'data' => $html]);
    }

    
}
