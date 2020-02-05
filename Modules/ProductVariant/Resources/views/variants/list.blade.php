<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs            = session('configs');

?>
@extends('layouts.main')

@section('page-style')
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
<style>
    #main-data .data-data .view{
        display: block;
    }
    #main-data .data-data .form{
        display: none;
    }
    #main-data .data-data.editing .view{
        display: none;
    }
    #main-data .data-data.editing .form{
        display: block;
    }
    .handle{
        cursor: move;
    }
</style>
@endsection

@section('page-script')
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.sortable').sortable({
            handle: '.handle'
        }).disableSelection();
        $('#main-data').on('click','.editBtn',function(){
            var id = $(this).data('id');
            $('.row'+id).addClass('editing');
        })
        $('#main-data').on('click','.saveBtn',function(){
            var id = $(this).data('id');
            var row = $('.row'+id);
            var code = row.find('.code');
            var name = row.find('.name');
            code.find('.view').text(code.find('.form input').val());
            name.find('.view').text(name.find('.form input').val());
            row.removeClass('editing');
        })
        $('#main-data').on('click','.cancelBtn',function(){
            var id = $(this).data('id');
            var row = $('.row'+id);
            var code = row.find('.code');
            var name = row.find('.name');
            console.log(code.find('.view').text());
            console.log(name.find('.view').text());
            code.find('.form input').val(code.find('.view').text().trim());
            name.find('.form input').val(name.find('.view').text().trim());
            row.removeClass('editing');
            $('.row'+id).removeClass('editing');
        })
    })
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
            <span class="caption-subject sbold uppercase font-blue">List Product Variant</span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="alert alert-info">Drag [<i class="fa fa-ellipsis-h" style="transform: rotate(90deg);"></i>] handle button to reorder variant</div>
        <form action="{{ url('product-variant/reorder') }}" method="post">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <ul class="nav nav-tabs tabs-left sortable">
                        @php $first=true; @endphp
                        @foreach($parents as $parent)
                        <li class="@if($first) active @php $first=false; @endphp @endif">
                            <a href="#tab_{{$parent['id_product_variant']}}" data-toggle="tab"><span class="handle"><i class="fa fa-ellipsis-h" style="transform: rotate(90deg);"></i></span> {{$parent['product_variant_name']}} </a>
                            <input type="hidden" name="parent[]" value="{{$parent['id_product_variant']}}">
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-9" id="main-data">
                    <div class="tab-content">
                        @php $first=true; @endphp
                        @foreach($parents as $parent)
                        <div class="tab-pane @if($first) active @php $first=false; @endphp @endif" id="tab_{{$parent['id_product_variant']}}">
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gear"></i>Variant Type Detail
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                    </div>
                                </div>
                                <div class="portlet-body form-horizontals" style="padding-top: 25px">
                                    <div class="row">
                                        <label class="col-md-2 control-label text-right">Code <i class="fa fa-question-circle tooltips" data-original-title="Kode unik yang membedakan tiap varian" data-container="body"></i></label>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="{{$parent['product_variant_code']}}" disabled>
                                            </div>
                                        </div>
                                        <label class="col-md-2 control-label text-right">Name <i class="fa fa-question-circle tooltips" data-original-title="Nama varian, akan ditampilkan di admin panel" data-container="body"></i></label>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="{{$parent['product_variant_name']}}" name="variants[{{$parent['id_product_variant']}}][product_variant_name]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 control-label text-right">Title <i class="fa fa-question-circle tooltips" data-original-title="Judul yang akan di tampilkan di mobile apps" data-container="body"></i></label>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="{{$parent['product_variant_title']}}" name="variants[{{$parent['id_product_variant']}}][product_variant_title]">
                                            </div>
                                        </div>
                                        <label class="col-md-2 control-label text-right">Subtitle <i class="fa fa-question-circle tooltips" data-original-title="Subtitle yang akan ditampilkan di mobile apps" data-container="body"></i></label>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="{{$parent['product_variant_subtitle']}}" name="variants[{{$parent['id_product_variant']}}][product_variant_subtitle]">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="portlet">
                                <div class="portlet-title green box">
                                    <div class="caption" style="margin-left: 10px;">
                                        Variants
                                    </div>
                                    <div class="tools" style="margin-right: 10px;">
                                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-advance table-hover" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 1%"></th>
                                                <th> Code </th>
                                                <th> Name </th>
                                                <th style="width: 85px"> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody class="sortable">
                                            @foreach($childs[$parent['id_product_variant']] as $child)
                                            <tr class="row{{$child['id_product_variant']}} data-data">
                                                <td class="handle">
                                                    <i class="fa fa-ellipsis-h" style="transform: rotate(90deg);"></i>
                                                </td>
                                                <td class="code">
                                                    <span class="view">
                                                        {{$child['product_variant_code']}}
                                                    </span>
                                                    <span class="form">
                                                        <input type="text" value="{{$child['product_variant_code']}}" class="form-control" name="variants[{{$child['id_product_variant']}}][product_variant_code]">
                                                    </span>
                                                </td>
                                                <td class="name">
                                                    <span class="view">
                                                        {{$child['product_variant_name']}}
                                                    </span>
                                                    <span class="form">
                                                        <input type="text" value="{{$child['product_variant_code']}}" class="form-control" name="variants[{{$child['id_product_variant']}}][product_variant_name]">
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <input type="hidden" name="child[{{$child['parent']['id_product_variant']}}][]" value="{{$child['id_product_variant']}}">
                                                    <span class="view">
                                                        <div class="btn-group">
                                                        <button href="{{url('product-variant/'.$child['product_variant_code'])}}" class="btn btn-sm blue editBtn" data-id="{{$child['id_product_variant']}}" type="button"><i class="fa fa-pencil"></i></button>
                                                    </span>
                                                    <span class="form">
                                                        <div class="btn-group">
                                                            <button href="{{url('product-variant/'.$child['product_variant_code'])}}" class="btn btn-sm green saveBtn" data-id="{{$child['id_product_variant']}}" type="button"><i class="fa fa-check"></i></button>
                                                            <button href="{{url('product-variant/'.$child['product_variant_code'])}}" class="btn btn-sm red cancelBtn" data-id="{{$child['id_product_variant']}}" type="button"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                {{ csrf_field() }}
                <div class="col-md-offset-5 col-md-6">
                    <button type="submit" class="btn blue">Update Data</button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection