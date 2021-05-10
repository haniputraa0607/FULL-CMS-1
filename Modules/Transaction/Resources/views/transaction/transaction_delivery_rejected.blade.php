@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#main-table').dataTable({
            ajax: {
                url : "{{url()->current()}}",
                type: 'GET',
                data: function (data) {
                    const info = $('#main-table').DataTable().page.info();
                    data.page = (info.start / info.length) + 1;
                },
                dataSrc: (res) => {
                    $('#list-filter-delivery-rejected').text(res.total);
                    return res.data;
                }
            },
            serverSide: true,
            columns: [
                {data: 'transaction_date'},
                {
                    data: 'transaction_receipt_number',
                    render: (value, type, row) => `<a href="{{url('transaction/detail')}}/${row.id_transaction}/delivery">${value}</a>`
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
                                return `${value} (${row.transaction_payment_midtrans?.payment_type})`;
                                break;
                            case 'ipay88':
                                return `${value} (${row.transaction_payment_ipay88?.payment_method})`;
                                break;
                        }
                        return value;
                    }
                },
                {
                    data: 'transaction_grandtotal',
                    render: value => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value)
                },
                {
                    data: 'transaction_shipment',
                    render:  value => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value)
                }
            ],
            searching: false
        });
    })
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

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">List Transaction Delivery Rejected</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-not-responsive" id="main-table">
            <thead>
              <tr>
                <th>Transaction Date</th>
                <th>Receipt Number</th>
                <th>Customer</th>
                <th>Payment Type</th>
                <th>Grandtotal</th>
                <th>Delivery</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
        </div>
    </div>
@endsection
