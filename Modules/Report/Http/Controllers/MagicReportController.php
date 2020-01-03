<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;
use Session;

class MagicReportController extends Controller
{
    function __construct() {
        date_default_timezone_set('Asia/Jakarta');
        $this->reportDua   = "Modules\Report\Http\Controllers\ReportDuaController";
    }

    public function magicReport(Request $request) {
        $post = $request->except('_token');

        if (empty($post)) {
            $post['date_start']   = date('Y-m-d', strtotime("-30 days"));
            $post['date_end']     = date('Y-m-d', strtotime("-1 days"));
            $post['id_outlet']    = 0; 
            $post['month'] = date('m');
            $post['year'] = date('Y');
            $exclude = MyHelper::get('report/magic/exclude');
            if(isset($exclude['status']) && $exclude['status'] == 'success'){
                $post['exclude_tag'] = $exclude['result']['tag'];
                $post['exclude_product'] = $exclude['result']['product'];
            }else{
                $post['exclude_tag'] = null;
                $post['exclude_product'] = null;
            }
        }
        else {
            if ($post['id_outlet'] == 0) {
                unset($post['id_outlet']);
                $data['id_outlet'] = 0;
            }

            if(!isset($post['exclude_product'])){
                $post['exclude_product'] = null;
            }

            if(!isset($post['exclude_tag'])){
                $post['exclude_tag'] = null;
            }
            
            $post['date_start']   = date('Y-m-d', strtotime($post['date_start']));
            $post['date_end']     = date('Y-m-d', strtotime($post['date_end']));
        }
        $data = [
            'title'          => 'Report',
            'menu_active'    => 'report-magic',
            'sub_title'      => 'Magic Report',
            'submenu_active' => 'report-magic'
        ];
        
        foreach ($post as $key => $value) {
            $data[$key] = $value;
        }

        // DATA TAG & PRODUCT
        $graph = $this->getDataMagicReport($post);

        foreach ($graph as $key => $value) {
            $data[$key] = $value;
        }

        $data['allProducts'] = parent::getData(MyHelper::get('product/be/list'));

        $data['allTags'] = parent::getData(MyHelper::get('product/tag/list'));

        $data['outlet'] = parent::getData(MyHelper::get('outlet/be/list'));

        Session::forget('exclude_rec');
        $getRecommendation = MyHelper::get('report/magic/recommendation');
		if (isset($getRecommendation['status']) && $getRecommendation['status'] == 'success') $data['recommendation'] = $getRecommendation['result']; else $data['recommendation'] = null;
        
        $data['newTopRec'] = parent::getData(MyHelper::post('report/magic/newtop/rec', $post));

        $data['newTopQty'] = parent::getData(MyHelper::post('report/magic/newtop/qty', $post));
        
        $getMinYear = MyHelper::get('report/min_year');
        if (isset($getMinYear['status']) && $getMinYear['status'] == "success") {
            $data['minYear'] = $getMinYear['result'];
        }else{
            $data['minYear'] = date('Y');
        }

        return view('report::magic_report', $data);
    }

    /* GET DATA */
    function getDataMagicReport($post) {
        $report = MyHelper::post('report/magic', $post);
        
        $dataRecTag     = [];
        $dataQtyTag     = [];
        $dataTag = [];

        if (isset($report['status']) && $report['status'] == "success") {
            $dataTag = $report['result']['tagRec'];

            foreach ($report['result']['tagQty'] as $key => $value) {
                $tempQty = [
                    'tag' => $value['tag_name'],
                    'qty' => $value['total_qty'],
                    'color'   =>  app($this->reportDua)->color($key)
                ];

                array_push($dataQtyTag, $tempQty);
            }

            foreach ($report['result']['tagRec'] as $key => $value) {
                if(count($dataRecTag)<10){
                    $tempRec = [
                        'tag' => $value['tag_name'],
                        'rec' => $value['total_rec'],
                        'color'   =>  app($this->reportDua)->color($key)
                    ];

                    array_push($dataRecTag, $tempRec);
                }else{
                    break;
                }
            }

        }

        $dataRecProduct = [];
        $dataQtyProduct = [];
        $dataProduct = [];
        if (isset($report['status']) && $report['status'] == "success") {
            $dataProduct = $report['result']['productRec'];

            foreach ($report['result']['productQty'] as $key => $value) {
                $tempQty = [
                    'product' => $value['product_name'],
                    'qty' => (int)$value['total_qty'],
                    'color'   =>  app($this->reportDua)->color($key)
                ];

                array_push($dataQtyProduct, $tempQty);
            }

            foreach ($report['result']['productRec'] as $key => $value) {
                $tempRec = [
                    'product' => $value['product_name'],
                    'rec' => $value['total_rec'],
                    'color'   =>  app($this->reportDua)->color($key)
                ];

                array_push($dataRecProduct, $tempRec);
            }
        }
        
        return $result = [
            'dataRecTag'     => json_encode($dataRecTag),
            'dataQtyTag'     => json_encode($dataQtyTag),
            'dataTag'        => $dataTag,
            'dataRecProduct' => json_encode($dataRecProduct),
            'dataQtyProduct' => json_encode($dataQtyProduct),
            'dataProduct'    => $dataProduct
        ];
    }

