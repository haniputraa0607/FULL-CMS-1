<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;

class ReportController extends Controller
{
    public function reportGlobal(Request $request) {
        $post = $request->except('_token');

        $warna = [
            '#FF0F00',
            '#FF6600',
            '#FF9E01',
            '#FCD202',
            '#F8FF01',
            '#B0DE09',
            '#04D215',
            '#0D8ECF',
            '#0D52D1',
            '#2A0CD0',
            '#8A0CCF',
            '#CD0D74'
        ];

        $warna1 = [
            '#CD0D74',
            '#8A0CCF',
            '#2A0CD0',
            '#0D52D1',
            '#0D8ECF',
            '#04D215',
            '#B0DE09',
            '#F8FF01',
            '#FCD202',
            '#FF9E01',
            '#FF6600',
            '#FF0F00',
        ];

        $chara = ["https://www.amcharts.com/lib/images/faces/A04.png","https://www.amcharts.com/lib/images/faces/C02.png","https://www.amcharts.com/lib/images/faces/D02.png","https://www.amcharts.com/lib/images/faces/E01.png"];

        if (empty($post)) {
            $data = [
                'title'          => 'Report',
                'menu_active'    => 'report-global',
                'sub_title'      => 'Report Global',
                'submenu_active' => 'report-global'
            ];

            $data['date_start']   = date('Y-m-d', strtotime("- 30 days"));
            $data['date_end']     = date('Y-m-d');

            $report = MyHelper::post('report/global', $data);

            if (isset($report['status']) && $report['status'] == 'success') {
                $data['report'] = $report['result'];

                if (!empty($report['result']['user'])) {
                    $dataUser = [];
                    foreach ($report['result']['user'] as $key => $user) {
                        $user = [
                            'name'   => $user['user']['name'],
                            'points' => $user['meh'],
                            'color'  => $warna[$key],
                            'bullet' => $chara[$key],
                        ];

                        array_push($dataUser, $user);
                        $data['user'] = json_encode($dataUser);
                    }
                } else {
                    $data['user'] = json_encode([
                        'name'   => 0,
                        'points' => 0,
                        'color'  => 0,
                        'bullet' => 0,
                    ]);
                }

                if (!empty($report['result']['product'])) {
                    $dataProduct = [];
                    foreach ($report['result']['product'] as $key => $product) {
                        $product = [
                            'country' => $product['product']['product_name'],
                            'visits'  => $product['qty'],
                            'color'   => $warna1[$key],
                        ];

                        array_push($dataProduct, $product);
                        $data['product'] = json_encode($dataProduct);
                    }
                } else {
                    $data['product'] = json_encode([
                        'country' => 0,
                        'visits'  => 0,
                        'color'   => 0,
                    ]);
                }

                if (!empty($report['result']['treatment'])) {
                    $dataTreatment = [];
                    foreach ($report['result']['treatment'] as $key => $treatment) {
                        $treatment = [
                            'country' => $treatment['treatment']['treatment_code'],
                            'visits'  => $treatment['total'],
                        ];

                        array_push($dataTreatment, $treatment);
                        $data['treatment'] = json_encode($dataTreatment);
                    }
                } else {
                    $data['treatment'] = json_encode([
                        'country'   => 0,
                        'visits'    => 0,
                    ]);
                }
            } else {
                $data['report'] = [];
            }
         
            return view('report::report_global', $data);
        } else {
            $data = [
                'title'          => 'Report',
                'menu_active'    => 'report-global',
                'sub_title'      => 'Report Global',
                'submenu_active' => 'report-global'
            ];

            $data['date_start'] = $post['date_start'];
            $data['date_end']   = $post['date_end'];

            $report = MyHelper::post('report/global', $post);
        
            if (isset($report['status']) && $report['status'] == "success") {
                $data['report'] = $report['result'];

                if (!empty($report['result']['user'])) {
                    $dataUser = [];
                    foreach ($report['result']['user'] as $key => $user) {
                        $user = [
                            'name'   => $user['user']['name'],
                            'points' => $user['meh'],
                            'color'  => $warna[$key],
                            'bullet' => $chara[$key],
                        ];

                        array_push($dataUser, $user);
                        $data['user'] = json_encode($dataUser);
                    }
                } else {
                    $data['user'] = json_encode([
                        'name'   => 0,
                        'points' => 0,
                        'color'  => 0,
                        'bullet' => 0,
                    ]);
                }

                if (!empty($report['result']['product'])) {
                    $dataProduct = [];
                    foreach ($report['result']['product'] as $key => $product) {
                        $product = [
                            'country' => $product['product']['product_code'],
                            'visits'  => $product['qty'],
                            'color'   => $warna1[$key],
                        ];

                        array_push($dataProduct, $product);
                        $data['product'] = json_encode($dataProduct);
                    }
                } else {
                    $data['product'] = json_encode([
                        'country' => 0,
                        'visits'  => 0,
                        'color'   => 0,
                    ]);
                }

                if (!empty($report['result']['treatment'])) {
                    $dataTreatment = [];
                    foreach ($report['result']['treatment'] as $key => $treatment) {
                        $treatment = [
                            'country'  => $treatment['treatment']['treatment_code'],
                            'visits' => $treatment['total'],
                        ];

                        array_push($dataTreatment, $treatment);
                        $data['treatment'] = json_encode($dataTreatment);
                    }
                } else {
                    $data['treatment'] = json_encode([
                        'country'   => 0,
                        'visits'    => 0,
                    ]);
                }
            } else {
                return parent::redirect($report, 'ok');
                // return back()->withErrors($report['messages']);
            }
            
            // return $data;
            return view('report::report_global', $data);
        }
    }

