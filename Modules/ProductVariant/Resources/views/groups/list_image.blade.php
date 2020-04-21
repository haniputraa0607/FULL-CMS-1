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
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/dropzone/basic.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
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
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/dropzone/dropzone.min.js') }}" type="text/javascript"></script>
<script src="{{ env('AWS_ASSET_URL') }}{{('assets/pages/scripts/form-dropzone.min.js') }}" type="text/javascript"></script>
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
                    <td><img style="width: 70px;" id="${item.product_group_code}" src="${item.product_group_photo}"></td>
                </tr>
                `;
            }
        };
    })
</script>
<script>
$( document ).ready(function() {
    Dropzone.options.myDropzone = {
        maxFilesize: 12,
        acceptedFiles: "image/*",
        parallelUploads: 1,
        init: function () {
            this.on("thumbnail", function(file) {
                if (file.width == 400 || file.height == 400) {
                    file.acceptDimensions();
                }
                else {
                    file.rejectDimensions();
                    this.removeFile(file)
                }
            });
        },
        accept: function(file, done) {
            file.acceptDimensions = done;
            file.rejectDimensions = function() {
                toastr.warning("Please check dimension of your photo.")
            };
        },
        success: function(file, response)
        {
            if (response.status == 'success') {
                filename = file.name.split('.')
                $("#"+filename[0]).replaceWith('<td id="'+filename[0]+'"><img style="width: 75px;" src="'+response.result.product_group_photo+'" alt=""></td>');
                toastr.success("Photo has been updated.")
            } else {
                toastr.warning("Make sure name file same as Product Code.")
                this.removeFile(file)
            }
        },
        error: function(file, response)
        {
            toastr.warning("Make sure you have right access.")
            this.removeFile(file)
        }
    };
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
<div class="portlet light bordered">
    <div class="row">
        <div class="col-md-12">
            <div class="m-heading-1 border-green m-bordered">
                <h4>Dropzone Product Image</h4>
                <p> Untuk melakukan perubahan image pada product, anda hanya perlu melakukan drop image yang ingin di ganti atau di tambahkan </p>
                <p>
                    <span class="label label-warning">NOTE:</span> &nbsp; Pastikan nama file sesuai dengan product code. Jika product code PR-001, maka nama file gambar PR-001.jpg dan pastikan ukuran gambar 400px X 400px. </p>
            </div>
            <form action="{{ url()->current() }}" method="POST" class="dropzone dropzone-file-area dz-clickable" id="my-dropzone" style="width: 600px; margin-top: 50px;">
                {{ csrf_field() }}
                <h3 class="sbold">Drop files here or click to upload</h3>
                <p> Image Pixel 400 X 400. </p>
            <div class="dz-default dz-message"><span></span></div></form>
        </div>
    </div>
</div>
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
                            <th>Image</th>
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