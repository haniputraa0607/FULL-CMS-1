@php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
@endphp

@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/ui-blockui.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')

    <script type="text/javascript">
        const data_display = 25;
        var table;

        function escapeHtml(unsafe) {
            return unsafe
                 .replace(/&/g, "&amp;")
                 .replace(/</g, "&lt;")
                 .replace(/>/g, "&gt;")
                 .replace(/"/g, "&quot;")
                 .replace(/'/g, "&#039;");
         }

        $(document).ready(function () {
            table = $('#tableList').DataTable({
                serverSide: true,
                ajax: {
                    url : "{{url('transaction/cancel-online-pos')}}",
                    type: "GET",
                    data: function (data) {
                        const info = $('#tableList').DataTable().page.info();
                        data.page = (info.start / info.length) + 1;
                        data.operator = 'and';
                        data.rule = [
                            {
                                subject: 'success_retry_status',
                                operator: '=',
                                parameter: 0
                            }
                        ];
                    },
                    dataSrc: 'data'
                },
                columns: [
                    {
                        data: 'id_transaction_online_pos_cancel',
                        orderable: false,
                        render: function (value, type, row) {
                            return row.success_retry_status?'':`<a onclick="resend(${value})" id="resend${value}" class="btn btn-block green btn-xs">Resend</a>`;
                        }
                    },
                    {
                        data: 'success_retry_status',
                        orderable: false,
                        render: function(value) {
                            if (value == 1) {
                                return `<b style="color: green">Success</b>`;
                            } else if (value == 2) {
                                return `<b style="color: orange">Pending</b>`;
                            } else {
                                return `<b style="color: red">Fail</b>`;
                            }
                        }
                    },
                    {data: 'transaction_date', render: value => (new Date(value)).toLocaleString('id-ID',{ year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' })},
                    {
                        data: 'outlet_code',
                        render: function (value, type, row) {
                            return value + ' - ' + row.outlet_name;
                        }
                    },
                    {data: 'order_id'},
                    {data: 'transaction_receipt_number'},
                    {data: 'name'},
                    {data: 'phone'},
                    {
                        data: 'request',
                        orderable: false,
                        render: function (value) {
                            return `<button class="btn btn-primary btn-xs modal-summoner" data-body="${escapeHtml(value)}">Show Request</button>`;
                        }
                    },
                    {
                        data: 'response',
                        orderable: false,
                        render: function (value) {
                            return `<button class="btn btn-primary btn-xs modal-summoner" data-body="${escapeHtml(value)}" data-is-response="1">Show Response</button>`;
                        }
                    },
                    {data: 'count_retry'}
                ],
                createdRow: function( row, data, dataIndex ) {
                    $(row).data('id', data.id_transaction_online_pos_cancel);
                    $(row).addClass('row-' + data.id_transaction_online_pos_cancel);
                },
                columnDefs: [
                    {
                        'targets': 1,
                        'createdCell':  function (td, cellData, rowData, row, col) {
                           $(td).addClass('status'); 
                        }
                    },
                    {
                        'targets': 1,
                        'createdCell':  function (td, cellData, rowData, row, col) {
                           $(td).addClass('button'); 
                        }
                    }
                ]
            });

            $('table').on('click', '.modal-summoner', function() {
                const modal = $('#modal-info');
                modal.find('.modal-title').text($(this).data('is-response')?'Response':'Request');
                modal.find('.modal-body').html('<pre>' + JSON.stringify($(this).data('body'), null, 2) + '</pre>');
                modal.modal('show');
            });
        });
        
        function resend(id_transaction_online_pos_cancel) {
            var token  = "{{ csrf_token() }}";
            var url = "{{url('transaction/cancel-online-pos/resend')}}";

            $(document).ajaxStart($.blockUI({ css: {border: 'none', backgroundColor: '#000', opacity: .3, color: '#fff'} })).ajaxStop($.unblockUI);
            $.ajax({
                type : "POST",
                url : url,
                data : {
                    id_transaction_online_pos_cancel : id_transaction_online_pos_cancel,
                    _token : token
                },
                success : function(result) {
                    if (result.status != "success") {
                        toastr.warning('Failed resend transaction');
                    }else{
                        toastr.success('Success resend');
                        $(`.row-${id_transaction_online_pos_cancel} .status`).html('<b id="status-'+id_transaction_online_pos_cancel+'" style="color: green">Success</b>');
                        $(`#resend${id_transaction_online_pos_cancel}`).remove();
                    }
                },
                error: function (jqXHR, exception) {
                    toastr.warning('Failed resend transaction');
                }
            });
        }
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
            </li>
        </ul>
    </div><br>
    
    @include('layouts.notifications')

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-red sbold uppercase">{{$sub_title}}</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover" width="100%" id="tableList">
                <thead>
                  <tr>
                      <th>Actions</th>
                      <th>Status</th>
                      <th>Transaction Date</th>
                      <th>Outlet</th>
                      <th>Order Id</th>
                      <th>Receipt Number</th>
                      <th>Customer Name</th>
                      <th>Customer Phone</th>
                      <th>Request</th>
                      <th>Response</th>
                      <th>Count Retry</th>
                  </tr>
                </thead>
                <tbody>                    
                </tbody>
            </table>
        </div>

        <div class="modal fade bs-modal-lg" id="modal-info" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection