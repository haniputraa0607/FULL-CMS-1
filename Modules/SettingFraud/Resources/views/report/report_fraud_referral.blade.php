@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
@endsection

@section('content')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ $title }}</span>
                @if (!empty($sub_title))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @if (!empty($sub_title))
                <li>
                    <span>{{ $sub_title }}</span>
                </li>
            @endif
        </ul>
    </div><br>

    @include('layouts.notifications')

    <h1 class="page-title">
        {{$sub_title}}
    </h1>

    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">Filter</div>
            <div class="tools">
                <a href="javascript:;" class="@if(Session::has('filter-fraud-log-referral'))  expand @else collapse @endif"> </a>
            </div>
        </div>
        <div class="portlet-body" @if(Session::has('filter-fraud-log-referral')) style="display: none;" @endif>
            <form role="form" class="form-horizontal" action="{{url()->current()}}?filter=1" method="POST">
                {{ csrf_field() }}
                @include('filter-report-log-fraud')
            </form>
        </div>
    </div>

    @if(Session::has('filter-fraud-log-referral'))
        <?php
        $search_param = Session::get('filter-fraud-log-referral');
        $start = $search_param['date_start'];
        $end = $search_param['date_end'];
        $search_param = array_filter($search_param['conditions']);
        ?>
        <div class="alert alert-block alert-success fade in">
            <button type="button" class="close" data-dismiss="alert"></button>
            <h4 class="alert-heading">Displaying search result with parameter(s):</h4>
            @if(isset($search_param))
                Start : {{date('d-m-Y', strtotime($start))}}<br>
                End : {{date('d-m-Y', strtotime($end))}}
                @foreach($search_param[0] as $row)
                    @if(isset($row['subject']))
                    <p>{{ucwords(str_replace("_"," ",$row['subject']))}}
                        @if($row['subject'] != 'all_user')
                            {{str_replace("-"," - ",$row['operator'])}}
                        @endif
                    </p>
                    @endif
                @endforeach
            @endif
            <br>
            <p>
                <a href="{{ url('fraud-detection/filter/reset') }}/filter-fraud-log-trx-point" class="btn yellow">Reset</a>
            </p>
        </div>
    @endif

    @if(!empty($result))
    <div style="text-align: right">
        <a class="btn blue" href="{{url('fraud-detection/report/referral-user')}}?export-excel=1"><i class="fa fa-download"></i> Export to Excel</a>
    </div>
    @endif

    <div class="table-scrollable">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th width="5%"> User Name </th>
                <th width="5%"> User Phone </th>
                <th width="5%"> User Email </th>
                <th width="5%"> Receipt Number </th>
                <th width="5%"> Outlet </th>
                <th width="5%"> Transaction Date </th>
                <th width="8%"> Transaction Time </th>
                <th width="8%"> Referral Code Used </th>
                <th width="40%"> Fraud Settings </th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($result))
                @foreach($result as $value)
                    <tr>
                        <td>{{$value['name']}}</td>
                        <td>{{$value['phone']}}</td>
                        <td>{{$value['email']}}</td>
                        <td>
                            @if(strtolower($value['trasaction_type']) == 'offline'){
                                <a target="_blank" href="{{url("transaction/detail/").'/'.$value['id_transaction']."/offline"}}">{{$value['transaction_receipt_number']}}</a>
                            @else
                                <a target="_blank" href="{{url("transaction/detail/").'/'.$value['id_transaction']."/pickup order"}}">{{$value['transaction_receipt_number']}}</a>
                            @endif
                        </td>
                        <td>{{$value['outlet_name']}}</td>
                        <td>{{date("d F Y", strtotime($value['referral_code_use_date']))}}</td>
                        <td>{{date("H:i", strtotime($value['referral_code_use_date']))}}</td>
                        <td>{{$value['referral_code']}}</td>
                        <td>
                            <label>Parameter</label>
                            <input class="form-control" disabled value="{{$value['fraud_setting_parameter_detail']}}">
                            <label>Parameter Time</label>
                            <input class="form-control" disabled value="{{$value['fraud_setting_parameter_detail_time']}}">
                            <label>Auto Suspend</label>
                            <input class="form-control" disabled value="@if($value['fraud_setting_auto_suspend_status'] == 1) Active @else Inactive @endif">
                            <label>Forward Admin</label>
                            <input class="form-control" disabled value="@if($value['fraud_setting_forward_admin_status'] == 1) Active @else Inactive @endif">
                        </td>
                    </tr>
                @endforeach
            @else
                <td colspan="11" style="text-align: center">No Data Available</td>
            @endif
            </tbody>
        </table>
    </div>
@endsection