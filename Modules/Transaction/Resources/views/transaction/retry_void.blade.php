@php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
@endphp
@include('filter-v2')
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .status-option button span.badge {
            position: absolute;
            top: -8px;
            right: -8px !important;
            display: none;
        }
        .status-option button.activex span.badge {
            display: block;
        }
        .status-option button {
            position: relative  !important;
            margin-right: 10px;
        }
    </style>
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    @yield('filter_script')
    <script type="text/javascript">
        // range date trx, receipt, order id, outlet, customer
        rules={
            all_data:{
                display:'All Data',
                operator:[],
                opsi:[]
            },
            transaction_receipt_number:{
                display:'Receipt Number',
                operator:[
                    ['=', '='],
                    ['like', 'like']
                ],
                opsi:[],
                placeholder: "ex. TRX-123456789"
            },
            order_id:{
                display:'Order Id',
                operator:[
                    ['=', '='],
                    ['like', 'like']
                ],
                opsi:[],
                placeholder: "ex. J3LX"
            },
            id_outlet:{
                display:'Outlet',
                operator:[],
                opsi:{!!json_encode($outlets)!!},
                placeholder: "ex. J3LX"
            },
            name:{
                display:'Customer Name',
                operator:[
                    ['=', '='],
                    ['like', 'like']
                ],
                opsi:[]
            },
            phone:{
                display:'Customer Phone',
                operator:[
                    ['=', '='],
                    ['like', 'like']
                ],
                opsi:[]
            },
        };

        let status = 'all';
        $('#table-retry-failed-void').dataTable({
            ajax: {
                url : "{{url()->current()}}",
                type: 'GET',
                data: function (data) {
                    const info = $('#table-retry-failed-void').DataTable().page.info();
                    data.page = (info.start / info.length) + 1;
                    data.status = status;
                },
                dataSrc: (res) => {
                    $('#list-filter-result-counter').text(res.total);
                    return res.data;
                }
            },
            serverSide: true,
            columns: [
                {data: 'transaction_date'},
                {data: 'transaction_receipt_number'},
                {
                    data: 'outlet_name',
                    render: function(value, type, row) {
                        return row.outlet_code + ' - ' + value;
                    }
                },
                {
                    data: 'name',
                    render: function(value, type, row) {
                        return `${row.name} (${row.phone})`;
                    }
                },
                // {data: 'name'},
                // {data: 'phone'},
                {
                    data: 'trasaction_payment_type',
                    render: function(value, type, row) {
                        switch (value.toLowerCase()) {
                            case 'midtrans':
                                return `${value} (${row.transaction_payment_midtrans.payment_type})`;
                                break;
                            case 'ipay88':
                                return `${value} (${row.transaction_payment_ipay88.payment_method})`;
                                break;
                        }
                        return value;
                    }
                },
                {
                    data: 'trasaction_payment_type',
                    render: function(value, type, row) {
                        switch (value.toLowerCase()) {
                            case 'midtrans':
                                return row.transaction_payment_midtrans?.vt_transaction_id;
                                break;

                            case 'ipay88':
                                return row.transaction_payment_ipay88?.trans_id;
                                break;

                            case 'shopeepay':
                                return row.transaction_payment_shopee_pay?.transaction_sn;
                                break;

                            case 'ovo':
                                return row.transaction_payment_ovo?.approval_code;
                                break;

                        }
                        return '';
                    }
                },
                {
                    data: 'transaction_grandtotal',
                    render: value => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value)
                },
                {
                    data: 'refund_nominal',
                    render:  value => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value)
                },
                {
                    data: 'failed_void_reason'
                },
                {
                    data: 'retry_count'
                },
                {
                    data: 'retry_status',
                    render: function(value, type, row) {
                        if (row.need_manual_void == '2') {
                            return '<div class="badge badge-info">Manual Refund</div>';
                        } else if (value == 1) {
                            return '<div class="badge badge-success">Success</div>';
                        } else {
                            return '<div class="badge badge-danger">Failed</div>';
                        }
                    }
                },
                {
                    data: 'transaction_receipt_number',
                    render: function(value, type, row) {
                        const buttons = [];
                        if (!row.retry_status && row.need_manual_void != '2') {
                            buttons.push(`<button type="button" class="btn yellow btn-sm btn-outline retry-btn" data-data='${JSON.stringify(row)}'>Retry</button>`);
                        }
                        buttons.push(`<a class="btn blue btn-sm btn-outline" target="_blank" href="{{url('transaction/detail')}}/${row.id_transaction}/${row.trasaction_type == 'Pickup Order' ? 'pickup order' : 'delivery'}">Detail Transaction</a>`);
                        return buttons.join('');
                    }
                },
            ],
            searching: false
        });

        $('#table-retry-failed-void').on('click', '.retry-btn', function() {
            const parent = $(this).parents('tr');
            const data = $(this).data('data');
            $.blockUI({ message: '<h1>Please wait...</h1>' });
            $.post("{{url('transaction/retry-void-payment/retry')}}", {
                id_transaction: data.id_transaction,
                _token: "{{csrf_token()}}"
            }, function(response) {
                if (response.status == 'success') {
                    toastr.info('Success');
                } else {
                    toastr.error(response.messages?.join('<br />'));
                }
                $.blockUI({ message: '<h1>Reloading table...</h1>' });
                $('#table-retry-failed-void').DataTable().ajax.reload(null, false);
                $.unblockUI();
            });
        });

        $(document).ready(function() {
            $(".form_datetime").datetimepicker({
                format: "d-M-yyyy hh:ii",
                autoclose: true,
                todayBtn: true,
                minuteStep: 1,
                endDate: new Date()
            });
            $('.status-option').on('change', function() {
                $(this).find('button').removeClass('btn-outline');
                $(this).find('button.activex').addClass('btn-outline');
                if (status != $(this).data('value')) {
                    status = $(this).data('value');
                    $('#table-retry-failed-void').DataTable().ajax.reload(null, false);
                }
            }).change();
            $('.status-option button').on('click', function() {
                $('.status-option').data('value', $(this).val());
                $('.status-option button').removeClass('activex');
                $(this).addClass('activex');
                $('.status-option').change();
                $(this).blur();
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
    @yield('filter_view')
    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Retry Refund Payment</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row status-option" data-value="all" style="margin-bottom: 10px">
                <label class="col-md-1" style="padding-top: 3px;"><strong>Status</strong></label>
                <div class="col-md-11">
                    <button class="btn green btn-sm" value="success">
                        Success
                        <span class="badge badge-success">
                            <i class="fa fa-check"></i>
                        </span>
                    </button>
                    <button class="btn red btn-sm" value="failed">
                        Failed
                        <span class="badge badge-danger">
                            <i class="fa fa-check"></i>
                        </span>
                    </button>
                    <button class="btn green btn-sm" value="manual_refund">
                        Manual Refund
                        <span class="badge badge-success">
                            <i class="fa fa-check"></i>
                        </span>
                    </button>
                    <button class="btn activex blue btn-sm" value="all">
                        All
                        <span class="badge badge-primary">
                            <i class="fa fa-check"></i>
                        </span>
                    </button>
                </div>
            </div>
            <table class="table table-striped table-bordered table-hover" width="100%" id="table-retry-failed-void">
            <thead>
              <tr>
                <th>Transaction Date</th>
                <th>Receipt Number</th>
                <th>Outlet</th>
                <th>Customer</th>
                <th>Payment Type</th>
                <th>Payment Reference Number</th>
                <th>Grandtotal</th>
                <th>Refund</th>
                <th>Failed Void Reason</th>
                <th>Retry Count</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
        </div>
    </div>
@endsection