    public function customerSummary(Request $request) {
        $post = $request->except('_token');
        
        if (empty($post)) {
            $data = [
                'title'          => 'Report',
                'menu_active'    => 'report-customer',
                'sub_title'      => 'Report Customer',
                'submenu_active' => 'report-summary'
            ];
            
            $getCity = MyHelper::get('city/list');

            if($getCity['status'] == 'success') $data['city'] = $getCity['result']; else $data['city'] = null;

            $getMembership = MyHelper::post('membership/be/list', $post);
            if($getMembership['status'] == 'success'){
                $data['membership'] = $getMembership['result'];
            }else{
                $data['membership'] = [];
            }

            $customer = MyHelper::post('report/customer/summary', $data);

            if (isset($customer['status']) && $customer['status'] == 'success') {
                $data['customer'] = $customer['result'];
             
                return view('report::report_customer_summary', $data);
            } else {
                return parent::redirect($data, 'failed');
            }
        } else {
            $data = [
                'title'          => 'Report',
                'menu_active'    => 'report-customer',
                'sub_title'      => 'Report Customer',
                'submenu_active' => 'report-summary'
            ];

            $data['post'] = $post;
            $data['cust'] = 1;
            $post['cust'] = 1;
            
            if (isset($post['age_start']) && isset($post['age_end'])) {
                if ($post['age_start'] > $post['age_end']) {
                    return back()->withErrors(['Age start must be smaller than age end'])->withInput();
                }
            }

            if (isset($post['regis_date_start']) && isset($post['regis_date_end'])) {
                if ($post['regis_date_start'] > $post['regis_date_end']) {
                    return back()->withErrors(['Registration start must be smaller than registration end'])->withInput();
                }
            }

            if (isset($post['point_start']) && isset($post['point_end'])) {
                if ($post['point_start'] > $post['point_end']) {
                    return back()->withErrors(['Point start must be smaller than point end'])->withInput();
                }
            }

            if (isset($post['phone'])) {
                if (!is_numeric($post['phone'])) {
                    return back()->withErrors(['Phone must be number'])->withInput();
                }
            }

            $getCity = MyHelper::get('city/list');

            if($getCity['status'] == 'success') $data['city'] = $getCity['result']; else $data['city'] = null;

            $getMembership = MyHelper::post('membership/be/list', $post);
            if($getMembership['status'] == 'success'){
                $data['membership'] = $getMembership['result'];
            }else{
                $data['membership'] = [];
            }

            $customer = MyHelper::post('report/customer/summary', $post);

            if (isset($customer['status']) && $customer['status'] == "success") {
                $data['customer'] = $customer['result'];
                return view('report::report_customer_summary', $data);
            } else {
                return parent::redirect($data, 'failed');
            }
        }
    }

    public function customerDetail(Request $request, $id, $type) {
        $data = [
            'title'          => 'Report',
            'menu_active'    => 'report-customer',
            'sub_title'      => 'Report Customer',
            'submenu_active' => 'report-summary',
            'type'           => $type
        ];

        $post = $request->except('_token');
        if(isset($post['page'])){
            $detail = MyHelper::post('report/customer/detail?page='.$post['page'], ['phone' => $id, 'type' => $type]);
        }else{
            $detail = MyHelper::post('report/customer/detail', ['phone' => $id, 'type' => $type]);
        }
     
        // dd($detail);die();
        if (isset($detail['status']) && $detail['status'] == "success") {
            $data['detail']     = $detail['result'];
            
            $data['paginator']  = new LengthAwarePaginator($detail['result'][$type]['data'], $detail['result'][$type]['total'], $detail['result'][$type]['per_page'], $detail['result'][$type]['current_page'], ['path' => url()->current()]);
            if($detail['result'][$type]['from']) {
                $data['from']   = $detail['result'][$type]['from'];
            }else{
                $data['from']   = 0;
            }
            if($detail['result'][$type]['to']) {
                $data['to']   = $detail['result'][$type]['to'];
            }else{
                $data['to']   = 0;
            }
            $data['total']      = $detail['result'][$type]['total'];

            return view('report::report_detail', $data);
        } else {
            return parent::redirect($detail, 'failed');
        }
    }

