<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs            = session('configs');

?>
@extends('layouts.main')

@section('page-style')
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
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
        <table class="table table-striped table-bordered table-hover dt-responsive" id="table-product-group">
            <thead>
                <tr>
                    <th style="width: 1%" class="text-center">No</th>
                    <th>Code</th>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Variants</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($product_groups??[] as $group)
                <tr>
                    <td class="text-center">{{$no}} @php $no++ @endphp</td>
                    <td>{{$group['product_group_code']}}</td>
                    <td>{{$group['product_category']['product_category_name']}}</td>
                    <td>{{$group['product_group_name']}}</td>
                    <td>{{$group['products_count']}}</td>
                    <td>
                      <div class="btn-group" style="width: 62px;">
                        <a href="{{url('product-variant/group/'.$group['id_product_group'])}}" class="btn btn-sm blue"><i class="fa fa-pencil"></i></a>
                        <form action="{{url('product-variant/group/delete')}}" class="form-inline" method="POST">
                          @csrf
                          <input type="hidden" name="id_product_group" value="{{$group['id_product_group']}}">
                          <button class="btn btn-sm red deleteBtn" data-toggle="confirmation" data-title="Are you sure delete this product group?" type="submit"><i class="fa fa-trash-o"></i></button>
                        </form>
                      </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection