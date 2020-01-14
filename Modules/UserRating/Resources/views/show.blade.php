@extends('layouts.main')

@section('page-style')
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
        	<div class="row">
        		<label class="col-md-3 control-label text-right">Create Rating Date</label>
        		<div class="col-md-5">
                    <input type="text" class="form-control" readonly value="{{date('d M Y',strtotime($rating['created_at']))}}"/><br/>
                </div>
        	</div>
        	<div class="row">
        		<label class="col-md-3 control-label text-right">Receipt Number</label>
        		<div class="col-md-5">
                    <div class="form-control" readonly>
                        <a href="{{url('transaction/detail'.'/'.$rating['transaction']['id_transaction'].'/'.strtolower($rating['transaction']['trasaction_type']))}}">{{$rating['transaction']['transaction_receipt_number']}}</a>
                    </div><br/>
                </div>
        	</div>
        	<div class="row">
        		<label class="col-md-3 control-label text-right">User</label>
        		<div class="col-md-5">
                    <div class="form-control" readonly>
                        <a href="{{url('user/detail'.'/'.$rating['user']['phone'])}}">{{$rating['user']['name']}}</a>
                    </div><br/>
                </div>
        	</div>
        	<div class="row">
        		<label class="col-md-3 control-label text-right">Outlet</label>
        		<div class="col-md-5">
                    <div class="form-control" readonly>
                        <a href="{{url('outlet/detail'.'/'.$rating['transaction']['outlet']['outlet_code'])}}">{{$rating['transaction']['outlet']['outlet_code']}} - {{$rating['transaction']['outlet']['outlet_name']}}</a>
                    </div><br/>
        	   </div>
            </div>
        	<div class="row">
        		<label class="col-md-3 control-label text-right">Grand Total</label>
        		<div class="col-md-5">
                    <input type="text" class="form-control" readonly value="Rp {{number_format($rating['transaction']['transaction_grandtotal'],0,',','.')}}"/><br/>
                </div>
        	</div>
        	<div class="row">
        		<label class="col-md-3 control-label text-right">Star</label>
        		<div class="col-md-5">
                    <input type="text" class="form-control" readonly value="{{$rating['rating_value']}}"/><br/>
                </div>
        	</div>
            <div class="row">
                <label class="col-md-3 control-label text-right">Question</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" readonly value="{{$rating['option_question']}}"/><br/>
                </div>
            </div>
            <div class="row">
                <label class="col-md-3 control-label text-right">Selected Options</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" readonly value="{{$rating['option_value']}}"/><br/>
                </div>
            </div>
        	<div class="row">
        		<label class="col-md-3 control-label text-right">Suggestion</label>
        		<div class="col-md-5">
                    <input type="text" class="form-control" readonly value="{{$rating['suggestion']}}"/><br/>
                </div>
        	</div>
        </div>
    </div>
@endsection