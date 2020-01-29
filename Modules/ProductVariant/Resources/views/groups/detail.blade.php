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
    .row-inactive {
        background-color: #ececec;
        color: #b9b9b9;
    }
    .select2b{
        width:200px !important;
    }
</style>
@endsection

@section('page-script')
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script>
    var products = {!!json_encode(array_map(function($var){return ['id'=>$var['id_product'],'text'=>$var['product_name']];},$products))!!};
    var assignData = {!!json_encode($product_group['variants'])!!};
    var removed = {};
    function assigner(){
        assignData.forEach(function(it){
            $(".selector"+it.variants.join('')).data("value",it.id_product);
            $(".selector"+it.variants.join('')).parents('tr').find('.row-disabler').attr('checked','checked');
        });
    }
    function productRemover(id_product){
        for(var i=0;i<products.length;i++){
            if(products[i].id == id_product){
                removed[id_product] = products[i];
                products.splice(i,1);
                break;
            }
        }
    }
    function productAdder(id,text){
        if(id && text){
            products.unshift({
                id:id,
                text:text
            });
        }
    }
    function redrawSelect(){
        var doms = $('.select2b');
        for(var i=0;i<doms.length;i++){
            var domi = $(doms[i]);
            if(domi.parents('tr').hasClass('row-inactive') === false){
                console.log(domi);
                var id = domi.val();
                var text = domi.find('option:selected').text();
                var prd = products;
                if( id && text){
                    prd.unshift({id:id,text:text});
                }
                domi.html('');
                domi.select2({data:prd});
            }
        }
    }
    $(document).ready(function(){
        assigner();
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
                x: 200,
                y: 200
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
                        toastr.warning("Please check dimension of your photo.");
                        domLock.parents('.fileinput').find('.removeImage').click();
                    }
                };
                image.src = _URL.createObjectURL(file);
            }
        });
        $('#variant_type').change();        
        $('.row-disabler').on('change',function(state){
            if($(this).prop('checked')){
                $('#variant'+$(this).data('id')+'-container').removeClass('row-inactive');
                $('#variant'+$(this).data('id')+'-container select').removeAttr('disabled');
                $('#variant'+$(this).data('id')+'-container .select2b').select2({data:products});
                var value = $('#variant'+$(this).data('id')+'-container .select2b').data('value');
                $('#variant'+$(this).data('id')+'-container .select2b').val(value);
                $('#variant'+$(this).data('id')+'-container .select2b').change();
                productRemover(value);
            }else{
                var id = $('#variant'+$(this).data('id')+'-container select').val();
                var text = $('#variant'+$(this).data('id')+'-container select option:selected').text();
                if(id && text){
                    productAdder(id,text);
                }
                $('#variant'+$(this).data('id')+'-container').addClass('row-inactive');
                $('#variant'+$(this).data('id')+'-container select').attr('disabled','disabled');
                $('#variant'+$(this).data('id')+'-container .select2b').html('').select2();
            }
        });
        $('.select2b').on('change',function(){
            var it = removed[$(this).data('id')];
            if(it){
                productAdder(it.id,it.text);
            }
            productRemover($(this).val());
            $(this).data('id',$(this).val());
            redrawSelect();
        })
        $('.row-disabler').change();
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
    <div class="portlet-title tabbable-line">
        <div class="caption">
            <span class="caption-subject sbold uppercase font-blue">Detail Product Group</span>
        </div>
        <ul class="nav nav-tabs">

            <li class="active" id="infoOutlet">
                <a href="#info" data-toggle="tab"> Info </a>
            </li>
            <li>
                <a href="#variants" data-toggle="tab"> Variants </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body form">
        <div class="tab-content">
            <div class="tab-pane active" id="info">
                @include('productvariant::groups.info')
            </div>
            <div class="tab-pane" id="variants">
                @include('productvariant::groups.variants')
            </div>
        </div>
    </div>

    <!--end::Modal-->
    @endsection