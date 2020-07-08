<?php
    use App\Lib\MyHelper;
    $configs = session('configs');
 ?>
@section('sub-page-style')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <style type="text/css">
        @font-face {
            font-family: 'Seravek';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("S3_URL_VIEW") }}{{("assets/fonts/Seravek.ttf")}}') format('truetype');
        }

        @font-face {
            font-family: 'Seravek Light';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("S3_URL_VIEW") }}{{("assets/fonts/Seravek-Light.ttf")}}') format('truetype');
        }

        @font-face {
            font-family: 'Seravek Medium';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("S3_URL_VIEW") }}{{("assets/fonts/Seravek-Medium.ttf")}}') format('truetype');
        }

        @font-face {
            font-family: 'Seravek Italic';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("S3_URL_VIEW") }}{{("assets/fonts/Seravek-Italic.ttf")}}') format('truetype');
        }

        @font-face {
            font-family: 'Roboto Regular';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("S3_URL_VIEW") }}{{("assets/fonts/Roboto-Regular.ttf")}}') format('truetype');
        }

        .swal-text {
            text-align: center;
        }

        .kotak {
            margin : 10px;
            padding: 10px;
            /*margin-right: 15px;*/
            -webkit-box-shadow: 0px 1px 3.3px 0px rgba(168,168,168,1);
            -moz-box-shadow: 0px 1px 3.3px 0px rgba(168,168,168,1);
            box-shadow: 0px 1px 3.3px 0px rgba(168,168,168,1);
            /* border-radius: 3px; */
            background: #fff;
            font-family: 'Open Sans', sans-serif;
        }

        .kotak-qr {
            -webkit-box-shadow: 0px 0px 5px 0px rgba(214,214,214,1);
            -moz-box-shadow: 0px 0px 5px 0px rgba(214,214,214,1);
            box-shadow: 0px 0px 5px 0px rgba(214,214,214,1);
            background: #fff;
            width: 130px;
            height: 130px;
            margin: 0 auto;
            border-radius: 20px;
            padding: 10px;
        }

        .kotak-full {
            margin-bottom : 15px;
            padding: 10px;
            background: #fff;
            font-family: 'Open Sans', sans-serif;
        }

        .kotak-inside {
            padding-left: 25px;
            padding-right: 25px
        }

        body {
            background: #fafafa;
        }

        .bg-green2{
            background: #a6ba35;
        }

        .bg-black{
            background: #000000;
        }

        .round-green{
            border: 1px solid #a6ba35;
            border-radius: 50% !important;
            width: 10px;
            height: 10px;
            display: inline-block;
            margin-right:3px;
        }

        .round-black{
            border: 1px solid #000000;
            border-radius: 50% !important;
            width: 10px;
            height: 10px;
            display: inline-block;
            margin-right:3px;
        }

        .completed {
            color: green;
        }

        .bold {
            font-weight: bold;
        }

        .space-bottom {
            padding-bottom: 15px;
        }

        .space-top-all {
            padding-top: 15px;
        }

        .space-text {
            padding-bottom: 10px;
        }

        .space-nice {
            padding-bottom: 20px;
        }

        .space-bottom-big {
            padding-bottom: 25px;
        }

        .space-top {
            padding-top: 5px;
        }

        .line-bottom {
            border-bottom: 1px solid rgba(0,0,0,.1);
            margin-bottom: 15px;
        }

        .text-grey {
            color: #aaaaaa;
        }

        .text-much-grey {
            color: #bfbfbf;
        }

        .text-black {
            color: #000000;
        }

        .text-medium-grey {
            color: #806e6e6e;
        }

        .text-grey-white {
            color: #666;
        }

        .text-grey-light {
            color: #b6b6b6;
        }

        .text-grey-medium-light{
            color: #a9a9a9;
        }

        .text-black-grey-light{
            color: #5f5f5f;
        }


        .text-medium-grey-black{
            color: #424242;
        }

        .text-grey-black {
            color: #4c4c4c;
        }

        .text-grey-red {
            color: #9a0404;
        }

        .text-grey-red-cancel {
            color: rgba(154,4,4,1);
        }

        .text-grey-blue {
            color: rgba(0,140,203,1);
        }

        .text-grey-yellow {
            color: rgba(227,159,0,1);
        }

        .text-grey-green {
            color: rgba(4,154,74,1);
        }

        .text-grey-white-light {
            color: #b8b8b8;
        }

        .text-greyish-brown{
            color: #6c5648;
        }

        .open-sans-font {
            font-family: 'Open Sans', sans-serif;
        }

        .questrial-font {
            font-family: 'Questrial', sans-serif;
        }

        .seravek-font {
            font-family: 'Seravek';
        }

        .seravek-light-font {
            font-family: 'Seravek Light';
        }

        .seravek-medium-font {
            font-family: 'Seravek Medium';
        }

        .seravek-italic-font {
            font-family: 'Seravek Italic';
        }

        .roboto-regular-font {
            font-family: 'Roboto Regular';
        }

        .text-21-7px {
            font-size: 21.7px;
        }

        .text-16-7px {
            font-size: 16.7px;
        }

        .text-15px {
            font-size: 15px;
        }

        .text-14-3px {
            font-size: 14.3px;
        }

        .text-14px {
            font-size: 14px;
        }

        .text-13-3px {
            font-size: 13.3px;
        }

        .text-12-7px {
            font-size: 12.7px;
        }

        .text-12px {
            font-size: 12px;
        }

        .text-11-7px {
            font-size: 11.7px;
        }

        .round-greyish-brown{
            border: 1px solid #6c5648;
            border-radius: 50% !important;
            width: 10px;
            height: 10px;
            display: inline-block;
            margin-right:3px;
        }

        .bg-greyish-brown{
            background: #6c5648;
        }

        .round-white{
            width: 10px;
            height: 10px;
            display: inline-block;
            margin-right:3px;
        }

        .line-vertical{
            font-size: 5px;
            width:10px;
            margin-right: 3px;
        }

        .inline{
            display: inline-block;
        }

        .vertical-top{
            vertical-align: top;
            padding-top: 5px;
        }

        #modal-usaha {
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(0,0,0, 0.5);
            width: 100%;
            display: none;
            height: 100vh;
            z-index: 999;
        }

        .modal-usaha-content {
            position: absolute;
            left: 50%;
            top: 50%;
            margin-left: -125px;
            margin-top: -125px;
        }

        .kotak-full.pending{
            padding-top:15px;
            padding-bottom:15px;
            background-color:#aaa;
        }

        .kotak-full.on_going{
            padding-top:15px;
            padding-bottom:15px;
            background-color:#ef9219;
        }

        .kotak-full.complated{
            padding-top:15px;
            padding-bottom:15px;
            background-color:#fff;
        }

        .kotak-full.ready{
            padding-top:15px;
            padding-bottom:15px;
            background-color:#15977b;
        }

        .kotak-full.pending .text-greyish-brown,
        .kotak-full.on_going .text-greyish-brown,
        .kotak-full.ready .text-greyish-brown,

        .kotak-full.pending .text-grey-white-light,
        .kotak-full.on_going .text-grey-white-light,
        .kotak-full.ready .text-grey-white-light
        {
            color:#fff;
        }

        .kotak-full.redbg{
            margin-top:-10px;
            background-color:#c10100;
        }

        .kotak-full.redbg #content-taken{
            text-transform : uppercase;
            color:#fff;
            text-align:center;
            padding:10px;
        }

        @media (min-width: 1200px) {
        .container {
        max-width: 1170px; } }

        .page-header{
            position: fixed;
        }

        .page-logo {
            margin-right:auto;
        }

    </style>
