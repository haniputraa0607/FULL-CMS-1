<?php

namespace Modules\Transaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class TransactionSettingController extends Controller
{
    public function list(Request $request)
    {
        $data = [
            'title'          => 'Setting',
            'menu_active'    => 'order',
            'sub_title'      => 'Global '.env('POINT_NAME', 'Points'),
            'submenu_active' => 'transaction-setting'
        ];

        $lists = MyHelper::get('transaction/setting/cashback');

        if (isset($lists['status']) && $lists['status'] == 'success') {
            $data['lists'] = $lists['result'];

            return view('transaction::setting.cashback_list', $data);
        } elseif (isset($lists['status']) && $lists['status'] == 'fail') {
            return view('transaction::setting.cashback_list', $data)->withErrors($lists['messages']);
        } else {
            return view('transaction::setting.cashback_list', $data)->withErrors(['Data not found']);
        }
    }

    public function update(Request $request)
    {
        $post = $request->except('_token');

        $update = MyHelper::post('transaction/setting/cashback/update', $post);
        if (isset($update['status']) && $update['status'] == 'success') {
            return back()->with('success', ['Update setting success']);
        } elseif (isset($update['status']) && $update['status'] == 'fail') {
            return back()->withErrors([$update['messages']]);
        } else {
            return back()->withErrors(['Something went wrong']);
        }
    }

    public function refundRejectOrder(Request $request)
    {
        $data = [
            'title'          => 'Setting',
            'menu_active'    => 'order',
            'sub_title'      => 'Setting Refund Failed Delivery',
            'submenu_active' => 'refund-reject-order'
        ];

        $data['status'] = [
            'refund_midtrans' => MyHelper::post('setting', ['key' => 'refund_midtrans'])['result']['value']??0,
            'refund_ovo' => MyHelper::post('setting', ['key' => 'refund_ovo'])['result']['value']??0,
            'refund_shopeepay' => MyHelper::post('setting', ['key' => 'refund_shopeepay'])['result']['value']??0,
            'refund_failed_process_balance' => MyHelper::post('setting', ['key' => 'refund_failed_process_balance'])['result']['value']??0,
        ];

        $get = MyHelper::post('autocrm/list',['autocrm_title'=>'Payment Void Failed']);
        if(isset($get['status']) && $get['status'] == 'success'){
            $data['result'] = $get['result'];

            $data['textreplaces'] = [];

            $custom = [];
            if (isset($get['result']['custom_text_replace'])) {
                $custom = array_filter(explode(';', $get['result']['custom_text_replace']));
            }
            $data['custom'] = $custom;
        }else{
            $data['result'] = [];
        }

        return view('transaction::setting.refund_reject_order', $data);
    }

    public function updateRefundRejectOrder(Request $request)
    {
        $sendData = [
            'refund_midtrans' => ['value', $request->refund_midtrans?1:0],
            'refund_ovo' => ['value', $request->refund_ovo?1:0],
            'refund_shopeepay' => ['value', $request->refund_shopeepay?1:0],
            'refund_failed_process_balance' => ['value', $request->refund_failed_process_balance?1:0]
        ];
        $data = MyHelper::post('setting/update2', ['update' => $sendData]);

        $updateAutocrm = [
            'id_autocrm' => $request->id_autocrm,
            'autocrm_forward_toogle' => '1',
            'autocrm_forward_email' => $request->autocrm_forward_email,
            'autocrm_forward_email_subject' => $request->autocrm_forward_email_subject,
            'autocrm_forward_email_content' => $request->autocrm_forward_email_content,
        ];
        
        $query = MyHelper::post('autocrm/update', $updateAutocrm);

        if (($data['status']??false) == 'success') {
            return back()->withSuccess(['Success update']);
        } else{
            return back()->withErrors(['Update failed']);
        }
    }

    public function defaultOutletPhone(Request $request)
    {
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'order',
            'sub_title'      => 'Setting Default Outlet Phone',
            'submenu_active' => 'setting-default-outlet-phone'
        ];
        // return MyHelper::post('transaction/available-shipment',['show_all' => 1]);
        $data['default_outlet_phone'] = MyHelper::post('setting',['key' => 'default_outlet_phone'])['result']['value'] ?? '';
        return view('transaction::setting.default_outlet_phone', $data);
    }

    public function defaultOutletPhoneUpdate(Request $request)
    {
        $sendData = [
            'default_outlet_phone' => ['value', $request->default_outlet_phone],
        ];
        $data = MyHelper::post('setting/update2', ['update' => $sendData]);

        if (($data['status']??false) == 'success') {
            return back()->withSuccess(['Success update']);
        } else{
            return back()->withErrors(['Update failed']);
        }
    }

    public function transactionEmailContact(Request $request)
    {
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'order',
            'sub_title'      => 'Contact Email for Refund Rejected Order',
            'submenu_active' => 'transaction-email-contact'
        ];
        // return MyHelper::post('transaction/available-shipment',['show_all' => 1]);
        $data['transaction_email_contact'] = MyHelper::post('setting',['key' => 'transaction_email_contact'])['result']['value'] ?? '';
        return view('transaction::setting.transaction_email_contact', $data);
    }

    public function transactionEmailContactUpdate(Request $request)
    {
        $sendData = [
            'transaction_email_contact' => ['value', $request->transaction_email_contact],
        ];
        $data = MyHelper::post('setting/update2', ['update' => $sendData]);

        if (($data['status']??false) == 'success') {
            return back()->withSuccess(['Success update']);
        } else{
            return back()->withErrors(['Update failed']);
        }
    }
}
