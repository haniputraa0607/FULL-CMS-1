@include('deals::deals.list_filter')
<?php
use App\Lib\MyHelper;
$configs    		= session('configs');
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main-closed')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
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
                url : "{{ url('deals/delete') }}",
                data : "_token="+token+"&id_deals="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Deals has been deleted.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete deals.");
                    }
                }
            });
        });
    </script>
    @yield('child-script')
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

    @yield('filter')
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">{{ $sub_title }}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>

                        <th> No</th>
                        <th> Type </th>
                        <th> Title </th>
                        @if(MyHelper::hasAccess([97], $configs))
                        <th> Brand </th>
                        <th> Price </th>
                        @endif
                        @if($deals_type != "Hidden" && $deals_type !='WelcomeVoucher')
                            <th> Date Publish </th>
                        @endif
                        @if($deals_type !='WelcomeVoucher')
                            <th> Date Start </th>
                        @endif
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($deals))
                        @foreach($deals as $key => $value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                	<ul>
                                		@if (!empty($value['is_online']))
                                			<li>{{'Online'}}</li>
                                		@endif
                                		@if (!empty($value['is_offline']))
                                			<li>{{'Offline'}}</li>
                                		@endif
                                	</ul>
                            	</td>
                                <td>{{ $value['deals_title'] }}</td>
                                @if(MyHelper::hasAccess([97], $configs))
                                <td>{{ $value['brand']['name_brand']??'Not Set' }}</td>
                                <td>
                                	@if($value['deals_voucher_price_type'] == 'free')
                                		{{ $value['deals_voucher_price_type'] }}
                                	@elseif(!empty($value['deals_voucher_price_point']))
                                		{{ number_format($value['deals_voucher_price_point']).' Points' }}
                                	@elseif(!empty($value['deals_voucher_price_cash']))
                                		{{ 'IDR'.number_format($value['deals_voucher_price_cash']) }}
                                	@endif
                                </td>
                                @endif
                                @if($deals_type !='WelcomeVoucher')
                                @if($deals_type != "Hidden")
                                <td>
                                    @php
                                        $bulan   = date('m', strtotime($value['deals_publish_start']));
                                        $bulanEx = date('m', strtotime($value['deals_publish_end']));
                                    @endphp
                                    @if ($bulan == $bulanEx)
                                        {{ date('d', strtotime($value['deals_publish_start'])) }} - {{ date('d M Y', strtotime($value['deals_publish_end'])) }}
                                    @else
                                        {{ date('d M Y', strtotime($value['deals_publish_start'])) }} - {{ date('d M Y', strtotime($value['deals_publish_end'])) }}
                                    @endif
                                </td>
                                @endif
                                <td>
                                    @php
                                        $bulan   = date('m', strtotime($value['deals_start']));
                                        $bulanEx = date('m', strtotime($value['deals_end']));
                                    @endphp
                                    @if ($bulan == $bulanEx)
                                        {{ date('d', strtotime($value['deals_start'])) }} - {{ date('d M Y', strtotime($value['deals_end'])) }}
                                    @else
                                        {{ date('d M Y', strtotime($value['deals_start'])) }} - {{ date('d M Y', strtotime($value['deals_end'])) }}
                                    @endif
                                </td>
                                @endif
                                <td style="width: 80px;">
                                    @if($deals_type == "Deals" && MyHelper::hasAccess([76], $grantedFeature) && $value['deals_total_claimed'] == 0)
                                        <a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $value['id_deals'] }}"><i class="fa fa-trash-o"></i></a>
                                    @endif
                                    @if($deals_type == "Hidden" && MyHelper::hasAccess([81], $grantedFeature) && $value['deals_total_claimed'] == 0)
                                        <a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $value['id_deals'] }}"><i class="fa fa-trash-o"></i></a>
                                    @endif
                                    @if($deals_type == "WelcomeVoucher" && MyHelper::hasAccess([183], $grantedFeature) && $value['deals_total_claimed'] == 0)
                                        <a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $value['id_deals'] }}"><i class="fa fa-trash-o"></i></a>
                                    @endif
                                    @if ($deals_type == "Deals" && MyHelper::hasAccess([73], $grantedFeature))
                                    <a href="{{ url('deals/step1') }}/{{ $value['id_deals'] }}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                    @elseif ($deals_type == "Point" && MyHelper::hasAccess([73], $grantedFeature))
                                    <a href="{{ url('deals-point/detail') }}/{{ $value['id_deals'] }}/{{ $value['deals_promo_id'] }}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                    @elseif ($deals_type == "WelcomeVoucher" && MyHelper::hasAccess([180], $grantedFeature))
                                        <a href="{{ url('welcome-voucher/detail') }}/{{ $value['id_deals'] }}/{{ $value['deals_promo_id'] }}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                    @else
                                        @if(MyHelper::hasAccess([78], $grantedFeature))
                                            <a href="{{ url('inject-voucher/detail') }}/{{ $value['id_deals'] }}/{{ $value['deals_promo_id'] }}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>



@endsection