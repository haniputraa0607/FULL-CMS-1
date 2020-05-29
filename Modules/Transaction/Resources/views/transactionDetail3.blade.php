<?php
    use App\Lib\MyHelper;
    $configs = session('configs');
 ?>
@include('transaction::transaction.transaction_detail')
@extends('layouts.main')
@section('page-style')
@yield('sub-page-style')
@endsection

@section('page-script')

<script>

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

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content" style="border-radius: 42.3px; border: 0;">
            <div class="modal-body">
                <img class="img-responsive" style="display: block; width: 100%; padding: 30px" src="{{ $data['qr'] }}">
            </div>
            </div>
        </div>
    </div>

    <!-- <div id="modal-usaha">
        <div class="modal-usaha-content">
        </div>
    </div> -->
    <div style="max-width: 480px; margin: auto">
    @if ($data['trasaction_type'] != 'Offline')
        <div class="kotak-full {{ str_replace(' ', '_', strtolower($data['status'])) }}">
            <div class="col-12">
                <div class="row">
                    <div class="col-6 text-21-7px text-greyish-brown seravek-medium-font">
                      {{strtoupper($data['status'])}}
                    </div>
                    <div class="col-6 text-16-7px text-grey-white-light seravek-font text-right" style="padding-top:5px">
                      {{date('d F Y H:i',strtotime($data['transaction_date']))}}
                    </div>
                </div>
            </div>
        </div>

        @if(isset($data['status']))
            @if($data['status'] == "Taken" || $data['status'] == "Reject")
                <div class="kotak-full redbg">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <div id="content-taken" class="seravek-medium-font">
                                    @if($data['status'] == "Taken")
                                        Order completed <br/>and taken
                                    @else
                                        Order reject <br/> {{ $data['detail']['reject_reason'] }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
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
                                <div class="col-12 Ubuntu-Medium space-text text-black" style="font-size: 15px;">Your Pick Up Code</div>
                                <div style="width: 135px;height: 135px;margin: 0 auto;" data-toggle="modal" data-target="#exampleModal">
                                    <div class="col-12 text-14-3px space-top"><img class="img-responsive" style="display: block;max-width: 100%;padding-top: 10px" src="{{ $data['qr'] }}"></div>
                                </div>
                                <div class="col-12 text-black Ubuntu-Medium" style="color: #333333;font-size: 21.7px;padding-bottom: 5px;padding-top: 18px">{{ $data['detail']['order_id'] }}</div>
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
                                    <div class="col-12 text-21-7px Ubuntu-Medium" style="color: #8fd6bd;">
                                        @if ($data['detail']['pickup_type'] == 'set time')
                                            {{ date('H:i', strtotime($data['detail']['pickup_at'])) }}
                                        @elseif($data['detail']['pickup_type'] == 'at arrival')
                                            ON ARRIVAL
                                        @else
                                            RIGHT NOW
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
                    <div class="col-12 text-14px Ubuntu-Medium">Your Transaction</div>
                </div>
                @foreach ($data['product_transaction'] as $key => $item)
                    <div class="row space-text">
                        <div class="col-2 Ubuntu text-left" style="color: #8fd6bd;">{{$item['transaction_product_qty']}}x</div>
                        <div class="col-7 Ubuntu-Medium text-black">{{$item['product']['product_name']}}</div>
                        <div class="col-3 text-right Ubuntu-Medium text-black">{{ number_format($item['transaction_product_price'])}}</div>
                    </div>

                    <div class="row space-text">
                        <div class="col-2 Ubuntu text-left"></div>
                        <div class="col-7 Ubuntu-Medium text-grey">
                            <?php
                            $topping = '';
                            if(isset($data['modifiers'])){
                                foreach ($data['modifiers'] as $mf){
                                    $topping .= $mf['text']. '('.$mf['qty'].'), ';
                                }
                            }
                            echo '<div style="font-size: 11px;">'.substr($topping, 0, -2).'</div>';
                            ?>
                        </div>
                        <div class="col-3 text-right Ubuntu-Medium text-black" style="padding-right: 0px;"></div>
                    </div>

                    @if (!empty($item['product']['product_discounts']))
                        <div class="row space-text">
                            <div class="col-2 Ubuntu text-black">{{$item['transaction_product_qty']}}x</div>
                            <div class="col-7 Ubuntu text-black" style="margin-left: -20px;">{{$item['product']['product_name']}}</div>
                            <div class="col-3 text-right Ubuntu-Medium text-black" style="padding-right: 0px;">{{ number_format($data['transaction_subtotal']) }}</div>
                        </div>
                    @endif
                    <div class="col-12">
                        <hr style="margin: 10px 0px;border-top: dashed 1px #aaaaaa;"/>
                    </div>
                @endforeach
            </div>

            <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 15px;margin-top: 10px;">
                <div class="row space-bottom">
                    <div class="col-12 text-14px Ubuntu-Bold text-black">Payment Details</div>
                </div>
                <div class="row space-bottom">
                    <div class="col-6 text-13-3px Ubuntu-Medium text-black ">Subtotal</div>
                    <div class="col-6 text-13-3px text-right Ubuntu text-black">{{ number_format($data['transaction_subtotal']) }}</div>
                </div>
                <div class="row" style="background-color: #f0f3f7;border-radius: 5px;">
                    <div class="col-6 text-13-3px Ubuntu-Medium text-black" style="padding-top: 4px;padding-bottom: 4px;">Grand Total</div>
                    <div class="col-6 text-13-3px text-right Ubuntu-Bold text-black" style="padding-top: 4px;padding-bottom: 4px;">{{ number_format($data['transaction_grandtotal']) }}</div>
                </div>
            </div>

            <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 15px;margin-top: 10px;">
                <div class="row space-bottom">
                    <div class="col-12 text-14px Ubuntu-Bold text-black">Payment Method</div>
                </div>
                <div class="row">
                    @foreach($data['data_payment'] as $dp)
                        @if(isset($dp['payment_method']))
                                <div class="col-6 text-13-3px Ubuntu text-black ">{{strtoupper($dp['payment_method'])}}</div>
                                <div class="col-6 text-13-3px text-right Ubuntu-Medium text-black">{{ number_format($dp['nominal'])}}</div>
                        @else
                                <div class="col-6 text-13-3px Ubuntu text-black ">{{strtoupper($dp['payment_type'])}}</div>
                                <div class="col-6 text-13-3px text-right Ubuntu-Medium text-black">{{ number_format($dp['payment_amount']) }}</div>
                        @endif

                    @endforeach
                </div>
            </div>

                @if ($data['trasaction_type'] != 'Offline')
                    <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 15px;margin-top: 10px;">
                        <div class="row space-bottom">
                            <div class="col-12 text-14px Ubuntu-Medium text-black">Order Status</div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            @php $top = 5; $bg = true; @endphp
                            @if(isset($data['transaction_payment_status']) && $data['transaction_payment_status'] == 'Cancelled')
                                <div class="col-12 text-13-3px Ubuntu-Medium text-black top-{{$top}}px">
                                    <div class="round-black @if($bg) bg-black @endif"></div>
                                    Your order has been canceled<br>
                                    <div style="margin-left: 4%;">{{ date('d F Y H:i', strtotime($data['void_date'])) }}</div>
                                </div>
                            @else
                                @if($data['detail']['reject_at'] != null)
                                    <div class="col-12 text-13-3px Ubuntu-Medium text-black">
                                        <div class="round-black bg-black"></div>
                                        Order rejected<br>
                                        <div style="margin-left: 4%;">{{ date('d F Y H:i', strtotime($data['detail']['reject_at'])) }}</div>
                                    </div>
                                @endif
                                @if($data['detail']['taken_by_system_at'] != null)
                                    <div class="col-12 text-13-3px Ubuntu-Medium text-black top-{{$top}}px">
                                        <div class="round-black @if($bg) bg-black @endif"></div>
                                        Your order has been done by system<br>
                                        <div style="margin-left: 4%;">{{date('d F Y H:i', strtotime($data['detail']['taken_by_system_at']))}}</div>
                                    </div>
                                @endif
                                @if($data['detail']['taken_at'] != null)
                                    <div class="col-12 text-13-3px Ubuntu-Medium text-black top-{{$top}}px">
                                        <div class="round-black @if($bg) bg-black @endif"></div>
                                        Your order has been taken<br>
                                        <div style="margin-left: 4%;">{{date('d F Y H:i', strtotime($data['detail']['taken_at']))}}</div>
                                    </div>
                                @endif
                                @if($data['detail']['ready_at'] != null)
                                    <div class="col-12 text-13-3px Ubuntu-Medium text-black top-{{$top}}px">
                                        <div class="round-black @if($bg) bg-black @endif"></div>
                                        Your order is ready<br>
                                        <div style="margin-left: 4%;">{{date('d F Y H:i', strtotime($data['detail']['ready_at']))}}</div>
                                    </div>
                                @endif
                                @if($data['detail']['receive_at'] != null)
                                    <div class="col-12 text-13-3px Ubuntu-Medium text-black top-{{$top}}px">
                                        <div class="round-black @if($bg) bg-black @endif"></div>
                                        Your order has been received<br>
                                        <div style="margin-left: 4%;">{{date('d F Y H:i', strtotime($data['detail']['receive_at']))}}</div>
                                    </div>
                                @endif
                                <div class="col-12 text-13-3px Ubuntu-Medium text-black top-{{$top}}px">
                                    <div class="round-black @if($bg) bg-black @endif"></div>
                                    Your order awaits confirmation
                                </div>
                                <div class="col-12 text-11-7px Ubuntu text-black space-bottom top-{{$top}}px">
                                    <div class="round-white"></div>
                                    {{ date('d F Y H:i', strtotime($data['transaction_date'])) }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
        </div>

    </div>
@endsection
