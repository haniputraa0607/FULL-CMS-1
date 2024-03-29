@extends('layouts.main')

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
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
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
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>


    <script>

    $(".form_datetime").datetimepicker({
        format: "d-M-yyyy hh:ii",
        autoclose: true,
        todayBtn: true
    });

    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            var _URL = window.URL || window.webkitURL;

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

                    $('#deals_nominal_voucher').prop("readonly", false);
                }
                else {
                    $('.dealsPromoTypeValuePrice').show();
                    $('.dealsPromoTypeValuePrice').prop('required', true);

                    $('.dealsPromoTypeValuePromo').val('');
                    $('.dealsPromoTypeValuePromo').hide();
                    $('.dealsPromoTypeValuePromo').removeAttr('required', true);

                    $('#deals_nominal_voucher').prop("readonly", true);
                }
            });

            $('.dealsPromoTypeValuePrice').change(function(){
                $('#deals_nominal_voucher').val($(this).val())
            })


            $('.dealsPromoTypeValuePromo').keypress(function (e) {
                // prevent hashtag in promo ID
                // because url with # will not match with route
                if(e.charCode == 35) {  // 35 = #
                    e.preventDefault();
                    return false;
                }
            });

             // upload & delete image on summernote
             $('.summernote').summernote({
                placeholder: 'Deals Content Long',
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
                        mentah.attr('src', "")
                        $('#fieldPhoto').val("");
                        $('#imagedeals').children('img').attr('src', "{{$deals['url_deals_image']}}");

                        toastr.warning("Please check dimension of your photo.");
                    }
                };
            })
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
                buttons: [{
                    extend: "print",
                    className: "btn dark btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "copy",
                  className: "btn blue btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                },{
                  extend: "pdf",
                  className: "btn yellow-gold btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }, {
                    extend: "excel",
                    className: "btn green btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                    extend: "csv",
                    className: "btn purple btn-outline ",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "colvis",
                  className: "btn red",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                aaSorting: [],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
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
                <span class="caption-subject font-blue sbold uppercase ">{{ $deals['deals_title'] }}</span>
            </div>
            <ul class="nav nav-tabs">

                <li class="active" id="infoOutlet">
                    <a href="#info" data-toggle="tab" > Info </a>
                </li>
                <li>
                    <a href="#promotion" data-toggle="tab"> Promotion </a>
                </li>
            </ul>
        </div>
        <div class="portlet-body">
            <div class="tab-content">
                <div class="tab-pane active" id="info">
                    <div class="portlet-body form">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data" id="form">
                            <div class="form-body">
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
                                            <input type="text" class="form-control" name="deals_title" value="{{ $deals['deals_title'] }}" placeholder="Title" required maxlength="20">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Second Title
                                        <i class="fa fa-question-circle tooltips" data-original-title="Sub Judul deals jika ada" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" name="deals_second_title" value="{{ $deals['deals_second_title'] }}" placeholder="Title" required maxlength="20">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
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
                                                        <input type="radio" id="radio14" name="deals_promo_id_type" class="md-radiobtn dealsPromoType" value="promoid" required @if ($deals['deals_promo_id_type'] == "promoid") checked @endif>
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
                                                        <input type="radio" id="radio16" name="deals_promo_id_type" class="md-radiobtn dealsPromoType" value="nominal" required @if ($deals['deals_promo_id_type'] == "nominal") checked @endif>
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

                                <div class="form-group dealsPromoTypeShow">
                                    <label class="col-md-3 control-label"> </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control dealsPromoTypeValuePromo" name="deals_promo_id_promoid" value="{{ $deals['deals_promo_id'] }}" placeholder="Input Promo ID"  @if ($deals['deals_promo_id_type'] == "promoid") style="display: block;" @else style="display: none;" @endif>

                                        <input type="text" class="form-control dealsPromoTypeValuePrice price" name="deals_promo_id_nominal" value="{{ $deals['deals_nominal'] }}" placeholder="Input nominal" @if ($deals['deals_promo_id_type'] == "nominal") style="display: block;" @else style="display: none;" @endif>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Nominal Voucher</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control price" name="deals_voucher_value" id="deals_nominal_voucher" value="{{$deals['deals_voucher_value']}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Content Short
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi singkat tentang deals yang dibuat" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <textarea name="deals_short_description" class="form-control" required>{{ $deals['deals_short_description'] }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Content Long
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi lengkap tentang deals yang dibuat" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                        <textarea name="deals_description" id="field_content_long" class="form-control summernote">{{ $deals['deals_description'] }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"> Deals Periode <span class="required" aria-required="true"> * </span> </label>
                                    <div class="col-md-4">
                                        <div class="input-icon right">
                                            <div class="input-group">
                                                <input type="text" class="form_datetime form-control" name="deals_start" value="{{ date('d-M-Y H:i', strtotime($deals['deals_start'])) }}" required>
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
                                                <input type="text" class="form_datetime form-control" name="deals_end" value="{{ date('d-M-Y H:i', strtotime($deals['deals_end'])) }}" required>
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
                                                <img src="{{ $deals['url_deals_image'] }}" alt="">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" id="imagedeals" style="max-width: 200px; max-height: 200px;"></div>
                                                <div>
                                                    <span class="btn default btn-file">
                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input type="file" accept="image/*" name="deals_image" class="file" id="fieldPhoto">

                                                    </span>

                                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Outlet Available
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang memberlakukan deals tersebut" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[]" multiple required>
                                            <optgroup label="Outlet List">
                                                @php $deals['id_outlet'] = explode(',', $deals['deals_list_outlet']); @endphp
                                                @if (!empty($outlet))
                                                    <option value="all" @if ($deals['id_outlet']) @if(in_array('all', $deals['id_outlet'])) selected @endif @endif>All Outlets</option>
                                                    @foreach($outlet as $suw)
                                                        <option value="{{ $suw['id_outlet'] }}" @if ($deals['id_outlet']) @if(in_array($suw['id_outlet'], $deals['id_outlet'])) selected @endif @endif>{{ $suw['outlet_code'] }} - {{ $suw['outlet_name'] }}</option>
                                                    @endforeach
                                                @endif
                                            </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Voucher Expiry
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masa berlaku voucher, bisa diatur berdasarkan durasi deal atau tanggal expirednya" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <div class="col-md-3">
                                                <div class="md-radio-inline">
                                                    <div class="md-radio">
                                                        <input type="radio" name="duration" id="radio9" value="dates" class="expiry md-radiobtn" required @if ($deals['deals_voucher_expired'] != null) checked @endif>
                                                        <label for="radio9">
                                                            <span></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span> By Date </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="md-radio-inline">
                                                    <div class="md-radio">
                                                        <input type="radio" name="duration" id="radio10" value="duration" class="expiry md-radiobtn" required @if ($deals['deals_voucher_duration'] != null) checked @endif>
                                                        <label for="radio10">
                                                            <span></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span> Duration </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" id="times">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-9">
                                        <div class="col-md-3">
                                            <label class="control-label">Expiry <span class="required" aria-required="true"> * </span> </label>
                                        </div>
                                        <div class="col-md-6 voucherTime" id="dates" @if ($deals['deals_voucher_expired']) style="display: block;" @else style="display: none;" @endif>
                                            <div class="input-group">
                                                <input type="text" class="form_datetime form-control dates durationOpp" name="deals_voucher_expired" value="@if($deals['deals_voucher_expired']){{ date('d-M-Y H:i', strtotime($deals['deals_voucher_expired'])) }}@endif">
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 voucherTime" id="duration" @if ($deals['deals_voucher_duration']) style="display: block;" @else style="display: none;" @endif>
                                            <input type="number" class="form-control duration datesOpp" name="deals_voucher_duration" value="{{ $deals['deals_voucher_duration'] }}" placeholder="in day">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Voucher Type
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tipe pembuatan voucher, di list secara manual, auto generate atau unlimited" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <div class="col-md-3">
                                                <div class="md-radio-inline">
                                                    <div class="md-radio">
                                                        <input type="radio" name="deals_voucher_type" id="radio1" value="Auto generated" class="voucherType" @if ($deals['deals_voucher_type'] == "Auto generated") checked @endif>
                                                        <label for="radio1">
                                                            <span></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span> Auto Generated </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="md-radio-inline">
                                                    <div class="md-radio">
                                                        <input type="radio" name="deals_voucher_type" id="radio2" value="List Vouchers" class="voucherType" @if ($deals['deals_voucher_type'] == "List Vouchers") checked @endif required>
                                                        <label for="radio2">
                                                            <span></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span> List Voucher </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="md-radio-inline">
                                                    <div class="md-radio">
                                                        <input type="radio" name="deals_voucher_type" id="radio3" value="Unlimited" class="voucherType" @if ($deals['deals_voucher_type']== "Unlimited") checked @endif required>
                                                        <label for="radio3">
                                                            <span></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span> Unlimited </label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" id="listVoucher" @if ($deals['deals_voucher_type'] == "List Vouchers") style="display: block;" @else style="display: none;" @endif>
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-9">
                                        <div class="col-md-3">
                                            <label class="control-label">Input Voucher
                                                <span class="required" aria-required="true"> * </span>
                                                <br> <small> Separated by new line </small>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea name="voucher_code" class="form-control listVoucher" rows="10">{{ str_replace(',', '&#13;&#10;', $deals['deals_list_voucher']) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" id="generateVoucher" @if ($deals['deals_total_voucher']) style="display: block;" @else style="display: none;" @endif>
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-9">
                                        <div class="col-md-3">
                                            <label class="control-label">Total Voucher <span class="required" aria-required="true"> * </span> </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control generateVoucher" name="deals_total_voucher" value="{{ $deals['deals_total_voucher'] }}" placeholder="Total Voucher">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane" id="promotion">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-blue sbold uppercase">Promotion List</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                                <thead>
                                    <tr>

                                        <th> No </th>
                                        <th> Promotion Name </th>
                                        <th> Type </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($promotion))
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach($promotion as $value)
                                            <tr>
                                                <td>{{$no}}</td>
                                                <td>{{ $value['promotion_name'] }}</td>
                                                <td>{{ $value['promotion_type'] }}</td>
                                                <td style="width: 80px;">
                                                    <a href="{{ url('promotion/') }}/step3/{{ $value['id_promotion'] }}" class="btn btn-sm blue">Summary</i></a>
                                                </td>
                                            </tr>
                                            @php
                                                $no++;
                                            @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection