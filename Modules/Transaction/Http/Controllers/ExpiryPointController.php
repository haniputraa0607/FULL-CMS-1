<?php

namespace Modules\Transaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\URL;

use App\Lib\MyHelper;
use Session;

class ExpiryPointController extends Controller
{
    public function settingExpiryPoint(Request $request){
        $post = $request->except('_token');
        $data = [
            'title'          => 'Expiry Point',
            'menu_active'    => 'expiry-point',
            'sub_title'      => 'Setting Expiry Point',
            'submenu_active' => 'transaction-setting-expiry-point'
        ];

        if(empty($post)){
            $data['result'] = MyHelper::get('expiry-point/setting')['result']??[];
            return view('transaction::setting.expiry_point', $data);
        }else{
            $save = MyHelper::post('expiry-point/setting', $post);
            if($save['status']??false){
                return back()->withSuccess(['Success update setting']);
            }else{
                return back()->withErrors(['Failed update setting']);
            }
        }
    }

    public function reportNotification(Request $request){
        $post = $request->except('_token');
        $data = [
            'title'          => 'Expiry Point',
            'menu_active'    => 'expiry-point',
            'sub_title'      => 'Report Notification Expiry Point',
            'submenu_active' => 'report-notification-expiry-point'
        ];

        $list =  MyHelper::post('expiry-point/report', $post);

        if (isset($list['status']) && $list['status'] == "success") {
            $data['data']          = $list['result']['data'];
            $data['dataTotal']     = $list['result']['total'];
            $data['dataPerPage']   = $list['result']['from'];
            $data['dataUpTo']      = $list['result']['from'] + count($list['result']['data'])-1;
            $data['dataPaginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
        }else{
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        $data['page'] = $post['page']??1;
        return view('transaction::expiry_point.report_notification_expiry_point', $data);
    }

    public function reportNotificationFilter(Request $request) {
        $post = $request->all();
        if (empty($post)) {
            return redirect('transaction/report/expiry-point');
        }

        if ($request->get('page') == null) {
            session(['date_start' => $post['date_start']]);
            session(['date_end'   => $post['date_end']]);
            if (isset($post['conditions'])) {
                session(['conditions' => $post['conditions']]);
                session(['rule'       => $post['rule']]);
            }
        } else {
            $post['date_start'] = session('date_start');
            $post['date_end']   = session('date_end');
            if (!empty(session('conditions'))) {
                $post['conditions'] = session('conditions');
                $post['rule']       = session('rule');
            }
        }

        $data = [
            'title'          => 'Expiry Point',
            'menu_active'    => 'expiry-point',
            'sub_title'      => 'Report Notification Expiry Point',
            'submenu_active' => 'report-notification-expiry-point',
            'date_start'     => $post['date_start'],
            'date_end'       => $post['date_end'],
            'rule'           => $post['rule'],
        ];

        if (isset($post['conditions'])) {
            $data['conditions'] = $post['conditions'];
        }

        $list = MyHelper::post('expiry-point/report?page='.$request->get('page'), $data);
        if (isset($list['status']) && $list['status'] == 'success') {
            if (isset($list['status']) && $list['status'] == "success") {
                $data['data']          = $list['result']['data'];
                $data['dataTotal']     = $list['result']['total'];
                $data['dataPerPage']   = $list['result']['from'];
                $data['dataUpTo']      = $list['result']['from'] + count($list['result']['data'])-1;
                $data['dataPaginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
            }else{
                $data['data']          = [];
                $data['dataTotal']     = 0;
                $data['dataPerPage']   = 0;
                $data['dataUpTo']      = 0;
                $data['dataPaginator'] = false;
            }

            $data['count']      = $data['dataTotal']??0;
            $data['rule']       = $post['rule'];
            $data['search']     = '1';
            $data['page'] = $post['page']??1;

        } elseif (isset($list['status']) && $list['status'] == 'fail') {
            return back()->withErrors($list['messages']);
        } else {
            return view('transaction::expiry_point.report_notification_expiry_point', $data)->withErrors(['Data not found']);
        }

        return view('transaction::expiry_point.report_notification_expiry_point', $data);
    }

    public function reportNotificationOutbox(Request $request, $type, $id){
        $post = $request->except('_token');
        $data = [
            'title'          => 'Expiry Point',
            'menu_active'    => 'expiry-point',
            'sub_title'      => 'Report Notification Expiry Point '.ucwords(str_replace('-',' ', $type)),
            'submenu_active' => 'report-notification-expiry-point'
        ];

        $post['type'] = $type;
        $post['id_notification_expiry_point_sent_user'] = $id;
        $list =  MyHelper::post('expiry-point/report/outbox', $post);

        if (isset($list['status']) && $list['status'] == "success") {
            $data['data']          = $list['result']['data'];
            $data['dataTotal']     = $list['result']['total'];
            $data['dataPerPage']   = $list['result']['from'];
            $data['dataUpTo']      = $list['result']['from'] + count($list['result']['data'])-1;
            $data['dataPaginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
        }else{
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        $data['page'] = $post['page']??1;
        $data['id_notification_expiry_point_sent_user'] = $post['page']??1;
        return view('transaction::expiry_point.'.str_replace('-', '_', $type), $data);
    }

    public function processingNowExpiryPoint(){
        $send = MyHelper::get('expiry-point/notification/processing-now');
        return $send;
    }

    public function processingNowAdjustmentPoint(){
        $send = MyHelper::get('adjustment-point/processing-now');
        return $send;
    }
}