@endsection

@section('page-script')

<script>

</script>
@endsection

@section('sub-content')
    @if(isset($data['detail']['order_id_qrcode']))
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content" style="border-radius: 42.3px; border: 0;">
                    <div class="modal-body">
                        <img class="img-responsive" style="display: block; width: 100%; padding: 30px" src="{{ $data['detail']['order_id_qrcode'] }}">
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- <div id="modal-usaha">
        <div class="modal-usaha-content">
        </div>
    </div> -->
    <div style="max-width: 480px; margin: auto">
    @if ($data['trasaction_type'] != 'Offline')
            <?php
                if($data['transaction_status'] == 'Payment Pending'){
                    $bg = '#FF9D6E';
                }elseif ($data['transaction_status'] == 'Order Canceled'){
                    $bg = '#B72126';
                }else{
                    $bg = '#9AD5C3';
                }

                $html = '<div class="kotak-full" style="background-color: #ffffff;padding: 20px; height: 65px; box-shadow: 0 1.3px 3.7px #b3b3b3;">';
                $html .= '<div class="container">';
                $html .= '<div class="row text-center">';
                $html .= '<div class="col-12 text-16-7px WorkSans-Bold" style="color: '.$bg.'"><b>'.$data['transaction_status'].'</b></div>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';

                echo $html;
            ?>
    @endif
        <div class="@if(isset($data['admin'])) body-admin @endif">
            @if(isset($data['detail']['pickup_by']) && $data['detail']['pickup_by'] == 'GO-SEND')
                <div class="kotak-biasa">
                    <div class="container">
                        <div class=" row text-center">
                            <div class="col-12 Ubuntu text-15px space-nice text-grey">Detail Pengiriman</div>
                            <div class="col-12 text-red text-21-7px space-bottom Ubuntu-Medium">GO-SEND</div>
                            <div class="col-12 text-16-7px text-black space-bottom Ubuntu">
                                {{ $data['detail']['transaction_pickup_go_send']['destination_name'] }}
                                <br>
                                {{ $data['detail']['transaction_pickup_go_send']['destination_phone'] }}
                            </div>
                            <div class="kotak-inside col-12">
                                <div class="col-12 text-13-3px text-grey-white space-nice text-center Ubuntu">{{ $data['detail']['transaction_pickup_go_send']['destination_address'] }}</div>
                            </div>
                            <div class="col-12 text-15px space-bottom text-black Ubuntu">Map</div>
                            <div class="col-12 space-bottom-big">
                                <div class="container">
                                    <div id="map"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 10px 0px;margin-top: 10px;">
                    <div class="container">
                        <div class="row text-center" style="background-color: #FFFFFF;padding: 5px;padding-top: 0px;margin-top: 20px;">
                            <div class="col-12 text-black space-text Ubuntu-Bold" style="font-size: 16.7px;">{{ $data['outlet']['outlet_name'] }}</div>
                            <div class="kotak-inside col-12">
                                <div class="col-12 text-11-7px text-grey-white space-nice text-center Ubuntu">{{ $data['outlet']['outlet_address'] }}</div>
                            </div>
                            @if(isset($data['transaction_payment_status']) && $data['transaction_payment_status'] != 'Cancelled' && $data['trasaction_type'] != 'Offline')
                                @if(isset($data['detail']['order_id_qrcode']))
                                    <div class="col-12 WorkSans-Bold text-14px space-text text-black-grey-light"><b>Your Pickup Code</b></div>

                                    <div style="width: 135px;height: 135px;margin: 0 auto;" data-toggle="modal" data-target="#exampleModal">
                                        <div class="col-12 text-14-3px space-top"><img class="img-responsive" style="display: block; max-width: 100%; padding-top: 10px" src="{{ $data['detail']['order_id_qrcode'] }}"></div>
                                    </div>
                                    <div class="col-12 text-black-grey-light text-20px WorkSans-SemiBold" style="font-size: 18px"><b>{{ $data['detail']['order_id'] }}</b></div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                @if($data['trasaction_type'] != 'Offline')
                    <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 10px 0px;margin-top: 10px;">
                        <div class="container">
                            <div class="row text-center">
                                @if(isset($data['admin']))
                                    <div class="col-12 text-16-7px text-black space-text Ubuntu">{{ strtoupper($data['user']['name']) }}</div>
                                    <div class="col-12 text-16-7px text-black Ubuntu space-nice">{{ $data['user']['phone'] }}</div>
                                @endif
                                @if (isset($data['transaction_payment_status']) && $data['transaction_payment_status'] == 'Cancelled')
                                    <div class="col-12 space-nice text-black Ubuntu" style="padding-bottom: 10px;">
                                        Your order cancelled on
                                    </div>
                                    <div class="col-12 text-14px space-text text-black Ubuntu-Medium">{{ date('d F Y', strtotime($data['transaction_date'])) }}</div>
                                @else
                                    <div class="col-12 space-nice text-black Ubuntu" style="padding-bottom: 10px;">
                                        Your order will be ready on
                                    </div>
                                    <div class="col-12 text-14px space-text text-black Ubuntu-Medium">{{ date('d F Y', strtotime($data['transaction_date'])) }}</div>

                                    @if ($data['detail']['pickup_type'] == 'set time')
                                        <div class="col-12 text-21-7px Ubuntu-Medium" style="color: #000000;">{{ $data['detail']['pickup_time'] }}</div>
                                    @elseif($data['detail']['pickup_type'] == 'at arrival')
                                        <div class="col-12 text-21-7px Ubuntu-Medium" style="color: #8fd6bd;">ON ARRIVAL</div>
                                    @else
                                        <div class="col-12 text-21-7px Ubuntu-Medium" style="color: #8fd6bd;">RIGHT NOW</div>
                                    @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 15px;margin-top: 10px;">
                <div class="row space-bottom">
                    <div class="col-7 text-left text-medium-grey-black text-13-3px Ubuntu">#{{ $data['transaction_receipt_number'] }}</div>
                    <div class="col-5 text-right text-medium-grey text-11-7px Ubuntu">{{ date('d M Y H:i', strtotime($data['transaction_date'])) }}</div>
                </div>
                <div class="row space-text" style="margin-top: 10px;">
                    <div class="col-12 text-14px Ubuntu-Medium"><b>Your Transaction</b></div>
                </div>
                @foreach ($data['product_transaction'] as $key => $item)
                    <div class="row space-text">
                        <div class="col-2 Ubuntu text-left" style="color: #8fd6bd;">{{$item['transaction_product_qty']}}x</div>
                        <div class="col-7 Ubuntu-Medium text-black">{{$item['product']['product_name']}}</div>
                        <div class="col-3 text-right Ubuntu-Medium text-black">@if (!is_string($item['transaction_product_subtotal'])) {{ number_format($item['transaction_product_subtotal'])}} @else {{$item['transaction_product_subtotal']}} @endif</div>
                    </div>
                    <div class="row space-text">
                        <div class="col-2 Ubuntu text-left"></div>
                        <div class="col-7 Ubuntu-Medium text-grey">
                            <?php
                            $topping = '';
                            if(isset($item['product']['product_modifiers'])){
                                foreach ($item['product']['product_modifiers'] as $mf){
                                    $topping .= $mf['product_modifier_name']. '('.$mf['product_modifier_qty'].'), ';
                                }
                            }

                            $variant = '';
                            foreach ($item['product']['product_variants'] as $vrt){
                                $variant .= $vrt['product_variant_name'].', ';
                            }

                            if($variant !== '') $variant = substr($variant, 0, -2);
                            if($topping !== '') $topping = '<br>'.substr($topping, 0, -2);
                            echo '<span style="color:#999;;font-size:14px;"><i>'.$variant.$topping.'</i><br>'.$item['transaction_product_note'].'</span>';
                            ?>
                        </div>
                        <div class="col-3 text-right Ubuntu-Medium text-black" style="color:grey;font-size: 11px">
                            @if($item['transaction_product_qty'] > 1)@ @if (!is_string($item['transaction_product_sub_item'])) {{ number_format(str_replace("@","",$item['transaction_product_sub_item']))}} @else {{ str_replace("@","",$item['transaction_product_sub_item'])}} @endif @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <hr style="margin: 10px 0px;border-top: dashed 1px #aaaaaa;"/>
                    </div>
                @endforeach
            </div>

            <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 15px;margin-top: 10px;">
                <div class="row space-bottom">
                    <div class="col-12 text-14px Ubuntu-Bold text-black"><b>Payment Details</b></div>
                </div>
                <div class="row space-bottom">
                    <div class="col-6 text-13-3px Ubuntu-Medium text-black ">Subtotal</div>
                    <div class="col-6 text-13-3px text-right Ubuntu text-black">@if (!is_string( $data['transaction_subtotal'])) {{ number_format($data['transaction_subtotal']) }} @else {{ $data['transaction_subtotal'] }} @endif </div>
                </div>
                @if($data['transaction_discount'] != 0)
                    <div class="row space-bottom">
                        <div class="col-6 text-13-3px Ubuntu-Medium">Discount</div>
                        <div class="col-6 text-13-3px text-right Ubuntu" style="color: red">@if (!is_string( $data['transaction_discount'])) {{ number_format($data['transaction_discount']) }} @else {{ $data['transaction_discount'] }} @endif </div>
                    </div>
                @endif
                <div class="row" style="background-color: #f0f3f7;border-radius: 5px;">
                    <div class="col-6 text-13-3px Ubuntu-Medium text-black" style="padding-top: 4px;padding-bottom: 4px;"><b>Grand Total</b></div>
                    <div class="col-6 text-13-3px text-right Ubuntu-Bold text-black" style="padding-top: 4px;padding-bottom: 4px;"><b>@if (!is_string( $data['transaction_grandtotal'])) {{ number_format($data['transaction_grandtotal']) }} @else {{ $data['transaction_grandtotal'] }} @endif</b></div>
                </div>
            </div>


            <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 15px;margin-top: 10px;">
                <div class="row space-bottom">
                    <div class="col-12 text-14px Ubuntu-Bold text-black"><b>Payment Method</b></div>
                </div>
                <div class="row">
                    @foreach($data['transaction_payment'] as $dp)
                        <div class="col-6 text-13-3px Ubuntu text-black ">{{$dp['name']}}</div>
                        <?php
                            $check = strpos(strtolower($dp['name']), 'point')
                        ?>
                        @if($check === false)
                            <div class="col-6 text-13-3px text-right Ubuntu-Medium text-black">@if (!is_string( $dp['amount'])) {{number_format($dp['amount'])}} @else {{ $dp['amount']}} @endif</div>
                        @else
                            <div class="col-6 text-13-3px text-right Ubuntu-Medium" style="color: red">@if (!is_string( $dp['amount'])) {{number_format($dp['amount'])}} @else {{ $dp['amount']}} @endif</div>
                        @endif
                    @endforeach
                </div>
            </div>

            @if ($data['trasaction_type'] != 'Offline')
                    <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 15px;margin-top: 10px;">
                    <div class="row space-bottom">
                        <div class="col-12 text-14px WorkSans-Bold text-black"><b>Order Status</b></div>
                    </div>
                    <div class="row">
                        <?php
                        $i = 1;
                        $count = count($data['detail']['detail_status']);
                        foreach ($data['detail']['detail_status'] as $status){
                            if($i == 1 ){
                                $html = '<div class="col-12 text-13-3px WorkSans-Medium">';
                                $html .= '<div class="round-black bg-black"></div>';
                                $html .= $status['text'];
                                $html .= '</div>';
                                $html .= '<div class="inline vertical-top">';
                                $html .= '<div class="col-12 text-11-7px WorkSans-Regular space-bottom" style="margin-left: 10%">';
                                $html .= $status['date'];
                                $html .= '</div>';
                                $html .= '</div>';

                                echo $html;
                            }else{
                                $html = '<div class="col-12 text-13-3px WorkSans-Medium">';
                                $html .= '<div class="round-black"></div>';
                                $html .= $status['text'];
                                $html .= '</div>';
                                $html .= '<div class="inline vertical-top">';
                                $html .= '<div class="col-12 text-11-7px WorkSans-Regular space-bottom" style="margin-left: 10%">';
                                $html .= $status['date'];
                                $html .= '</div>';
                                $html .= '</div>';

                                echo $html;
                            }
                            $i++;
                        }
                        ?>
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection