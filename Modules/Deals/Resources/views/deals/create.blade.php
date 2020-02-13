@extends('layouts.main')
<?php
use App\Lib\MyHelper;
$configs    		= session('configs');
$grantedFeature     = session('granted_features');
?>
@section('page-style')

    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')

    <!-- <script src="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> -->
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js')}}"></script>

    <script>
    $('.datepicker').datepicker({
        'format' : 'd-M-yyyy',
        'todayHighlight' : true,
        'autoclose' : true
    });
    $('.timepicker').timepicker();

    $(".form_datetime").datetimepicker({
        format: "d-M-yyyy hh:ii",
        autoclose: true,
        todayBtn: true,
        minuteStep:1
    });

    </script>

    <script type="text/javascript">        
        var oldOutlet=[];
        function redrawOutlets(list,selected,convertAll){
            var html="";
            if(list.length){
                html+="<option value=\"all\">All Outlets</option>";
            }
            list.forEach(function(outlet){
                html+="<option value=\""+outlet.id_outlet+"\">"+outlet.outlet_code+" - "+outlet.outlet_name+"</option>";
            });
            $('select[name="id_outlet[]"]').html(html);
            $('select[name="id_outlet[]"]').val(selected);
            if(convertAll&&$('select[name="id_outlet[]"]').val().length==list.length){
                $('select[name="id_outlet[]"]').val(['all']);
            }
            oldOutlet=list;
        }
        $(document).ready(function() {

            var _URL = window.URL || window.webkitURL;

            $('.price').each(function() {
                var input = $(this).val();
                var input = input.replace(/[\D\s\._\-]+/g, "");
                input = input ? parseInt( input, 10 ) : 0;

                $(this).val( function() {
                    return ( input === 0 ) ? "" : input.toLocaleString( "id" );
                });
            });
            token = '<?php echo csrf_token();?>';

            $('#is_offline').change(function() {
		        if(this.checked) {
		            $('#promo-type-form').show().find('input').prop('required', true).prop('checked', false);
		        }else{
		            $('#promo-type-form').hide().find('input').prop('required', false).prop('checked', false);

                    $('.dealsPromoTypeValuePrice').val('');
                    $('.dealsPromoTypeValuePrice').hide();
                    $('.dealsPromoTypeValuePrice').removeAttr('required', true);
                    $('.dealsPromoTypeValuePromo').val('');
                    $('.dealsPromoTypeValuePromo').hide();
                    $('.dealsPromoTypeValuePromo').removeAttr('required', true);

		        	$('.dealsPromoTypeShow').hide();
		        }
		    });

		    $('#is_online').change(function() {
		        if(this.checked) {
		            $('#step-online').show();
		            $('#step-offline').hide();
		        }else{
		            $('#step-online').hide();
		            $('#step-offline').show();
		        }
		    });

            /* TYPE VOUCHER */
            $('.voucherType').click(function() {
                // tampil duluk
                var nilai = $(this).val();

                // alert(nilai);

                if (nilai == "List Vouchers") {
                    $('#listVoucher').show();
                    $('.listVoucher').prop('required', true);

                    $('#generateVoucher').hide();
                    $('.generateVoucher').removeAttr('required');
                }
                else if(nilai == "Unlimited") {
                    $('.generateVoucher').val('');
                    $('.listVoucher').val('');
                    $('.listVoucher').removeAttr('required');

                    $('#listVoucher').hide();
                    $('#generateVoucher').hide();
                    $('.generateVoucher').removeAttr('required');
                }
                else {
                    $('#generateVoucher').show();
                    $('.generateVoucher').prop('required', true);

                    $('#listVoucher').hide();
                    $('.listVoucher').removeAttr('required');
                }
            });

            /* PRICES */
            $('.prices').click(function() {
                var nilai = $(this).val();

                if (nilai != "free") {
                    $('#prices').show();

                    $('.payment').hide();

                    $('#'+nilai).show();
                    $('.'+nilai).prop('required', true);
                    $('.'+nilai+'Opp').removeAttr('required');
                    $('.'+nilai+'Opp').val('');
                }
                else {
                    $('#prices').hide();
                    $('.freeOpp').removeAttr('required');
                    $('.freeOpp').val('');
                }
            });

            /* EXPIRY */
            $('.expiry').click(function() {
                var nilai = $(this).val();

                $('#times').show();

                $('.voucherTime').hide();

                $('#'+nilai).show();
                $('.'+nilai).prop('required', true);
                $('.'+nilai+'Opp').removeAttr('required');
                $('.'+nilai+'Opp').val('');
            });

            $('.dealsPromoType').click(function() {
                $('.dealsPromoTypeShow').show();
                var nilai = $(this).val();

                if (nilai == "promoid") {
                    $('.dealsPromoTypeValuePromo').show();
                    $('.dealsPromoTypeValuePromo').prop('required', true);

                    $('.dealsPromoTypeValuePrice').val('');
                    $('.dealsPromoTypeValuePrice').hide();
                    $('.dealsPromoTypeValuePrice').removeAttr('required', true);
                }
                else {
                    $('.dealsPromoTypeValuePrice').show();
                    $('.dealsPromoTypeValuePrice').prop('required', true);

                    $('.dealsPromoTypeValuePromo').val('');
                    $('.dealsPromoTypeValuePromo').hide();
                    $('.dealsPromoTypeValuePromo').removeAttr('required', true);
                }
            });

            // upload & delete image on summernote
            $('.summernote').summernote({
                placeholder: true,
                tabsize: 2,
                height: 120,
                toolbar: [
                  ['style', ['style']],
                  ['style', ['bold', 'underline', 'clear']],
                  ['color', ['color']],
                  ['para', ['ul', 'ol', 'paragraph']],
                  ['insert', ['table']],
                  ['insert', ['link', 'picture', 'video']],
                  ['misc', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onInit: function(e) {
                      this.placeholder
                        ? e.editingArea.find(".note-placeholder").html(this.placeholder)
                        : e.editingArea.remove(".note-placeholder");
                    },
                    onImageUpload: function(files){
                        sendFile(files[0]);
                    },
                    onMediaDelete: function(target){
                        var name = target[0].src;
                        token = "{{ csrf_token() }}";
                        $.ajax({
                            type: 'post',
                            data: 'filename='+name+'&_token='+token,
                            url: "{{url('summernote/picture/delete/deals')}}",
                            success: function(data){
                                // console.log(data);
                            }
                        });
                    }
                }
            });

            function sendFile(file){
                token = "{{ csrf_token() }}";
                var data = new FormData();
                data.append('image', file);
                data.append('_token', token);
                // document.getElementById('loadingDiv').style.display = "inline";
                $.ajax({
                    url : "{{url('summernote/picture/upload/deals')}}",
                    data: data,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    success: function(url) {
                        if (url['status'] == "success") {
                            $('#field_content_long').summernote('insertImage', url['result']['pathinfo'], url['result']['filename']);
                        }
                        // document.getElementById('loadingDiv').style.display = "none";
                    },
                    error: function(data){
                        // document.getElementById('loadingDiv').style.display = "none";
                    }
                })
            }

            // $("#file").change(function(e) {

            //     var image, file;
            //     if ((file = this.files[0])) {
            //         image = new Image();

            //         if (this.width != 300 && this.height != 300) {
            //             toastr.warning("Please check dimension of your photo.");
            //             $('#file').val("");
            //         }

            //         image.onload = function() {
            //             if (this.width != 300 && this.height != 300) {
            //                 toastr.warning("Please check dimension of your photo.");
            //                 $('#file').val("");
            //             }
            //             else {
            //                 image.src = _URL.createObjectURL(file);
            //             }
            //         };

            //     }
            //     else {
            //         $('#file').val("");
            //     }
            // });

            // $("#file").change(function(e) {
            //     var file = $(this)[0].files[0];

            //     img = new Image();

            //     var maxwidth  = 300;
            //     var maxheight = 300;


            //     img.src = _URL.createObjectURL(file);
            //     img.onload = function() {
            //         imgwidth  = this.width;
            //         imgheight = this.height;

            //         if(imgwidth == maxwidth && imgheight == maxheight){

            //         }else{
            //             toastr.warning("Please check dimension of your photo. Image size must be "+maxwidth+" X "+maxheight);
            //             // img.src = _URL.createObjectURL('https://www.placehold.it/500x500/EFEFEF/AAAAAA&text=no+image');
            //             $('#file').val("");
            //             $('#file').removeAttr('src');
            //         }
            //     };
            // });
            $('.fileinput-preview').bind('DOMSubtreeModified', function() {
                var mentah    = $(this).find('img')
                // set image
                var cariImage = mentah.attr('src')
                var ko        = new Image()
                ko.src        = cariImage
                // load image
                ko.onload     = function(){
                    if (this.naturalHeight === 500 && this.naturalWidth === 500) {
                    } else {
                        mentah.attr('src', "https://www.placehold.it/500x500/EFEFEF/AAAAAA&text=no+image")
                        $('#file').val("");
                        toastr.warning("Please check dimension of your photo.");
                    }
                };
            });
            @if(MyHelper::hasAccess([97], $configs))
            $('select[name="id_brand"]').on('change',function(){
                var id_brand=$('select[name="id_brand"]').val();
                $.ajax({
                    url:"{{url('outlet/ajax_handler')}}",
                    method: 'GET',
                    data: {
                        select:['id_outlet','outlet_code','outlet_name'],
                        condition:{
                            rules:[
                                {
                                    subject:'id_brand',
                                    parameter:id_brand,
                                    operator:'=',
                                }
                            ],
                            operator:'and'
                        }
                    },
                    success: function(data){
                        if(data.status=='success'){
                            var value=$('select[name="id_outlet[]"]').val();
                            var convertAll=false;
                            if($('select[name="id_outlet[]"]').data('value')){
                                value=$('select[name="id_outlet[]"]').data('value');
                                $('select[name="id_outlet[]"]').data('value',false);
                                convertAll=true;
                            }
                            redrawOutlets(data.result,value,convertAll);
                        }
                    }
                });
            });
            $('select[name="id_brand"]').change();
            @endif
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
    	<div class="col-md-12">
            <div class="mt-element-step">
                <div class="row step-line">
                    <div id="step-online" style="display: none">
	                    <div class="col-md-4 mt-step-col first active">
	                        <div class="mt-step-number bg-white">1</div>
	                        <div class="mt-step-title uppercase font-grey-cascade">Info</div>
	                        <div class="mt-step-content font-grey-cascade">Title, Image, Periode</div>
	                    </div>
	                    <div class="col-md-4 mt-step-col ">
	                        <div class="mt-step-number bg-white">2</div>
	                        <div class="mt-step-title uppercase font-grey-cascade">Rule</div>
	                        <div class="mt-step-content font-grey-cascade">discount rule</div>
	                    </div>
	                    <div class="col-md-4 mt-step-col last">
		                    <div class="mt-step-number bg-white">3</div>
		                    <div class="mt-step-title uppercase font-grey-cascade">Content</div>
		                    <div class="mt-step-content font-grey-cascade">Detail Content Deals</div>
	                    </div>
                    </div>
                    <div id="step-offline">
                    	<div class="col-md-6 mt-step-col first active">
	                        <div class="mt-step-number bg-white">1</div>
	                        <div class="mt-step-title uppercase font-grey-cascade">Info</div>
	                        <div class="mt-step-content font-grey-cascade">Title, Image, Periode</div>
	                    </div>
	                    <div class="col-md-6 mt-step-col last">
		                    <div class="mt-step-number bg-white">2</div>
		                    <div class="mt-step-title uppercase font-grey-cascade">Content</div>
		                    <div class="mt-step-content font-grey-cascade">Detail Content Deals</div>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase ">New {{ $title }}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data" id="form">
                <div class="form-body">
                    @if ($deals_type == "Hidden")
                    {{--
                    <div class="form-group">
                        <label class="col-md-3 control-label">Import File : </label>
                        <div class="col-md-9">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="input-group input-large">
                                    <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                        <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                        <span class="fileinput-filename"> </span>
                                    </div>
                                    <span class="input-group-addon btn default btn-file">
                                        <span class="fileinput-new"> Select file </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" name="import_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" onChange="this.form.submit();"> </span>
                                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3"> </label>
                        <div class="col-md-9">
                            Import data customer from excel. To filter customer please <a href="{{ url('user') }}" target="_blank"> click. </a>
                        </div>
                    </div>
                    <br>

                    <div class="form-group">
                        <label class="col-md-3 control-label">To
                            <span class="required" aria-required="true"> * </span>
                            <br> <small> Separated by coma (,) </small>
                        </label>
                        <div class="col-md-9">
                            <textarea name="to" class="form-control" required rows="5">@if (Session::get('deals_recipient')){{ Session::get('deals_recipient') }} @else {{ old('to') }} @endif</textarea>
                        </div>
                    </div>
                    --}}
                    @endif
                    @if(MyHelper::hasAccess([99], $configs))
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Deals Type
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih tipe untuk deal ini" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                        	<div class="mt-checkbox-inline">
                                <label class="mt-checkbox mt-checkbox-outline" style="margin-bottom: 0px">
                                    <input type="checkbox" id="is_online" name="is_online" value="1" @if (old('is_online') == "1") checked @endif> Online
                                    <span></span>
                                </label>
                                <label class="mt-checkbox mt-checkbox-outline" style="margin-bottom: 0px">
                                    <input type="checkbox" id="is_offline" name="is_offline" value="1" @if (old('is_offline') == "1") checked @endif> Offline
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Brand
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih brand untuk deal ini" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <select class="form-control select2-multiple" data-placeholder="Select Brand" name="id_brand" required>
                                    <option></option>
                                @if (!empty($brands))
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand['id_brand'] }}" @if (old('id_brand')) @if($brand['id_brand'] == old('id_brand')) selected @endif @endif>{{ $brand['name_brand'] }}</option>
                                    @endforeach
                                @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Title
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Judul deals" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <input type="text" class="form-control" name="deals_title" value="{{ old('deals_title') }}" placeholder="Title" required maxlength="20">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Second Title
                            <i class="fa fa-question-circle tooltips" data-original-title="Sub judul deals jika ada" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <input type="text" class="form-control" name="deals_second_title" value="{{ old('deals_second_title') }}" placeholder="Second Title" maxlength="20">
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="promo-type-form" style="display: none">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Promo Type
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Tipe promosi berdasarkan Promo ID atau nominal promo" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" id="radio14" name="deals_promo_id_type" class="md-radiobtn dealsPromoType" value="promoid" @if (old('deals_promo_id_type') == "promoid") checked @endif>
                                            <label for="radio14">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Promo ID </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" id="radio16" name="deals_promo_id_type" class="md-radiobtn dealsPromoType" value="nominal" @if (old('deals_promo_id_type') == "nominal") checked @endif>
                                            <label for="radio16">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Nominal </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-group dealsPromoTypeShow" @if (!old('deals_promo_id_type')) style="display: none;" @endif>
                        <label class="col-md-3 control-label"> </label>
                        <div class="col-md-9">
                            <input type="text" class="form-control dealsPromoTypeValuePromo" name="deals_promo_id_promoid" value="{{ old('deals_promo_id_promoid') }}" placeholder="Input Promo ID"  @if (old('deals_promo_id_type') == "promoid") style="display: block;" @else style="display: none;" @endif>

                            <input type="text" class="form-control dealsPromoTypeValuePrice price" name="deals_promo_id_nominal" value="{{ old('deals_promo_id_nominal') }}" placeholder="Input nominal" @if (old('deals_promo_id_type') == "nominal") style="display: block;" @else style="display: none;" @endif>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"> Deals Periode <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="deals_start" value="{{ old('deals_start') }}" required autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode deals" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="deals_end" value="{{ old('deals_end') }}" required autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode deals" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($deals_type != "Hidden")
                    <div class="form-group">
                        <label class="col-md-3 control-label"> Publish Periode <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="deals_publish_start" value="{{ old('deals_publish_start') }}" required autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai deals dipublish" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="deals_publish_end" value="{{ old('deals_publish_end') }}" autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai deals dipublish" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Image
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar deals" data-container="body"></i>
                            <br>
                            <span class="required" aria-required="true"> (500*500) </span>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                      <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                                    <div>
                                        <span class="btn default btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" accept="image/*" name="deals_image" required id="file">

                                        </span>

                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Video </label>
                        <div class="col-md-9">
                            <input name="deals_video" type="url" class="form-control" value="{{ old('deals_video') }}">
                        </div>
                    </div> -->

                    <!-- {{-- <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Product Related <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-9">
                            <select class="form-control select2" data-placeholder="Select Product" name="id_product" required>
                                <optgroup label="Product List">
                                    <option value="">Select Product</option>
                                    @if (!empty($product))
                                        @foreach($product as $suw)
                                            <option value="{{ $suw['id_product'] }}">{{ $suw['product_code'] }} - {{ $suw['product_name'] }}</option>
                                        @endforeach
                                    @endif
                                </optgroup>
                            </select>
                        </div>
                    </div> --}} -->

                        @if(MyHelper::hasAccess([97], $configs))
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                        Outlet Available
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang memberlakukan deals tersebut" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[]" multiple data-value="{{json_encode(old('id_outlet',[]))}}">
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                        Outlet Available
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang memberlakukan deals tersebut" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[]" multiple data-value="{{json_encode(old('id_outlet',[]))}}">
                                        @if(!empty($outlets))
                                            <option value="all">All Outlets</option>
                                            @foreach($outlets as $row)
                                                <option value="{{$row['id_outlet']}}">{{$row['outlet_code']}} - {{$row['outlet_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        @endif

                    <!-- IDENTIFIER DEALS OR HIDDEN -->
                    @if ($deals_type == "Deals")
                        @include('deals::deals.deals_form')
                    @else
                        @include('deals::hidden.hidden_form')
                    @endif

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            User Limit
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Batasan user untuk claim voucher, input 0 untuk unlimited" data-container="body"></i>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="number" class="form-control" name="user_limit" value="{{ old('user_limit') }}" placeholder="User limit" min="0">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <input type="hidden" name="deals_type" value="{{ $deals_type }}">
                            <button type="submit" class="btn green">Submit</button>
                            <!-- <button type="button" class="btn default">Cancel</button> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection