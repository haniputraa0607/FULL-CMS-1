<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');
 ?>
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
    <script>
        function updateStatusSuspend(status,phone,name) {
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
            html += '<form action="{{url('fraud-detection/update/suspend')}}/suspend-user/'+phone+'" role="form" method="POST" id="formSuspend">';
            html += '<input type="hidden" name="_token" value="{{csrf_token()}}">';

            html += '<div class="alert alert-danger">';
            html += 'Apakah Anda yakin untuk <strong>'+status_msg+' '+name+' ('+phone+')</strong> ? Jika iya, silahkan masukkan pin dan tekan tombol <strong>Save</strong>.</p>';
            html += '</div>';
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
        {{$title}}
    </h1>

    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">Filter</div>
            <div class="tools">
                <a href="javascript:;" class="@if(Session::has('filter-user-fraud'))  expand @else collapse @endif"> </a>
            </div>
        </div>
        <div class="portlet-body" @if(Session::has('filter-user-fraud')) style="display: none;" @endif>
            <form role="form" class="form-horizontal" action="{{url()->current()}}?filter=1" method="POST">
                {{ csrf_field() }}
                @include('filter-report-log-fraud')
            </form>
        </div>
    </div>

    @if(Session::has('filter-user-fraud'))
        <?php
        $search_param = Session::get('filter-user-fraud');
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
                <a href="{{ url('fraud-detection/filter/reset') }}/filter-user-fraud" class="btn yellow">Reset</a>
            </p>
        </div>
    @endif

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">List User</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="table-scrollable">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th scope="col"> Actions </th>
                        <th scope="col"> Name </th>
                        <th scope="col"> Phone </th>
                        <th scope="col"> Email </th>
                        <th scope="col"> Suspend Date </th>
                        <th scope="col"> Suspend Time </th>
                    </tr>
                    </thead>
                    <tbody>
                        {{ csrf_field() }}
                        @if(!empty($content))
                            @foreach($content as $no => $data)

                                @if($data['phone_verified'] == 0)
                                    <tr style="color:red">
                                @elseif($data['level'] == "Admin")
                                    <tr style="color:blue">
                                @elseif($data['level'] == "Super Admin")
                                    <tr style="color:green">
                                @else
                                    <tr>
                                @endif
                                        <td>
                                            <a href="{{url('fraud-detection/suspend-user/detail')}}/{{$data['phone']}}" target="_blank" class="btn btn-block blue btn-xs">Log Fraud</a>
                                            @if($data['level'] != 'Super Admin')<a onclick="updateStatusSuspend('{{$data['is_suspended']}}','{{$data['phone']}}','{{$data['name']}}')" class="btn btn-block red btn-xs"><i class="icon-pencil"></i>@if($data['is_suspended'] == 1) Unsuspend @else Suspend @endif</a>@endif
                                        </td>
                                        <td> {!!str_replace(" ","&nbsp;", $data['name'])!!} </td>
                                        <td> {{$data['phone']}} </td>
                                        <td> {{$data['email']}} </td>
                                        <td> @if($data['suspended_date'] != NULL){{date('d F Y', strtotime($data['suspended_date']))}} @endif</td>
                                        <td> @if($data['suspended_date'] != NULL){{date('H:i', strtotime($data['suspended_date']))}} @endif</td>
                                    </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="row" style="text-align: right">
                <div class="col-md-12">
                    <div class="pull-right pagination" style="margin-top: 0px;margin-bottom: 0px;">
                        <ul class="pagination" style="margin-top: 0px;margin-bottom: 0px;">
                            @if($page <= 1) <li class="page-first disabled"><a href="javascript:void(0)">«</a></li>
                            @else <li class="page-first"><a href="{{url('fraud-detection/suspend-user')}}/?page={{$page-1}}">«</a></li>
                            @endif

                            @if($total <= $last) <li class="page-last disabled"><a href="javascript:void(0)">»</a></li>
                            @else <li class="page-last"><a href="{{url('fraud-detection/suspend-user')}}/?page={{$page+1}}">»</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="div_modal"></div>
@endsection