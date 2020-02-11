<?php

namespace Modules\PromoCampaign\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use \App\Lib\MyHelper;

class ReferralController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('promocampaign::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('promocampaign::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('promocampaign::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('promocampaign::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function setting(Request $request) {
        $data = [
            'title'             => 'Referral',
            'sub_title'         => 'Referral Setting',
            'menu_active'       => 'referral',
            'submenu_active'    => 'referral-setting'
        ];
        $data['setting'] = MyHelper::get('referral/setting')['result']??[];
        $data['is_active'] = time()<strtotime($data['setting']['promo_campaign']['date_end']);
        return view('promocampaign::referral.setting',$data);
    }
    public function settingUpdate(Request $request) {
        $post = $request->except('_token');
        $date_end = strtotime(str_replace('-','',$post['date_end']));
        $post['date_end'] = date('Y-m-d H:i:s',$date_end);
        if((($post['referral_status']??false) == '1') && time()>$date_end){
            return back()->withInput()->withErrors(['End date should be greater than now']);
        }elseif(!($post['referral_status']??false) && $date_end > time()){
            $post['date_end'] = date('Y-m-d H:i:s',time()-1);
        }
        $update = MyHelper::post('referral/settingUpdate',$post);
        if(($update['status']??'')=='success'){
            return back()->with('success',['Success update setting']);
        }else{
            return back()->withInput()->withErrors($update['messages']??['Failed update setting']);
        }
    }
}