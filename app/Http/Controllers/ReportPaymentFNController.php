<?php

namespace App\Http\Controllers;

use App\ReportAdmin;
use Auth;
use App\User;
use App\CPS_PAYMENTS;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\HBS_CL_CLAIM;

class ReportPaymentFNController extends Controller
{

    public function __construct()
    {
        //$this->authorizeResource(ReportAdmin::class);
        parent::__construct();
    }

    /**
     * Display a listing of the ReportAdmin.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $search_params = [
            'created_user' => $request->get('created_user'),
            'created_at' => $request->get('created_at'),
            'updated_user' => $request->get('updated_user'),
            'updated_at' => $request->get('updated_at'),
        ];
        $CPS_PAYMENTS = CPS_PAYMENTS::select(DB::raw('DISTINCT(DATE(TF_DATE)) AS date'))->where('TF_DATE',"!=",NULL)->where('TF_STATUS_ID',200)->orderBy('TF_DATE', 'desc');
        $admin_list = User::getListIncharge();
        //pagination result
        $limit_list = config('constants.limit_list');
        $limit = $request->get('limit');
        $per_page = !empty($limit) ? $limit : Arr::first($limit_list);
        $CPS_PAYMENTS  = $CPS_PAYMENTS->paginate($per_page);
        return view('reportpaymentFNManagement.index', compact('search_params', 'admin_list', 'limit', 'limit_list', 'CPS_PAYMENTS' ));        
    }


    /**
     * Display the specified ReportAdmin.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($datereport)
    {
        $CPS_PAYMENTS = CPS_PAYMENTS::whereDate('TF_DATE', $datereport)->where('TF_DATE',"!=",NULL)->where('TF_STATUS_ID',200)->get();
        $array_clno = $CPS_PAYMENTS->pluck('CL_NO')->toArray();
        $HBS_CL_CLAIM = HBS_CL_CLAIM::whereIn('cl_no',$array_clno)->with(['HBS_CL_LINE'])->get()->pluck('HBS_CL_LINE','cl_no');
        
        foreach ($CPS_PAYMENTS as $key => $CPS_PAYMENT) {
            $hbs = $HBS_CL_CLAIM[$CPS_PAYMENT->CL_NO]->map(function ($c) {
                $q=  collect($c)->only(['incur_date_from', 'incur_date_to']);
                if($q['incur_date_from'] == $q['incur_date_to']){
                    return str_replace(" 00:00:00", "",$q['incur_date_from']) ;
                }else{
                    return str_replace(" 00:00:00", "",$q['incur_date_from']) .' to ' . str_replace(" 00:00:00", "",$q['incur_date_to']);
                }
            })->unique()->toArray();
            $CPS_PAYMENTS[$key]['incur'] = implode(" ; ",$hbs);
        }
        $admin_list = User::getListIncharge();
        return view('reportpaymentFNManagement.show', compact('CPS_PAYMENTS','admin_list'));
    }

}
