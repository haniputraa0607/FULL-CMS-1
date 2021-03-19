<?php

namespace Modules\Report\Http\Controllers;

use App\Exports\MultisheetExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;
use Session;
use Excel;

class ReportGosend extends Controller
{
    function index(Request $request){
        $post = $request->except('_token');
        $data = [
            'title'          => 'Report',
            'menu_active'    => 'report-gosend',
            'sub_title'      => 'Report GoSend',
            'submenu_active' => 'report-gosend'
        ];

        if(Session::has('filter-list-gosend') && !empty($post) && !isset($post['filter'])){
            $page = 1;
            if(isset($post['page'])){
                $page = $post['page'];
            }
            $post = Session::get('filter-list-gosend');
            $post['page'] = $page;
        }else{
            Session::forget('filter-list-gosend');
        }

        $report = MyHelper::post('report/gosend', $post);

        if (isset($report['status']) && $report['status'] == "success") {
            $data['trx']          = $report['result']['data']['data'];
            $data['trxTotal']     = $report['result']['data']['total'];
            $data['trxPerPage']   = $report['result']['data']['from'];
            $data['trxUpTo']      = $report['result']['data']['from'] + count($report['result']['data']['data'])-1;
            $data['trxPaginator'] = new LengthAwarePaginator($report['result']['data']['data'], $report['result']['data']['total'], $report['result']['data']['per_page'], $report['result']['data']['current_page'], ['path' => url()->current()]);
            $data['sum'] = $report['result']['sum']['total_price_go_send']??0;
        }else{
            $data['trx']          = [];
            $data['trxTotal']     = 0;
            $data['trxPerPage']   = 0;
            $data['trxUpTo']      = 0;
            $data['trxPaginator'] = false;
            $data['sum'] = 0;
        }

        if($post){
            Session::put('filter-list-gosend',$post);
        }
        return view('report::report_gosend.index', $data);
    }

    function export(Request $request){
        $post = $request->except('_token');

        if(Session::has('filter-list-gosend') && !isset($post['filter'])){
            $post = Session::get('filter-list-gosend');
        }
        $post['export'] = 1;
        $report = MyHelper::post('report/gosend', $post);

        if (isset($report['status']) && $report['status'] == "success") {
            $arr['All Type'] = $report['result'];
            $data = new MultisheetExport($arr);
            return Excel::download($data,'report_gosend_'.date('dmYHis').'.xls');
        }else{
            return redirect('report/gosend')->withErrors(['No data to export']);
        }
    }
}
