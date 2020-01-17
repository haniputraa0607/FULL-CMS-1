<?php
    use App\Lib\MyHelper;
    $configs = session('configs');
 ?>
@extends('layouts.main')

@include('userrating::transactionDetail3')

@section('page-style')
@yield('sub-page-style')
@endsection

@section('page-script')
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-dark sbold uppercase font-blue">Detail Rating</span>
            </div>
        </div>
        <div class="portlet-body form form-horizontal" id="detailRating">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_rating" data-toggle="tab"> Rating </a>
                </li>
                <li>
                    <a href="#tab_transaction" data-toggle="tab"> Transaction </a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane in active" id="tab_rating">
                	<div class="row">
                		<label class="col-md-3 text-right">Create Rating Date</label>
                		<div class="col-md-5">
                            {{date('d M Y',strtotime($rating['created_at']))}}<br/>
                        </div>
                	</div>
                	<div class="row">
                		<label class="col-md-3 text-right">Receipt Number</label>
                		<div class="col-md-5">
                            {{$rating['transaction']['transaction_receipt_number']}}
                            <br/>
                        </div>
                	</div>
                	<div class="row">
                		<label class="col-md-3 text-right">User</label>
                		<div class="col-md-5">
                            <a href="{{url('user/detail'.'/'.$rating['user']['phone'])}}">{{$rating['user']['name']}}</a>
                            <br/>
                        </div>
                	</div>
                	<div class="row">
                		<label class="col-md-3 text-right">Outlet</label>
                		<div class="col-md-5">
                            <a href="{{url('outlet/detail'.'/'.$rating['transaction']['outlet']['outlet_code'])}}">{{$rating['transaction']['outlet']['outlet_code']}} - {{$rating['transaction']['outlet']['outlet_name']}}</a><br/>
                	   </div>
                    </div>
                	<div class="row">
                		<label class="col-md-3 text-right">Grand Total</label>
                		<div class="col-md-5">
                            Rp {{number_format($rating['transaction']['transaction_grandtotal'],0,',','.')}}<br/>
                        </div>
                	</div>
                	<div class="row">
                		<label class="col-md-3 text-right">Star</label>
                		<div class="col-md-5">
                            <span class="font-yellow-crusta">{!!str_repeat('<i class="fa fa-star"></i>',$rating['rating_value'])!!}{!!str_repeat('<i class="fa fa-star-o"></i>',(5-$rating['rating_value']))!!}</span> ({{$rating['rating_value']}})<br/>
                        </div>
                	</div>
                    <div class="row">
                        <label class="col-md-3 text-right">Question</label>
                        <div class="col-md-5">
                            {{$rating['option_question']}}<br/>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3 text-right">Selected Options</label>
                        <div class="col-md-5">
                            @foreach(explode(',',$rating['option_value']) as $option)
                                <span class="badge ">{{$option}}</span>
                            @endforeach
                        </div>
                    </div>
                	<div class="row">
                		<label class="col-md-3 text-right">Suggestion</label>
                		<div class="col-md-5">
                            {{$rating['suggestion']}}<br/>
                        <br/>
                        </div>
                	</div>
                </div>
                <div class="tab-pane" id="tab_transaction">
                    @yield('sub-content')
                </div>
            </div>
        </div>
    </div>
@endsection