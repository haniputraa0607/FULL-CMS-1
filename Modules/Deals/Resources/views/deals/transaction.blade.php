@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script>
    $('.datepicker').datepicker({
        'format' : 'd-M-yyyy',
        'todayHighlight' : true,
        'autoclose' : true
    });
    $('.timepicker').timepicker();

    </script>
    <script type="text/javascript">
        $('#sample_1').dataTable({
            language: {
                aria: {
                    sortAscending: ": activate to sort column ascending",
                    sortDescending: ": activate to sort column descending"
                },
                emptyTable: "No data available in table",
                // info: "Showing _START_ to _END_ of _TOTAL_ entries",
                info: "Showing "+{{ $dealsPerPage }}+" to "+ {{ $dealsUpTo }} +" of "+{{ $dealsTotal }}+" entries",
                infoEmpty: "No entries found",
                infoFiltered: "(filtered1 from _MAX_ total entries)",
                lengthMenu: "_MENU_ entries",
                search: "Search:",
                zeroRecords: "No matching records found"
            },
            buttons: [],
            responsive: {
                details: {
                    type: "column",
                    target: "tr"
                }
            },
            order: [2, "asc"],
            lengthMenu: [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"]
            ],
            pageLength: 10,
            "searching": false,
            "paging": false,
            dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#sample_1').on('click', '.delete', function() {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('news/delete') }}",
                data : "_token="+token+"&id_news="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("News has been deleted.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete news.");
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
                <span class="caption-subject font-blue sbold uppercase ">Filter</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('deals/transaction/filter') }}" method="post" id="form">
                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-3 control-label"> Date Range <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="datepicker form-control" name="date_start" value="{{ date('d-M-Y', strtotime($date_start)) }}" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <!-- <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode deals" data-container="body"></i>
                                        </button> -->
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="datepicker form-control" name="date_end" value="{{ date('d-M-Y', strtotime($date_end)) }}" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <!-- <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode deals" data-container="body"></i>
                                        </button> -->
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Outlet Available <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <!-- <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang memberlakukan deals tersebut" data-container="body"></i> -->
                                <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet">
                                <optgroup label="Outlet List">
                                    <!-- <option value="">Select Outlet</option> -->
                                    @if (!empty($outlet))
                                        <option value="all" @if(isset($id_outlet)) @if($id_outlet == "all") selected @endif  @endif>All Outlets</option>
                                        @foreach($outlet as $suw)
                                            <option value="{{ $suw['id_outlet'] }}" @if(isset($id_outlet)) @if($id_outlet == $suw['id_outlet']) selected @endif  @endif>{{ $suw['outlet_code'] }} - {{ $suw['outlet_name'] }}</option>
                                        @endforeach
                                    @endif
                                </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Deals <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <!-- <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang memberlakukan deals tersebut" data-container="body"></i> -->
                                <select class="form-control select2-multiple" data-placeholder="Select Deals" name="id_deals" required>
                                <optgroup label="Deals List">
                                    <!-- <option value="">Select Outlet</option> -->
                                    @if (!empty($dealsType))
                                        <option value="all" @if(isset($id_outlet)) @if($id_deals == "all") selected @endif  @endif>All Deals</option>
                                        @foreach($dealsType as $suw)
                                            <option value="{{ $suw['id_deals'] }}" @if(isset($id_deals)) @if($id_deals == $suw['id_deals']) selected @endif  @endif>{{ $suw['deals_title'] }}</option>
                                        @endforeach
                                    @endif
                                </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn green">Submit</button>
                            <!-- <button type="button" class="btn default">Cancel</button> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Result</span>
            </div>
            <div class="actions">
                @if(isset($deals) && !empty($deals))
                    <a class="btn green-jungle" id="btn-export" href="{{url()->current()}}?export=1" target="_blank"><i class="fa fa-download"></i> Export</a>
                @endif
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>

                        <th> Deals </th>
                        <th> Code </th>
                        <th> User </th>
                        <th> Phone </th>
                        <th> Claim </th>
                        <th> Redeem </th>
                        <th> Used </th>
                        <th> Expiry </th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($deals))
                        @foreach($deals as $value)
                            <tr>
                                <td>{{ $value['deal_voucher']['deal']['deals_title'] }}</td>
                                <td>{{ $value['deal_voucher']['voucher_code'] }}</td>
                                <td>{{ $value['user']['name'] }}</td>
                                <td>{{ $value['user']['phone'] }}</td>
                                <td>@if (empty($value['claimed_at'])) - @else {{ date('d-M-y', strtotime($value['claimed_at'])) }} @endif</td>
                                <td>@if (empty($value['redeemed_at'])) - @else {{ date('d-M-y', strtotime($value['redeemed_at'])) }} @endif</td>
                                <td>@if (empty($value['used_at'])) - @else {{ date('d-M-y', strtotime($value['used_at'])) }} @endif</td>
                                <td>@if (empty($value['voucher_expired_at'])) - @else {{ date('d-M-y', strtotime($value['voucher_expired_at'])) }} @endif</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            @if ($dealsPaginator)
                {{ $dealsPaginator->links() }}
            @endif
        </div>
    </div>
@endsection