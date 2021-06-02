<?php

namespace App\Http\Controllers;
use App\User;
use Auth;
use App\Setting;
use App\Claim;
use App\HBS_CL_CLAIM;
use App\Provider;
use App\HBS_PV_PROVIDER;
use App\LogHbsApproved;
use App\HBS_PD_BEN_HEAD;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\HbsBenhead;
use DB;


class SettingController extends Controller
{
    
    //use Authorizable;
    public function __construct()
    {
        //$this->authorizeResource(Product::class);
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $setting = Setting::where('id', 1)->first();
        if($setting === null){
            $setting = Setting::create([]);
        }
        $admin_list = User::getListIncharge();
        return view('settingManagement.index', compact('setting','admin_list'));
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->except([]);
        Setting::updateOrCreate(['id' => 1], $data);

        $request->session()->flash('status', "setting update success"); 
        return redirect('/admin/setting');
    }

    public function notifiAllUser(Request $request)
    {
        $data = $request->except([]);
        $text_notifi = $request->message;
        $arr_id = User::pluck('id');
        notifi_system($text_notifi, $arr_id);
    }

    public function checkUpdateClaim(Request $request){
        $claims = Claim::where('code_claim_show',null)->orWhere('barcode', null)->pluck('code_claim')->toArray();
        $claims_chunk = array_chunk($claims, 500);
        foreach ($claims_chunk as $key => $value) {
            $HBS_CL_CLAIM = HBS_CL_CLAIM::whereIn('clam_oid',$value)->get();
            foreach ($HBS_CL_CLAIM as $key2 => $value2) {
                DB::table('claim')->where('code_claim',$value2->clam_oid)->update([
                    'code_claim_show' => $value2->cl_no,
                    'barcode' => $value2->barcode
                ]);
            }
        }
        $request->session()->flash('status', "setting update success"); 
        return redirect('/admin/setting');
    }

    public function checkUpdateLogApproved(Request $request){
        $claims = LogHbsApproved::where('MANTIS_ID',null)->orWhere('MEMB_NAME', null)->orWhere('POCY_REF_NO', null)->orWhere('MEMB_REF_NO', null)->pluck('cl_no')->toArray();
        $claims_chunk = array_chunk($claims, 500);
        foreach ($claims_chunk as $key => $value) {
            $HBS_CL_CLAIM = HBS_CL_CLAIM::whereIn('cl_no',$value)->get();
            foreach ($HBS_CL_CLAIM as $key2 => $value2) {
                DB::table('log_hbs_approved')->where('cl_no',$value2->cl_no)->update([
                    'MANTIS_ID' => $value2->barcode,
                    'MEMB_NAME' => $value2->MemberNameCap,
                    'POCY_REF_NO' => $value2->police->pocy_ref_no,
                    'MEMB_REF_NO' => $value2->member->memb_ref_no
                ]);
            }
        }
        $request->session()->flash('status', "setting update success"); 
        return redirect('/admin/setting');
    }

    public function updateBenhead(Request $request){
        $HBS_PD_BEN_HEAD = HBS_PD_BEN_HEAD::whereNotNull('BEN_HEAD')->with('PD_BEN_HEAD_LANG')->get();
        foreach ($HBS_PD_BEN_HEAD as $key => $value) {
            $HbsBenhead = HbsBenhead::updateOrCreate([
                'code'   => $value->ben_head,
            ],[
                'desc_vn'     => $value->PD_BEN_HEAD_LANG != null ? $value->PD_BEN_HEAD_LANG->code_desc_vn : null,
                'desc_en'     => $value->PD_BEN_HEAD_LANG != null ? $value->PD_BEN_HEAD_LANG->code_desc : null,
                'ben_type'    => str_replace('BENEFIT_TYPE_',"",$value->scma_oid_ben_type),
                'name'     => numberToRomanRepresentation($value->ben_head)
            ]);
        }
        $request->session()->flash('status', "setting update success"); 
        return redirect('/admin/setting');
    }
    
    public function updateProject(Request $request){
        $id_project_mb = DB::connection('mysql_mantic')->table('mantis_project_table')->where('name','CLM - Mobile')->first()->id;
        $claim_chunk = Claim::where('claim_type','M')->whereNull('project')->pluck('barcode')->chunk(100);
        
        foreach ($claim_chunk as $key => $claims) {
            $MANTIS_BUG = \App\MANTIS_BUG::where('project_id',$id_project_mb)->whereIn('id',$claims->toArray())->pluck('id');
            if($MANTIS_BUG->count() > 0){
                Claim::whereIn('barcode',$MANTIS_BUG->toArray())->update([
                    'project' => 'mobile'
                ]);
            }
        }
        $request->session()->flash('status', "setting update success"); 
        return redirect('/admin/setting');
    }
}
