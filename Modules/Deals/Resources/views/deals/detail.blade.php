@php
use App\Lib\MyHelper;
$id_decrypt 		= MyHelper::explodeSlug($deals['id_deals']);
$configs    		= session('configs');
$grantedFeature     = session('granted_features');
	if($deals_type == 'Promotion'){
        $rpage = 'promotion/deals';
	}elseif($deals_type == 'WelcomeVoucher'){
        $rpage = 'welcome-voucher';
    }elseif($deals_type == 'SecondDeals'){
        $rpage = 'second-deals';
    }else{
        $rpage = $deals_type=='Deals'?'deals':'inject-voucher';
    }
@endphp
@extends('layouts.main-closed')
@include('deals::deals.detail-info')
@include('deals::deals.detail-info-content')
@include('deals::deals.participate')
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
    <link href="{{ env('S3_URL_VIEW') }}{{ ('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" /> 
    <style type="text/css">
		.d-none {
			display: none;
		}
		.width-60-percent {
			width: 60%;
		}
		.width-100-percent {
			width: 100%;
		}
		.width-voucher-img {
			max-width: 200px;
			width: 100%;
		}
		.v-align-top {
			vertical-align: top;
		}
		.p-t-10px {
			padding-top: 10px;
		}
		.page-container-bg-solid .page-content {
			background: #fff!important;
		}
		.text-decoration-none {
			text-decoration: none!important;
		}
		.p-l-0{
			padding-left: 0px;
		}
		.p-r-0{
			padding-right: 0px;
		}
		.p-l-r-0{
			padding-left: 0px;
			padding-right: 0px;
		}
		.font-custom-dark-grey {
			color: #95A5A6!important;
		}
		.font-custom-green {
			color: #26C281!important;
		}
		.select2-results__option[aria-selected=true] {
		    display: none;
		}
	</style>
@yield('detail-style')	
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
    <script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/jquery.inputmask.min.js') }}" type="text/javascript"></script>

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
        startDate: new Date(),
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

    	$('.list-deals').on('click', function() {
            id = $(this).data('deals');
            $('#modal-id-deals').val(id);
        });

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
        $('#participate_tables').dataTable({
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
            buttons: [{
                extend: "print",
                className: "btn dark btn-outline"
            }, {
                extend: "pdf",
                className: "btn green btn-outline"
            }, {
                extend: "csv",
                className: "btn purple btn-outline "
            }],
            deferRender: !0,
            scroller: !0,
            deferRender: !0,
            scrollX: !0,
            scrollCollapse: !0,
            stateSave: !0,
            lengthMenu: [
                [10, 15, 20, -1],
                [10, 15, 20, "All"]
            ],
            pageLength: 10,
            dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
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
                    $('.listVoucher').prop('disabled', false);

                    $('#generateVoucher').hide();
                    $('.generateVoucher').removeAttr('required');
                    $('.generateVoucher').prop('disabled', true);
                }
                else if (nilai == "Auto generated"){
                    $('#generateVoucher').show();
                    $('.generateVoucher').prop('required', true);
                    $('.generateVoucher').prop('disabled', false);

                    $('#listVoucher').hide();
                    $('.listVoucher').removeAttr('required');
                    $('.listVoucher').prop('disabled', true);
                }else{
                    $('#generateVoucher').hide();
                    $('.generateVoucher').removeAttr('required');
                    $('.generateVoucher').prop('disabled', true);
                    $('#listVoucher').hide();
                    $('.listVoucher').removeAttr('required');
                    $('.listVoucher').prop('disabled', true);
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
        });
    </script>
	@yield('child-script')
	@yield('child-script2')
	@yield('detail-script')
	@yield('participate-script')
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

@if($deals_type != 'Promotion')
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue">
                <div class="visual">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $deals['deals_total_voucher'] }}">
                        @if (!empty($deals['deals_voucher_type']))
                        	@if ( $deals['deals_voucher_type'] == "Unlimited")
                        		{{ 'Unlimited' }}
                        	@else
                        		{{ number_format(($deals['deals_total_voucher']??0)-($deals['deals_total_claimed']??0)) }}
                        	@endif
                        @endif
                        </span>
                    </div>
                    <div class="desc"> Total Voucher </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red">
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $deals['deals_total_claimed'] }}">{{ $deals['deals_total_claimed'] }}</span>
                    </div>
                    <div class="desc"> Total Claimed </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green">
                <div class="visual">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $deals['deals_total_redeemed'] }}">{{ $deals['deals_total_redeemed'] }}</span>
                    </div>
                    <div class="desc"> Total Redeem </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 purple">
                <div class="visual">
                    <i class="fa fa-globe"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $deals['deals_total_used'] }}">{{ $deals['deals_total_used'] }}</span>
                    </div>
                    <div class="desc"> Total Used </div>
                </div>
            </a>
        </div>
    </div>