    public function reportProduct() {
        $data = [
            'title'          => 'Report',
            'menu_active'    => 'report-product',
            'sub_title'      => 'Report Product',
            'submenu_active' => 'report-product'
        ];

        $warna = [
            '#FF0F00',
            '#FF6600',
            '#FF9E01',
            '#FCD202',
            '#F8FF01',
            '#B0DE09',
            '#04D215',
            '#0D8ECF',
            '#0D52D1',
            '#2A0CD0',
            '#8A0CCF',
            '#CD0D74'
        ];

        $random_keys=array_rand($warna, 10);

        $data['date_start']   = date('Y-m-d', strtotime("- 30 days"));
        $data['date_end']     = date('Y-m-d');

        $report = MyHelper::post('report/product', $data);
        // return $report['result'];
        if (isset($report['status']) && $report['status'] == "success") {
            $data['product'] = $report['result'];

            if (!empty($report['result']['total_product'])) {
                $total = [];

                foreach ($report['result']['total_product'] as $key => $product) {
                    $product = [
                        'country' => date('Y-m-d', strtotime($product['created_at'])),
                        'visits'  => $product['qty'],
                        'color'   => $warna[$random_keys[0]],
                    ];

                    array_push($total, $product);
                    $data['total'] = json_encode($total);
                }
            } else {
                $data['total'] = json_encode([
                    'country' => 0,
                    'visits'  => 0,
                    'color'   => 0,
                ]);
            }

            if (!empty($report['result']['recur_product'])) {
                $recur = [];

                foreach ($report['result']['recur_product'] as $key => $recuring) {
                    $re = [
                        'country' => date('Y-m-d', strtotime($recuring['created_at'])),
                        'visits'  => $recuring['qty'],
                        'color'   => $warna[$random_keys[0]],
                    ];

                    array_push($recur, $re);
                    $data['recur'] = json_encode($recur);
                }
            } else {
                $data['recur'] = json_encode([
                    'country' => 0,
                    'visits'  => 0,
                    'color'   => 0,
                ]);
            }

            return view('report::report_product', $data);
        } else {
            return parent::redirect($product, 'failed');
        }
    }

    public function reportProductDetail(Request $request) {
        $post = $request->except('_token');
        
        if (empty($post)) {
            return redirect('report/product');
        }

        $data = [
            'title'          => 'Report',
            'menu_active'    => 'report-product',
            'sub_title'      => 'Report Product',
            'submenu_active' => 'report-product'
        ];

        $warna = [
            '#FF0F00',
            '#FF6600',
            '#FF9E01',
            '#FCD202',
            '#F8FF01',
            '#B0DE09',
            '#04D215',
            '#0D8ECF',
            '#0D52D1',
            '#2A0CD0',
            '#8A0CCF',
            '#CD0D74'
        ];

        $random_keys=array_rand($warna, 10);

        $data['date_start']   = date('Y-m-d', strtotime($post['date_start']));
        $data['date_end']     = date('Y-m-d', strtotime($post['date_end']));

        $report = MyHelper::post('report/product/detail', $post);
        // return $report;
        if (isset($report['status']) && $report['status'] == "success") {
            $data['product'] = $report['result'];

            if (!empty($report['result']['total_product'])) {
                $total = [];

                foreach ($report['result']['total_product'] as $key => $product) {
                    $product = [
                        'country' => date('Y-m-d', strtotime($product['created_at'])),
                        'visits'  => $product['qty'],
                        'color'   => $warna[$random_keys[0]],
                    ];

                    array_push($total, $product);
                    $data['total'] = json_encode($total);
                }
            } else {
                $data['total'] = json_encode([
                    'country' => 0,
                    'visits'  => 0,
                    'color'   => 0,
                ]);
            }

            if (!empty($report['result']['recur_product'])) {
                $recur = [];

                foreach ($report['result']['recur_product'] as $key => $recuring) {
                    $re = [
                        'country' => date('Y-m-d', strtotime($recuring['created_at'])),
                        'visits'  => $recuring['qty'],
                        'color'   => $warna[$random_keys[0]],
                    ];

                    array_push($recur, $re);
                    $data['recur'] = json_encode($recur);
                }
            } else {
                $data['recur'] = json_encode([
                    'country' => 0,
                    'visits'  => 0,
                    'color'   => 0,
                ]);
            }

            return view('report::report_product', $data);
        } else {
            return parent::redirect($product, 'failed');
        }
    }
}
