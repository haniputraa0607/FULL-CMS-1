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

        function updateStatusSuspend(device_id,status,phone,name, id_user) {
            $( ".modal" ).remove();
            var status_msg = '';
            var status_input = 1;
            if(status == 1){
                status_msg = 'Unsuspend';
                status_input = 0;
            }else{
                status_msg = 'Suspend';
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
            html += '<form action="{{url('fraud-detection/update/suspend')}}/device/'+phone+'" role="form" method="POST" id="formSuspend">';
            html += '<input type="hidden" name="_token" value="{{csrf_token()}}">';
            html += '<input type="hidden" name="id_user" value="'+id_user+'">';

            html += '<div class="alert alert-danger">';
            html += 'Apakah Anda yakin untuk <strong>'+status_msg+' '+name+' ('+phone+')</strong> ? Jika iya, silahkan masukkan pin dan tekan tombol <strong>Save</strong>.</p>';
            html += '</div>';
            html += '<input type="hidden" name="device_id" value="'+device_id+'">';
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
        }

        function  updateStatusDeviceLogin(id_user,device_id,status) {
            var status_msg = '';
            var token  = "{{ csrf_token() }}";

            if(status == 'Active'){
                status = 'Inactive';
            }else{
                status = 'Active';
            }

            if(confirm('Are you sure you want to '+status+' this User?')) {
                $.ajax({
                    type : "POST",
                    url : "{{ url('fraud-detection/update/device/login') }}",
                    data : "_token="+token+"&device_id="+device_id+"&status="+status+"&id_user="+id_user,
                    success : function(result) {
                        if (result.status == "success") {
                            toastr.info(result.messages);
                            setTimeout(function(){ window.location.href = '{{url('fraud-detection/report/detail/device')}}/'+device_id; }, 1000);
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
                <span>{{ $sub_title }}</span>
            </li>
        </ul>
    </div><br>

    @include('layouts.notifications')

    <h1 class="page-title">
        <div class="row">
            <div class="col-md-6">
                Detail Report Fraud Device
            </div>
            <div class="col-md-6" style="text-align: right">
                <a href="{{url('fraud-detection/report/device')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </h1>

    <div class="m-heading-1 border-green m-bordered">
        <div class="row">
            <div class="col-md-2">
                <strong>Device ID</strong>
            </div>
            <div class="col-md-4">
                <strong>: {{$result['detail_user'][0]['device_id']}}</strong>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <strong>Device Type</strong>
            </div>
            <div class="col-md-4">
                <strong>: {{$result['detail_user'][0]['device_type']}}</strong>
            </div>
        </div>
    </div>

    <div class="note note-danger">
        <p>
            <i class="fa fa-warning"></i>&nbsp; Jika Anda mau mengubah status menjadi <strong class="font-red">Unsuspend</strong>, silahkan mengubah status user yang akan di buang atau tidak akan dipakai menjadi <strong class="font-red">Inactive</strong>.<br>
            <i class="fa fa-info-circle"></i> Kolom "Suspend", tanda centang (<i class="fa fa-check"></i>) brarti saat ini user "sudah" di suspend dan tanda silang (<i class="fa fa-close"></i>) brarti saat ini user "belum" di suspend.
        </p>
    </div>
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-dark sbold uppercase font-green">List User</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-scrollable">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th width="17%" style="text-align: center;"> Actions </th>
                        <th width="5%" style="text-align: center;"> Suspend </th>
                        <th width="15%" style="text-align: center;"> Name </th>
                        <th width="10%" style="text-align: center;"> Phone </th>
                        <th width="15%" style="text-align: center;"> Last Login Date</th>
                        <th width="15%" style="text-align: center;"> Last Login Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($result['detail_user']))
                        @foreach($result['detail_user'] as $val)
                            @if($val['status'] == 'Inactive')
                                <tr style="background-color: #BFBFBF;" >
                            @else
                                <tr>
                            @endif
                                <td width="15%">
                                    @if($val['status'] == 'Active')@if($val['level'] != 'Super Admin')<a onclick="updateStatusSuspend('{{$val['device_id']}}','{{$val['is_suspended']}}','{{$val['phone']}}','{{$val['name']}}','{{$val['id']}}')" class="btn @if($val['is_suspended']) green-dark @else red @endif btn-xs"><i class="icon-pencil"></i>@if($val['is_suspended'] == 1) Unsuspend @else Suspend @endif</a>@endif @endif
                                    <a onclick="updateStatusDeviceLogin('{{$val['id_user']}}','{{$val['device_id']}}','{{$val['status']}}')" class="btn @if($val['status'] == 'Active') red-mint @endif btn-xs">@if($val['status'] == 'Active') <i class="icon-close"></i> Remove Account from this device @endif</a>
                                </td>
                                <td style="text-align: center;font-size: 16px;">
                                    @if($val['is_suspended'] == 1) <strong style="color: green"><i class="fa fa-check"></i></strong> @else <strong class="font-red"><i class="fa fa-close"></i></strong> @endif
                                </td>
                                <td>
                                    {{$val['name']}}
                                </td>
                                <td>
                                    {{$val['phone']}}
                                </td>
                                <td>
                                    {{date("d F Y", strtotime($val['last_login']))}}
                                </td>
                                <td>
                                    {{date("H:i", strtotime($val['last_login']))}}
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
                <span class="caption-subject font-dark sbold uppercase font-green">Log Fraud</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-scrollable">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th width="20%"> Date Fraud </th>
                        <th width="20%"> Time Fraud </th>
                        <th width="15%"> Name </th>
                        <th width="10%"> Phone </th>
                        <th width="40%"> Fraud Settings </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($result['detail_fraud']))
                        @foreach($result['detail_fraud'] as $val)
                            <tr>
                                <td>
                                    {{date("d F Y", strtotime($val['created_at']))}}
                                </td>
                                <td>
                                    {{date("H:i", strtotime($val['created_at']))}}
                                </td>
                                <td>
                                    {{$val['name']}}
                                </td>
                                <td>
                                    {{$val['phone']}}
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

    <div id="div_modal"></div>
@endsection