    function otherRecommedantion($exclude_rec){
        $arrExclude = Session::get('exclude_rec');
        $arrExclude[] = $exclude_rec;
        Session::put('exclude_rec', $arrExclude);
        $rec = parent::getData(MyHelper::post('report/magic/recommendation', ['exclude_rec'=>$arrExclude]));
        if(empty($rec)){
            Session::forget('exclude_rec');
            $rec = parent::getData(MyHelper::get('report/magic/recommendation')); 
        }
        return $rec;
    }

    /* REPORT TAG DETAIL */
    function reportTagDetail($id, $date_start, $date_end, $id_outlet) {
        $data = [
            'title'          => 'Report',
            'menu_active'    => 'report-magic',
            'sub_title'      => 'Tag',
            'submenu_active' => 'report-magic'
        ];
        
        $post = [
            'id_tag'     => $id,
            'date_start' => $date_start,
            'date_end'   => $date_end
        ];

        if($id_outlet != 0){
            $post['id_outlet'] = $id_outlet;
        }

        $graph = $this->getDataReportTagDetail($post);

        foreach ($graph as $key => $value) {
            $data[$key] = $value;
        }

        $data['date_start'] = $date_start;
        $data['date_end']   = $date_end;        
        $data['tag']    = parent::getData(MyHelper::post('product/tag/list', ['id_tag' => $id]));
        
        return view('report::report_tag_detail', $data);
    }

    function getDataReportTagDetail($post) {
        $report = MyHelper::post('report/trx/tag/detail', $post);

        $dataRecQty  = [];
        $dataTagProduct  = [];
        $outlet = "All";

        if (isset($report['status']) && $report['status'] == "success") {
            foreach ($report['result']['tag'] as $key => $value) {
                $recQtyTemp = [
                    'date' => $value['trx_date'],
                    'qty'  => $value['total_qty'],
                    'rec'  => $value['total_rec']
                ];  

                array_push($dataRecQty, $recQtyTemp);
            }

            foreach ($report['result']['tagProduct'] as $key => $value) {
                $recQtyTemp = [
                    'product_name' => $value['product_name'],
                    'qty'  => $value['total_qty'],
                    'rec'  => $value['total_rec']
                ];  

                array_push($dataTagProduct, $recQtyTemp);
            }

            if(isset($report['result']['outlet'])){
                $outlet = $report['result']['outlet'];
            }
        }
        
        $result = [
            'dataRecQty'  => json_encode($dataRecQty),
            'dataTagProduct'  => json_encode($dataTagProduct),
            'outlet' => $outlet
        ];

        return $result;
    }

    function newTop(Request $request){
        $post = $request->except('_token');
        $newTopRec = MyHelper::post('report/magic/newtop/rec', $post);
    
        if(isset($newTopRec['status']) && $newTopRec['status'] == 'success'){
            $newTopRec = $newTopRec['result'];
        }else{
            $newTopRec = [];
        }
        $newTopQty = MyHelper::post('report/magic/newtop/qty', $post);
        if(isset($newTopQty['status']) && $newTopQty['status'] == 'success'){
            $newTopQty = $newTopQty['result'];
        }else{
            $newTopQty = [];
        }
        
        return $data = [
            'rec' => $newTopRec, 
            'qty' => $newTopQty
        ];
    }
}