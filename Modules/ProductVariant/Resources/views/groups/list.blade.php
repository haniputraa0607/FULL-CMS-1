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
<script type="text/javascript">
    $(document).ready(function(){
        $('#table-product-group').dataTable({
            stateSave: true,
            language: {
                aria: {
                    sortAscending: ": activate to sort column ascending",
                    sortDescending: ": activate to sort column descending"
                },
                emptyTable: "No data available in table",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries found",
                infoFiltered: "(filtered1 from _MAX_ total entries)",
                lengthMenu: "_MENU_ entries",
                search: "Search:",
                zeroRecords: "No matching records found"
            },
            buttons: [{
                extend: "print",
                className: "btn dark btn-outline",
                exportOptions: {
                   columns: "thead th:not(.noExport)"
               },
           }, {
              extend: "copy",
              className: "btn blue btn-outline",
              exportOptions: {
                 columns: "thead th:not(.noExport)"
             },
         },{
          extend: "pdf",
          className: "btn yellow-gold btn-outline",
          exportOptions: {
             columns: "thead th:not(.noExport)"
         },
     }, {
        extend: "excel",
        className: "btn green btn-outline",
        exportOptions: {
           columns: "thead th:not(.noExport)"
       },
   }, {
    extend: "csv",
    className: "btn purple btn-outline ",
    exportOptions: {
       columns: "thead th:not(.noExport)"
   },
}, {
  extend: "colvis",
  className: "btn red",
  exportOptions: {
     columns: "thead th:not(.noExport)"
 },
}],
responsive: {
    details: {
        type: "column",
        target: "tr"
    }
},
order: [0, "asc"],
lengthMenu: [
[5, 10, 15, 20, -1],
[5, 10, 15, 20, "All"]
],
pageLength: 10,
dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
});
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
        <form action="{{ url('product-variant/reorder') }}" method="post">
            <table class="table table-striped table-bordered table-hover dt-responsive" id="table-product-group">
                <thead>
                    <tr>
                        <th style="width: 1%" class="text-center">No</th>
                        <th>Code</th>
                        <th>Category</th>
                        <th>Name</th>
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
                        <td class="text-center">
                            <a href="{{url('product-variant/group/'.$group['id_product_group'])}}" class="btn btn-sm blue">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
</div>


@endsection