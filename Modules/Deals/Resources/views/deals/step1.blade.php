@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <!-- <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css')}}" rel="stylesheet" type="text/css" /> -->
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <!-- <script src="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> -->
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/jquery.inputmask.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js')}}"></script>

<!--     <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
-->
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
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>

    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $('#sample_1').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                info:false,
                buttons: [],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [2, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                "searching": false,
                "paging": false,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#sample_1').on('click', '.delete-disc', function() {
            let token  = "{{ csrf_token() }}";
            let column = $(this).parents('tr');
            let id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('deals/voucher/delete') }}",
                data : "_token="+token+"&id_deals_voucher="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Voucher has been deleted.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete voucher.");
                    }
                },
                error : function(result) {
                    toastr.warning("Something went wrong. Failed to delete voucher.");
                }
            });
        });
    </script>
    <script type="text/javascript">
        $('#sample_2').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [2, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                "searching": false,
                "paging": false,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });
    </script>

    <script type="text/javascript">
        var oldOutlet=[];
        var value=$('select[name="id_outlet[]"]').val();
        var convertAll=false;

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
            if( convertAll && $('select[name="id_outlet[]"]').val() != null && $('select[name="id_outlet[]"]').val().length==list.length){
                $('select[name="id_outlet[]"]').val(['all']);
            }
            oldOutlet=list;
        }

        $(document).ready(function() {
            token = '<?php echo csrf_token();?>';

            $('.digit-mask').inputmask({
				removeMaskOnSubmit: true, 
				placeholder: "",
				alias: "currency", 
				digits: 0, 
				rightAlign: false,
				min: 0,
				max: '999999999'
			});

            $('#is_online, #is_offline').on('change', function(){
            	var is_online = $('#is_online').is(":checked");
            	var is_offline = $('#is_offline').is(":checked");
            	if (is_online || is_offline) {$('.online_offline').prop('required', false);}
            	if (!is_offline && !is_online) {$('.online_offline').prop('required', true);}
            });

		    $('#is_online').change(function() {
		        if(this.checked) {
		            $('#product-type-form').show();
		        }else{
		            $('#product-type-form').hide();
		        }
		    });

            /* TYPE VOUCHER */
            $('input[name=deals_voucher_type]').click(function() {
                // tampil duluk
                var nilai = $(this).val();

                // alert(nilai);

                if (nilai == "List Vouchers") {

                	$('input[name=total_voucher_type]:checked').prop('checked', false);
                	$('input[name=total_voucher_type]').prop('required', false);
                	$('input[name=deals_total_voucher]').val('');

                    $('#listVoucher').show();
                    $('.listVoucher').prop('required', true);
                    $('.listVoucher').prop('disabled', false);

                    $('#total-voucher-form').hide();
                    $('#generateVoucher').hide();
                    $('.generateVoucher').removeAttr('required');
                    $('.generateVoucher').prop('disabled', true);
                }
                else if (nilai == "Auto generated"){
                    $('#total-voucher-form').show();
                    
                	$('input[name=total_voucher_type]').prop('required', true);
                    $('#listVoucher').hide();
                    $('.listVoucher').removeAttr('required');
                    $('.listVoucher').prop('disabled', true);
                }
            });

            /* TOTAL TYPE VOUCHER */
            $('input[name=total_voucher_type]').click(function() {
                // tampil duluk
                var nilai = $(this).val();
                // alert(nilai);

                if (nilai == "Auto generated") {

                    $('#generateVoucher').show();
                    $('.generateVoucher').prop('required', true);
                    $('.generateVoucher').prop('disabled', false);

                    $('#listVoucher').hide();
                    $('.listVoucher').removeAttr('required');
                    $('.listVoucher').prop('disabled', true);
                }
                else if (nilai == "Unlimited"){
                    $('#listVoucher').hide();
                    $('.listVoucher').removeAttr('required');
                    $('.listVoucher').prop('disabled', true);

                    $('#generateVoucher').hide();
                    $('.generateVoucher').removeAttr('required');
                    $('.generateVoucher').prop('disabled', true);
                    $('input[name=deals_total_voucher]').val('');
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

                $('.dealsPromoTypeValuePrice').val('');
                $('.dealsPromoTypeValuePromo').val('');

                if (nilai == "promoid") {
                    $('.dealsPromoTypeValuePromo').show();
                    $('.dealsPromoTypeValuePromo').prop('required', true);

                    $('.dealsPromoTypeValuePrice').hide();
                    $('.dealsPromoTypeValuePrice').removeAttr('required', true);
                }
                else {
                    $('.dealsPromoTypeValuePrice').show();
                    $('.dealsPromoTypeValuePrice').prop('required', true);

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
                // var dim = realImgDimension($('#file'))

                // console.log(dim)
                // var _URL = window.URL || window.webkitURL;
                // var image, file;
                // if ((file = this.files[0])) {
                //     var dim = realImgDimension($('#file'))

                //     console.log(dim)

                //     if (this.width != 300 && this.height != 300) {
                //         toastr.warning("Please check dimension of your photo.");
                //         $('#file').val("");
                //     }
                //     else {
                //         image = new Image();
                //         image.src = _URL.createObjectURL(file);
                //     }
                // }
                // else {
                    // $('#file').val("");
                // }
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
                        mentah.attr('src', "{{ $deals['url_deals_image']??'https://www.placehold.it/500x500/EFEFEF/AAAAAA&text=no+image' }}")
                        $('#file').val("");
                        toastr.warning("Please check dimension of your photo.");
                    }
                };
            })
            @if(($conditions[0][0]['operator']??false)=="WHERE IN")
                var collapsed=false;
            @else
                var collapsed=true;
            @endif
            function collapser(){
                if(collapsed){
                    $('#manualFilter input,#manualFilter select').removeAttr('disabled');
                    $('#manualFilter').collapse('show');
                    $('#csvFilter').collapse('hide');
                    $('#campaign-csv-file').attr('disabled','disabled');
                    $('input[name="csv_content"]').attr('disabled','disabled');
                    $('#campaign-csv-file').attr('disabled','disabled');
                }else{
                    $('input[name="csv_content"]').removeAttr('disabled');
                    $('#campaign-csv-file').removeAttr('disabled');
                    $('#manualFilter').collapse('hide');
                    $('#csvFilter').collapse('show');
                    $('#manualFilter input,#manualFilter select').attr('disabled','disabled');
                }
                collapsed=!collapsed;
            }
            $('.collapser').on('click',collapser);
            collapser();
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

            if($('select[name="id_outlet[]"]').data('value')){
	            var value=$('select[name="id_outlet[]"]').val();
	            var convertAll=false;
	            if($('select[name="id_outlet[]"]').data('value')){
	                value=$('select[name="id_outlet[]"]').data('value');
	                $('select[name="id_outlet[]"]').data('value',false);
	                convertAll=true;
	            }
	            redrawOutlets($('select[name="id_outlet[]"]').data('all-outlet'),value,convertAll);
	        }
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
                    <div id="step-online">
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
                </div>
            </div>
        </div>
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue bold uppercase">{{ $deals['deals_title']??'New '.( ($title??'Deals') == 'Promotion' ? 'Deals Promotion' : ($title??'Deals') ) }}</span>
            </div>
        </div>
        <div class="portlet-body">

            <div class="tab-content">
                <div class="tab-pane active" id="info">
                	<div class="portlet-body form">
					    <form id="form" class="form-horizontal" role="form" action=" @if($deals_type == "Deals") {{ url('deals/update') }} @else {{ url('inject-voucher/update') }} @endif" method="post" enctype="multipart/form-data">
                				@include('deals::deals.step1-form')
				                <div class="form-actions">
				                @if(empty($deals['deals_total_claimed']) || $deals['deals_total_claimed'] == 0)
				                {{ csrf_field() }}
				                <div class="row">
				                    <div class="col-md-offset-3 col-md-9">
				                        <button type="submit" class="btn green">Submit</button>
				                        <!-- <button type="button" class="btn default">Cancel</button> -->
				                    </div>
				                </div>
				                @else
				                <div class="row">
				                    <div class="col-md-offset-3 col-md-9">
				                    	<a href="{{ ($deals['slug'] ?? false) ? url('deals/detail/'.$deals['slug']) : '' }}" class="btn green">Detail</a>
				                    </div>
				                </div>
				                @endif
				            </div>
				            <input type="hidden" name="id_deals" value="{{ $deals['id_deals']??'' }}">
				            <input type="hidden" name="slug" value="{{ $deals['slug']??'' }}">
				            <input type="hidden" name="deals_type" value="{{ $deals['deals_type']??$deals_type??'' }}">
				            <input type="hidden" name="template" value="{{ $deals['template']??0 }}">
					    </form>
					</div>
                </div>
            </div>
        </div>
    </div>


@endsection