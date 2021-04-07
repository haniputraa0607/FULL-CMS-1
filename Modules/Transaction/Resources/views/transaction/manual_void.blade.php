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
@endsection

@section('page-script')
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
                placeholder: "ex. J+123456789"
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

        $('#table-failed-void').dataTable({
            ajax: {
                url : "{{url()->current()}}",
                type: 'GET',
                data: function (data) {
                    const info = $('#table-failed-void').DataTable().page.info();
                    data.page = (info.start / info.length) + 1;
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
                    data: 'manual_refund_nominal',
                    render:  value => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value)
                },
                {
                    data: 'failed_void_reason'
                },
                {
                    data: 'need_manual_void',
                    render: function(value) {
                        if (value == 1) {
                            return '<div class="badge badge-warning">Unprocessed</div>';
                        } else {
                            return '<div class="badge badge-success">Processed</div>';
                        }
                    }
                },
                {
                    data: 'transaction_receipt_number',
                    render: function(value, type, row) {
                        return `
                        <button type="button" class="btn ${row.need_manual_void == 1 ? 'yellow confirm-btn' : 'green detail-btn'} btn-sm btn-outline" data-data='${JSON.stringify(row)}'>${row.need_manual_void == 1 ? 'Confirm Process' : 'Detail Refund'}</button>
                        <a class="btn blue btn-sm btn-outline" href="{{url('transaction/detail')}}/${row.id_transaction}/${row.trasaction_type == 'Pickup Order' ? 'pickup order' : 'delivery'}">Detail Transaction</a>
                        `;
                    }
                },
            ],
            searching: false
        });

        $('#table-failed-void').on('click', '.confirm-btn', function() {
            $('#modal-confirm :input').val(null);
            const data = $(this).data('data');
            $('#input-id-transaction').val(data.id_transaction);
            $('#input-customer-name').val(`${data.name} (${data.phone})`);
            $('#input-receipt-number').val(data.transaction_receipt_number);
            $('#modal-confirm').modal('show');
        });

        $('#table-failed-void').on('click', '.detail-btn', function() {
            const data = $(this).data('data');
            $('#preview-id-transaction').val(data.id_transaction);
            $('#preview-customer-name').val(`${data.name} (${data.phone})`);
            $('#preview-receipt-number').val(data.transaction_receipt_number);
            $('#preview-confirm-name').val(`${data.validator_name} (${data.validator_phone})`);
            $('#preview-confirm-at').val((new Date(data.confirm_at)).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric",hour:"2-digit",minute:"2-digit"}));
            $('#preview-date-refund').val((new Date(data.refund_date)).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric",hour:"2-digit",minute:"2-digit"}));
            $('#preview-note').val(data.note);

            let imageTag = '';

            if (data.images) {
                data.images.forEach(item => {
                    imageTag += `<img src="${item}" class="img-responsive" style="margin-bottom: 5px">`;
                });
            }

            $('#preview-image').html(imageTag);

            $('#modal-detail').modal('show');
        });

        $(document).ready(function() {
            $(".form_datetime").datetimepicker({
                format: "d-M-yyyy hh:ii",
                autoclose: true,
                todayBtn: true,
                minuteStep: 1,
                endDate: new Date()
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
                <span class="caption-subject font-blue sbold uppercase">Failed Void Payment</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover" width="100%" id="table-failed-void">
            <thead>
              <tr>
                <th>Transaction Date</th>
                <th>Receipt Number</th>
                <th>Outlet</th>
                <th>Customer</th>
                <th>Payment Type</th>
                <th>Payment Reference Number</th>
                <th>Grandtotal</th>
                <th>Manual Refund</th>
                <th>Failed Void Reason</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
        </div>
    </div>
    <!-- Modal Confirm -->
    <form action="{{url('transaction/failed-void-payment/confirm')}}" class="form-horizontal" method="POST" role="form" enctype="multipart/form-data" >
        @csrf
        <div aria-labelledby="modal-confirm-label" class="modal fade" id="modal-confirm" role="dialog" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">
                                ×
                            </span>
                        </button>
                        <h4 class="modal-title" id="modal-confirm-label">
                            Confirm Manual Void
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    Customer
                                </label>
                                <div class="col-md-9">
                                    <input class="form-control" disabled="" id="input-customer-name" type="text" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    Transaction
                                </label>
                                <div class="col-md-9">
                                    <input class="form-control" id="input-receipt-number" readonly="" type="text" />
                                    <input type="hidden" name="id_transaction" id="input-id-transaction">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    Date Refund
                                    <span aria-required="true" class="required">
                                        *
                                    </span>
                                </label>
                                <div class="col-md-9">
                                    <input class="form-control form_datetime" id="input-date-refund" name="date_refund" required="" type="text" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    Note
                                </label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="input-note" name="note"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    Image
                                </label>
                                <div class="col-md-9">
                                    <input class="form-control" id="input-image" multiple="" name="images[]" type="file" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal" type="button">
                            Close
                        </button>
                        <button class="btn btn-primary" type="submit">
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Modal Confirm -->
    <div aria-labelledby="modal-detail-label" class="modal fade" id="modal-detail" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                    <h4 class="modal-title" id="modal-detail-label">
                        Detail Manual Void
                    </h4>
                </div>
                <div class="modal-body form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                Customer
                            </label>
                            <div class="col-md-9">
                                <input class="form-control" disabled="" id="preview-customer-name" type="text" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                Transaction
                            </label>
                            <div class="col-md-9">
                                <input class="form-control" id="preview-receipt-number" readonly="" type="text" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                Confirmed By
                            </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="preview-confirm-name" disabled />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                Confirmed At
                            </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="preview-confirm-at" disabled />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                Date Refund
                            </label>
                            <div class="col-md-9">
                                <input class="form-control form_datetime" id="preview-date-refund" name="date_refund" required="" type="text" disabled />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                Note
                            </label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="preview-note" name="note" disabled></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                Image
                            </label>
                            <div class="col-md-9" id="preview-image">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="button">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
