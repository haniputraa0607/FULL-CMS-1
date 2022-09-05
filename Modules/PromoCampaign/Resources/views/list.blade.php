@php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    date_default_timezone_set('Asia/Jakarta');
@endphp
@extends('layouts.main-closed')
@include('promocampaign::promocampaign_filter')
@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
    <link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> 
    <style type="text/css">
        .w-100 {
            width: 100%;
        }
        .nowrap {
            white-space: nowrap;
        }
        .d-inline-block {
            display: inline-block;
        }
        .checked-button {
            height: 34px!important;
            padding: 9px 12px !important;
            border-color: #508edb!important;
            font-weight: 400!important;
            margin: 0px!important;
        }
        .checked-button div{
            font-size: 14px!important;
            font-weight: 400!important;
            margin-top: 0px!important;
            margin-bottom: 0px!important;
        }
        .page-container-bg-solid .page-content {
            background: #fff!important;
        }

        .middle-center, .header-table th, .content-middle-center td {
            vertical-align: middle!important;
            text-align: center;
        }
        .paginator-right {
            display: flex;
            justify-content: flex-end;
        }
        .middle-left {
            vertical-align: middle!important;
            text-align: left;
        }
    </style>
@endsection

@section('page-plugin')
    <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <!-- <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script> -->
    <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">
        $(document).on('click', '#btn-delete', function() {
            var id = $(this).data('id');
            $('#id-promo').val(id);
            $('#modal-delete').modal('show');
        });

        $("#input-password").on("keyup", function(){
            if ($(this).val()) {
                $("#submit-button").prop('disabled', false);
            }else{
                $("#submit-button").prop('disabled', true);
            }
        });

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
                ordering: false,
                order: [0, "asc"],
                paging: false,
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'>><'row'<'col-md-6 col-sm-12'><'col-md-6 col-sm-12'>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
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

    @if (!empty($search))
        <div class="alert alert-block alert-info fade in">
            <button type="button" class="close" data-dismiss="alert"></button>
            <h4 class="alert-heading">Displaying search result :</h4>
                <p>{{ $promoTotal }}</p><br>
            <a href="{{ url('promo-campaign') }}" class="btn btn-sm btn-warning">Reset</a>
            <br>
        </div>
    @endif

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption w-100">
                <span class="caption-subject font-red sbold uppercase"> Promo Campaign List {{ Request::get('promo_type') }}</span>
            </div>
            <div class="caption">
                <span class="caption-subject sbold">Promo Type : </span>
                @if( Request::get('promo_type') == 'Product discount' )
                <a href="{{ url('promo-campaign/list?promo_type=Product discount') }}" class="icon-btn checked-button" >
                    <div style="">Product Discount</div>
                    <span class="badge badge-success">
                   <i class="fa fa-check"></i>
                </span>
                </a>
                @else
                <a href="{{ url('promo-campaign/list?promo_type=Product discount') }}" class="btn btn-primary">Product Discount</a>
                @endif
                @if( Request::get('promo_type') == 'Tier discount' )
                <a href="{{ url('promo-campaign/list?promo_type=Tier discount') }}" class="icon-btn checked-button" >
                    <div style="">Tier Discount</div>
                    <span class="badge badge-success">
                   <i class="fa fa-check"></i>
                </span>
                </a>
                @else
                <a href="{{ url('promo-campaign/list?promo_type=Tier discount') }}" class="btn btn-info">Tier Discount</a>
                @endif
                @if( Request::get('promo_type') == 'Buy X Get Y' )
                <a href="{{ url('promo-campaign/list?promo_type=Buy X Get Y') }}" class="icon-btn checked-button" >
                    <div style="">Buy X Get Y</div>
                    <span class="badge badge-success">
                   <i class="fa fa-check"></i>
                </span>
                </a>
                @else
                <a href="{{ url('promo-campaign/list?promo_type=Buy X Get Y') }}" class="btn btn-success">Buy X get Y</a>
                @endif
                @if( Request::get('promo_type') == 'Promo Product Category' )
                <a href="{{ url('promo-campaign/list?promo_type=Promo Product Category') }}" class="icon-btn checked-button" >
                    <div style="">Promo Product Category</div>
                    <span class="badge badge-success">
                   <i class="fa fa-check"></i>
                </span>
                </a>
                @else
                <a href="{{ url('promo-campaign/list?promo_type=Promo Product Category') }}" class="btn btn-success">Promo Product Category</a>
                @endif
                <a href="{{ url('promo-campaign') }}" class="btn btn-danger">All</a>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
            <thead>
              <tr class="header-table">
                  <th>Name</th>
                  <th>Creator</th>
                  <th>Periode</th>
                  <th>Code Type</th>
                  <th>Promo Type</th>
                  <th>Product Type</th>
                  <th>Status</th>
                  <th>Actions</th>
              </tr>
            </thead>
            <tbody>
            	@php
            		$i = $promoPerPage;
                    $now = date("Y-m-d H:i:s");
            	@endphp
                @if(!empty($promo))
                    @foreach($promo as $res)
                        @php
                            if( isset($res['date_start']) )
                            {
                                $date_start = $res['date_start'];
                                $date_end = $res['date_end'];
                            }
                        @endphp
                        <tr class="content-middle-center">
                            <td>{{ $res['campaign_name'] }}</td>
                            <td>{{ $res['user']['name'] }}</td>
                            <td>
                                Start&nbsp;: {{ date("d F Y", strtotime($date_start)) }}&nbsp;{{ date("H:i", strtotime($date_start)) }}<br>
                                End&nbsp;&nbsp;&nbsp;: {{ date("d F Y", strtotime($date_end)) }}&nbsp;{{ date("H:i", strtotime($date_end)) }}
                            </td>
                            <td>{{$res['code_type']}}</td>
                            <td>{{ $res['promo_type'] }}</td>
                            <td class="nowrap">{{ $res['product_type'] }}</td>
                            <td class="middle-center">
                                @if ( empty($res['step_complete']) )
                                    <a href="{{url('promo-campaign/step2', $res['id_promo_campaign'])??'#'}}"><span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #F4D03F;padding: 5px 12px;color: #fff;">Not Complete</span></a>
                                @elseif($date_end < $now)
                                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #ACB5C3;padding: 5px 12px;color: #fff;">Ended</span>
                                @elseif($date_start <= $now)
                                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Started</span>
                                @elseif($date_start > $now)
                                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Not Started</span>
                                @endif
                            </td>
                            <td class="nowrap middle-left">
                                @if(MyHelper::hasAccess([201], $grantedFeature))
                                    <a class="btn btn-sm blue" href="{{ url('promo-campaign/detail', $res['id_promo_campaign']) }}"><i class="fa fa-search"></i></a>
                                @endif
                                @if(MyHelper::hasAccess([252], $grantedFeature))
                                <form action="{{ url('promo-campaign/export') }}" method="post" style="display: inline;">
			                		{{ csrf_field() }}
								    <input type="hidden" value="{{ $res['id_promo_campaign'] }}" name="id_promo_campaign" />
								    <button type="submit" class="btn btn-sm green-jungle"><i class="fa fa-download"></i></button>
								</form>
                                @endif
                                @if(MyHelper::hasAccess([204], $grantedFeature))
                                    @if( empty($res['used_code']) || empty($res['step_complete']))
                                        <a class="btn btn-sm red" href="#" data-id="{{ $res['id_promo_campaign'] }}" id="btn-delete"><i class="fa fa-trash-o"></i></a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="7" style="text-align: center">Promo Campaign not found</td></tr>
                @endif
            </tbody>
            </table>
            <div class="paginator-right">
                @if ($promoPaginator)
                  {{ $promoPaginator->links() }}
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ url('promo-campaign/delete') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group m-form__group">
                            <label for="title">Password * : </label>
                            <input class="form-control m-input m-input--square" placeholder="Enter password" type="password" name="password" required value="" id="input-password">
                            <input class="form-control m-input m-input--square" type="hidden" name="id_promo_campaign" id="id-promo">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" id="submit-button" class="btn btn-info" disabled>Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div> 
@endsection