@endif
    <div class="portlet light bordered">
        <div class="portlet-title tabbable-line">
            <span class="caption-subject font-black bold uppercase" style="font-size: 20px">{{ $id_decrypt[0]??'' }}</span><br>
            <div class="caption">
                <span class="caption-subject font-blue bold uppercase">{{ $deals['deals_title'] }}</span>
            </div>
            <ul class="nav nav-tabs">

                <li class="active" id="infoOutlet">
                    <a href="#info" data-toggle="tab" > Info </a>
                </li>
                <li>
                    <a href="#voucher" data-toggle="tab"> Voucher </a>
                </li>
                <li>
                    <a href="#participate" data-toggle="tab"> Participate </a>
                </li>
            </ul>
        </div>
        <div class="portlet-body">

            <div class="tab-content">
                <div class="tab-pane active" id="info">
                	@if ($deals['deals_voucher_type']!='List Vouchers')
                	<form action="{{ url('deals/export') }}" method="post" style="display: inline;">
                		{{ csrf_field() }}
					    <input type="hidden" value="{{ $deals['id_deals'] }}" name="id_deals" />
					    <input type="hidden" value="{{ $deals_type }}"  name="deals_type" />
					    <button type="submit" class="btn green-jungle" style="float: right;"><i class="fa fa-download"></i> Export</button>
					</form>
					@else
					<a data-toggle="modal" href="#export-modal" class="btn green-jungle list-deals" data-deals="{{ $deals['id_deals'] }}" style="float: right;"><i class="fa fa-download"></i> Export</a>
                    @endif
                	@if ($deals['step_complete'] != 1)
                    <a data-toggle="modal" href="#small" class="btn btn-primary" style="float: right; margin-right: 5px">Start Deals</a>
                    @endif
                    <a data-toggle="modal" href="#edit-modal" class="btn btn-primary" style="float: right; margin-right: 5px">Edit Deals</a>
                	<ul class="nav nav-tabs" id="tab-header">
                        <li class="active" id="infoOutlet">
                            <a href="#basic" data-toggle="tab" > Basic Info </a>
                        </li>
                        <li>
                            <a href="#content" data-toggle="tab"> Content Info </a>
                        </li>
                        <li>
                            <a href="#outlet" data-toggle="tab"> Outlet Info </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="basic">
                			@yield('detail-info')
                        </div>
                        <div class="tab-pane " id="content">
                			@yield('detail-info-content')
                        </div>
                        <div class="tab-pane" id="outlet">
                            @if($deals['is_all_outlet'] == 1)
                                <div class="alert alert-warning">
                                    This deals applied to <strong>All Outlet</strong>.
                                </div>
                            @else
                                <!-- BEGIN: Comments -->
                                <div class="mt-comments">
                                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_2">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(($promotion_outlets??$deals['outlets']) as $res)
                                                <tr>
                                                    <td>{{ $res['outlet_code'] }}</td>
                                                    <td>{{ $res['outlet_name'] }}</td>
                                                    <td>{{ $res['outlet_address'] }}</td>
                                                    <td>{{ $res['outlet_phone'] }}</td>
                                                    <td>{{ $res['outlet_email'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END: Comments -->
                            @endif
                        </div>
                    </div>
                </div>
                @if($deals_type != 'Promotion')
                <div class="tab-pane" id="voucher">
                    @include('deals::deals.voucher')
                </div>
                <div class="tab-pane" id="participate">
                    @yield('detail-participate')
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Start deals Modal --}}
    @if ($deals['step_complete'] != 1)
    <div class="modal fade bs-modal-sm" id="small" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Start Deals?</h4>
                </div>
                <form action="{{url('deals/update-complete')}}" method="post">
                	@csrf
                	<input type="hidden" name="id_deals" value="{{$deals['id_deals']}}">
                	<input type="hidden" name="deals_type" value="{{$deals['deals_type']??$deals_type}}">
	                <div class="modal-footer">
	                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
	                    <button type="submit" class="btn green">Confirm</button>
	                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    @endif

    {{-- Export Deals Modal --}}
    <div class="modal fade bs-modal-sm" id="export-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Export Detail Deals</h4>
                </div>
                <div class="modal-body row">
	                <form action="{{url('deals/export')}}" method="post">
	                	{{ csrf_field() }}
					    <input type="hidden" value="" name="id_deals" id="modal-id-deals" />
					    <input type="hidden" value="{{ $deals_type??'' }}"  name="deals_type" />
			    		<button type="submit" class="btn green-jungle col-md-12" value="1" name="list_voucher"><i class="fa fa-download"></i> With Voucher</button>
			    		<button type="submit" class="btn green-jungle col-md-12" value="0" name="list_voucher" style="margin-top: 15px"><i class="fa fa-download"></i> Without Voucher</button>
	                </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Edit Modal --}}
    <div id="edit-modal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            	<form action="{{ url('deals/detail-update') }}" method="post">
            		{{ csrf_field() }}
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	                    <h4 class="modal-title">Edit Deals</h4>
	                </div>
	                <div class="modal-body">
	                    <div class="row">
		                    {{-- Deals Periode --}}
		                    @if ( $deals_type == "Deals" || $deals_type == "WelcomeVoucher" )
		                    <div class="form-group">
		                        <label class="col-md-6 control-label"> Deals End Periode <span class="required" aria-required="true"> * </span> </label>
		                        <div class="col-md-6">
		                            <div class="input-icon right">
		                                <div class="input-group">
		                                    <input type="text" class="form_datetime form-control" name="deals_end" value="{{ !empty($deals['deals_end']) || old('deals_end') ? date('d-M-Y H:i', strtotime(old('deals_end')??$deals['deals_end'])) : ''}}" required autocomplete="off">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                    </span>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                    @endif

		                    {{-- Publish Periode --}}
		                    @if ($deals_type == "Deals")
		                    <div class="form-group">
		                        <label class="col-md-6 control-label"> Publish End Periode <span class="required" aria-required="true"> * </span> </label>
		                        <div class="col-md-6">
		                            <div class="input-icon right">
		                                <div class="input-group">
		                                    <input type="text" class="form_datetime form-control" name="deals_publish_end" value="{{ !empty($deals['deals_publish_end']) || old('deals_publish_end') ? date('d-M-Y H:i', strtotime(old('deals_publish_end')??$deals['deals_publish_end'])) : '' }}" required autocomplete="off">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                    </span>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                    @endif

		                    {{-- Outlet --}}
		                    @php
						        if (!empty($deals['outlets'])) {
						            $outlet_selected = array_pluck($deals['outlets'],'id_outlet');
						        }
						        else {
						            $outlet_selected = old('id_outlet',[]);
						        }
						    @endphp

						    <div class="form-group">
						        <div class="input-icon right">
						            <label class="col-md-12 control-label">Outlet</label>
						        </div>
						        <div class="col-md-12">
						            <select name="id_outlet[]" class="form-control select2 select2-hidden-accessible" multiple tabindex="-1" aria-hidden="true" data-placeholder="Select Outlet" style="width: auto;">
										@php
											$selected_outlet = [];
											if (old('id_outlet')) {
												$selected_outlet = old('id_outlet');
											}
											elseif (!empty($deals['outlets'])) {
												$selected_outlet = array_column($deals['outlets'], 'id_outlet');
											}
										@endphp

						            	<option value="all" 
						            		@if (old('id_outlet'))
						            			@if (in_array('all', old('id_outlet')))
							            			selected 
						            			@endif
							            	@elseif($deals['is_all_outlet'] == 1)
							            		selected 
							            	@endif>All Outlet</option>

						                @if (!empty($outlets))
						                    @foreach($outlets as $outlet)
						                        <option value="{{ $outlet['id_outlet'] }}" 
						                        	@if ( $selected_outlet??false ) 
						                        		@if( in_array($outlet['id_outlet'], $selected_outlet) ) selected 
						                        		@endif 
						                        	@endif
						                        >{{ $outlet['outlet_code'].' - '.$outlet['outlet_name'] }}</option>
						                    @endforeach
						                @endif
									</select>
						        </div>
						    </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
	                    <input type="hidden" value="{{ $deals['id_deals'] }}" name="id_deals" />
					    <input type="hidden" value="{{ $deals_type??'' }}"  name="deals_type" />
	                    <button type="submit" class="btn green">Save changes</button>
	                </div>
                </form>
            </div>
        </div>
    </div>
@endsection