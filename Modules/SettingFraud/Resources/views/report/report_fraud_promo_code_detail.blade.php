@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        table.table-description td {
            width: 30%;
        }
    </style>
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

    @if(!empty($result['detail_fraud']))
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">Description</div>
        </div>
        <div class="portlet-body" >
            <div class="row">
                <div class="col-md-6">
                    <p><b>User Data</b></p>
                    <table class="table-description">
                        <tr>
                            <td>User Name</td>
                            <td>: {{$result['detail_fraud']['name']}}</td>
                        </tr>
                        <tr>
                            <td>User Phone</td>
                            <td>: {{$result['detail_fraud']['phone']}}</td>
                        </tr>
                        <tr>
                            <td>User Email</td>
                            <td>: {{$result['detail_fraud']['email']}}</td>
                        </tr>
                    </table>
                </div>
                <div>
                    <p><b>Fraud Setting</b></p>
                    <table class="table-description">
                        <tr>
                            <td>Number of violation</td>
                            <td>: (maximum) {{$result['detail_fraud']['fraud_setting_parameter_detail']}} validation</td>
                        </tr>
                        <tr>
                            <td>Parameter Time</td>
                            <td>: (below) {{$result['detail_fraud']['fraud_parameter_detail_time']}} minutes</td>
                        </tr>
                        <tr>
                            <td>Auto Suspend Status</td>
                            <td>: @if($result['detail_fraud']['fraud_setting_auto_suspend_status'] == 1) Active @else Inactive @endif</td>
                        </tr>
                        <tr>
                            <td>Forward Admin Status</td>
                            <td>: @if($result['detail_fraud']['fraud_setting_forward_admin_status'] == 1) Active @else Inactive @endif</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="table-scrollable">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th width="5%"> Device ID </th>
                <th width="5%"> Promo Code </th>
                <th width="5%"> Date </th>
                <th width="5%"> Time </th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($result['list_promo_code']))
                @foreach($result['list_promo_code'] as $value)
                    <tr>
                        <td>{{$value['device_id']}}</td>
                        <td>{{$value['promo_code']}}</td>
                        <td>{{date("d F Y", strtotime($value['created_at']))}}</td>
                        <td>{{date("H:i", strtotime($value['created_at']))}}</td>
                    </tr>
                @endforeach
            @else
                <td colspan="11" style="text-align: center">No Data Available</td>
            @endif
            </tbody>
        </table>
    </div>
@endsection