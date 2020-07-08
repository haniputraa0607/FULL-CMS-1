<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Kopi Kenangan | Invoice Delivery</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #4 for invoice sample" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{ env('S3_URL_VIEW') }}{{('assets/pages/css/invoice-2.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="{{ env('S3_URL_VIEW') }}{{('assets/layouts/layout4/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ env('S3_URL_VIEW') }}{{('assets/layouts/layout4/css/themes/default.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
        <link href="{{ env('S3_URL_VIEW') }}{{('assets/layouts/layout4/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" />

        <style type="text/css">
            @media only screen and (max-width: 768px) {
                /* For mobile phones: */
                [class*="col-"] {
                    width: 100%;
                }

                .count {
                    width: 50%;
                }

                .countValue {
                    text-align: right;
                    padding-right: 10px !important;
                }

                .outlet {
                    text-align: center;
                    padding-bottom: 12px;
                }

                .warning {
                    font-size: 11px
                }

                .customer {
                    margin-top: -20px;
                }

                .dataCustomer {
                        margin-top: 5px;
                }

                .product {
                    margin-top: -30px;
                }
            }

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
    </head>
    <!-- END HEAD -->

    <body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">
        <!-- BEGIN CONTAINER -->
        <div class="page-container" style="margin-top: 10px;margin-left: -250px;margin-bottom: 40px;">
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE BASE CONTENT -->
                    <div class="invoice-content-2 bordered">
                        <div class="row invoice-head">
                            <div class="col-md-7 col-xs-6 outlet">
                                <div>
                                    <h1 style="font-size: 30px;margin-top: 10px;font-weight: bold">{{ $trx['outlet']['outlet_name'] }}</h1>
                                    <h1 style="font-size: 25px;margin-top: 5px;">Order ID: <label>#{{ $trx['detail']['order_id'] }}</label></h1>
                                </div>
                                @if (!is_null($trx['detail']['receive_at']))
                                @if ($trx['trasaction_type'] == 'Delivery')
                                    @if (!is_null($trx['detail']['send_at']))
                                        @if ($trx['trasaction_type'] == 'Delivery')
                                            <span class="label label-sm label-success">Order Sudah Dikirim Oleh Admin</span>
                                        @else
                                            <span class="label label-sm label-success">Order Sudah Diambil Oleh Pelanggan</span>
                                        @endif
                                    @else
                                        <span class="label label-sm label-success">Order Sudah Diterima Admin</span>
                                    @endif
                                @else
                                    @if (!is_null($trx['detail']['taken_at']))
                                        @if ($trx['trasaction_type'] == 'Delivery')
                                            <span class="label label-sm label-success">Order Sudah Dikirim Oleh Admin</span>
                                        @else
                                            <span class="label label-sm label-success">Order Sudah Diambil Oleh Pelanggan</span>
                                        @endif
                                    @else
                                        <span class="label label-sm label-success">Order Sudah Diterima Admin</span>
                                    @endif
                                @endif
                                @else
                                    <span class="label label-sm label-success">Order Belum Diterima Admin</span>
                                @endif
                            </div>
                            <div class="col-md-5 col-xs-6">
                                @if (!is_null($trx['detail']['receive_at']))
                                    <center>
                                        <a style="margin-bottom: 8px; background-color: #f7faff; border: 1px solid #ccc" class="col-xs-12 btn-default btn-lg no-radius" >Order sudah diterima oleh<b> {{ $trx['detail']['admin_receive']['name'] }} ({{ $trx['detail']['admin_receive']['phone'] }})</b> pada<br>
                                        <b><font size="3">{{ date('d F Y H:i:s', strtotime($trx['detail']['receive_at'])) }}</font></b></a>
                                    </center>
                                @else
                                    <a style="margin-bottom: 8px;" class="col-xs-12 btn btn-info btn-lg no-radius" onclick="return confirm('Pastikan barang sudah diterima oleh admin, sebelum anda memilih Ok. Apakah anda yakin?')" @if ($trx['trasaction_type'] == 'Delivery') href="{{ url('transaction/admin/delivery/receive') }}/{{ $trx['transaction_receipt_number'] }}/{{ $admin['id_user_outlet'] }}" @else href="{{ url('transaction/admin/pickup/receive') }}/{{ $trx['transaction_receipt_number'] }}/{{ $admin['id_user_outlet'] }}" @endif >Terima Order</a>
                                @endif

                                @if ($trx['trasaction_type'] == 'Pickup Order')
                                    @if (!is_null($trx['detail']['taken_at']))
                                        <center>
                                            <a style="margin-bottom: 8px;background-color: #f7faff; border: 1px solid #ccc" class="col-xs-12 btn-default btn-lg no-radius">Order sudah dikirim oleh <b>{{ $trx['detail']['admin_taken']['name'] }} ({{ $trx['detail']['admin_taken']['phone'] }})</b> pada<br>
                                            <b><font size="3">{{ date('d F Y H:i:s', strtotime($trx['detail']['taken_at'])) }}</font></b></a>
                                        </center>
                                    @else
                                        @if (!is_null($trx['detail']['receive_at']))
                                            <a @if ($trx['trasaction_type'] == 'Pickup Order') onclick="return confirm('Pastikan barang sudah diterima oleh pelanggan, sebelum anda memilih Ok. Apakah anda yakin?')" @else($trx['trasaction_type'] == 'Pickup Order') onclick="return confirm('Pastikan barang sudah dikirim oleh admin, sebelum anda memilih Ok. Apakah anda yakin?')" @endif style="margin-bottom: 8px;" class="col-xs-12 btn btn-danger btn-lg no-radius" @if ($trx['trasaction_type'] == 'Delivery') href="{{ url('transaction/admin/delivery/taken') }}/{{ $trx['transaction_receipt_number'] }}/{{ $admin['id_user_outlet'] }}" @else href="{{ url('transaction/admin/pickup/taken') }}/{{ $trx['transaction_receipt_number'] }}/{{ $admin['id_user_outlet'] }}" @endif>@if ($trx['trasaction_type'] == 'Pickup Order') Order Sudah Diambil @else Order Sudah Dikirim @endif</a>
                                        @else
                                            <a style="margin-bottom: 8px;" class="col-xs-12 btn btn-danger btn-lg no-radius" disabled>@if ($trx['trasaction_type'] == 'Pickup Order') Order Sudah Diambil @else Order Sudah Dikirim @endif</a>
                                        @endif
                                    @endif
                                @else
                                    @if (!is_null($trx['detail']['send_at']))
                                        <center>
                                            <a style="margin-bottom: 8px;background-color: #f7faff; border: 1px solid #ccc" class="col-xs-12 btn-default btn-lg no-radius">Order sudah dikirim oleh <b>{{ $trx['detail']['admin_taken']['name'] }} ({{ $trx['detail']['admin_taken']['phone'] }})</b> pada<br>
                                            <b><font size="3">{{ date('d F Y H:i:s', strtotime($trx['detail']['send_at'])) }}</font></b></a>
                                        </center>
                                    @else
                                        @if (!is_null($trx['detail']['receive_at']))
                                            <a @if ($trx['trasaction_type'] == 'Pickup Order') onclick="return confirm('Pastikan barang sudah diterima oleh pelanggan, sebelum anda memilih Ok. Apakah anda yakin?')" @else($trx['trasaction_type'] == 'Pickup Order') onclick="return confirm('Pastikan barang sudah dikirim oleh admin, sebelum anda memilih Ok. Apakah anda yakin?')" @endif style="margin-bottom: 8px;" class="col-xs-12 btn btn-danger btn-lg no-radius" @if ($trx['trasaction_type'] == 'Delivery') href="{{ url('transaction/admin/delivery/taken') }}/{{ $trx['transaction_receipt_number'] }}/{{ $admin['id_user_outlet'] }}" @else href="{{ url('transaction/admin/pickup/taken') }}/{{ $trx['transaction_receipt_number'] }}/{{ $admin['id_user_outlet'] }}" @endif>@if ($trx['trasaction_type'] == 'Pickup Order') Order Sudah Diambil @else Order Sudah Dikirim @endif</a>
                                        @else
                                            <a style="margin-bottom: 8px;" class="col-xs-12 btn btn-danger btn-lg no-radius" disabled>@if ($trx['trasaction_type'] == 'Pickup Order') Order Sudah Diambil @else Order Sudah Dikirim @endif</a>
                                        @endif
                                    @endif
                                @endif


                                @if ($trx['trasaction_type'] == 'Pickup Order') <center><b><u><font class="warning">Pastikan menekan tombol "Order Sudah Diterima" ketika barang sudah diterima oleh Pelanggan.<font color="red">*</font></font></u></b></center> @else <center><b><u><font class="warning">Pastikan menekan tombol "Order Sudah Dikirim" ketika barang sudah dikirm oleh Admin.<font color="red">*</font></font></u></b></center> @endif
                            </div>
                        </div>
                        <div class="row invoice-cust-add">
                            <div class="col-xs-3 customer">
                                <h2 class="invoice-title uppercase">Customer</h2>
                                <p class="invoice-desc dataCustomer"><i class="fa fa-user"></i> {{ $trx['user']['name'] }}</p>
                            </div>
                            <div class="col-xs-3 customer">
                                <h2 class="invoice-title uppercase">Phone</h2>
                                <p class="invoice-desc dataCustomer"><i class="fa fa-phone"></i> {{ $trx['user']['phone'] }}</p>
                            </div>
                            <div class="col-xs-3 customer">
                                <h2 class="invoice-title uppercase">Date</h2>
                                <p class="invoice-desc dataCustomer"><i class="fa fa-calendar"></i> {{ date('d F Y', strtotime($trx['transaction_date'])) }}</p>
                            </div>
                            <div class="col-xs-3 customer">
                            	@if ($trx['trasaction_type'] == 'Delivery')
	                                <h2 class="invoice-title uppercase">Address</h2>
	                                <p class="invoice-desc dataCustomer"><i class="fa fa-street-view"></i> Jalan Garuda UH 3 / 159 Yogyakarta, Indonesia</p>
	                            @else
		                            <h2 class="invoice-title uppercase">Receipt Number</h2>
	                                <p class="invoice-desc dataCustomer"><i class="fa fa-newspaper-o"></i> TRX-2018-06-02-20180713090017</p>
	                            @endif
                            </div>
                        </div>
                        <div class="row invoice-body">
                            <div class="col-xs-12 table-responsive product">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="invoice-title uppercase">Product</th>
                                            <th class="invoice-title uppercase text-center">Quantity</th>
                                            <th class="invoice-title uppercase text-center">Price</th>
                                            <th class="invoice-title uppercase text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	@if (!empty($trx['products']))
                                    		@foreach ($trx['products'] as $key => $product)
	                                    		<tr>
		                                            <td>
		                                                <h3>{{ strtoupper($product['product_name']) }}</h3>
		                                            </td>
		                                            <td class="text-center sbold">{{ $product['pivot']['transaction_product_qty'] }}</td>
		                                            <td class="text-center sbold">{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}} {{ number_format($product['pivot']['transaction_product_price']) }}</td>
		                                            <td class="text-center sbold">{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}} {{ number_format($product['pivot']['transaction_product_subtotal']) }}</td>
		                                        </tr>
                                    		@endforeach
                                    	@endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row invoice-subtotal">
                            <div class="col-xs-6 count countKey">
                            	@foreach ($setting as $row => $value)
	                                <h2 class="invoice-desc" @if ($trx['trasaction_type'] == 'Pickup Order' && $value == 'shipment') style="display: none" @endif>{{ ucwords($value) }}</h2>
                            	@endforeach
	                                <h2 class="invoice-desc">Total</h2>
                            </div>
                            <div class="col-xs-6 count countValue">
                            	@foreach ($setting as $row => $value)
                            		@if ($trx['transaction_'.$value] < 1)
                                		<h2 @if ($trx['trasaction_type'] == 'Pickup Order' && $value == 'shipment') style="display: none" @endif class="invoice-desc" @if ($value == 'discount') style="color: red" @endif>-</h2>
                            		@else
                                		<h2 @if ($trx['trasaction_type'] == 'Pickup Order' && $value == 'shipment') style="display: none" @endif class="invoice-desc" @if ($value == 'discount') style="color: red" @endif>{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}} {{ number_format($trx['transaction_'.$value]) }}</h2>
                            		@endif
                            	@endforeach
                                	<h2 class="invoice-desc">{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}} {{ number_format($trx['transaction_grandtotal']) }}</h2>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-xs-12">
                                <a class="btn btn-lg green-haze hidden-print uppercase print-btn" onclick="javascript:window.print();">Print</a>
                            </div>
                        </div>
                    </div>
                    <!-- END PAGE BASE CONTENT -->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <!--[if lt IE 9]>
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
        <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-slimscroll/jqu') }}" y.slimscroll.min.js" type="text/javascript"></script>
        <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
        <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bo') }}" strap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{ env('S3_URL_VIEW') }}{{('assets/layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
        <script src="{{ env('S3_URL_VIEW') }}{{('assets/layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
        <script src="{{ env('S3_URL_VIEW') }}{{('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
        <script src="{{ env('S3_URL_VIEW') }}{{('assets/layouts/global/scripts/quick-nav.min.js') }}" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
</body>


</html>