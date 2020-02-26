<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs            = session('configs');

?>
@extends('layouts.main')
@include('infinitescroll')
@section('page-style')
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
@yield('is-style')
<style>
    .btn{
        margin:0 !important;
    }
</style>
@endsection

@section('page-script')
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
@yield('is-script')
<script type="text/javascript">
    function enableConfirmation(table,response){
        $(`.page${table.data('page')+1} [data-toggle='confirmation']`).confirmation({
            'btnOkClass':'btn btn-sm green',
            'btnCancelClass':'btn btn-sm red',
            'placement':'left'
        });
    }
    $(document).ready(function(){
        template = {
            productgroup: function(item){
                return `
                <tr class="page${item.page}">
                    <td class="text-center">${item.increment}</td>
                    <td>${item.product_group_code}</td>
                    <td>${item.product_category?item.product_category.product_category_name:'Uncategorized'}</td>
                    <td>${item.product_group_name}</td>
                    <td>${item.products_count}</td>
                    <td>
                      <div style="width: 75px">
                        <form action="{{url('product-variant/group/delete')}}" class="form-inline" method="POST">
                          <a href="{{url('product-variant/group')}}/${item.id_product_group}" class="btn btn-sm blue"><i class="fa fa-pencil"></i></a>
                          @csrf
                          <input type="hidden" name="id_product_group" value="${item.id_product_group}">
                          <button class="btn btn-sm red deleteBtn" data-toggle="confirmation" data-title="Are you sure delete this product group?" type="submit"><i class="fa fa-trash-o"></i></button>
                        </form>
                      </div>
                    </td>
                </tr>
                `;
            }
        };
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
            <span class="caption-subject sbold uppercase font-blue">List Product Group</span>
        </div>
    </div>
    <div class="portlet-body">
        <div class=" table-responsive is-container">
            <div class="table-infinite">
                <table class="table table-striped" id="tableTrx" data-template="productgroup"  data-page="0" data-is-loading="0" data-is-last="0" data-url="{{url()->current()}}" data-callback="enableConfirmation" data-order="promo_campaign_referral_transactions.created_at" data-sort="asc">
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
    </div>
</div>


@endsection