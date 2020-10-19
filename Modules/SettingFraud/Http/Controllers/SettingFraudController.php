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

        $config = MyHelper::get('setting-fraud/config');
        if(isset($config['status']) && $config['status'] == 'success'){
            $data['config'] = $config['result']['is_active'];
        }else{
            $data['config'] = null;
        }

        $getApiKey = MyHelper::get('setting/whatsapp');
        if(isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']){
            $data['api_key_whatsapp'] = $getApiKey['result']['value'];
        }else{
            $data['api_key_whatsapp'] = null;
        }

        $textReplace = MyHelper::get('autocrm/textreplace');
        if(isset($textReplace['status']) && $textReplace['status'] == 'success'){
            $data['textreplaces'] = $textReplace['result'];
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

        $data['textreplaces_point'] = $data['textreplaces'];
        $data['textreplaces_point'][] = [
            'keyword' => '%point%',
            'reference' => 'user point'
        ];

        $data['textreplaces_between'] = $data['textreplaces'];
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

    //======================== Start Fraud list Report ========================//
    function fraudReportDevice(Request $request){
        $post = $request->except('_token');
        $exportStatus = 0;
        if(isset($post['export-excel'])){
            $exportStatus = 1;
        }

        if(Session::has('filter-fraud-log-device') && !isset($post['filter'])){
            $post = Session::get('filter-fraud-log-device');
        }else{
            Session::forget('filter-fraud-log-device');
        }
        $type_view = 'device';
        $data = [
            'title'          => 'Report',
            'sub_title'      => 'Report Fraud Device',
            'menu_active'    => 'fraud-detection',
            'submenu_active' => 'report-fraud-device',
        ];
        $data['outlets'] = [];

        $post['export'] = $exportStatus;
        $url = 'fraud/list/log/device';
        $list = MyHelper::post($url, $post);

        if(isset($list['status']) && $list['status'] == 'success'){
            //process export
            if($exportStatus == 1){
                $arr['All Type'] = [];
                foreach ($list['result'] as $value){
                    foreach ($value['users_fraud'] as $dtUser){
                        $dt = [
                            'Nama customer' => $dtUser['name'],
                            'No HP' => $dtUser['phone'],
                            'Email' => $dtUser['email'],
                            'Device ID' => $value['device_id'],
                            'Device Type' => $value['device_type'],
                            'Tanggal login' => date('d F Y', strtotime($dtUser['last_login'])),
                            'Waktu login' => date('H:i', strtotime($dtUser['last_login'])),
                            'Tanggal Fraud' => date('d F Y', strtotime($dtUser['log_date'])),
                            'Waktu Fraud' => date('H:i', strtotime($dtUser['log_date']))
                        ];
                        $arr['All Type'][] = $dt;
                    }
                }

                $data = new MultisheetExport($arr);
                return Excel::download($data,'Fraud_device_'.date('Ymdhis').'.xls');
            }
            $data['result'] = $list['result'];
        }else{
            $data['result'] = [];
        }
        $data['type'] = 'device';
        $data['conditions'] = [];

        if($post){
            if(isset($post['conditions'])){
                $data['conditions'] = $post['conditions'];
            }

            if(isset($post['date_start']) && isset($post['date_end'])){
                $data['date_start'] = $post['date_start'];
                $data['date_end'] = $post['date_end'];
                Session::put('filter-fraud-log-device',$data);
            }
        }

        return view('settingfraud::report.report_fraud_device', $data);
    }

    function fraudReportTrxPoint(Request $request){
        $post = $request->except('_token');
        $exportStatus = 0;
        if(isset($post['export-excel'])){
            $exportStatus = 1;
        }

        if(Session::has('filter-fraud-log-trx-point') && !isset($post['filter'])){
            $post = Session::get('filter-fraud-log-trx-point');
        }else{
            Session::forget('filter-fraud-log-trx-point');
        }
        $type_view = 'transaction_point';
        $data = [
            'title'          => 'Report',
            'sub_title'      => 'Report Fraud Transaction Point',
            'menu_active'    => 'fraud-detection',
            'submenu_active' => 'report-fraud-transaction-point',
        ];
        $getOutlet = MyHelper::get('outlet/be/list');
        if($getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = [];

        $post['export'] = $exportStatus;
        $url = 'fraud/list/log/transaction-point';
        $list = MyHelper::post($url, $post);

        if(isset($list['status']) && $list['status'] == 'success'){
            //process export
            if($exportStatus == 1){
                $arr['All Type'] = [];
                foreach ($list['result'] as $value){
                    $dt = [
                        'Nama customer' => $value['name'],
                        'No HP' => $value['phone'],
                        'Email' => $value['email'],
                        'Tanggal Fraud' => date('d F Y', strtotime($value['created_at'])),
                        'Waktu Fraud' => date('H:i', strtotime($value['created_at'])),
                        'Outlet' => $value['most_outlet']['outlet_name']
                    ];
                    $arr['All Type'][] = $dt;
                }

                $data = new MultisheetExport($arr);
                return Excel::download($data,'Fraud_transaction_point_'.date('Ymdhis').'.xls');
            }
            $data['result'] = $list['result'];
        }else{
            $data['result'] = [];
        }
        $data['type'] = 'transaction-point';
        $data['conditions'] = [];

        if($post){
            if(isset($post['conditions'])){
                $data['conditions'] = $post['conditions'];
            }

            if(isset($post['date_start']) && isset($post['date_end'])){
                $data['date_start'] = $post['date_start'];
                $data['date_end'] = $post['date_end'];
                Session::put('filter-fraud-log-trx-point',$data);
            }
        }
        return view('settingfraud::report.report_fraud_transaction_point', $data);
    }

    function fraudReportTrx(Request $request, $type){
        $post = $request->except('_token');
        $exportStatus = 0;
        if(isset($post['export-excel'])){
            $exportStatus = 1;
        }

        if($type == 'transaction-day'){
            if(Session::has('filter-fraud-log-trx-day') && !isset($post['filter'])){
                $post = Session::get('filter-fraud-log-trx-day');
            }else{
                Session::forget('filter-fraud-log-trx-day');
            }

            $type_view = 'transaction_day';
            $data = [
                'title'          => 'Report',
                'sub_title'      => 'Report Fraud Transaction Day',
                'menu_active'    => 'fraud-detection',
                'submenu_active' => 'report-fraud-transaction-day',
            ];
        }elseif($type == 'transaction-week'){
            if(Session::has('filter-fraud-log-trx-week') && !isset($post['filter'])){
                $post = Session::get('filter-fraud-log-trx-week');
            }else{
                Session::forget('filter-fraud-log-trx-week');
            }
            $type_view = 'transaction_week';
            $data = [
                'title'          => 'Report',
                'sub_title'      => 'Report Fraud Transaction Week',
                'menu_active'    => 'fraud-detection',
                'submenu_active' => 'report-fraud-transaction-week',
            ];
        }elseif($type == 'transaction-between'){
            if(Session::has('filter-fraud-log-trx-between') && !isset($post['filter'])){
                $post = Session::get('filter-fraud-log-trx-between');
            }else{
                Session::forget('filter-fraud-log-trx-between');
            }
            $type_view = 'transaction_between';
            $data = [
                'title'          => 'Report',
                'sub_title'      => 'Report Fraud Transaction in Between',
                'menu_active'    => 'fraud-detection',
                'submenu_active' => 'report-fraud-transaction-between',
            ];
        }

        $getOutlet = MyHelper::get('outlet/be/list');
        if($getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = [];

        $post['export'] = $exportStatus;
        $url = 'fraud/list/log/'.$type;
        $list = MyHelper::post($url, $post);

        if(isset($list['status']) && $list['status'] == 'success'){
            //process export
            if($exportStatus == 1){
                $arr['All Type'] = [];
                foreach ($list['result'] as $value) {
                    $dt = [
                        'Nama customer' => $value['name'],
                        'No HP' => $value['phone'],
                        'Email' => $value['email'],
                        'Tanggal Fraud' => date('d F Y', strtotime($value['log_date'])),
                        'Waktu Fraud' => date('H:i', strtotime($value['log_date'])),
                        'Tanggal transaksi' => date('d F Y', strtotime($value['transaction_date'])),
                        'Jam transaksi' => date('H:i', strtotime($value['transaction_date'])),
                        'Lokasi transaksi' => $value['outlet_name'],
                        'Nominal transaksi' => number_format($value['transaction_grandtotal'], 2),
                    ];
                    $arr['All Type'][] = $dt;
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

        if($post){
            if(isset($post['conditions'])){
                $data['conditions'] = $post['conditions'];
            }

            if(isset($post['date_start']) && isset($post['date_end'])){
                $data['date_start'] = $post['date_start'];
                $data['date_end'] = $post['date_end'];
                if($type == 'transaction-day'){
                    Session::put('filter-fraud-log-trx-day',$data);
                }elseif($type == 'transaction-week'){
                    Session::put('filter-fraud-log-trx-week',$data);
                }elseif($type == 'transaction-between'){
                    Session::put('filter-fraud-log-trx-between',$data);
                }
            }
        }

        return view('settingfraud::report.report_fraud_'.$type_view, $data);
    }

    function fraudReportReferral(Request $request){
        $post = $request->except('_token');
        $exportStatus = 0;
        if(isset($post['export-excel'])){
            $exportStatus = 1;
        }

        if(Session::has('filter-fraud-log-referral') && !isset($post['filter'])){
            $post = Session::get('filter-fraud-log-referral');
        }else{
            Session::forget('filter-fraud-log-referral');
        }
        $type_view = 'transaction_point';
        $data = [
            'title'          => 'Report',
            'sub_title'      => 'Report Fraud Referral',
            'menu_active'    => 'fraud-detection',
            'submenu_active' => 'report-fraud-referral',
        ];
        $getOutlet = MyHelper::get('outlet/be/list');
        if($getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = [];

        $post['export'] = $exportStatus;
        $url = 'fraud/list/log/referral';
        $list = MyHelper::post($url, $post);

        if(isset($list['status']) && $list['status'] == 'success'){
            //process export
            if($exportStatus == 1){
                $arr['All Type'] = [];
                foreach ($list['result'] as $value){
                    $dt = [
                        'Nama customer' => $value['name'],
                        'No HP' => $value['phone'],
                        'Email' => $value['email'],
                        'Receipt Number' => $value['transaction_receipt_number'],
                        'Outlet' => $value['outlet_name'],
                        'Tanggal Transaksi' => date('d F Y', strtotime($value['referral_code_use_date'])),
                        'Waktu Transaksi' => date('H:i', strtotime($value['referral_code_use_date'])),
                        'Referral code' => $value['referral_code']
                    ];
                    $arr['All Type'][] = $dt;
                }

                $data = new MultisheetExport($arr);
                return Excel::download($data,'Fraud_referral_user_'.date('Ymdhis').'.xls');
            }
            $data['result'] = $list['result'];
        }else{
            $data['result'] = [];
        }
        $data['type'] = 'referral-user';
        $data['conditions'] = [];

        if($post){
            if(isset($post['conditions'])){
                $data['conditions'] = $post['conditions'];
            }

            if(isset($post['date_start']) && isset($post['date_end'])){
                $data['date_start'] = $post['date_start'];
                $data['date_end'] = $post['date_end'];
                Session::put('filter-fraud-log-referral-user',$data);
            }
        }
        return view('settingfraud::report.report_fraud_referral', $data);
    }

    function fraudReportReferralUser(Request $request){
        $post = $request->except('_token');
        $exportStatus = 0;
        if(isset($post['export-excel'])){
            $exportStatus = 1;
        }

        if(Session::has('filter-fraud-log-referral-user') && !isset($post['filter'])){
            $post = Session::get('filter-fraud-log-referral-user');
        }else{
            Session::forget('filter-fraud-log-referral-user');
        }
        $type_view = 'transaction_point';
        $data = [
            'title'          => 'Report',
            'sub_title'      => 'Report Fraud Referral User',
            'menu_active'    => 'fraud-detection',
            'submenu_active' => 'report-fraud-referral-user',
        ];
        $getOutlet = MyHelper::get('outlet/be/list');
        if($getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = [];

        $post['export'] = $exportStatus;
        $url = 'fraud/list/log/referral-user';
        $list = MyHelper::post($url, $post);

        if(isset($list['status']) && $list['status'] == 'success'){
            //process export
            if($exportStatus == 1){
                $arr['All Type'] = [];
                foreach ($list['result'] as $value){
                    $dt = [
                        'Nama customer' => $value['name'],
                        'No HP' => $value['phone'],
                        'Email' => $value['email'],
                        'Receipt Number' => $value['transaction_receipt_number'],
                        'Outlet' => $value['outlet_name'],
                        'Tanggal Transaksi' => date('d F Y', strtotime($value['referral_code_use_date'])),
                        'Waktu Transaksi' => date('H:i', strtotime($value['referral_code_use_date'])),
                        'Referral code' => $value['referral_code']
                    ];
                    $arr['All Type'][] = $dt;
                }

                $data = new MultisheetExport($arr);
                return Excel::download($data,'Fraud_referral_user_'.date('Ymdhis').'.xls');
            }
            $data['result'] = $list['result'];
        }else{
            $data['result'] = [];
        }
        $data['type'] = 'referral-user';
        $data['conditions'] = [];

        if($post){
            if(isset($post['conditions'])){
                $data['conditions'] = $post['conditions'];
            }

            if(isset($post['date_start']) && isset($post['date_end'])){
                $data['date_start'] = $post['date_start'];
                $data['date_end'] = $post['date_end'];
                Session::put('filter-fraud-log-referral-user',$data);
            }
        }
        return view('settingfraud::report.report_fraud_referral_user', $data);
    }

    function fraudReportPromoCode(Request $request){
        $post = $request->except('_token');
        $exportStatus = 0;
        if(isset($post['export-excel'])){
            $exportStatus = 1;
        }

        if(Session::has('filter-fraud-log-promo-code') && !isset($post['filter'])){
            $post = Session::get('filter-fraud-log-promo-code');
        }else{
            Session::forget('filter-fraud-log-promo-code');
        }

        $data = [
            'title'          => 'Report',
            'sub_title'      => 'Report Fraud Promo Code',
            'menu_active'    => 'fraud-detection',
            'submenu_active' => 'report-fraud-promo-code',
        ];
        $getOutlet = MyHelper::get('outlet/be/list');
        if($getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = [];

        $post['export'] = $exportStatus;
        $url = 'fraud/list/log/promo-code';
        $list = MyHelper::post($url, $post);

        if(isset($list['status']) && $list['status'] == 'success'){
            //process export
            if($exportStatus == 1){
                $arr['All Type'] = [];
                foreach ($list['result'] as $value){
                    $dt = [
                        'Nama customer' => $value['name'],
                        'No HP' => $value['phone'],
                        'Email' => $value['email'],
                        'Tanggal Fraud' => date('d F Y', strtotime($value['created_at'])),
                        'Waktu Fraud' => date('H:i', strtotime($value['created_at']))
                    ];
                    $arr['All Type'][] = $dt;
                }

                $data = new MultisheetExport($arr);
                return Excel::download($data,'Fraud_promo_code_'.date('Ymdhis').'.xls');
            }
            $data['result'] = $list['result'];
        }else{
            $data['result'] = [];
        }
        $data['type'] = 'promo-code';
        $data['conditions'] = [];

        if($post){
            if(isset($post['conditions'])){
                $data['conditions'] = $post['conditions'];
            }

            if(isset($post['date_start']) && isset($post['date_end'])){
                $data['date_start'] = $post['date_start'];
                $data['date_end'] = $post['date_end'];
                Session::put('filter-fraud-log-promo-code',$data);
            }
        }
        return view('settingfraud::report.report_fraud_promo_code', $data);
    }
    //======================== End Fraud list Report ========================//

    public function fraudReportDeviceDetail(Request $request, $device_id){
        $data = [
            'title'          => 'Report',
            'sub_title'      => 'Detail',
            'menu_active'    => 'fraud-detection',
            'submenu_active' => 'report-fraud-device',
            'device_id'      => $device_id
        ];

        $detail = MyHelper::post('fraud/detail/log/device', ['device_id' => $device_id]);
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

        $detail = MyHelper::post('fraud/detail/log/transaction-day', ['id_fraud_detection_log_transaction_day' => $id]);
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

        $detail = MyHelper::post('fraud/detail/log/transaction-week', ['id_fraud_detection_log_transaction_week' => $id]);

        if(isset($detail['status']) && $detail['status'] == 'success'){
            $data['result'] = $detail['result'];
        }else{
            $data['result'] = [];
        }
        $data['id_fraud_log'] = $id;
        return view('settingfraud::report.report_fraud_transaction_week_detail', $data);
    }

    public function fraudReportTransactionBetweenDetail(Request $request, $id_user, $date){

        $data = [
            'title'          => 'Report',
            'sub_title'      => 'Detail',
            'menu_active'    => 'fraud-detection',
            'submenu_active' => 'report-fraud-device',
        ];

        $detail = MyHelper::post('fraud/detail/log/transaction-between', ['id_user' => $id_user, 'date_fraud' => $date]);

        if(isset($detail['status']) && $detail['status'] == 'success'){
            $data['result'] = $detail['result'];
        }else{
            $data['result'] = [];
        }

        return view('settingfraud::report.report_fraud_transaction_between_detail', $data);
    }

    public function fraudReportPromoCodeDetail(Request $request, $id){
        $data = [
            'title'          => 'Report',
            'sub_title'      => 'Detail',
            'menu_active'    => 'fraud-detection',
            'submenu_active' => 'report-fraud-promo-code'
        ];

        $detail = MyHelper::post('fraud/detail/log/promo-code', ['id_fraud_detection_log_check_promo_code' => $id]);
        if(isset($detail['status']) && $detail['status'] == 'success'){
            $data['result'] = [
                'list_promo_code' => $detail['result']['list_promo_code'],
                'detail_fraud' => $detail['result']['detail_fraud']
            ];
        }else{
            $data['result'] = [
                'list_promo_code' => [],
                'detail_fraud' => []
            ];
        }

        return view('settingfraud::report.report_fraud_promo_code_detail', $data);
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
        $update = MyHelper::post('fraud/detail/log/update', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return ['status' => 'success', 'messages' => 'Success update status'];
        }elseif (isset($update['status']) && $update['status'] == 'fail') {
            return ['status' => 'fail', 'messages' => 'Failed update status'];
        } else {
            return ['status' => 'fail', 'messages' => 'Something went wrong. Failed update status'];
        }
    }

    public function logFraudUser(Request $request){
        $post = $request->except('_token');
        if(Session::has('filter-user-fraud') && !isset($post['filter'])){
            $post = Session::get('filter-user-fraud');
        }else{
            Session::forget('filter-user-fraud');
        }
        $take = 20;

        $data = [
            'title'          => 'List User Fraud',
            'sub_title'      => 'List User Fraud',
            'menu_active'    => 'fraud-detection',
            'submenu_active' => 'suspend-user',
        ];

        $post['skip'] = 0;
        if(isset($post['page'])){
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
        }

        if(isset($post['date_start']) && isset($post['date_end'])){
            $data['date_start'] = $post['date_start'];
            $data['date_end'] = $post['date_end'];
            Session::put('filter-user-fraud',$data);
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
        $update = MyHelper::post('fraud/device-login/update-status', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return ['status' => 'success', 'messages' => 'Success update status'];
        }elseif (isset($update['status']) && $update['status'] == 'fail') {
            return ['status' => 'fail', 'messages' => 'Failed update status'];
        } else {
            return ['status' => 'fail', 'messages' => 'Something went wrong. Failed update status'];
        }
    }
}