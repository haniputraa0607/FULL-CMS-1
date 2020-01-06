<?php

namespace Modules\SettingFraud\Http\Controllers;

use App\Exports\MultisheetExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;

use App\Lib\MyHelper;
use Excel;

class SettingFraudController extends Controller
{
    public function index(Request $request){
        $post = $request->except('_token');

        //update data
        if($post){
            if(isset($post['files'])){
                unset($post['files']);
            }
            $save = MyHelper::post('setting-fraud/update', $post);

            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('setting-fraud-detection#'.$post['type'])->withSuccess(['Setting fraud detection has been updated.']);
            }else {
                if (isset($save['errors'])) {
                    return back()->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }

                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
        }

        $data = [
            'title'          => 'Setting',
            'sub_title'      => 'Fraud Detection',
            'menu_active'    => 'fraud-detection',
            'submenu_active' => 'fraud-detection-update',
        ];

        $getSetting = MyHelper::post('setting-fraud', []);

        if(isset($getSetting['status']) && $getSetting['status'] == 'success'){
            $data['result'] = $getSetting['result'];
        }else{
            $data['result'] = null;
        }

        $getApiKey = MyHelper::get('setting/whatsapp');
        if(isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']){
            $data['api_key_whatsapp'] = $getApiKey['result']['value'];
        }else{
            $data['api_key_whatsapp'] = null;
        }

        $test = MyHelper::get('autocrm/textreplace');
        if($test['status'] == 'success'){
            $data['textreplaces'] = $test['result'];
        }

        $data['textreplaces'][] = [
            'keyword' => '%fraud_date%',
            'reference' => 'fraud date'
        ];

        $data['textreplaces'][] = [
            'keyword' => '%fraud_time%',
            'reference' => 'fraud time'
        ];

        $data['textreplaces_day'] = $data['textreplaces'];
        $data['textreplaces_day'][] = [
            'keyword' => '%transaction_count_day%',
            'reference' => 'number of transaction in 1 day'
        ];
        $data['textreplaces_day'][] = [
            'keyword' => '%receipt_number%',
            'reference' => 'receipt number'
        ];
        $data['textreplaces_day'][] = [
            'keyword' => '%list_transaction_day%',
            'reference' => 'list transaction'
        ];
        $data['textreplaces_day'][] = [
            'keyword' => '%area_outlet%',
            'reference' => 'area outlet'
        ];

        $data['textreplaces_week'] = $data['textreplaces'];
        $data['textreplaces_week'][] = [
            'keyword' => '%transaction_count_week%',
            'reference' => 'number of transaction in 1 week'
        ];
        $data['textreplaces_week'][] = [
            'keyword' => '%receipt_number%',
            'reference' => 'receipt number'
        ];
        $data['textreplaces_week'][] = [
            'keyword' => '%list_transaction_week%',
            'reference' => 'list transaction'
        ];
        $data['textreplaces_week'][] = [
            'keyword' => '%area_outlet%',
            'reference' => 'area outlet'
        ];

        $data['textreplaces_device'] = $data['textreplaces'];
        $data['textreplaces_device'][] = [
            'keyword' => '%device_type%',
            'reference' => 'device type used'
        ];

        $data['textreplaces_device'][] = [
            'keyword' => '%device_id%',
            'reference' => 'device id used'
        ];

        $data['textreplaces_device'][] = [
            'keyword' => '%count_account%',
            'reference' => 'number of account'
        ];

        $data['textreplaces_device'][] = [
            'keyword' => '%user_list%',
            'reference' => 'user list realted this device ID'
        ];

        return view('settingfraud::index', $data);
    }

    public function updateStatus(Request $request){
        $post = $request->except('_token');
        $update = MyHelper::post('setting-fraud/update/status', $post);
        if (isset($update['status']) && $update['status'] == "success") {
            return ['status' => 'success'];
        }elseif (isset($update['status']) && $update['status'] == 'fail') {
            return ['status' => 'fail', 'messages' => $update['messages']];
        } else {
            return ['status' => 'fail', 'messages' => 'Something went wrong. Failed update fraud status'];
        }
    }

    public function list(){
        $data = [ 'title'             => 'Setting Fraud Detection List',
            'menu_active'       => 'fraud-detection',
            'submenu_active'    => 'campaign-list'
        ];

        $action = MyHelper::get('setting-fraud');

        if (isset($action['status']) && $action['status'] == "success") {
            $data['list'] = $action['result'];
        }
        else {
            $data['list'] = [];
        }

        return view('settingfraud::list', $data);
    }

    public function detail(Request $request, $id)
    {
        $post = $request->except('_token');

        //update data
        if($post){
            if(isset($post['files'])){
                unset($post['files']);
            }
            $save = MyHelper::post('setting-fraud/update', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('setting-fraud-detection/detail/'.$id)->withSuccess(['Setting fraud detection has been updated.']);
            }else {
                if (isset($save['errors'])) {
                    return back()->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }

                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
        }

        $data = [
            'title'          => 'Setting',
            'sub_title'      => 'Fraud Detection',
            'menu_active'    => 'fraud-detection',
            'submenu_active' => 'fraud-detection',
        ];

        $getSetting = MyHelper::post('setting-fraud', ['id_fraud_setting' => $id]);

        if(isset($getSetting['status']) && $getSetting['status'] == 'success'){
            $data['result'] = $getSetting['result'];
        }else{
            $data['result'] = null;
        }

        $getApiKey = MyHelper::get('setting/whatsapp');
        if(isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']){
            $data['api_key_whatsapp'] = $getApiKey['result']['value'];
        }else{
            $data['api_key_whatsapp'] = null;
        }

        $test = MyHelper::get('autocrm/textreplace');
        if($test['status'] == 'success'){
            $data['textreplaces'] = $test['result'];
        }

        $data['textreplaces'][] = [
            'keyword' => '%transaction_count_day%',
            'reference' => 'number of transaction in 1 day'
        ];

        $data['textreplaces'][] = [
            'keyword' => '%transaction_count_week%',
            'reference' => 'number of transaction in 1 week'
        ];

        $data['textreplaces'][] = [
            'keyword' => '%last_device_type%',
            'reference' => 'last device type used'
        ];

        $data['textreplaces'][] = [
            'keyword' => '%last_device_id%',
            'reference' => 'last device id used'
        ];

        $data['textreplaces'][] = [
            'keyword' => '%last_device_token%',
            'reference' => 'last device token used'
        ];

        return view('settingfraud::detail', $data);
    }

    public function fraudReport(Request $request, $type){
        $post = $request->except('_token');
        $exportStatus = 0;
        if(isset($post['export-excel'])){
            $exportStatus = 1;
        }
        if($post && !isset($post['conditions'])){
            if($type == 'device'){
                $post = Session::get('filter-fraud-log-device');
            }elseif($type == 'transaction-day'){
                $post = Session::get('filter-fraud-log-trx-day');
            }elseif($type == 'transaction-week'){
                $post = Session::get('filter-fraud-log-trx-week');
            }
            $post['export'] = $exportStatus;
        }

        if($type == 'device'){
            $type_view = 'device';
            $data = [
                'title'          => 'Report',
                'sub_title'      => 'Report Fraud Device',
                'menu_active'    => 'fraud-detection',
                'submenu_active' => 'report-fraud-device',
            ];
            $data['outlets'] = [];
        }elseif($type == 'transaction-day'){
            $type_view = 'transaction_day';
            $data = [
                'title'          => 'Report',
                'sub_title'      => 'Report Fraud Transaction Day',
                'menu_active'    => 'fraud-detection',
                'submenu_active' => 'report-fraud-transaction-day',
            ];
            $getOutlet = MyHelper::get('outlet/be/list');
            if($getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = [];
        }elseif($type == 'transaction-week'){
            $type_view = 'transaction_week';
            $data = [
                'title'          => 'Report',
                'sub_title'      => 'Report Fraud Transaction Week',
                'menu_active'    => 'fraud-detection',
                'submenu_active' => 'report-fraud-transaction-week',
            ];
            $getOutlet = MyHelper::get('outlet/be/list');
            if($getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = [];
        }

        $url = 'setting-fraud/list/log/'.$type;
        $list = MyHelper::post($url, $post);

        if(isset($list['status']) && $list['status'] == 'success'){
            if($exportStatus == 1){
                $arr['All Type'] = [];
                if($type == 'device'){
                    foreach ($list['result'] as $value){
                        foreach ($value['all_usersdevice'] as $dtUser){
                            $dt = [
                                'Nama customer' => $dtUser['name'],
                                'No HP' => $dtUser['phone'],
                                'Email' => $dtUser['email'],
                                'Device ID' => $value['device_id'],
                                'Device Type' => $value['device_type'],
                                'Tanggal login' => date('d F Y H:i', strtotime($dtUser['last_login']))
                            ];
                            $arr['All Type'][] = $dt;
                        }
                    }
                }elseif($type == 'transaction-day' || $type == 'transaction-week'){
                    foreach ($list['result'] as $value){
                        if($type == 'transaction-day'){
                            $count = $value['count_transaction_day'];
                        }else{
                            $count = $value['count_transaction_week'];
                        }
                        $dt = [
                            'Nama customer' => $value['name'],
                            'No HP' => $value['phone'],
                            'Email' => $value['email'],
                            'Tanggal transaksi' => date('d F Y', strtotime($value['transaction_date'])),
                            'Jam transaksi' => date('H:i', strtotime($value['transaction_date'])),
                            'Lokasi transaksi' => $value['outlet_name'],
                            'Nominal transaksi' => $value['transaction_grandtotal']
                        ];
                        $arr['All Type'][] = $dt;
                    }
                }

                $data = new MultisheetExport($arr);
                return Excel::download($data,'Fraud_'.$type.'_'.date('Ymdhis').'.xls');
            }
            $data['result'] = $list['result'];
        }else{
            $data['result'] = [];
        }
        $data['type'] = $type;
        $data['conditions'] = [];

        if($post && !isset($post['export'])){
            $data['conditions'] = $post['conditions'];
            $data['date_start'] = $post['date_start'];
            $data['date_end'] = $post['date_end'];
            if($type == 'device'){
                Session::put('filter-fraud-log-device',$data);
            }elseif($type == 'transaction-day'){
                Session::put('filter-fraud-log-trx-day',$data);
            }elseif($type == 'transaction-week'){
                Session::put('filter-fraud-log-trx-week',$data);
            }
        }

        return view('settingfraud::report.report_fraud_'.$type_view, $data);
    }

    public function fraudReportDeviceDetail(Request $request, $device_id){
        $data = [
            'title'          => 'Report',
            'sub_title'      => 'Detail',
            'menu_active'    => 'fraud-detection',
            'submenu_active' => 'report-fraud-device',
            'device_id'      => $device_id
        ];

        $detail = MyHelper::post('setting-fraud/detail/log/device', ['device_id' => $device_id]);
        if(isset($detail['status']) && $detail['status'] == 'success'){
            $data['result'] = [
                'detail_user' => $detail['result']['detail_user'],
                'detail_fraud' => $detail['result']['detail_fraud']
            ];
        }else{
            $data['result'] = [
                'detail_user' => [],
                'detail_fraud' => []
            ];
        }

        return view('settingfraud::report.report_fraud_device_detail', $data);
    }

    public function fraudReportTransactionDayDetail(Request $request, $id){
        $data = [
            'title'          => 'Report',
            'sub_title'      => 'Detail',
            'menu_active'    => 'fraud-detection',
            'submenu_active' => 'report-fraud-device',
        ];

        $detail = MyHelper::post('setting-fraud/detail/log/transaction-day', ['id_fraud_detection_log_transaction_day' => $id]);
        if(isset($detail['status']) && $detail['status'] == 'success'){
            $data['result'] = $detail['result'];
        }else{
            $data['result'] = [];
        }
        $data['id_fraud_log'] = $id;
        return view('settingfraud::report.report_fraud_transaction_day_detail', $data);
    }

    public function fraudReportTransactionWeekDetail(Request $request, $id){
        $data = [
            'title'          => 'Report',
            'sub_title'      => 'Detail',
            'menu_active'    => 'fraud-detection',
            'submenu_active' => 'report-fraud-device',
        ];

        $detail = MyHelper::post('setting-fraud/detail/log/transaction-week', ['id_fraud_detection_log_transaction_week' => $id]);

        if(isset($detail['status']) && $detail['status'] == 'success'){
            $data['result'] = $detail['result'];
        }else{
            $data['result'] = [];
        }
        $data['id_fraud_log'] = $id;
        return view('settingfraud::report.report_fraud_transaction_week_detail', $data);
    }

    public function updateSuspend(Request $request, $type, $phone){
        $post = $request->except('_token');
        $post['phone'] = $phone;
        $update = MyHelper::post('users/update/suspend', $post);

        if($type == 'device'){
            $device_id = $post['device_id'];
            $url = 'fraud-detection/report/detail/device/'.$device_id;
        }elseif($type == 'transaction-day'){
            $id = $post['id_fraud_log'];
            $url = 'fraud-detection/report/detail/transaction-day/'.$id;
        }elseif($type == 'transaction-week'){
            $id = $post['id_fraud_log'];
            $url = 'fraud-detection/report/detail/transaction-week/'.$id;
        }elseif($type == 'suspend-user'){
            $url = 'fraud-detection/suspend-user/1';
        }

        if(isset($update['status']) && isset($update['status']) == 'success'){
            return redirect($url)->withSuccess(['Success Update Suspend Status']);
        }else{
            return redirect($url)->withErrors(['Failed Update Suspend Status']);
        }

    }

    public function updateStatusLog(Request $request, $type){
        $post = $request->except('_token');
        $post['type'] = $type;
        $update = MyHelper::post('setting-fraud/detail/log/update', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return ['status' => 'success', 'messages' => 'Success update status'];
        }elseif (isset($update['status']) && $update['status'] == 'fail') {
            return ['status' => 'fail', 'messages' => 'Failed update status'];
        } else {
            return ['status' => 'fail', 'messages' => 'Something went wrong. Failed update status'];
        }
    }

    public function suspendUser(Request $request){
        $post = $request->except('_token');
        $take = 20;

        $data = [
            'title'          => 'List User Fraud',
            'sub_title'      => 'List User Fraud',
            'menu_active'    => 'fraud-detection',
            'submenu_active' => 'suspend-user',
        ];

        $post['skip'] = 0;
        if(isset($post['page'])){
            $post['conditions'] = Session::get('filter-user-fraud');
            $page = $post['page'];
            $post['take'] = $take;
            if($post['page'] > 1 ){
                $post['skip'] = $post['page'] + $take;
            }

            $data['page'] = $page;
        }else{
            $post['page'] = 1;
            $post['take'] = $take;

            $data['page'] = $post['page'];
        }

        $data['conditions'] = [];
        $data['type'] = 'suspend';
        $data['outlets'] = [];

        if(isset($post['conditions'])){
            $data['conditions'] = $post['conditions'];
            Session::put('filter-user-fraud',$post['conditions']);
        }

        if(isset($post['date_start']) && isset($post['date_end'])){
            $data['date_start'] = $post['date_start'];
            $data['date_end'] = $post['date_end'];
        }

        $getUser = MyHelper::post('fraud/list/user', $post);

        $data['last'] = $post['page'] + $take;
        if (isset($getUser['status']) && $getUser['status'] == 'success') {
            $data['content'] = $getUser['result'];
            $data['total'] = $getUser['total'];
        }
        else {
            $data['content'] = null;
            $data['total'] = null;
        }

        return view('settingfraud::suspend-user', $data);
    }

    public function detailLogFraudUser(Request $request, $phone){
        $data = [
            'title'          => 'Log Fraud',
            'sub_title'      => 'Log Fraud',
            'menu_active'    => 'fraud-detection',
            'submenu_active' => 'suspend-user',
        ];
        $list = MyHelper::post('fraud/detail/log/user', ['phone' => $phone]);

        if (isset($list['status']) && $list['status'] == 'success') {
            $data['result'] = $list['result'];
        }
        else {
            $data['result'] = [];
        }

        return view('settingfraud::detail-log-user', $data);
    }

    public function searchReset($session)
    {
        Session::forget($session);
        return back();
    }

    public function updateStatusDeviceLogin(Request $request){
        $post = $request->except('_token');
        $update = MyHelper::post('setting-fraud/device-login/update-status', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return ['status' => 'success', 'messages' => 'Success update status'];
        }elseif (isset($update['status']) && $update['status'] == 'fail') {
            return ['status' => 'fail', 'messages' => 'Failed update status'];
        } else {
            return ['status' => 'fail', 'messages' => 'Something went wrong. Failed update status'];
        }
    }
}
