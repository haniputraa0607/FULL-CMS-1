@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script type="text/javascript">
        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        $('.switch-change').on('switchChange.bootstrapSwitch', function (event, state) {
            var data = $(this).data('id');
            var split = data.split('|');
            var name = split[1];
            var phone = split[0];
            var id_fraud_log = split[2];

            $( ".modal" ).remove();
            var status_msg = '';

            if(state == 1){
                status_msg = 'Unsuspend';
                var status_input = 1;
            }else{
                status_msg = 'Suspend';
                var status_input = 0;
            }

            var html = '';
            html += '<div class="modal fade" id="update_suspend" tabindex="-1" role="update_suspend" aria-hidden="true">';
            html += '<div class="modal-dialog">';
            html += '<div class="modal-content">';
            html += '<div class="modal-header">';
            html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>';
            html += '<h4 class="modal-title">Update Status Suspend</h4>';
            html += '</div>';
            html += '<div class="modal-body">';
            html += '<form action="{{url('fraud-detection/update/suspend')}}/transaction-day/'+phone+'" role="form" method="POST" id="formSuspend">';
            html += '<input type="hidden" name="_token" value="{{csrf_token()}}">';

            html += '<div class="alert alert-danger">';
            html += 'Apakah Anda yakin untuk <strong>'+status_msg+' '+name+' ('+phone+')</strong> ? Jika iya, silahkan masukkan pin dan tekan tombol <strong>Save</strong>.</p>';
            html += '</div>';
            html += '<input type="hidden" name="id_fraud_log" value="'+id_fraud_log+'">';
            html += '<input type="hidden" name="is_suspended" value="'+status_input+'">';
            html += '<div class="form-group row">';
            html += '<label class="control-label col-md-12">Your PIN</label>';
            html += '<div class="col-md-6">';
            html += '<input type="password" id="pinUser" class="form-control" width="30%" name="password_suspend" placeholder="Enter Your current PIN" required style="width: 91.3%;" maxLength="6" minLength="6" onkeypress="return isNumberKey(event)">';
            html += '</div>';
            html += '<div class="col-md-8"></div>';
            html += '</div>';
            html += '<div class="margin-top-10">';
            html += '<button type="submit" class="btn green">'+status_msg+'</button>';
            html += '</div>';
            html += '</form>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            $("#div_modal").append(html);
            $('#update_suspend').modal('show');
        });

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
        <div class="row">
            <div class="col-md-6">
                Detail Report Fraud Transaction Day
            </div>
            <div class="col-md-6" style="text-align: right">
                <a href="{{url('fraud-detection/report/transaction-day')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </h1>
    @if(isset($result['detail_user'])  && $result['detail_user']['level'] != 'Super Admin')
    <div class="form-group">
        <label class="col-md-3 control-label" style="text-align: left">Suspend/Unsuspend <i class="fa fa-question-circle tooltips" data-original-title="untuk mengatur status fraud menjadi status suspend user" data-container="body"></i></label>

        <div class="col-md-8" style="margin-left: -5%;">
            <input type="checkbox" id="switch-change-device_id" name="fraud_settings_status" @if(isset($result['detail_user']) && $result['detail_user']['is_suspended'] == 1) checked @endif data-id="@if(isset($result['detail_user']) ){{ $result['detail_user']['phone'] }}|{{ $result['detail_user']['name'] }}|{{$id_fraud_log}}@endif" class="make-switch switch-change" data-size="small" data-on-text="Suspend" data-off-text="Unsuspend">
            @if(isset($result['detail_user'])  && $result['detail_user']['is_suspended'] == 1)
                <strong class="font-red"> &nbsp;(Now, status user is Inactive)</strong>
            @else
                <strongs class="font-green"> &nbsp;(Now, status user is Active)</strongs>
            @endif
        </div>
    </div>
    <br>
    <br>
    @endif

    <div class="m-heading-1 border-green m-bordered">
        <p><strong>Fraud Setting</strong></p>
        <hr>
        <div class="form-group row">
            <label class="col-md-4">Detection Parameter</label>
            <div class="col-md-4"><input class="form-control" disabled value="(maximum) {{$result['detail_log']['fraud_setting_parameter_detail']}}"></div>
        </div>
        <div class="form-group row">
            <label class="col-md-4">Auto Suspend</label>
            <div class="col-md-4"><input class="form-control" disabled value="@if($result['detail_log']['fraud_setting_auto_suspend_status'] == 1) Active @else Inactive @endif"></div>
        </div>
        @if($result['detail_log']['fraud_setting_auto_suspend_status'] == 1 )
            <div class="form-group row">
                <label class="col-md-4">Auto Suspend Value</label>
                <div class="col-md-4"><input class="form-control" disabled value="(maximum) {{$result['detail_log']['fraud_setting_auto_suspend_value']}}"></div>
            </div>
                <div class="form-group row">
                    <label class="col-md-4">Auto Suspend Time Period</label>
                    <div class="col-md-4"><input class="form-control" disabled value="{{$result['detail_log']['fraud_setting_auto_suspend_time_period']}} (day)"></div>
                </div>
        @endif
        <div class="form-group row">
            <label class="col-md-4">Forward Admin</label>
            <div class="col-md-4"><input class="form-control" disabled value="@if($result['detail_log']['fraud_setting_forward_admin_status'] == 1) Active @else Inactive @endif"></div>
        </div>
    </div>
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-blue ">
                <span class="caption-subject bold uppercase">List Transaction</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="portlet-body form">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th scope="col"> Status Fraud </th>
                            <th scope="col"> Order ID </th>
                            <th scope="col"> User Name </th>
                            <th scope="col"> User Phone </th>
                            <th scope="col"> Outlet </th>
                            <th scope="col"> Transaction Date </th>
                            <th scope="col"> Transaction Time </th>
                            <th scope="col"> Point </th>
                            <th scope="col"> Grand Total </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($result['detail_transaction']))
                            @foreach($result['detail_transaction'] as $val)
                                <tr>
                                    <td>
                                        <?php
                                        if($val['fraud_flag'] != null){
                                            if($val['fraud_flag'] == 'transaction day'){
                                                echo '<span style="color: red">Yes, Fraud Transaction Day</span>';
                                            }else{
                                                echo '<span style="color: red">Yes, Fraud Transaction Week</span>';
                                            }
                                        }else{
                                            echo '<span style="color: green">No Fraud</span>';
                                        }

                                        ?></td>
                                    <td>
                                        @if(strtolower($val['trasaction_type']) == 'offline')
                                            <a target="_blank" href="{{ url('transaction/detail/') }}/{{ $val['id_transaction'] }}/offline">{{$val['transaction_receipt_number']}}</a>
                                        @else
                                            <a target="_blank" href="{{ url('transaction/detail/') }}/{{ $val['id_transaction'] }}/pickup order">{{$val['transaction_receipt_number']}}</a>
                                        @endif
                                    </td>
                                    <td>{{$result['detail_user']['name']}}</td>
                                    <td>{{$result['detail_user']['phone']}}</td>
                                    <td>{{$val['outlet']['outlet_name']}}</td>
                                    <td>{{date("d F Y", strtotime($val['transaction_date']))}}</td>
                                    <td>{{date("H:i", strtotime($val['transaction_date']))}}</td>
                                    <td>{{$val['transaction_cashback_earned']}}</td>
                                    <td>{{ number_format($val['transaction_grandtotal'], 2) }}</td>
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
    </div>

    <div id="div_modal"></div>
@endsection