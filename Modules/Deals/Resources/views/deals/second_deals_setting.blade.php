<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs    		= session('configs');
?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-family: "Montserrat", "Lato", "Open Sans", "Helvetica Neue", Helvetica, Calibri, Arial, sans-serif;
            color: #6b7381;
            background: #f2f2f2;
        }
        .jumbotron {
            background: #6b7381;
            color: #bdc1c8;
        }
        .jumbotron h1 {
            color: #fff;
        }
        .example {
            margin: 4rem auto;
        }
        .example > .row {
            margin-top: 2rem;
            height: 5rem;
            vertical-align: middle;
            text-align: center;
            border: 1px solid rgba(189, 193, 200, 0.5);
        }
        .example > .row:first-of-type {
            border: none;
            height: auto;
            text-align: left;
        }
        .example h3 {
            font-weight: 400;
        }
        .example h3 > small {
            font-weight: 200;
            font-size: 0.75em;
            color: #939aa5;
        }
        .example h6 {
            font-weight: 700;
            font-size: 0.65rem;
            letter-spacing: 3.32px;
            text-transform: uppercase;
            color: #bdc1c8;
            margin: 0;
            line-height: 5rem;
        }
        .example .btn-toggle {
            top: 50%;
            transform: translateY(-50%);
        }
        .btn-toggle {
            margin: 0 4rem;
            padding: 0;
            position: relative;
            border: none;
            height: 1.5rem;
            width: 3rem;
            border-radius: 1.5rem;
            color: #6b7381;
            background: #bdc1c8;
        }
        .btn-toggle:focus,
        .btn-toggle.focus,
        .btn-toggle:focus.active,
        .btn-toggle.focus.active {
            outline: none;
        }
        .btn-toggle:before,
        .btn-toggle:after {
            line-height: 1.5rem;
            width: 4rem;
            text-align: center;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            bottom: 0;
            transition: opacity 0.25s;
        }
        .btn-toggle:before {
            content: "Inactive";
            left: -4rem;
        }
        .btn-toggle:after {
            content: "Active";
            right: -4rem;
            opacity: 0.5;
        }
        .btn-toggle > .handle {
            position: absolute;
            top: 0.1875rem;
            left: 0.1875rem;
            width: 1.125rem;
            height: 1.125rem;
            border-radius: 1.125rem;
            background: #fff;
            transition: left 0.25s;
        }
        .btn-toggle.active {
            transition: background-color 0.25s;
        }
        .btn-toggle.active > .handle {
            left: 1.6875rem;
            transition: left 0.25s;
        }
        .btn-toggle.active:before {
            opacity: 0.5;
        }
        .btn-toggle.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-sm:before,
        .btn-toggle.btn-sm:after {
            line-height: -0.5rem;
            color: #fff;
            letter-spacing: 0.75px;
            left: 0.4125rem;
            width: 2.325rem;
        }
        .btn-toggle.btn-sm:before {
            text-align: right;
        }
        .btn-toggle.btn-sm:after {
            text-align: left;
            opacity: 0;
        }
        .btn-toggle.btn-sm.active:before {
            opacity: 0;
        }
        .btn-toggle.btn-sm.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-xs:before,
        .btn-toggle.btn-xs:after {
            display: none;
        }
        .btn-toggle:before,
        .btn-toggle:after {
            color: #6b7381;
        }
        .btn-toggle.active {
            background-color: #29b5a8;
        }
        .btn-toggle.btn-lg {
            margin: 0 5rem;
            padding: 0;
            position: relative;
            border: none;
            height: 2.5rem;
            width: 5rem;
            border-radius: 2.5rem !important;
        }
        .btn-toggle.btn-lg:focus,
        .btn-toggle.btn-lg.focus,
        .btn-toggle.btn-lg:focus.active,
        .btn-toggle.btn-lg.focus.active {
            outline: none;
        }
        .btn-toggle.btn-lg:before,
        .btn-toggle.btn-lg:after {
            line-height: 2.5rem;
            width: 5rem;
            text-align: center;
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            bottom: 0;
            transition: opacity 0.25s;
        }
        .btn-toggle.btn-lg:before {
            content: "Inactive";
            left: -7rem;
        }
        .btn-toggle.btn-lg:after {
            content: "Active";
            right: -6rem;
            opacity: 0.5;
        }
        .btn-toggle.btn-lg > .handle {
            position: absolute;
            top: 0.3125rem;
            left: 0.3125rem;
            width: 1.875rem;
            height: 1.875rem;
            border-radius: 1.875rem !important;
            background: #fff;
            transition: left 0.25s;
        }
        .btn-toggle.btn-lg.active {
            transition: background-color 0.25s;
        }
        .btn-toggle.btn-lg.active > .handle {
            left: 2.8125rem;
            transition: left 0.25s;
        }
        .btn-toggle.btn-lg.active:before {
            opacity: 0.5;
        }
        .btn-toggle.btn-lg.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-lg.btn-sm:before,
        .btn-toggle.btn-lg.btn-sm:after {
            line-height: 0.5rem;
            color: #fff;
            letter-spacing: 0.75px;
            left: 0.6875rem;
            width: 3.875rem;
        }
        .btn-toggle.btn-lg.btn-sm:before {
            text-align: right;
        }
        .btn-toggle.btn-lg.btn-sm:after {
            text-align: left;
            opacity: 0;
        }
        .btn-toggle.btn-lg.btn-sm.active:before {
            opacity: 0;
        }
        .btn-toggle.btn-lg.btn-sm.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-lg.btn-xs:before,
        .btn-toggle.btn-lg.btn-xs:after {
            display: none;
        }
        .btn-toggle.btn-sm {
            margin: 0 0.5rem;
            padding: 0;
            position: relative;
            border: none;
            height: 1.5rem;
            width: 3rem;
            border-radius: 1.5rem;
        }
        .btn-toggle.btn-sm:focus,
        .btn-toggle.btn-sm.focus,
        .btn-toggle.btn-sm:focus.active,
        .btn-toggle.btn-sm.focus.active {
            outline: none;
        }
        .btn-toggle.btn-sm:before,
        .btn-toggle.btn-sm:after {
            line-height: 1.5rem;
            width: 0.5rem;
            text-align: center;
            font-weight: 600;
            font-size: 0.55rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            bottom: 0;
            transition: opacity 0.25s;
        }
        .btn-toggle.btn-sm:before {
            content: "Off";
            left: -0.5rem;
        }
        .btn-toggle.btn-sm:after {
            content: "On";
            right: -0.5rem;
            opacity: 0.5;
        }
        .btn-toggle.btn-sm > .handle {
            position: absolute;
            top: 0.1875rem;
            left: 0.1875rem;
            width: 1.125rem;
            height: 1.125rem;
            border-radius: 1.125rem;
            background: #fff;
            transition: left 0.25s;
        }
        .btn-toggle.btn-sm.active {
            transition: background-color 0.25s;
        }
        .btn-toggle.btn-sm.active > .handle {
            left: 1.6875rem;
            transition: left 0.25s;
        }
        .btn-toggle.btn-sm.active:before {
            opacity: 0.5;
        }
        .btn-toggle.btn-sm.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-sm.btn-sm:before,
        .btn-toggle.btn-sm.btn-sm:after {
            line-height: -0.5rem;
            color: #fff;
            letter-spacing: 0.75px;
            left: 0.4125rem;
            width: 2.325rem;
        }
        .btn-toggle.btn-sm.btn-sm:before {
            text-align: right;
        }
        .btn-toggle.btn-sm.btn-sm:after {
            text-align: left;
            opacity: 0;
        }
        .btn-toggle.btn-sm.btn-sm.active:before {
            opacity: 0;
        }
        .btn-toggle.btn-sm.btn-sm.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-sm.btn-xs:before,
        .btn-toggle.btn-sm.btn-xs:after {
            display: none;
        }
        .btn-toggle.btn-xs {
            margin: 0 0;
            padding: 0;
            position: relative;
            border: none;
            height: 1rem;
            width: 2rem;
            border-radius: 1rem;
        }
        .btn-toggle.btn-xs:focus,
        .btn-toggle.btn-xs.focus,
        .btn-toggle.btn-xs:focus.active,
        .btn-toggle.btn-xs.focus.active {
            outline: none;
        }
        .btn-toggle.btn-xs:before,
        .btn-toggle.btn-xs:after {
            line-height: 1rem;
            width: 0;
            text-align: center;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            bottom: 0;
            transition: opacity 0.25s;
        }
        .btn-toggle.btn-xs:before {
            content: "Off";
            left: 0;
        }
        .btn-toggle.btn-xs:after {
            content: "On";
            right: 0;
            opacity: 0.5;
        }
        .btn-toggle.btn-xs > .handle {
            position: absolute;
            top: 0.125rem;
            left: 0.125rem;
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 0.75rem;
            background: #fff;
            transition: left 0.25s;
        }
        .btn-toggle.btn-xs.active {
            transition: background-color 0.25s;
        }
        .btn-toggle.btn-xs.active > .handle {
            left: 1.125rem;
            transition: left 0.25s;
        }
        .btn-toggle.btn-xs.active:before {
            opacity: 0.5;
        }
        .btn-toggle.btn-xs.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-xs.btn-sm:before,
        .btn-toggle.btn-xs.btn-sm:after {
            line-height: -1rem;
            color: #fff;
            letter-spacing: 0.75px;
            left: 0.275rem;
            width: 1.55rem;
        }
        .btn-toggle.btn-xs.btn-sm:before {
            text-align: right;
        }
        .btn-toggle.btn-xs.btn-sm:after {
            text-align: left;
            opacity: 0;
        }
        .btn-toggle.btn-xs.btn-sm.active:before {
            opacity: 0;
        }
        .btn-toggle.btn-xs.btn-sm.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-xs.btn-xs:before,
        .btn-toggle.btn-xs.btn-xs:after {
            display: none;
        }
        .btn-toggle.btn-secondary {
            color: #6b7381;
            background: #bdc1c8;
        }
        .btn-toggle.btn-secondary:before,
        .btn-toggle.btn-secondary:after {
            color: #6b7381;
        }
        .btn-toggle.btn-secondary.active {
            background-color: #ff8300;
        }

    </style>
