<?php

namespace Modules\Transaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class ManualRefundController extends Controller
{
    public function listFailedVoidPayment(Request $request)
    {
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'failed-void-payment',
            'sub_title'      => 'Failed Refund Payment',
            'submenu_active' => 'failed-void-payment',
            'filter_title'   => 'Filter Transaction',
            'filter_date'    => true,
            'filter_date_today' => true,
        ];

        if(session('filter_failed_void')){
            $extra=session('filter_failed_void');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra=[
                'rule' => [
                    '9998' => [
                        'subject' => 'transaction_date',
                        'operator' => '>=',
                        'parameter' => date('Y-m-01'),
                        'hide' => '1'
                    ],
                    '9999' => [
                        'subject' => 'transaction_date',
                        'operator' => '<=',
                        'parameter' => date('Y-m-d'),
                        'hide' => '1'
                    ]
                ],
                'operator' => ''
            ];
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
            $data['hide_record_total']=1;
        }

        if ($request->wantsJson()) {
            $data = MyHelper::post('transaction/failed-void-payment', $extra + $request->all());
            return $data['result'];
        }
        
        $dateRange = [];
        foreach ($data['rule']??[] as $rule) {
            if ($rule[0] == 'transaction_date') {
                if ($rule[1] == '<=') {
                    $dateRange[0] = $rule[2];
                } elseif ($rule[1] == '>=') {
                    $dateRange[1] = $rule[2];
                }
            }
        }

        if (count($dateRange) == 2 && $dateRange[0] == $dateRange[1] && $dateRange[0] == date('Y-m-d')) {
            $data['is_today'] = true;
        }

        $data['outlets'] = array_map(function($item) {
            return [$item['id_outlet'], $item['outlet_code'].' - '.$item['outlet_name']];
        }, MyHelper::get('outlet/be/list')['result'] ?? []);
        return view('transaction::transaction.manual_void', $data);
    }

    /**
     * apply filter.
     * @return Response
     */
    public function filter(Request $request)
    {
        $post = $request->all();

        if(($post['rule']??false) && !isset($post['draw'])){
            if (($post['filter_type'] ?? false) == 'today') {
                $post['rule'][9998] = [
                    'subject' => 'transaction_date',
                    'operator' => '>=',
                    'parameter' => date('Y-m-d'),
                    'hide' => '1',
                ];
                $post['rule'][9999] = [
                    'subject' => 'transaction_date',
                    'operator' => '<=',
                    'parameter' => date('Y-m-d'),
                    'hide' => '1',
                ];
            }
            session(['filter_failed_void'=>$post]);
            return back();
        }

        if($post['clear']??false){
            session(['filter_failed_void'=>null]);
            return back();
        }

        return abort(404);
    }

    public function confirmManualRefund(Request $request)
    {
        $post = $request->except('_token');
        $post['refund_date'] = date('Y-m-d H:i:s', strtotime($post['date_refund']));
        $post['images'] = array_map(function($item) {
            return MyHelper::encodeImage($item);
        }, $post['images'] ?? []);
        $response = MyHelper::post('transaction/failed-void-payment/confirm', $post);
        if (($response['status'] ?? false) == 'success') {
            return back()->withSuccess(['Success confirm manual refund']);
        } else {
            return back()->withErrors($response['messages'] ?? ['Something went wrong']);
        }
    }
}
