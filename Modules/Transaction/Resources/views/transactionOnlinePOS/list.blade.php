@php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
@endphp

@extends('layouts.main')
@include('list_filter')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/ui-blockui.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    @yield('filter_script')
    <script type="text/javascript">
        rules = {
            all_product_modifier :{
                display:'All Transaction',
                operator:[],
                opsi:[]
            },
            transaction_receipt_number :{
                display:'Receipt Number',
                operator:[
                    ['=','='],
                    ['like','like']
                ],
                opsi:[]
            },
            order_id :{
                display:'Order Id',
                operator:[
                    ['=','='],
                    ['like','like']
                ],
                opsi:[]
            },
            transaction_date :{
                display:'Transaction Date',
                operator:[
                    ['=','='],
                    ['<','<'],
                    ['>','>'],
                    ['<=','<='],
                    ['>=','>='],
                ],
                type: 'date',
                opsi:[]
            },
            success_retry_status :{
                display:'Send POS Status',
                operator:[
                ],
                opsi:[
                    ['1', 'Success'],
                    ['0', 'Failed']
                ]
            },
            id_outlet :{
                display:'Outlet',
                operator:[
                ],
                opsi:{!!json_encode($outlets)!!}
            },
            name :{
                display:'Customer Name',
                operator:[
                    ['=','='],
                    ['like','like']
                ],
                opsi:[]
            },
            phone :{
                display:'Customer Phone',
                operator:[
                    ['=','='],
                    ['like','like']
                ],
                opsi:[]
            }
        };
        var manual = 1;
        $(document).ready(function(){
            $('table').on('switchChange.bootstrapSwitch','.default-visibility',function(){
                if(!manual){
                    manual=1;
                    return false;
                }
                var switcher=$(this);
                var newState=switcher.bootstrapSwitch('state');
                $.ajax({
                    method:'PATCH',
                    url:"{{url('product/modifier')}}/"+switcher.data('id'),
                    data:{
                        product_modifier_visibility:newState?1:0,
                        _token:"{{csrf_token()}}"
                    },
                    success:function(data){
                        if(data.status == 'success'){
                            toastr.info("Success update visibility");
                        }else{
                            manual=0;
                            toastr.warning("Fail update visibility");
                            switcher.bootstrapSwitch('state',!newState);
                        }
                    }
                }).fail(function(data){
                    manual=0;
                    toastr.warning("Fail update visibility");
                    switcher.bootstrapSwitch('state',!newState);
                });
            });
        });
    </script>
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
            var total_data = 0;
            table = $('#tableList').DataTable({
                serverSide: true,
                ajax: {
                    url : "{{url('transaction/online-pos')}}",
                    type: "GET",
                    data: function (data) {
                        const info = $('#tableList').DataTable().page.info();
                        data.page = (info.start / info.length) + 1;
                    },
                    dataSrc: 'data'
                },
                fnDrawCallback: function( oSettings ) {
                    $('#list-filter-result-counter').text(oSettings.jqXHR.responseJSON.recordsTotal);
                },
                columns: [
                    {
                        data: 'id_transaction_online_pos',
                        orderable: false,
                        render: function (value, type, row) {
                            return row.success_retry_status?'':`<a onclick="resend(${value})" id="resend${value}" class="btn btn-block green btn-xs">Resend</a>`;
                        }
                    },
                    {
                        data: 'success_retry_status',
                        orderable: false,
                        render: function(value) {
                            return `<b style="color: ${value?'green':'red'}">${value?'Success':'Fail'}</b>`;
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
                    $(row).data('id', data.id_transaction_online_pos);
                    $(row).addClass('row-' + data.id_transaction_online_pos);
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
                modal.find('.modal-body').html('<pre>' + escapeHtml(JSON.stringify($(this).data('body'), null, 2)) + '</pre>');
                modal.modal('show');
            });
        });
        
        function resend(id_transaction_online_pos) {
            var token  = "{{ csrf_token() }}";
            var url = "{{url('transaction/online-pos/resend')}}";

            $(document).ajaxStart($.blockUI({ css: {border: 'none', backgroundColor: '#000', opacity: .3, color: '#fff'} })).ajaxStop($.unblockUI);
            $.ajax({
                type : "POST",
                url : url,
                data : {
                    id_transaction_online_pos : id_transaction_online_pos,
                    _token : token
                },
                success : function(result) {
                    if (result.status != "success") {
                        toastr.warning('Failed resend transaction');
                    }else{
                        toastr.success('Success resend');
                        $(`.row-${id_transaction_online_pos} .status`).html('<b id="status-'+id_transaction_online_pos+'" style="color: green">Success</b>');
                        $(`#resend${id_transaction_online_pos}`).remove();
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
    @yield('filter_view')
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