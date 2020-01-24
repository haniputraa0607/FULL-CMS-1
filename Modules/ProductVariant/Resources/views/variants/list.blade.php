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
@endsection

@section('page-script')
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.sortable').sortable().disableSelection();
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
            <span class="caption-subject sbold uppercase font-blue">List Product By Category</span>
        </div>
    </div>
    <div class="portlet-body">
        <form action="{{ url('product_variant/reorder') }}" method="post">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <ul class="nav nav-tabs tabs-left sortable">
                        @php $first=true; @endphp
                        @foreach($parents as $parent)
                        <li class="@if($first) active @php $first=false; @endphp @endif">
                            <a href="#tab_{{$parent['id_product_variant']}}" data-toggle="tab"> {{$parent['product_variant_name']}} </a>
                            <input type="hidden" name="parent[]" value="{{$parent['id_product_variant']}}">
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-9">
                    <div class="tab-content">
                        @php $first=true; @endphp
                        @foreach($parents as $parent)
                        <div class="tab-pane @if($first) active @php $first=false; @endphp @endif" id="tab_{{$parent['id_product_variant']}}">
                            <table class="table table-striped table-bordered table-hover dt-responsive sample_1" width="100%">
                                <thead>
                                    <tr>
                                        <th> Code </th>
                                        <th> Name </th>
                                    </tr>
                                </thead>
                                <tbody class="sortable">
                                    @foreach($childs[$parent['id_product_variant']] as $child)
                                    <tr>
                                        <td>{{$child['product_variant_code']}}</td>
                                        <td>{{$child['product_variant_name']}}</td>
                                        <input type="hidden" name="parent[]" value="{{$child['id_product_variant']}}">
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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