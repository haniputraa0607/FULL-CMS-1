@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        function  updateStatus(device_id,status) {
            var status_msg = '';
            var token  = "{{ csrf_token() }}";


            if(confirm('Are you sure you want to delete this log?')) {
                $.ajax({
                    type : "POST",
                    url : "{{ url('fraud-detection/update/log/device') }}",
                    data : "_token="+token+"&device_id="+device_id+"&status="+status,
                    success : function(result) {
                        if (result.status == "success") {
                            toastr.info(result.messages);
                            setTimeout(function(){ window.location.href = '{{url('fraud-detection/report/device')}}'; }, 1000);
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
            </li>
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
                <a href="javascript:;" class="@if(Session::has('filter-fraud-log-device'))  expand @else collapse @endif"> </a>
            </div>
        </div>
        <div class="portlet-body" @if(Session::has('filter-fraud-log-device')) style="display: none;" @endif>
            <form role="form" class="form-horizontal" action="{{url()->current()}}?filter=1" method="POST">
                {{ csrf_field() }}
                @include('filter-report-log-fraud')
            </form>
        </div>
    </div>

    @if(Session::has('filter-fraud-log-device'))
        <?php
        $search_param = Session::get('filter-fraud-log-device');
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
                            @if($row['subject'] != 'all_user')@if($row['parameter'] != "") {{str_replace("-"," - ",$row['operator'])}} {{str_replace("-"," - ",$row['parameter'])}}
                            @else : {{str_replace("-"," - ",$row['operator'])}}
                            @endif
                            @endif
                        </p>
                    @endif
                @endforeach
            @endif
            <br>
            <p>
                <a href="{{ url('fraud-detection/filter/reset') }}/filter-fraud-log-device" class="btn yellow">Reset</a>
            </p>
        </div>
    @endif

    @if(!empty($result))
    <div style="text-align: right">
        <a class="btn blue" href="{{url('fraud-detection/report/device')}}?export-excel=1"><i class="fa fa-download"></i> Export to Excel</a>
    </div>
    @endif

    <div class="table-scrollable">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col" width="10%"> Actions </th>
                    <th scope="col" width="25%"> Device Id </th>
                    <th scope="col" width="20%"> Device Type </th>
                    <th scope="col" width="30%"> User Fraud </th>
                    <th scope="col" width="30%"> List of user related devices </th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($result))
                    @foreach($result as $value)
                        <tr>
                            <td><a href="{{ url('fraud-detection/report/detail/device') }}/{{ $value['device_id'] }}" target="_blank" class="btn btn-block blue btn-xs"><i class="fa fa-edit"></i> Detail</a>
{{--                                <a onclick="updateStatus('{{$value['device_id']}}','Inactive')" class="btn btn-block red btn-xs"><i class="icon-close"></i> Delete Log</a>--}}
                            </td>
                            <td>{{$value['device_id']}}</td>
                            <td>{{$value['device_type']}}</td>
                            <td>
                                <?php
                                $html = '<table class="table table-bordered">';
                                $html .= '<tr><th>Date</th><th>Time</th><th>Name</th><th>Phone</th><th>Status</th></tr>';
                                foreach ($value['users_fraud'] as $dt){
                                    if($dt['is_suspended'] == 1){
                                        $status = '<span class="font-red">Suspend</span>';
                                    }else{
                                        $status = '<span class="font-green">Unsuspend</span>';
                                    }
                                    $html .= '<tr><td>'.date('d F Y', strtotime($dt['log_date'])).'</td><td>'.date('H:i', strtotime($dt['log_date'])).'</td><td>'.$dt['name'].'</td><td>'.$dt['phone'].'</td><td>'.$status.'</td></tr>';
                                }
                                $html .= '</table>';

                                echo $html;
                                ?>
                            </td>
                            <td>
                                <?php
                                $html = '<table class="table table-bordered">';
                                $html .= '<tr><th>Name</th><th>Phone</th><th>Status</th></tr>';
                                foreach ($value['users_no_fraud'] as $dt){
                                    if($dt['is_suspended'] == 1){
                                        $status = '<span class="font-red">Suspend</span>';
                                    }else{
                                        $status = '<span class="font-green">Unsuspend</span>';
                                    }
                                    $html .= '<tr><td>'.$dt['name'].'</td><td>'.$dt['phone'].'</td><td>'.$status.'</td></tr>';
                                }
                                $html .= '</table>';

                                echo $html;
                                ?>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <td colspan="10" style="text-align: center">No Data Available</td>
                @endif
            </tbody>
        </table>
    </div>
@endsection