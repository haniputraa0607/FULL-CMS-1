<?php
    use App\Lib\MyHelper;
    $configs = session('configs');
 ?>
@extends('layouts.main')

@section('page-style')
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/pages/css/invoice-2.min.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    .invoice-desc {
        font-weight: bold !important;
    }

    .countValue {
        text-align: right;
        padding-right: 55px;
    }

    a:hover {
        text-decoration: none;
    }
</style>

@section('page-script')
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
                    infoFiltered: "(filtered1 from MAX total entries)",
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
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#sample_2').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from MAX total entries)",
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
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
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

    <div class="invoice-content-2 bordered">
        <div class="row invoice-head">
            <div class="col-md-12 col-xs-6 text-right">
                <div>
                    <h1 style="font-size: 25px;margin-top: 10px;font-weight: bold">{{ $result['outlet']['outlet_name'] }}</h1>
                    <h1 style="font-size: 20px;margin-top: 5px;">Receipt Number : <label>{{ $result['transaction_receipt_number'] }}</label></h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 customer">
                <h2 class="invoice-title uppercase">Customer</h2>
                <p class="invoice-desc dataCustomer"><i class="fa fa-user"></i> {{ $result['user']['name'] }}</p>
            </div>
            <div class="col-xs-4 customer">
                <h2 class="invoice-title uppercase">Phone</h2>
                <p class="invoice-desc dataCustomer"><i class="fa fa-phone"></i> {{ $result['user']['phone'] }}</p>
            </div>
            <div class="col-xs-4 customer">
                <h2 class="invoice-title uppercase">Date</h2>
                <p class="invoice-desc dataCustomer"><i class="fa fa-calendar"></i> {{ date('d M Y H:i', strtotime($result['transaction_date'])) }}</p>
            </div>
        </div>
        <div class="row invoice-cust-add">
            {{-- <div class="col-xs-6 customer">
                <h2 class="invoice-title uppercase">Payment Detail</h2>
                @if ($result['trasaction_payment_type'] == 'Offline')
                    @if(!empty($result['payment_offline']))
                        @foreach($result['payment_offline'] as $res)
                            <p class="invoice-desc dataCustomer" style="margin:20px 0 5px"> Type&nbsp&nbsp&nbsp&nbsp : {{ $res['payment_type'] }}</p>
                            <p class="invoice-desc dataCustomer" style="margin:5px 0"> Name&nbsp&nbsp&nbsp : {{ $res['payment_bank'] }}</p>
                            <p class="invoice-desc dataCustomer" style="margin:5px 0"> Amount : Rp {{ number_format($res['payment_amount'], 2) }}</p>
                            <p class="invoice-desc dataCustomer" style="margin:5px 0"> Date&nbsp&nbsp : {{ date('d M Y H:i:s', strtotime($res['created_at'])) }}</p>
                        @endforeach
                    @endif
                @else
                    @if(!empty($result['payment']))
                        @foreach ($result['payment'] as $k => $val)
                            @if(isset($val['gross_amount']))
                                <p class="invoice-desc dataCustomer" style="margin:20px 0 5px"> Type&nbsp&nbsp&nbsp&nbsp : {{ ucwords(str_replace('_', ' ', $val['payment_type'])) }}</p>
                                <p class="invoice-desc dataCustomer" style="margin:5px 0"> Amount : Rp {{ number_format($val['gross_amount'], 2) }}</p>
                            @else
                                <p class="invoice-desc dataCustomer" style="margin:20px 0 5px"> Type&nbsp&nbsp&nbsp&nbsp : {{ $val['payment_method'] }}</p>
                                <p class="invoice-desc dataCustomer" style="margin:5px 0"> Name&nbsp&nbsp&nbsp : {{ $val['payment_bank'] }}</p>
                                <p class="invoice-desc dataCustomer" style="margin:5px 0"> Amount : Rp {{ number_format($val['payment_nominal'], 2) }}</p>
                            @endif
                            <p class="invoice-desc dataCustomer" style="margin:5px 0"> Date&nbsp&nbsp&nbsp : {{ date('d M Y H:i:s', strtotime($val['created_at'])) }}</p>
                        @endforeach
                    @else
                        <p class="invoice-desc dataCustomer" style="margin:20px 0 5px"> Type&emsp; : {{ $result['trasaction_payment_type'] }}</p>
                        <p class="invoice-desc dataCustomer" style="margin:5px 0"> Amount : </p>
                        <p class="invoice-desc dataCustomer" style="margin:5px 0"> Date&nbsp&nbsp&nbsp : {{ date('d M Y H:i:s', strtotime($val['created_at'])) }}</p>
                    @endif
                @endif
            </div> --}}

            @if ($result['trasaction_payment_type'] != 'Offline')
                <div class="col-xs-4 customer">
                    @if ($result['trasaction_type'] == 'Delivery')
                        <h2 class="invoice-title uppercase">Delivery Detail</h2>
                        <p class="invoice-desc dataCustomer" style="margin:20px 0 5px">Name : {{ $result['detail']['destination_name'] }}</p>
                        <p class="invoice-desc dataCustomer" style="margin:5px 0">Phone : {{ $result['detail']['destination_phone'] }}</p>
                        <p class="invoice-desc dataCustomer" style="margin:5px 0">Address : {{ $result['detail']['destination_address'] }}</p>
                    @else
                        <h2 class="invoice-title uppercase">Pickup</h2>
                        <p class="invoice-desc dataCustomer" style="margin:20px 0 5px">Status : @if($result['detail']['receive_at'] == null) Pending  @elseif($result['detail']['taken_at'] != null) Completed @elseif($result['detail']['ready_at'] != null) Ready @else On Going @endif</p>

                        <p class="invoice-desc dataCustomer" style="margin:5px 0">Type&nbsp : {{ucwords($result['detail']['pickup_type'])}}</p>
                        @if ($result['detail']['pickup_type'] == 'set time')
                            <p class="invoice-desc dataCustomer" style="margin:5px 0">Time&nbsp : {{ date('d M Y H:i', strtotime($result['detail']['pickup_at'])) }}</p>
                        @endif
                    @endif
                </div>
                <div class="col-xs-4 customer">
                    @if ($result['trasaction_type'] == 'Delivery')
                    @else
                        <h2 class="invoice-title uppercase">Detail</h2>
                        <p class="invoice-desc dataCustomer" style="margin:5px 0">Accepted At : @if($result['detail']['receive_at']) {{date('d M Y H:i', strtotime($result['detail']['receive_at']))}} @endif</p>
                        <p class="invoice-desc dataCustomer" style="margin:5px 0">Ready At : @if($result['detail']['ready_at']) {{date('d F Y H:i', strtotime($result['detail']['ready_at']))}} @endif</p>
                        <p class="invoice-desc dataCustomer" style="margin:5px 0">Taken At : @if($result['detail']['taken_at']) {{date('d F Y H:i', strtotime($result['detail']['taken_at']))}} @endif</p>
                    @endif
                </div>
            @endif
            <div class="col-xs-4 customer">
                <h2 class="invoice-title uppercase">Payment Status</h2>
                <p class="invoice-desc dataCustomer"><i class="fa fa-money"></i> {{ $result['transaction_payment_status'] }}</p>
            </div>
        </div>
        <div class="row invoice-body">
            <div class="col-xs-12 table-responsive product">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="invoice-title uppercase">Product</th>
                            <th class="invoice-title uppercase">Product Category</th>
                            <th class="invoice-title uppercase text-center">Quantity</th>
                            <th class="invoice-title uppercase text-center">Price</th>
                            <th class="invoice-title uppercase text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($result['product_transaction']))
                            @foreach ($result['product_transaction'] as $key => $product)
                                <tr>
                                    <td style="padding:0">
                                        <h3>{{ strtoupper($product['product']['product_name']) }}</h3>
                                    </td>
                                    <td >
                                        <h3>{{ strtoupper($product['product']['product_category']['product_category_name']) }}</h3>
                                    </td>
                                    <td style="padding:0" class="text-center sbold">{{ $product['transaction_product_qty'] }}</td>
                                    <td style="padding:0" class="text-center sbold">Rp {{ number_format($product['transaction_product_price']) }}</td>
                                    <td style="padding:0" class="text-center sbold">Rp {{ number_format($product['transaction_product_subtotal']) }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row invoice-subtotal">
            <div class="col-xs-3 count countKey">
                {{-- @foreach ($setting as $row => $value)
                    <h2 class="invoice-desc" @if ($result['trasaction_type'] == 'Pickup Order' && $value == 'shipment') style="display: none" @endif>{{ ucwords($value) }}</h2>
                @endforeach
                    <h2 class="invoice-desc">Total</h2> --}}
            </div>
            <div class="col-xs-3 count countKey">
                {{-- @foreach ($setting as $row => $value)
                    <h2 class="invoice-desc" @if ($result['trasaction_type'] == 'Pickup Order' && $value == 'shipment') style="display: none" @endif>{{ ucwords($value) }}</h2>
                @endforeach
                    <h2 class="invoice-desc">Total</h2> --}}
            </div>
            <div class="col-xs-3 count countKey text-right">
                @foreach ($setting as $row => $value)
                    <h2 class="invoice-desc" @if ($result['trasaction_type'] == 'Pickup Order' && $value == 'shipment') style="display: none" @endif>{{ ucwords($value) }}</h2>
                @endforeach
                    <h2 class="invoice-desc">Total</h2>
            </div>
            <div class="col-xs-3 count text-right" style="padding-bottom: 50px">
                @foreach ($setting as $row => $value)
                    @if ($result['transaction_'.$value] < 1)
                        <h2 @if ($result['trasaction_type'] == 'Pickup Order' && $value == 'shipment') style="display: none" @endif class="invoice-desc" @if ($value == 'discount') style="color: red" @endif>-</h2>
                    @else
                        <h2 @if ($result['trasaction_type'] == 'Pickup Order' && $value == 'shipment') style="display: none" @endif class="invoice-desc" @if ($value == 'discount') style="color: red" @endif>Rp {{ number_format($result['transaction_'.$value]) }}</h2>
                    @endif
                @endforeach
                    <h2 class="invoice-desc">{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}} {{ number_format($result['transaction_grandtotal']) }}</h2>
            </div>

            <div class="col-md-12">
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-green"></i>
                            <span class="caption-subject font-green sbold uppercase">Payment</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                       <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_2">
                        <thead>
                          <tr>
                              <th>Payment Type</th>
                              <th>Payment Ammount</th>
                              <th>Date</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if ($result['trasaction_payment_type'] == 'Offline')
                                @if(!empty($result['payment_offline']))
                                    @foreach($result['payment_offline'] as $res)
                                        <tr>
                                            <td>{{ $res['payment_type'] }}</td>
                                            <td>Rp {{ number_format($res['payment_amount'], 2) }}</td>
                                            <td>{{ date('Y-m-d H:i:s', strtotime($res['created_at'])) }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @else
                                @if(!empty($result['payment']))
                                     @foreach ($result['payment'] as $pay)
                                        @if (isset($pay['gross_amount']))
                                            <tr>
                                                <td>{{ $pay['payment_type'] }}</td>
                                                <td>Rp {{ number_format($pay['gross_amount'], 2) }}</td>
                                                <td>{{ date('Y-m-d H:i:s', strtotime($pay['created_at'])) }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>Point</td>
                                                <td>Rp {{ number_format($pay['balance_nominal'], 2) }}</td>
                                                <td>{{ date('Y-m-d H:i:s', strtotime($pay['created_at'])) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
@endsection