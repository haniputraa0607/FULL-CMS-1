@extends('layouts.main')

@section('page-style')
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        $('#variant_type').on('change',function(){
            switch($(this).val()){
                case 'parent':
                $('#parent').removeClass('hidden');
                $('#child').addClass('hidden');
                $('#child :input').attr('disabled','disabled');
                $('#parent :input').removeAttr('disabled');
                break;
                case 'child':
                $('#parent').addClass('hidden');
                $('#child').removeClass('hidden');
                $('#parent :input').attr('disabled','disabled');
                $('#child :input').removeAttr('disabled');
                break;
            }
        });
        $('#variant_type').change();
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
            <span class="caption-subject sbold uppercase font-blue">New Product Variant</span>
        </div>
    </div>
    <div class="portlet-body form">
        <div class="row">
            <div class="col-md-8">
                <form role="form" action="{{ url()->current() }}" method="post">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <label class="col-md-4 text-right control-label">Product Variant Type</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="parent" class="select2 form-control" data-placeholder="Select one..." required>
                                        @foreach($parents as $parent)
                                        <option value="{{$parent['id_product_variant']}}" @if($variants['id_product_variant']==$parent['id_product_variant']) selected @endif>{{$parent['product_variant_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 text-right control-label">Product Variant Code</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="product_variant_code" value="{{$variants['product_variant_code']}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 text-right control-label">Product Variant Name</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="product_variant_name" value="{{$variants['product_variant_name']}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-offset-4 col-md-8">
                                    <button type="submit" class="btn blue">Submit</button>
                                    <!--<button type="submit" name="next" value="1" class="btn blue">Submit & Manage Photo</button>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--end::Modal-->
    @endsection