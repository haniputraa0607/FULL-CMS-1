@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('css/custom.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/table-datatables-responsive.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $('#sample_1').on('click', '.delete', function() {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('product/category/delete') }}",
                data : "_token="+token+"&id_product_category="+id,
                success : function(result) {

                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Product has been deleted.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete product category.");
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
                <span class="caption-subject font-dark sbold uppercase font-blue">List Category</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th width="10"> No </th>
                        <th > Name </th>
                        <th class="noExport"> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($category))
                        @foreach($category as $key => $res)
                            <tr style="background-color: #fbfbfb;font-weight:bold">
                                <td class="clickable" data-toggle="collapse" data-target=".{{ str_replace(' ', '_', $res['product_category_name']) }}" style="background-color:  #fbfbfb !important"> <i class="glyphicon glyphicon-plus" style="padding-top: 5px">{{ ++$key }}. </td>
                                <td > {{ $res['product_category_name'] }} </td>
                                <td style="width: 80px;">
                                    <a href="{{ url('product/category/edit', $res['id_product_category']) }}" class="btn btn-sm blue"><i class="fa fa-edit"></i></a>
                                    <a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $res['id_product_category'] }}"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            @foreach($res['child'] as $row => $child)
                                <tr class="collapse {{ str_replace(' ', '_', $res['product_category_name']) }}" style="background-color: white !important">
                                    <td style="background-color:  white !important"> {{ $key }}.{{ ++$row }} </td>
                                    <td > {{ $child['product_category_name'] }} </td>
                                    <td style="width: 80px;">
                                        <a href="{{ url('product/category/edit', $child['id_product_category']) }}" class="btn btn-sm blue"><i class="fa fa-edit"></i></a>
                                        <a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $child['id_product_category'] }}"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection