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
        $admin_list = User::getListIncharge();
        return view('reportpaymentFNManagement.show', compact('CPS_PAYMENTS','admin_list'));
    }

}
