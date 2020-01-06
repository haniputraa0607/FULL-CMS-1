<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');
 ?>
 @extends('layouts.main')

@section('page-style')
    <link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/dropzone/basic.min.css') }}" rel="stylesheet" type="text/css" />


    @endsection

    @section('page-script')
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/dropzone/dropzone.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/pages/scripts/form-dropzone.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('#sample_1').dataTable({
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
    <script>
    $( document ).ready(function() {
        Dropzone.options.myDropzone = {
            maxFilesize: 12,
            acceptedFiles: "image/*",
            init: function () {
                this.on("thumbnail", function(file) {
                    if (file.width == 300 || file.height == 300) {
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
                        <span class="label label-warning">NOTE:</span> &nbsp; Pastikan nama file sesuai dengan product code. Jika product code PR-001, maka nama file gambar PR-001.jpg dan pastikan ukuran gambar 300px X 300px. </p>
                </div>
                <form action="{{ url()->current() }}" method="POST" class="dropzone dropzone-file-area dz-clickable" id="my-dropzone" style="width: 600px; margin-top: 50px;">
                    {{ csrf_field() }}
                    <h3 class="sbold">Drop files here or click to upload</h3>
                    <p> Image Pixel 300 X 300. </p>
                <div class="dz-default dz-message"><span></span></div></form>
            </div>
        </div>
    </div>
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
                        <th> Name </th>
                        <th> Image </th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($product))
                        @foreach($product as $key => $value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $value['product_code'] }}</td>
                                <td>{{ $value['product_name'] }}</td>
                                @if (empty($value['photos']))
                                    <td>No Image</td>
                                @else
                                    <td><img style="width: 75px;" src="{{env('AWS_URL').$value['photos'][0]['product_photo'] }}" alt=""></td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>



@endsection