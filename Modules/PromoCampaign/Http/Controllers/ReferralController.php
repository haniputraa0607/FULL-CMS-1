<?php

namespace Modules\PromoCampaign\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use \App\Lib\MyHelper;

class ReferralController extends Controller
{
    public function getReportFilter($type){
        return session('filter_report_'.$type,[]);
    }
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function report(Request $request){
        $data = [
            'title'             => 'Referral',
            'sub_title'         => 'Referral Report',
            'menu_active'       => 'referral',
            'submenu_active'    => 'referral-report'
        ];
        $filter = $this->getReportFilter('trx');
        $data['date_start'] = date('d F Y',strtotime($filter['date_start']??date('Y-m-01 H:i:s')));
        $data['date_end'] = date('d F Y',strtotime($filter['date_end']??date('Y-m-d H:i:s')));
        return view('promocampaign::referral.report',$data);
    }
    public function setReportFilter(Request $request){
        $post = $request->except('_token');
        $new_sess = [];
        if($request->post('date_start')){
            $new_sess['date_start'] = str_replace('-','',$request->post('date_start',date('01 M Y')));
        }
        if($request->post('date_end')){
            $new_sess['date_end'] = str_replace('-','',$request->post('date_end',date('d M Y')));
        }
        if($request->post('order_by')){
            $new_sess['order_by'] = str_replace('-','',$request->post('order_by',date('d M Y')));
        }
        if($request->post('order_sorting')){
            $new_sess['order_sorting'] = str_replace('-','',$request->post('order_sorting',date('d M Y')));
        }
        session(['filter_report_'.$post['type']=>$new_sess]);
        if($request->ajax){
            return ['status'=>'success'];
        }
        return $request->redirect_url?redirect($request->redirect_url):back();
    }
    public function reportAjax(Request $request,$key){
        $page = $request->page?:1;
        $filter = $this->getReportFilter(explode('-',$key)[0]);
        $filter['page'] = $page;
        $filter = array_merge($filter,$request->except('_token'));
        // return MyHelper::post('referral/report/'.$key,$filter);
        $raw_data = MyHelper::post('referral/report/'.$key,$filter)['result']??[];
        $data['data'] = $raw_data['data'];
        $data['total'] = $raw_data['total']??0;
        $data['from'] = $raw_data['from']??0;
        $data['order_by'] = $raw_data['order_by']??0;
        $data['order_sorting'] = $raw_data['order_sorting']??0;
        $data['last_page'] = !($raw_data['next_page_url']??false);
        return $data;
    }

    public function reportUser(Request $request,$phone){
        $data = [
            'title'             => 'Referral',
            'sub_title'         => 'Referral Report',
            'menu_active'       => 'referral',
            'submenu_active'    => 'referral-report'
        ];
        $page = $request->page?:1;
        $filter = $this->getReportFilter('user');
        $data['date_start'] = date('d F Y',strtotime($filter['date_start']??date('Y-m-01 H:i:s')));
        $data['date_end'] = date('d F Y',strtotime($filter['date_end']??date('Y-m-d H:i:s')));
        if($request->ajax){
            $raw_data = MyHelper::post('referral/report/user',['phone'=>$phone,'page'=>$page,'ajax'=>1]+$data)['result']??[];
            $datax['data'] = array_map(function($var){
                $var['created_at'] = date('d F Y H:i',strtotime($var['created_at']));
                return $var;
            },$raw_data['data']??[]);
            $datax['from'] = $raw_data['from']??0;
            $datax['last_page'] = !($raw_data['next_page_url']??false);
            return $datax;
        }
        // return MyHelper::post('referral/report/user-total',['phone'=>$phone,'page'=>$page]);
        $data['report'] = MyHelper::post('referral/report/user-total',['phone'=>$phone,'page'=>$page])['result']??[];
        return view('promocampaign::referral.report_user',$data);
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