@endsection

@section('page-plugin')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $('.switch').on('click', function(e){
            var state = $(this).attr('aria-pressed');
            var token  = "{{ csrf_token() }}";

            if(state === 'false'){
                state = 1;
            }else{
                state = 0;
            }

            $.ajax({
                type : "POST",
                url : "{{ url('second-deals/update/status') }}",
                data : "_token="+token+"&status="+state,
                success : function(result) {
                    if (result.status == "success") {
                        toastr.info("Status has been updated.");
                        if(state == 1){
                            document.getElementById('div_list').style.display = 'block';
                            $('.input-required').prop('required', true);
                        }else{
                            document.getElementById('div_list').style.display = 'none';
                            $('.input-required').prop('required', false);
                        }
                    }
                    else {
                        toastr.warning(result.messages);
                    }
                },
                error: function (jqXHR, exception) {
                    toastr.warning('Failed update status');
                }
            });
        });

        function addDealsToList() {
            var list_deals_id = $("input[name='list_deals_id[]']")
                .map(function(){return $(this).val();}).get();
            var id_deals = $('#id_all_deals').val();

            var check_deals_exist = list_deals_id.indexOf(id_deals);

            if(check_deals_exist >= 0){
                confirm('Voucher already exist in list, please select another voucher?')
            }else{
                var data = $('#id_all_deals').select2('data');
                var text = data[0].text;
                var id_deals = $('#id_all_deals').val();
                var html = '';
                html += '<div class="row" id="div_'+id_deals+'" style="margin-bottom: 2%;">';
                html += '<div class="col-md-1">';
                html += '<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteDeals('+id_deals+')">';
                html += '<i class="fa fa-close"></i>';
                html += '</a>';
                html += '</div>';
                html += '<div class="col-md-6">';
                html += '<textarea class="form-control" type="text" value="'+text+'" disabled>'+text+'</textarea>';
                html += '</div>';
                html += '<div class="col-md-2">';
                html += '<input class="form-control price input-required" placeholder="Total" name="list_deals_total[]" type="text" value="" required>';
                html += '</div>';
                html += '<input type="hidden" name="list_deals_id[]" value="'+id_deals+'">';
                html += '</div>';

                $("#list").append(html);
            }
        }

        function deleteDeals(id_deals){
            if(confirm('Are you sure you want to delete this deals from list?')) {
                $('#div_'+id_deals).remove()
            }

        }

        function inCheck() {
            var list_deals_id = $("input[name='list_deals_id[]']")
                .map(function(){return $(this).val();}).get();
            var list_deals_total = $("input[name='list_deals_total[]']")
                .map(function(){return $(this).val();}).get();
            var validation_status = 0;

            if(list_deals_id.length <= 0){
                confirm('Please add one or more voucher.')
                validation_status = 1;
            }else{
                if(list_deals_total.indexOf("") >= 0){
                    confirm('Total can not be empty.')
                    validation_status = 1;
                }
            }

            if(validation_status === 0){
                document.getElementById("form_setting").submit();
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase ">Second Deals Setting</span>
            </div>
        </div>
        <div class="portlet-body form">

            <br>
            <div class="form-group row">
                <div class="col-md-4" style="margin-left: 2.5%;margin-top: 7px;">
                    <button type="button" class="btn btn-lg btn-toggle switch @if($setting['value']) active @endif" data-toggle="button" aria-pressed="<?=($setting['value'] == '1' ? 'true' : 'false')?>" autocomplete="off">
                        <div class="handle"></div>
                    </button>
                </div>
            </div>
            <br>

            <div class="portlet light bordered" id="div_list">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-blue sbold uppercase ">List Voucher</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="row" style="margin-bottom: 5%;" class="col-md-12">
                        <div class="col-md-7">
                            @if(MyHelper::hasAccess([25], $configs))
                                <select id="id_all_deals" class="form-control select2" placeholder="Search Deals">
                                    @foreach($all_deals as $val)
                                        <option id="{{$val['id_deals']}}" value="{{$val['id_deals']}}">{{$val['deals_title']}}</option>
                                    @endforeach
                                </select>
                            @else
                                <select id="id_all_deals" class="form-control select2" placeholder="Search Deals">
                                    @foreach($all_deals as $val)
                                        <option id="{{$val['id_deals']}}" value="{{$val['id_deals']}}">{{$val['deals_title']}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <button class="btn green" onclick="addDealsToList()">Add Voucher</button>
                        </div>
                    </div>

                    <form role="form" class="form-horizontal" id="form_setting" action="{{url('second-deals/setting')}}" method="POST">
                        {{ csrf_field() }}
                        <div id="list">
                            @foreach($deals as $val)
                                @if(MyHelper::hasAccess([25], $configs))
                                    <div class="row" id="div_{{$val['id_deals']}}" style="margin-bottom: 2%;">
                                        <div class="col-md-1">
                                            <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteDeals('{{$val['id_deals']}}')">
                                                <i class="fa fa-close"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <textarea class="form-control" type="text" rows="2" disabled>{{$val['deals_title']}}</textarea>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control price input-required" placeholder="Total" name="list_deals_total[]" type="text" value="{{$val['deals_total']}}" required>
                                        </div>
                                        <input type="hidden" name="list_deals_id[]" value="{{$val['id_deals']}}">
                                    </div>
                                @else
                                    <div class="row" id="div_{{$val['id_deals']}}" style="margin-bottom: 2%;">
                                        <div class="col-md-1">
                                            <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteDeals('{{$val['id_deals']}}')">
                                                <i class="fa fa-close"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <textarea class="form-control" type="text" rows="2" disabled>{{$val['deals_title']}}</textarea>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control price input-required" placeholder="Total" name="list_deals_total[]" type="text" value="{{$val['deals_total']}}" required>
                                        </div>
                                        <input type="hidden" name="list_deals_id[]" value="{{$val['id_deals']}}">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </form>
                    <div style="text-align: center;margin-top: 5%">
                        <button onclick="inCheck()" class="btn green"> Save </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection