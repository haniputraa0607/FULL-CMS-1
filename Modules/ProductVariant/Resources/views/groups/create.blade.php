@extends('layouts.main')

@section('page-style')
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
<style>
    .item{
        padding: 10px;
        border-bottom: 4px solid #eeeeee;
        background: #fff;
        margin: 15px;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        position: relative;
    }
    .value-bg{
        text-align: center;
        border: 3px solid;
        width: 100px;
        height: 100px;
        border-radius: 50% 50% !important;
        font-size: 60px;
        position: absolute;
        right: 10px;
        bottom: 10px;
        opacity: .7;
    }
</style>
@endsection

@section('page-script')
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
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
        $(".file").change(function(e) {
            var widthImg  = 0;
            var heightImg = 0;
            var _URL = window.URL || window.webkitURL;
            var image, file;
            var domLock = $(this);
            var i_size = {
                x: 400,
                y: 400
            }
            if($(this).data('type') == 'image_detail'){
                i_size = {
                    x: 720,
                    y: 360
                }
            }
            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (domLock.val().split('.').pop().toLowerCase() != 'png') {
                        domLock.val().split('.').pop().toLowerCase()
                        domLock.parents('.fileinput').find('.removeImage').click();
                    }
                    if (this.width != i_size.x || this.height != i_size.y) {
                        console.log('width: '+this.width+' height:'+this.height);
                        toastr.warning("Please check dimension of your photo.");
                        domLock.parents('.fileinput').find('.removeImage').click();
                    }
                };
                image.src = _URL.createObjectURL(file);
            }
        });
        $('#variant_type').change();
        $('.img-photo').hover(function(){
            $('#img_preview').attr('src','{{env('S3_URL_VIEW')}}img/setting/product_photo_preview.png');
        },function(){
            $('#img_preview').attr('src','{{env('S3_URL_VIEW')}}img/setting/product_group_preview.png');
        });
        $('#variant-selector :input').on('change',function(){
            var val = $('#variant-selector :input:checked').val();
            if(val == 'single'){
                $('.single-only').show();
            } else {
                $('.single-only').hide();
            }
        });
        $('#variant-selector :input').change();
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
            <span class="caption-subject sbold uppercase font-blue">New Product Group</span>
        </div>
    </div>
    <div class="portlet-body form">
        <div class="row">
            <div class="col-md-8">
                <form role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <label class="col-md-4 text-right control-label">Code</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="product_group_code" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 text-right control-label">Category</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="id_product_category" class="select2 form-control" data-placeholder="Select category" required>
                                        @foreach($categories as $category)
                                        <option value="{{$category['id_product_category']}}">{{$category['product_category_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 text-right control-label">Name</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="product_group_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 text-right control-label">Short Description</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea class="form-control" name="product_group_description" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row img-photo">
                            <label class="col-md-4 control-label text-right">
                                Image
                                <span class="required" aria-required="true"> * </span>
                                <br>
                                <span class="required" aria-required="true"> (400 * 400) (PNG Only) </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Gambar yang akan ditampilkan di daftar produk" data-container="body"></i>
                            </label>
                            <div class="col-md-7">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
                                        <img id="preview_image" src="https://www.placehold.it/200x200/EFEFEF/AAAAAA"/>
                                    </div>

                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                    <div>
                                        <span class="btn default btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" accept="image/png" class="file" name="product_group_photo" data-type="photo" required> 
                                        </span>
                                        <a href="javascript:;" class="btn red default fileinput-exists removeImage" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px; margin-bottom: 10px">
                            <label class="col-md-4 control-label text-right">
                                Image Detail
                                <span class="required" aria-required="true"> * </span>
                                <br>
                                <span class="required" aria-required="true"> (720 * 360) (PNG Only) </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Gambar yang akan ditampilkan di detail produk" data-container="body"></i>
                            </label>
                            <div class="col-md-7">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 144px; height: 78px;">
                                        <img id="preview_image" src="https://www.placehold.it/720x360/EFEFEF/AAAAAA"/>
                                    </div>

                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                    <div>
                                        <span class="btn default btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" accept="image/png" class="file" name="product_group_image_detail" data-type="image_detail" required> 
                                        </span>
                                        <a href="javascript:;" class="btn red default fileinput-exists removeImage" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px">
                            <label class="col-md-4 control-label text-right">
                                Product Variant
                                <span class="required" aria-required="true"> * </span>
                                <br>
                                <i class="fa fa-question-circle tooltips" data-original-title="Jenis produk variant. Multiple memungkinkan memiliki banyak jenis varian, sedangkan single tidak memiliki varian" data-container="body"></i>
                            </label>
                            <div class="col-md-7">
                                <div class="row" id="variant-selector">
                                    <div class="col-md-5">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" name="variant_type" id="radio4" value="multiple" checked>
                                                <label for="radio4">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Multiple
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" name="variant_type" id="radio3" value="single">
                                                <label for="radio3">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Single
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row single-only" style="margin-bottom: 10px">
                            <label class="col-md-4 control-label text-right">
                                Product
                                <span class="required" aria-required="true"> * </span>
                                <br>
                                <i class="fa fa-question-circle tooltips" data-original-title="Produk" data-container="body"></i>
                            </label>
                            <div class="col-md-7">
                                <select name="id_product" id="product-selector" class="select2" data-placeholder="Select Product">
                                    <option></option>
                                    @foreach($products as $product)
                                    <option value="{{$product['id_product']}}">{{$product['product_code']}} - {{$product['product_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-actions">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-offset-4 col-md-8">
                                    <button type="submit" class="btn blue">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="preview col-md-4 pull-right" style="right: 0;top: 70px; position: sticky">
                <img id="img_preview" src="{{env('S3_URL_VIEW')}}img/setting/product_group_preview.png" class="img-responsive">
            </div>
        </div>
    </div>

    <!--end::Modal-->
    @endsection