<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;
use Session;

class ReportDuaController extends Controller
{
    function __construct() {
        date_default_timezone_set('Asia/Jakarta');
    }

    /* warna */
    function color($key) {
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
            '#CD0D74',
            'ff4000',
            'ff8000',
            'ffbf00',
            'ffff00',
            'bfff00',
            '80ff00',
            '40ff00',
            '00ff00',
            '00ff40',
            '00ff80',
            '00ffbf',
            '00ffff',
            '00bfff',
            '0080ff',
            '0040ff',
            '0000ff',
            '4000ff',
            '8000ff',
            'bf00ff',
            'ff00ff',
            'ff00bf',
            'ff0080',
            'ff0040',
        ];

        if ($key >= count($warna)) {
            $key = ($key % count($warna));
        }

        return $warna[$key];
    }

    /* character */
    function character($key) {
        $chara = [
            "https://www.amcharts.com/lib/images/faces/A04.png",
            "https://www.amcharts.com/lib/images/faces/A01.png",
            "https://www.amcharts.com/lib/images/faces/A02.png",
            "https://www.amcharts.com/lib/images/faces/C01.png",
            "https://www.amcharts.com/lib/images/faces/C02.png",
            "https://www.amcharts.com/lib/images/faces/C03.png",
            "https://www.amcharts.com/lib/images/faces/D01.png",
            "https://www.amcharts.com/lib/images/faces/D02.png",
            "https://www.amcharts.com/lib/images/faces/D03.png",
            "https://www.amcharts.com/lib/images/faces/E01.png",
            "https://www.amcharts.com/lib/images/faces/E02.png",
            "https://www.amcharts.com/lib/images/faces/E03.png"
        ];

        return $chara[$key];
    }

    public function reportProductAll(Request $request) {
        $post = $request->except('_token');
        
        if (empty($post)) {
            $post['date_start']   = date('Y-m-d', strtotime("-30 days"));
            $post['date_end']     = date('Y-m-d', strtotime("-1 days"));
        }
        else {
            $post['date_start']   = date('Y-m-d', strtotime($post['date_start']));
            $post['date_end']     = date('Y-m-d', strtotime($post['date_end']));
        }

        $data = [
            'title'          => 'Report',
            'menu_active'    => 'report-product',
            'sub_title'      => 'Product',
            'submenu_active' => 'report-product'
        ];

        foreach ($post as $key => $value) {
            $data[$key] = $value;
        }

        // DATA
        $graph = $this->getDataReportProduct($post);

        foreach ($graph as $key => $value) {
            $data[$key] = $value;
        }

        return view('report::report_product_all', $data);
    }

    /* GET DATA */
    function getDataReportProduct($post) {
        $report = MyHelper::post('report/trx/product', $post);

        $dataRec     = [];
        $dataQty     = [];
        $dataNominal = [];
        $dataProduct = [];

        if (isset($report['status']) && $report['status'] == "success") {
            // PRODUCT
            $dataProduct = $report['result'];

            foreach ($report['result'] as $key => $value) {
                $tempNominal = [
                    'product' => $value['product_code'].'-'.$value['product_name'],
                    'nominal' => $value['total_nominal'],
                    'color'   =>  $this->color($key)
                ];

                array_push($dataNominal, $tempNominal);

                $tempQty = [
                    'product' => $value['product_code'].'-'.$value['product_name'],
                    'qty'     => $value['total_qty']
                ];

                array_push($dataQty, $tempQty);

                $tempRec = [
                    'product' => $value['product_code'].'-'.$value['product_name'],
                    'rec'     => $value['total_rec']
                ];

                array_push($dataRec, $tempRec);
            }
        }

        return $result = [
            'dataRec'     => json_encode($dataRec),
            'dataQty'     => json_encode($dataQty),
            'dataNominal' => json_encode($dataNominal),
            'dataProduct' => $dataProduct
        ];
    }

    /* REPORT PRODUCT DETAIL */
    function reportProductDetail($id, $date_start, $date_end) {
        $data = [
            'title'          => 'Report',
            'menu_active'    => 'report-product',
            'sub_title'      => 'Product',
            'submenu_active' => 'report-product'
        ];

        $post = [
            'id_product' => $id,
            'date_start' => $date_start,
            'date_end'   => $date_end
        ];

        $graph = $this->getDataReportProductDetail($post);

        foreach ($graph as $key => $value) {
            $data[$key] = $value;
        }

        $data['date_start'] = $date_start;
        $data['date_end']   = $date_end;        
        $data['product']    = parent::getData(MyHelper::post('product/be/list', ['id_product' => $id]));

        return view('report::report_product_detail', $data);
    }

    function getDataReportProductDetail($post) {
        $report = MyHelper::post('report/trx/product/detail', $post);

        $dataRecQty  = [];
        $dataNominal = [];

        if (isset($report['status']) && $report['status'] == "success") {
            foreach ($report['result'] as $key => $value) {
                $recQtyTemp = [
                    'date' => $value['trx_date'],
                    'qty'  => $value['total_qty'],
                    'rec'  => $value['total_rec']
                ];  

                array_push($dataRecQty, $recQtyTemp);

                $nominalTemp = [
                    'date'  => $value['trx_date'],
                    'price' => $value['total_nominal']
                ];

                array_push($dataNominal, $nominalTemp);
            }
        }

        $result = [
            'dataRecQty'  => json_encode($dataRecQty),
            'dataNominal' => json_encode($dataNominal),
        ];

        return $result;
    }

    /* REPORT OUTLET */
    public function reportOutletAll(Request $request) {
        $post = $request->except('_token');
        
        if (empty($post)) {
            $post['date_start']   = date('Y-m-d', strtotime("-30 days"));
            $post['date_end']     = date('Y-m-d', strtotime("-1 days"));
        }
        else {
            $post['date_start']   = date('Y-m-d', strtotime($post['date_start']));
            $post['date_end']     = date('Y-m-d', strtotime($post['date_end']));
        }

        $data = [
            'title'          => 'Report',
            'menu_active'    => 'report-outlet',
            'sub_title'      => 'Outlet',
            'submenu_active' => 'report-outlet'
        ];

        foreach ($post as $key => $value) {
            $data[$key] = $value;
        }

        // DATA
        $graph = $this->getDataReportOutlet($post);
        
        foreach ($graph as $key => $value) {
            $data[$key] = $value;
        }

        return view('report::report_outlet_all', $data);
    }

    /* GET DATA REPORT OUTLET */
    function getDataReportOutlet($post) {
        $report = MyHelper::post('report/trx/outlet', $post);

        $dataCount     = [];
        $dataValue     = [];
        $dataOutlet = [];

        if (isset($report['status']) && $report['status'] == "success") {
            // PRODUCT
            $dataOutlet = $report['result']['value'];

            foreach ($report['result']['count'] as $key => $value) {
                $tempCount = [
                    'outlet' => $value['outlet_code'].'-'.$value['outlet_name'],
                    'count' => $value['total_count'],
                    'color'   =>  $this->color($key)
                ];

                array_push($dataCount, $tempCount);
            }

            foreach ($report['result']['value'] as $key => $value) {
                $tempValue = [
                    'outlet' => $value['outlet_code'].'-'.$value['outlet_name'],
                    'value'     => $value['total_value'],
                    'color'   =>  $this->color($key)
                ];

                array_push($dataValue, $tempValue);
            }

            usort($dataValue, function($a, $b) { 
                return $a['value'] < $b['value']; 
            }); 
            $dataValue = array_slice($dataValue, 0, 10);
        }

        return $result = [
            'dataCount'     => json_encode($dataCount),
            'dataValue'     => json_encode($dataValue),
            'dataOutlet'    => $dataOutlet
        ];
    }

     /* REPORT OUTLET DETAIL */
     function reportOutletDetail($id, $date_start, $date_end) {
        $data = [
            'title'          => 'Report',
            'menu_active'    => 'report-outlet',
            'sub_title'      => 'Outlet',
            'submenu_active' => 'report-outlet'
        ];

        $post = [
            'id_outlet' => $id,
            'date_start' => $date_start,
            'date_end'   => $date_end
        ];

        $graph = $this->getDataReportOutletDetail($post);

        foreach ($graph as $key => $value) {
            $data[$key] = $value;
        }

        $data['date_start'] = $date_start;
        $data['date_end']   = $date_end;        
        $data['outlet']    = parent::getData(MyHelper::post('outlet/be/list', ['id_outlet' => $id]));

        return view('report::report_outlet_detail', $data);
    }

    function getDataReportOutletDetail($post) {
        $report = MyHelper::post('report/trx/outlet/detail', $post);

        $dataOutlet  = [];

        if (isset($report['status']) && $report['status'] == "success") {
            foreach ($report['result'] as $key => $value) {
                $temp = [
                    'date' => $value['trx_date'],
                    'count'  => $value['total_count'],
                    'value'  => $value['total_value']
                ];  

                array_push($dataOutlet, $temp);

            }
        }

        $result = [
            'dataOutlet'  => json_encode($dataOutlet),
        ];

        return $result;
    }

    /* REPORT GLOBAL */
    function reportGlobal(Request $request) {
        $post = $request->except('_token');
        
        $data = [
            'title'          => 'Report',
            'menu_active'    => 'report-global',
            'sub_title'      => 'Report Global',
            'submenu_active' => 'report-global'
        ];

        if (empty($post)) {
            $post['date_start']   = date('Y-m-d', strtotime("-30 days"));
            $post['date_end']     = date('Y-m-d', strtotime("-1 days"));
            $post['id_outlet']    = 0;
        }
        else {
            if (!isset($post['id_outlet']) || $post['id_outlet'] == 0) {
                unset($post['id_outlet']);
                $data['id_outlet'] = 0;
            }
            else {
                $post['id_outlet']    = $post['id_outlet'];
            }
            
            $post['date_start']   = date('Y-m-d', strtotime($post['date_start']));
            $post['date_end']     = date('Y-m-d', strtotime($post['date_end']));
        }

        

        foreach ($post as $key => $value) {
            $data[$key] = $value;
        }

        /* TRANSAKSI */
        $trx = $this->globalTrx($post);

        foreach ($trx as $key => $value) {
            $data[$key] = $value;
        }

        /* POINT */
        // $point = $this->point($post);

        // foreach ($point as $key => $value) {
        //     $data[$key] = $value;
        // }

        /* CUSTOMER */
        $customer = $this->customer($post);

        foreach ($customer as $key => $value) {
            $data[$key] = $value;
        }

        /* PRODUCT */
        $product = $this->product($post);

        foreach ($product as $key => $value) {
            $data[$key] = $value;
        }

        /* OUTLET */
        $data['outlet'] = parent::getData(MyHelper::get('outlet/be/list'));

        return view('report::report_global_new', $data);
    }

    function globalTrx($post) {
        $report = MyHelper::post('report/trx/transaction', $post);

        // print_r($report); exit();

        $nominal       = [];
        $totalNominal  = 0;
        $totalTrx      = 0;
        $totalAvg      = 0;
        $totalAvgTrx   = 0;
        $totalCountTrx = 0;
        $tempDate      = "";

        if (isset($report['status']) && $report['status'] == "success") {
            foreach ($report['result'] as $key => $value) {
                $nominalTemp = [
                    'nominal' => $value['trx_grand'],
                    'date'    => $value['trx_date']
                ];  

                array_push($nominal, $nominalTemp);

                $totalNominal  = $totalNominal + $value['trx_grand'];
                $totalCountTrx = $totalCountTrx + $value['trx_count'];

                if($value['trx_date'] != $tempDate){
                    $totalTrx = $totalTrx + 1; 
                    $tempDate = $value['trx_date'];
                }
            }

            $totalAvg    = $totalNominal / $totalTrx;
            $totalAvgTrx = $totalNominal / $totalCountTrx;
        }


        return [
            'nominal'       => json_encode($nominal),
            'totalNominal'  => $totalNominal,
            'totalTrx'      => $totalTrx,
            'totalAvg'      => $totalAvg,
            'totalAvgTrx'   => $totalAvgTrx,
            'totalCountTrx' => $totalCountTrx
        ];
    }

    function point($post) {
        $report      = MyHelper::post('report/trx/transaction/point', $post);
        
        $pointGiven  = 0;
        $pointRedeem = 0;
        $pointTotal       = 0;

        if (isset($report['status']) && $report['status'] == "success") {
            $pointGiven  = $report['result']['pointGiven'];
            $pointRedeem = $report['result']['pointRedeem'];
            $pointTotal       = $report['result']['pointTotal'];
        }

        return [
            'pointGiven'  => $pointGiven,
            'pointRedeem' => $pointRedeem,
            'pointTotal'  => $pointTotal,
        ];
    }

    function customer($post) {
        $user     = [];
        $dataUser = [];

        $report = MyHelper::post('report/trx/transaction/user', $post);

        if (isset($report['status']) && $report['status'] == "success") {
            foreach ($report['result'] as $key => $value) {
                $userTemp = [
                    'name'    => $value['user']['name'],
                    'nominal' => $value['nominal'],
                    // 'color'   => $this->color($key),
                    // 'bullet'  => $this->character($key),
                ];

                array_push($user, $userTemp);
            }

            $dataUser = $report['result'];
        }

        return [
            'customer'     => json_encode($user),
            'dataCustomer' => $dataUser
        ];
    }

    function product($post) {
        $product     = [];
        $dataProduct = [];

        $report = MyHelper::post('report/trx/product', $post);

        if (isset($report['status']) && $report['status'] == "success") {
            foreach ($report['result'] as $key => $value) {

                if ($key < 10) {
                    $tempNominal = [
                        'product' => $value['product_code'].'-'.$value['product_name'],
                        'qty'     => $value['total_qty'],
                        'color'   =>  $this->color($key)
                    ];

                    array_push($product, $tempNominal);
                }
            }

            usort($product, function($a, $b) {
                return $a['qty'] < $b['qty'];
            });

            $dataProduct = $report['result'];
        }

        return [
            'product'     => json_encode($product),
            'dataProduct' => $dataProduct
        ];
    }
}