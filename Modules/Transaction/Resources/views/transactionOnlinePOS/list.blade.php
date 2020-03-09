@php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
@endphp

@extends('layouts.main')

@section('page-style')
    <link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/pages/scripts/ui-blockui.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            datatables();
        });

        function datatables(){
            $("#tableListBody").empty();
            var data_display = 25;
            var token  = "{{ csrf_token() }}";
            var url = "{{url('transaction/online-pos/ajax')}}";
            var dt = 0;
            var tab = $.fn.dataTable.isDataTable( '#tableList' );
            if(tab){
                $('#tableList').DataTable().destroy();
            }

            var data = {
                _token : token
            };

            $('#tableList').DataTable( {
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": false,
                "bSort": false,
                "bInfo": true,
                "iDisplayLength": data_display,
                "bProcessing": true,
                "serverSide": true,
                "searching": false,
                "ajax": {
                    url : url,
                    dataType: "json",
                    type: "POST",
                    data: data,
                    "dataSrc": function (json) {
                        return json.data;
                    }
                },
                columnDefs: [
                    {
                        targets: 0,
                        render: function ( data, type, row, meta ) {
                            var html = '';
                            if(row[1] === 0){
                                html = '<a onclick="resend('+data+')" id="resend'+data+'" class="btn btn-block green btn-xs">Resend</a>';
                            }
                            return html;
                        }
                    },
                    {
                        targets: 1,
                        render: function ( data, type, row, meta ) {
                            if(data === 0){
                                var html = '<b style="color: red" id="status-'+row[0]+'">Fail</b>';
                            }else{
                                var html = '<b style="color: green" id="status-'+row[0]+'">Success</b>';
                            }
                            return html;
                        }
                    }
                ]
            });
        }
        
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
                        document.getElementById("status-"+id_transaction_online_pos).innerHTML = '<b id="status-'+id_transaction_online_pos+'" style="color: green">Success</b>';
                        console.log($('#resend'+id_transaction_online_pos));
                        $('#resend'+id_transaction_online_pos).remove();
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
                  <th>Receipt Number</th>
                  <th>Customer Name</th>
                  <th>Customer Phone</th>
                  <th>Request</th>
                  <th>Response</th>
                  <th>Count Retry</th>
              </tr>
            </thead>
            <tbody id="tableListBody"></tbody>
            </table>
        </div>
    </div>
@endsection