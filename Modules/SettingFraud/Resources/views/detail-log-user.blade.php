<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');
 ?>
@extends('layouts.main')

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
        <div class="row">
            <div class="col-md-6">
                {{$title}}
            </div>
            <div class="col-md-6" style="text-align: right">
                <a href="{{url('fraud-detection/suspend-user')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </h1>

    <div class="m-heading-1 border-green m-bordered">
        <div class="row">
            <div class="col-md-2">
                <strong>Name</strong>
            </div>
            <div class="col-md-4">
                <strong>: {{$result['detail_user']['name']}}</strong>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <strong>Phone</strong>
            </div>
            <div class="col-md-4">
                <strong>: {{$result['detail_user']['phone']}}</strong>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <strong>Email</strong>
            </div>
            <div class="col-md-4">
                <strong>: @if(!empty($result['detail_user']['email'])){{$result['detail_user']['email']}}@else N/A @endif</strong>
            </div>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Log Fraud Device</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="table-scrollable">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th width="20%"> Date Fraud </th>
                        <th width="15%"> Device ID </th>
                        <th width="10%"> Device Type </th>
                        <th width="40%"> Fraud Settings </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($result['list_device']))
                        @foreach($result['list_device'] as $val)
                            <tr>
                                <td>
                                    {{date("d F Y H:i", strtotime($val['created_at']))}}
                                </td>
                                <td>
                                    {{$val['device_id']}}
                                </td>
                                <td>
                                    {{$val['device_type']}}
                                </td>
                                <td>
                                    <?php
                                    if($val['fraud_setting_auto_suspend_value'] == 'all_account'){
                                        $value = 'All User';
                                    }elseif($val['fraud_setting_auto_suspend_value'] == 'last_login'){
                                        $value = 'Last Login';
                                    }else{
                                        $value = '-';
                                    }
                                    ?>
                                    <div class="form-group row">
                                        <label class="col-md-6">Detection Parameter</label>
                                        <div class="col-md-6"><input class="form-control" disabled value="(maximum) {{$val['fraud_setting_parameter_detail']}}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-6">Auto Suspend</label>
                                        <div class="col-md-6"><input class="form-control" disabled value="@if($val['fraud_setting_auto_suspend_status'] == 1) Active @else Inactive @endif"></div>
                                    </div>
                                    @if($val['fraud_setting_auto_suspend_status'] == 1 )
                                        <div class="form-group row">
                                            <label class="col-md-6">Auto Suspend Action</label>
                                            <div class="col-md-6"><input class="form-control" disabled value="{{$value}}"></div>
                                        </div>
                                    @endif
                                    <div class="form-group row">
                                        <label class="col-md-6">Forward Admin</label>
                                        <div class="col-md-6"><input class="form-control" disabled value="@if($val['fraud_setting_forward_admin_status'] == 1) Active @else Inactive @endif"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <td colspan="8" style="text-align: center">No Data Available</td>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Log Fraud Transaction Day</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="table-scrollable">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th width="5%"> Date </th>
                        <th width="5%"> Count Transaction </th>
                        <th width="30%"> Fraud Settings </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($result['list_trans_day']))
                        @foreach($result['list_trans_day'] as $value)
                            <tr>
                                <td>{{date("d F Y H:i", strtotime($value['created_at']))}}</td>
                                <td>{{$value['count_transaction_day']}}</td>
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
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Log Fraud Transaction Week</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="table-scrollable">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th width="5%"> Date </th>
                        <th width="5%"> Count Transaction </th>
                        <th width="30%"> Fraud Settings </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($result['list_trans_week']))
                        @foreach($result['list_trans_week'] as $value)
                            <tr>
                                <td>{{date("d F Y H:i", strtotime($value['created_at']))}}</td>
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
        </div>
    </div>
@endsection