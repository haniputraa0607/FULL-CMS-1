<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs     = session('configs');
 ?>
@extends('layouts.main')

@include('outlet::list_filter')
@section('page-style')
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
  $('.select2').select2({
    placeholder:$(this).data('placeholder')
  });
</script>
@yield('child-script')
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

    @yield('filter')

    <div class="portlet light bordered">
      <div class="portlet-title tabbable-line">
          <div class="caption">
              <span class="caption-subject font-blue bold uppercase">Manage Outlet Location</span>
          </div>
      </div>
      <div class="portlet-body">
        @if($outlets)
        <div class="col-md-12" style="padding-left:0px;padding-right:0px;margin-bottom:20px;">
          <form action="{{ url('outlet/manage-location') }}" method="post">
          {{ csrf_field() }}
          <div class="col-md-offset-4 col-md-2" style="padding-left:0px;padding-right:0px;">
            <select name="take" class="form-control select2">
              <option value="10" @if($take == 10) selected @endif>Show 10 Data</option>
              <option value="25" @if($take == 25) selected @endif>Show 25 Data</option>
              <option value="50" @if($take == 50) selected @endif>Show 50 Data</option>
              <option value="100" @if($take == 100) selected @endif>Show 100 Data</option>
            </select>
          </div>
          <div class="col-md-3" style="padding-left:0px;padding-right:0px;">
            <select name="order_field" class="form-control select2">
              <option value="id_outlet" @if($order_field == 'id_outlet') selected @endif>Order by ID</option>
              <option value="outlet_code" @if($order_field == 'outlet_code') selected @endif>Order by Outlet Code</option>
              <option value="outlet_name" @if($order_field == 'outlet_name') selected @endif>Order by Name</option>
              <option value="updated_at" @if($order_field == 'updated_at') selected @endif>Order by Updated At</option>
            </select>
          </div>
          <div class="col-md-2" style="padding-left:0px;padding-right:0px">
            <select name="order_method" class="form-control select2">
              <option value="desc" @if($order_method == 'desc') selected @endif>Desc</option>
              <option value="asc" @if($order_method == 'asc') selected @endif>Asc</option>
            </select>
          </div>
          <div class="col-md-1" style="padding-left:0px;padding-right:0px;text-align:right">
            <button type="submit" class="btn yellow">Show</button>
          </div>
          </form>
        </div>
        <form method="post" action="#">
          <div class="table">
            <div class="row">
              <div class="col-sm-3"></div>
              <div class="col-sm-3 text-center"><strong>City</strong></div>
              <div class="col-sm-3 text-center"><strong>Latitude</strong></div>
              <div class="col-sm-3 text-center"><strong>Longitude</strong></div>
            </div><br>
            @foreach($outlets as $outlet)
            <div class="row">
              <div class="col-sm-3">{{$outlet['outlet_code']}} - {{$outlet['outlet_name']}}</div>
              <div class="col-sm-3">
                <div class="form-group">
                  <select id="city{{$outlet['id_outlet']}}" class="form-control select2" name="outlets[{{$outlet['id_outlet']}}][id_city]" data-placeholder="City">
                    <option></option>
                    @foreach($cities as $city)
                      <option value="{{$city['id_city']}}" @if((old('outlet_city')[$outlet['id_outlet']]??$outlet['id_city'])==$city['id_city']) selected @endif>{{$city['city_name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <input type="text" class="form-control" name="outlets[{{$outlet['id_outlet']}}][outlet_latitude]" placeholder="Latitude" value="{{$outlet['outlet_latitude']}}">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <input type="text" class="form-control" name="outlets[{{$outlet['id_outlet']}}][outlet_longitude]" placeholder="Longitude" value="{{$outlet['outlet_longitude']}}">
                </div>
              </div>
            </div>
            @endforeach
          </div>
          <div class="form-actions">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-md-offset-3 col-md-3">
                    <button type="submit" class="btn green">Save</button>
                </div>
                <div class="col-md-offset-3 col-md-3 text-right">
                  <div class="pull-right pagination" style="margin-top: 0px;margin-bottom: 0px;">
                    <ul class="pagination" style="margin-top: 0px;margin-bottom: 0px;">
                       <li class="page-first {{($prev_page_url??false)?'':'disabled'}}"><a href="{{$prev_page_url??'javascript:void(0)'}}">«</a></li>
                       <li class="page-last {{($next_page_url??false)?'':'disabled'}}"><a href="{{$next_page_url??'javascript:void(0)'}}">»</a></li>
                    </ul>
                  </div>
                </div>
              </div>
          </div>
        </form>
        @else
        <div class="row">
          <div class="col-md-12 text-center">No outlet found with this filter</div>
        </div>
        @endif
      </div>
    </div>


@endsection