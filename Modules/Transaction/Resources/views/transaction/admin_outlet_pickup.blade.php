<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>CRMSystem | Invoice Pickup Order</title>
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
                                    <h1 style="font-size: 30px;margin-top: 10px;font-weight: bold">Bandung Festival Citylink</h1>
                                    <h1 style="font-size: 25px;margin-top: 5px;">Order ID: <label>#T8JH</label></h1>
                                </div>
                                <span class="label label-sm label-success">Order Belum Diterima Admin</span>
                            </div>
                            <div class="col-md-5 col-xs-6">
                                <a style="margin-bottom: 8px;" class="col-xs-12 btn btn-info btn-lg no-radius" onclick="return confirm('Pastikan barang sudah diterima oleh admin, sebelum anda memilih Ok. Apakah anda yakin?')">Terima Order</a>
                                <a style="margin-bottom: 8px;" class="col-xs-12 btn btn-danger btn-lg no-radius" disabled>Order Sudah Diambil</a>
                                <center><b><u><font class="warning">Pastikan menekan tombol "Order Sudah Diambil" ketika barang sudah diterima oleh Pelanggan.<font color="red">*</font></font></u></b></center>
                            </div>
                        </div>
                        <div class="row invoice-cust-add">
                            <div class="col-xs-3 customer">
                                <h2 class="invoice-title uppercase">Customer</h2>
                                <p class="invoice-desc dataCustomer"><i class="fa fa-user"></i> Ivan Kurniawan Prasetyo</p>
                            </div>
                            <div class="col-xs-3 customer">
                                <h2 class="invoice-title uppercase">Phone</h2>
                                <p class="invoice-desc dataCustomer"><i class="fa fa-phone"></i> 08985005660</p>
                            </div>
                            <div class="col-xs-3 customer">
                                <h2 class="invoice-title uppercase">Date</h2>
                                <p class="invoice-desc dataCustomer"><i class="fa fa-calendar"></i> 18 Jul 2018 14:00</p>
                            </div>
                            <div class="col-xs-3 customer">
                                <h2 class="invoice-title uppercase">Receipt Number</h2>
                                <p class="invoice-desc dataCustomer"><i class="fa fa-newspaper-o"></i> TRX-2018-06-02-20180713090017</p>
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
                                        <tr>
                                            <td>
                                                <h3>NG NATURAL PEELING FOR ANTI AGING</h3>
                                            </td>
                                            <td class="text-center sbold">4</td>
                                            <td class="text-center sbold">{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}} 100.000</td>
                                            <td class="text-center sbold">{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}} 400.000</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h3>UV FILTER MOIST DAY CREAM</h3>
                                            </td>
                                            <td class="text-center sbold">1</td>
                                            <td class="text-center sbold">{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}} 10.000</td>
                                            <td class="text-center sbold">{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}} 10.000</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h3>TEEN'S SEBUM CONTROL CREAM</h3>
                                            </td>
                                            <td class="text-center sbold">1</td>
                                            <td class="text-center sbold">{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}} 25.000</td>
                                            <td class="text-center sbold">{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}} 25.000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row invoice-subtotal">
                            <div class="col-xs-6 count countKey">
                                <h2 class="invoice-desc">Subtotal</h2>
                                <h2 class="invoice-desc">Service</h2>
                                <h2 class="invoice-desc">Tax(10%)</h2>
                                <h2 class="invoice-desc">Discount</h2>
                                <h2 class="invoice-desc">Total</h2>
                            </div>
                            <div class="col-xs-6 count countValue">
                                <h2 class="invoice-desc">{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}} 435.000</h2>
                                <h2 class="invoice-desc">{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}} 21.750</h2>
                                <h2 class="invoice-desc">{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}} 45.675</h2>
                                <h2 class="invoice-desc" style="color: red">-</h2>
                                <h2 class="invoice-desc">{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}} 50.2425</h2>
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