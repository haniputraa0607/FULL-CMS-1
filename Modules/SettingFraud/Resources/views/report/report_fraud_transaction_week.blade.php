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
    <script type="text/javascript">
        function updateStatusLog(id_fraud_detection_log_transaction_week,status) {
            var status_msg = '';
            var token  = "{{ csrf_token() }}";

            if(confirm('Are you sure you want to delete this log?')) {
                $.ajax({
                    type : "POST",
                    url : "{{ url('fraud-detection/update/log/transaction-week') }}",
                    data : "_token="+token+"&id_fraud_detection_log_transaction_week="+id_fraud_detection_log_transaction_week+"&status="+status,
                    success : function(result) {

                        if (result.status == "success") {
                            toastr.info(result.messages);
                            location.reload();
                        }
                        else {
                            toastr.warning(result.messages);
                        }
                    },
                    error: function (jqXHR, exception) {
                        toastr.warning('Failed update status');
                    }
                });
            }
        }
    </script>
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
                <a href="javascript:;" class="expand"> </a>
            </div>
        </div>
        <div class="portlet-body" style="display: none">
            <form role="form" class="form-horizontal" action="{{url()->current()}}" method="POST">
                {{ csrf_field() }}
                @include('filter-report-log-fraud')
            </form>
        </div>
    </div>

    @if(Session::has('filter-fraud-log-trx-week'))
        <?php
        $search_param = Session::get('filter-fraud-log-trx-week');
        $search_param = array_filter($search_param['conditions']);
        ?>
        <div class="alert alert-block alert-success fade in">
            <button type="button" class="close" data-dismiss="alert"></button>
            <h4 class="alert-heading">Displaying search result with parameter(s):</h4>
            @if(isset($search_param))
                @foreach($search_param as $row)
                    <?php $row = $row[0];?>
                    <p>{{ucwords(str_replace("_"," ",$row['subject']))}}
                        @if($row['subject'] != 'all_user')@if($row['parameter'] != "") {{str_replace("-"," - ",$row['operator'])}} {{str_replace("-"," - ",$row['parameter'])}}
                        @else : {{str_replace("-"," - ",$row['operator'])}}
                        @endif
                        @endif
                    </p>
                @endforeach
            @endif
            <br>
            <p>
                <a href="{{ url('fraud-detection/filter/reset') }}/filter-fraud-log-trx-week" class="btn yellow">Reset</a>
            </p>
        </div>
    @endif

    @if(!empty($result))
    <div style="text-align: right">
        <a class="btn blue" href="{{url('fraud-detection/report/transaction-week')}}?export-excel=1"><i class="fa fa-download"></i> Export to Excel</a>
    </div>
    @endif

    <div class="table-scrollable">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th width="5%"> Actions </th>
                <th width="5%"> User Name </th>
                <th width="5%"> User Phone </th>
                <th width="5%"> Date </th>
                <th width="5%"> Count Transaction </th>
                <th width="30%"> Fraud Settings </th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($result))
                @foreach($result as $value)
                    <tr>
                        <td><a href="{{ url('fraud-detection/report/detail/transaction-week') }}/{{ $value['id_fraud_detection_log_transaction_week'] }}" target="_blank" class="btn btn-block blue btn-xs"><i class="fa fa-edit"></i> Detail</a>
{{--                            <a onclick="updateStatusLog('{{$value['id_fraud_detection_log_transaction_week']}}','Inactive')" class="btn btn-block red btn-xs "><i class="icon-close"></i> Delete Log</a>--}}
                        </td>
                        <td>{{$value['name']}}</td>
                        <td>{{$value['phone']}}</td>
                        <td>{{date("d F Y", strtotime($value['created_at']))}}</td>
                        <td>{{$value['count_transaction_week']}}</td>
                        <td>
                            <div class="form-group row">
                                <label class="col-md-6">Detection Parameter</label>
                                <div class="col-md-6"><input class="form-control" disabled value="(maximum) {{$value['fraud_setting_parameter_detail']}}"></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-6">Auto Suspend</label>
                                <div class="col-md-6"><input class="form-control" disabled value="@if($value['fraud_setting_auto_suspend_status'] == 1) Active @else Inactive @endif"></div>
                            </div>
                            @if($value['fraud_setting_auto_suspend_status'] == 1 )
                                <div class="form-group row">
                                    <label class="col-md-6">Auto Suspend Value</label>
                                    <div class="col-md-6"><input class="form-control" disabled value="(maximum) {{$value['fraud_setting_auto_suspend_value']}}"></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-6">Auto Suspend Time Period</label>
                                    <div class="col-md-6"><input class="form-control" disabled value="{{$value['fraud_setting_auto_suspend_time_period']}} (hari)"></div>
                                </div>
                            @endif
                            <div class="form-group row">
                                <label class="col-md-6">Forward Admin</label>
                                <div class="col-md-6"><input class="form-control" disabled value="@if($value['fraud_setting_forward_admin_status'] == 1) Active @else Inactive @endif"></div>
                            </div>
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