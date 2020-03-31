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

class SmsReportController extends Controller
{
    public function index(Request $request)
    {
        $post = $request->except('_token');

        $data = [
            'title'          => 'Report',
            'menu_active'    => 'report-sms',
            'sub_title'      => 'SMS Report',
            'submenu_active' => 'report-sms'
        ];

        $export = 0;
        if(isset($post['export'])){
            $export = 1;
        }

        if(Session::has('filter-report-sms') && !empty($post) && !isset($post['filter'])){
            $post = Session::get('filter-report-sms');
        }else{
            Session::forget('filter-report-sms');
        }

        $post['export'] = $export;
        $report = MyHelper::post('report/sms?page='.$request->get('page'), $post);

        if(isset($report['status']) && $report['status'] == 'success'){
            if(isset($post['export']) && $post['export'] == 1){
                foreach($report['result'] as $row){

                    $statusCodes = [
                        1  => 'Success',
                        2  => 'Missing Parameter',
                        3  => 'Invalid User Id or Password',
                        4  => 'Invalid Message',
                        5  => 'Invalid MSISDN',
                        6  => 'Invalid Sender',
                        7  => 'Client’s IP Address is not allowed',
                        8  => 'Internal Server Error',
                        9  => 'Invalid division',
                        20 => 'Invalid Channel',
                        21 => 'Token Not Enough',
                        22 => 'Token Not Available',
                    ];

                    $code = substr($row['response'], strpos($row['response'], "=") + 1);
                    $dt = [
                        'Name' => $row['name'],
                        'Phone' => $row['phone'],
                        'Email' => $row['email'],
                        'Request URL' => $row['request_url'],
                        'Request Body' => $row['request_body'],
                        'Request Response' => $row['response'].' - ('.$statusCodes[$code].')',
                        'Date Send' => $row['created_at'] == NULL ? '' : date('d M Y H:i', strtotime($row['created_at']))
                    ];
                    $arr['All Type'][] = $dt;
                }

                $dataExport = new MultisheetExport($arr);
                return Excel::download($dataExport, 'SMS Report '.date('d M Y Hi').'.xls');
            }else{
                $data['data']      = $report['result']['data'];
                $data['total']     = $report['result']['total'];
                $data['perPage']   = $report['result']['from'];
                $data['upTo']      = $report['result']['from'] + count($report['result']['data'])-1;
                $data['paginator'] = new LengthAwarePaginator($report['result']['data'], $report['result']['total'], $report['result']['per_page'], $report['result']['current_page'], ['path' => url()->current()]);
            }
        }else {
            $data['data']          = [];
            $data['total']     = 0;
            $data['perPage']   = 0;
            $data['upTo']      = 0;
            $data['paginator'] = false;
        }

        if($post){
            Session::put('filter-report-sms',$post);
        }

        return view('report::sms_report.sms_report', $data);
    }

    public function detailRequest(Request $request)
    {
        $post = $request->except('_token');
        $dt = MyHelper::post('report/sms/detail-request', $post);

        return response()->json($dt);
    }
}
