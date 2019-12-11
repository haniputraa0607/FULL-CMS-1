<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');

 ?>
 @extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />


@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('.price').inputmask("numeric", {
            radixPoint: ",",
            groupSeparator: ".",
            digits: 0,
            autoGroup: true,
            rightAlign: false,
            oncleared: function () { self.Value(''); }
        });
        $('#outlet_selector').on('change',function(){
            window.location.href = "{{url('product/modifier/price')}}/"+$(this).val();
        });
        $('#form-prices').submit(function(){
            $('.price').inputmask('remove');
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">List Product Modifier</span>
            </div>
            <div class="actions">
                <div class="btn-group" style="width: 300px">
                   <select class="form-control select2" name="id_outlet" id="outlet_selector" data-placeholder="select outlet">
                        @foreach($outlets as $outlet)
                            <option value="{{ $outlet['id_outlet'] }}" @if ($outlet['id_outlet'] == $key) selected @endif>{{ $outlet['outlet_code'] }} - {{ $outlet['outlet_name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="portlet-body form">
            <form id="form-prices" action="{{url()->current()}}" method="POST">
                <table class="table table-striped table-bordered table-hover table-responsive" width="100%">
                    <thead>
                        <tr>
                            <th> No </th>
                            <th> Modifier </th>
                            <th> Price </th>
                            <th> Visible </th>
                            <th> Stock </th>
                            <th> Status </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($modifiers['data']))
                            @foreach($modifiers['data'] as $modifier)
                                @php $start++  @endphp
                                <tr>
                                    <td style="width: 1%">{{$start}}</td>
                                    <td>{{$modifier['code']}} - {{$modifier['text']}}</td>
                                    <td style="width: 15%"><input type="text" class="form-control price" name="prices[{{$modifier['id_product_modifier']}}][product_modifier_price]" value="{{$modifier['product_modifier_price']}}" style="max-width: 120px" /></td>
                                    <td style="width: 15%">
                                        <select class="form-control" name="prices[{{$modifier['id_product_modifier']}}][product_modifier_visibility]">
                                            <option></option>
                                            <option value="Visible" @if($modifier['product_modifier_visibility']=='Visible') selected @endif>Visible</option>
                                            <option value="Hidden" @if($modifier['product_modifier_visibility']=='Hidden') selected @endif>Hidden</option>
                                        </select>
                                    </td>
                                    <td style="width: 15%">
                                        <select class="form-control" name="prices[{{$modifier['id_product_modifier']}}][product_modifier_stock_status]">
                                            <option></option>
                                            <option value="Available" @if($modifier['product_modifier_stock_status']=='Available') selected @endif>Available</option>
                                            <option value="Sold Out" @if($modifier['product_modifier_stock_status']=='Sold Out') selected @endif>Sold Out</option>
                                        </select>
                                    </td>
                                    <td style="width: 15%">
                                        <select class="form-control" name="prices[{{$modifier['id_product_modifier']}}][product_modifier_status]">
                                            <option></option>
                                            <option value="Active" @if($modifier['product_modifier_status']=='Active') selected @endif>Active</option>
                                            <option value="Inactive" @if($modifier['product_modifier_status']=='Inactive') selected @endif>Inactive</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        @if ($paginator)
                        <div class="col-md-10">
                            {{ $paginator->links() }}
                        </div>
                        @endif
                        <div class="col-md-2">
                            <button type="submit" class="btn blue pull-right" style="margin:10px 0">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



@endsection