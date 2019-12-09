<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');

 ?>
 @extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />


    @endsection

    @section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('#sample_1').dataTable({
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

        $('#sample_1').on('click', '.delete', function() {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('product/delete') }}",
                data : "_token="+token+"&id_product="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Product has been deleted.");
                    }
                    else {
						window.location.reload(true);
                        toastr.info("Product has been deleted.");
                    }
                }
            });
        });

        $('#sample_1').on('switchChange.bootstrapSwitch', '.changeStatus', function(event, state) {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');
            var nama     = $(this).data('nama');

            if (state) {
              var change = "Visible";
            }
            else {
              var change = "Hidden";
            }

            $.ajax({
                type : "POST",
                url : "{{ url('product/update') }}",
                data : "_token="+token+"&id_product="+id+"&product_visibility="+change,
                success : function(result) {
                    if (result == "success") {
                        toastr.info("Product "+ nama +" has been updated.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to update data product.");
                    }
                }
            });
        });

        $('#sample_1').on('draw.dt', function() {
            $(".changeStatus").bootstrapSwitch();
            $('input[name="allow_sync"]').bootstrapSwitch();
            $('input[name="product_visibility"]').bootstrapSwitch();
            $('[data-toggle=confirmation]').confirmation({ btnOkClass: 'btn btn-sm btn-success', btnCancelClass: 'btn btn-sm btn-danger'});
        });

        $('#sample_1').on('switchChange.bootstrapSwitch', 'input[name="allow_sync"]', function(event, state) {
            var id     = $(this).data('id');
            var token  = "{{ csrf_token() }}";
            $.ajax({
                type : "POST",
                url : "{{ url('product/update/allow_sync') }}",
                data : "_token="+token+"&id_product="+id+"&product_allow_sync="+state,
                success : function(result) {
                    if (result.status == "success") {
                        toastr.info("Product allow sync has been updated.");
                    }
                    else {
                        toastr.warning(result.messages);
                    }
                }
            });
        });

        $('#sample_1').on('switchChange.bootstrapSwitch', 'input[name="product_visibility"]', function(event, state) {
            var id     = $(this).data('id');
            var token  = "{{ csrf_token() }}";
            if(state == true){
                state = 'Visible'
            }
            else if(state == false){
                state = 'Hidden'
            }
            $.ajax({
                type : "POST",
                url : "{{ url('product/update/visibility/global') }}",
                data : "_token="+token+"&id_product="+id+"&product_visibility="+state,
                success : function(result) {
                    if (result.status == "success") {
                        toastr.info("Product visibility has been updated.");
                    }
                    else {
                        toastr.warning(result.messages);
                    }
                }
            });
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
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">List Product</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th> No </th>
                        <th> Code </th>
                        <th> Category </th>
                        <th> Name </th>
                        <th> Allow Sync </th>
                        <th >Default Visibility Product</th>
                        <th> Override Visible </th>
                        <th> Override Hidden </th>
                        @if(MyHelper::hasAccess([49,51,52], $grantedFeature))
                            <th> Action </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($product))
                        @foreach($product as $key => $value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $value['product_code'] }}</td>
                                @if (empty($value['category']))
                                    <td>Uncategorize</td>
                                @else
                                    <td>{{ $value['category'][0]['product_category_name']??'Uncategories' }}</td>
                                @endif
                                <td>{{ $value['product_name'] }}</td>
                                <td>
                                    <div class="bootstrap-switch-container">
                                        <span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 35px;"></span>
                                        <span class="bootstrap-switch-label" style="width: 35px;">&nbsp;</span>
                                        <span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 35px;"></span>
                                        <input type="checkbox" name="allow_sync" @if($value['product_allow_sync'] == '1') checked @endif data-id="{{ $value['id_product'] }}" class="make-switch switch-large switch-change" data-label-icon="fa fa-fullscreen" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                                    </div>
                                </td>
                                <td>
                                    <div class="bootstrap-switch-container">
                                        <span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 35px;"></span>
                                        <span class="bootstrap-switch-label" style="width: 35px;">&nbsp;</span>
                                        <span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 35px;"></span>
                                        <input type="checkbox" name="product_visibility" @if($value['product_visibility'] == 'Visible') checked @endif data-id="{{ $value['id_product'] }}" class="make-switch switch-large switch-change" data-on-text="Visible" data-off-text="Hidden">
                                    </div>
                                </td>
                                <td><a href="{{ url('product/detail') }}/{{ $value['product_code'] }}#visibility">{{ $value['product_prices_count'] }}</a></td>
                                <td><a href="{{ url('product/detail') }}/{{ $value['product_code'] }}#visibility">{{ $value['product_price_hiddens_count'] }}</td>
                                @if(MyHelper::hasAccess([49,51,52], $grantedFeature))
                                    <td style="width: 80px;">
                                        @if(MyHelper::hasAccess([52], $grantedFeature))
                                            <a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $value['id_product'] }}"><i class="fa fa-trash-o"></i></a>
                                        @endif
                                        @if(MyHelper::hasAccess([49,51], $grantedFeature))
                                            <a href="{{ url('product/detail') }}/{{ $value['product_code'] }}" class="btn btn-sm blue"><i class="fa fa-edit"></i></a>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>



@endsection