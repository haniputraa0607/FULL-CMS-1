<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs    		= session('configs');
?>
@extends('layouts.main-closed')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-family: "Montserrat", "Lato", "Open Sans", "Helvetica Neue", Helvetica, Calibri, Arial, sans-serif;
            color: #6b7381;
            background: #f2f2f2;
        }
        .jumbotron {
            background: #6b7381;
            color: #bdc1c8;
        }
        .jumbotron h1 {
            color: #fff;
        }
        .example {
            margin: 4rem auto;
        }
        .example > .row {
            margin-top: 2rem;
            height: 5rem;
            vertical-align: middle;
            text-align: center;
            border: 1px solid rgba(189, 193, 200, 0.5);
        }
        .example > .row:first-of-type {
            border: none;
            height: auto;
            text-align: left;
        }
        .example h3 {
            font-weight: 400;
        }
        .example h3 > small {
            font-weight: 200;
            font-size: 0.75em;
            color: #939aa5;
        }
        .example h6 {
            font-weight: 700;
            font-size: 0.65rem;
            letter-spacing: 3.32px;
            text-transform: uppercase;
            color: #bdc1c8;
            margin: 0;
            line-height: 5rem;
        }
        .example .btn-toggle {
            top: 50%;
            transform: translateY(-50%);
        }
        .btn-toggle {
            margin: 0 4rem;
            padding: 0;
            position: relative;
            border: none;
            height: 1.5rem;
            width: 3rem;
            border-radius: 1.5rem;
            color: #6b7381;
            background: #bdc1c8;
        }
        .btn-toggle:focus,
        .btn-toggle.focus,
        .btn-toggle:focus.active,
        .btn-toggle.focus.active {
            outline: none;
        }
        .btn-toggle:before,
        .btn-toggle:after {
            line-height: 1.5rem;
            width: 4rem;
            text-align: center;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            bottom: 0;
            transition: opacity 0.25s;
        }
        .btn-toggle:before {
            content: "Inactive";
            left: -4rem;
        }
        .btn-toggle:after {
            content: "Active";
            right: -4rem;
            opacity: 0.5;
        }
        .btn-toggle > .handle {
            position: absolute;
            top: 0.1875rem;
            left: 0.1875rem;
            width: 1.125rem;
            height: 1.125rem;
            border-radius: 1.125rem;
            background: #fff;
            transition: left 0.25s;
        }
        .btn-toggle.active {
            transition: background-color 0.25s;
        }
        .btn-toggle.active > .handle {
            left: 1.6875rem;
            transition: left 0.25s;
        }
        .btn-toggle.active:before {
            opacity: 0.5;
        }
        .btn-toggle.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-sm:before,
        .btn-toggle.btn-sm:after {
            line-height: -0.5rem;
            color: #fff;
            letter-spacing: 0.75px;
            left: 0.4125rem;
            width: 2.325rem;
        }
        .btn-toggle.btn-sm:before {
            text-align: right;
        }
        .btn-toggle.btn-sm:after {
            text-align: left;
            opacity: 0;
        }
        .btn-toggle.btn-sm.active:before {
            opacity: 0;
        }
        .btn-toggle.btn-sm.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-xs:before,
        .btn-toggle.btn-xs:after {
            display: none;
        }
        .btn-toggle:before,
        .btn-toggle:after {
            color: #6b7381;
        }
        .btn-toggle.active {
            background-color: #29b5a8;
        }
        .btn-toggle.btn-lg {
            margin: 0 5rem;
            padding: 0;
            position: relative;
            border: none;
            height: 2.5rem;
            width: 5rem;
            border-radius: 2.5rem !important;
        }
        .btn-toggle.btn-lg:focus,
        .btn-toggle.btn-lg.focus,
        .btn-toggle.btn-lg:focus.active,
        .btn-toggle.btn-lg.focus.active {
            outline: none;
        }
        .btn-toggle.btn-lg:before,
        .btn-toggle.btn-lg:after {
            line-height: 2.5rem;
            width: 5rem;
            text-align: center;
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            bottom: 0;
            transition: opacity 0.25s;
        }
        .btn-toggle.btn-lg:before {
            content: "Inactive";
            left: -7rem;
        }
        .btn-toggle.btn-lg:after {
            content: "Active";
            right: -6rem;
            opacity: 0.5;
        }
        .btn-toggle.btn-lg > .handle {
            position: absolute;
            top: 0.3125rem;
            left: 0.3125rem;
            width: 1.875rem;
            height: 1.875rem;
            border-radius: 1.875rem !important;
            background: #fff;
            transition: left 0.25s;
        }
        .btn-toggle.btn-lg.active {
            transition: background-color 0.25s;
        }
        .btn-toggle.btn-lg.active > .handle {
            left: 2.8125rem;
            transition: left 0.25s;
        }
        .btn-toggle.btn-lg.active:before {
            opacity: 0.5;
        }
        .btn-toggle.btn-lg.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-lg.btn-sm:before,
        .btn-toggle.btn-lg.btn-sm:after {
            line-height: 0.5rem;
            color: #fff;
            letter-spacing: 0.75px;
            left: 0.6875rem;
            width: 3.875rem;
        }
        .btn-toggle.btn-lg.btn-sm:before {
            text-align: right;
        }
        .btn-toggle.btn-lg.btn-sm:after {
            text-align: left;
            opacity: 0;
        }
        .btn-toggle.btn-lg.btn-sm.active:before {
            opacity: 0;
        }
        .btn-toggle.btn-lg.btn-sm.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-lg.btn-xs:before,
        .btn-toggle.btn-lg.btn-xs:after {
            display: none;
        }
        .btn-toggle.btn-sm {
            margin: 0 0.5rem;
            padding: 0;
            position: relative;
            border: none;
            height: 1.5rem;
            width: 3rem;
            border-radius: 1.5rem;
        }
        .btn-toggle.btn-sm:focus,
        .btn-toggle.btn-sm.focus,
        .btn-toggle.btn-sm:focus.active,
        .btn-toggle.btn-sm.focus.active {
            outline: none;
        }
        .btn-toggle.btn-sm:before,
        .btn-toggle.btn-sm:after {
            line-height: 1.5rem;
            width: 0.5rem;
            text-align: center;
            font-weight: 600;
            font-size: 0.55rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            bottom: 0;
            transition: opacity 0.25s;
        }
        .btn-toggle.btn-sm:before {
            content: "Off";
            left: -0.5rem;
        }
        .btn-toggle.btn-sm:after {
            content: "On";
            right: -0.5rem;
            opacity: 0.5;
        }
        .btn-toggle.btn-sm > .handle {
            position: absolute;
            top: 0.1875rem;
            left: 0.1875rem;
            width: 1.125rem;
            height: 1.125rem;
            border-radius: 1.125rem;
            background: #fff;
            transition: left 0.25s;
        }
        .btn-toggle.btn-sm.active {
            transition: background-color 0.25s;
        }
        .btn-toggle.btn-sm.active > .handle {
            left: 1.6875rem;
            transition: left 0.25s;
        }
        .btn-toggle.btn-sm.active:before {
            opacity: 0.5;
        }
        .btn-toggle.btn-sm.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-sm.btn-sm:before,
        .btn-toggle.btn-sm.btn-sm:after {
            line-height: -0.5rem;
            color: #fff;
            letter-spacing: 0.75px;
            left: 0.4125rem;
            width: 2.325rem;
        }
        .btn-toggle.btn-sm.btn-sm:before {
            text-align: right;
        }
        .btn-toggle.btn-sm.btn-sm:after {
            text-align: left;
            opacity: 0;
        }
        .btn-toggle.btn-sm.btn-sm.active:before {
            opacity: 0;
        }
        .btn-toggle.btn-sm.btn-sm.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-sm.btn-xs:before,
        .btn-toggle.btn-sm.btn-xs:after {
            display: none;
        }
        .btn-toggle.btn-xs {
            margin: 0 0;
            padding: 0;
            position: relative;
            border: none;
            height: 1rem;
            width: 2rem;
            border-radius: 1rem;
        }
        .btn-toggle.btn-xs:focus,
        .btn-toggle.btn-xs.focus,
        .btn-toggle.btn-xs:focus.active,
        .btn-toggle.btn-xs.focus.active {
            outline: none;
        }
        .btn-toggle.btn-xs:before,
        .btn-toggle.btn-xs:after {
            line-height: 1rem;
            width: 0;
            text-align: center;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            bottom: 0;
            transition: opacity 0.25s;
        }
        .btn-toggle.btn-xs:before {
            content: "Off";
            left: 0;
        }
        .btn-toggle.btn-xs:after {
            content: "On";
            right: 0;
            opacity: 0.5;
        }
        .btn-toggle.btn-xs > .handle {
            position: absolute;
            top: 0.125rem;
            left: 0.125rem;
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 0.75rem;
            background: #fff;
            transition: left 0.25s;
        }
        .btn-toggle.btn-xs.active {
            transition: background-color 0.25s;
        }
        .btn-toggle.btn-xs.active > .handle {
            left: 1.125rem;
            transition: left 0.25s;
        }
        .btn-toggle.btn-xs.active:before {
            opacity: 0.5;
        }
        .btn-toggle.btn-xs.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-xs.btn-sm:before,
        .btn-toggle.btn-xs.btn-sm:after {
            line-height: -1rem;
            color: #fff;
            letter-spacing: 0.75px;
            left: 0.275rem;
            width: 1.55rem;
        }
        .btn-toggle.btn-xs.btn-sm:before {
            text-align: right;
        }
        .btn-toggle.btn-xs.btn-sm:after {
            text-align: left;
            opacity: 0;
        }
        .btn-toggle.btn-xs.btn-sm.active:before {
            opacity: 0;
        }
        .btn-toggle.btn-xs.btn-sm.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-xs.btn-xs:before,
        .btn-toggle.btn-xs.btn-xs:after {
            display: none;
        }
        .btn-toggle.btn-secondary {
            color: #6b7381;
            background: #bdc1c8;
        }
        .btn-toggle.btn-secondary:before,
        .btn-toggle.btn-secondary:after {
            color: #6b7381;
        }
        .btn-toggle.btn-secondary.active {
            background-color: #ff8300;
        }

        .table {
            width: 50%;
        }
    </style>
@endsection

@section('page-plugin')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.fn.modal.Constructor.prototype.enforceFocus = function() {};

            $('.summernote').summernote({
                placeholder: 'Email Content',
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
                        sendFile(files[0], $(this).attr('id'));
                    },
                    onMediaDelete: function(target){
                        var name = target[0].src;
                        token = "<?php echo csrf_token(); ?>";
                        $.ajax({
                            type: 'post',
                            data: 'filename='+name+'&_token='+token,
                            url: "{{url('summernote/picture/delete/fraud-setting')}}",
                            success: function(data){
                                // console.log(data);
                            }
                        });
                    }
                }
            });

            function sendFile(file, id){
                token = "<?php echo csrf_token(); ?>";
                var data = new FormData();
                data.append('image', file);
                data.append('_token', token);
                // document.getElementById('loadingDiv').style.display = "inline";
                $.ajax({
                    url : "{{url('summernote/picture/upload/fraud-setting')}}",
                    data: data,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    success: function(url) {
                        if (url['status'] == "success") {
                            $('#'+id).summernote('editor.saveRange');
                            $('#'+id).summernote('editor.restoreRange');
                            $('#'+id).summernote('editor.focus');
                            $('#'+id).summernote('insertImage', url['result']['pathinfo'], url['result']['filename']);
                        }
                        // document.getElementById('loadingDiv').style.display = "none";
                    },
                    error: function(data){
                        // document.getElementById('loadingDiv').style.display = "none";
                    }
                })
            }

            //For Device ID tab
            divMain('device_id','{{$result[2]['fraud_settings_status']}}')

            @if (isset($result[2]['auto_suspend_status']))
                checkboxAction('checkbox_auto_suspend-device_id')
            @endif

            @if (isset($result[2]['forward_admin_status']))
                checkboxAction('checkbox_forward_admin-device_id')
            @endif

            @if (isset($result[2]['email_toogle']))
                visibleDiv('email', "{{$result[2]['email_toogle']}}",'device_id')
                $('#email_toogle_device_id').val("{{$result[2]['email_toogle']}}")
            @endif

            @if (isset($result[2]['sms_toogle']))
                visibleDiv('sms', "{{$result[2]['sms_toogle']}}",'device_id')
            @endif

            @if (isset($result[2]['whatsapp_toogle']))
                visibleDiv('whatsapp', "{{$result[2]['whatsapp_toogle']}}",'device_id')
            @endif

            //For transaction in day
            divMain('transaction_in_day','{{$result[0]['fraud_settings_status']}}')

            @if (isset($result[0]['auto_suspend_status']))
                checkboxAction('checkbox_auto_suspend-transaction_in_day')
            @endif

            @if (isset($result[0]['forward_admin_status']))
                checkboxAction('checkbox_forward_admin-transaction_in_day')
            @endif

            @if (isset($result[0]['email_toogle']))
                visibleDiv('email', "{{$result[0]['email_toogle']}}",'transaction_in_day')
                $('#email_toogle_transaction_in_day').val("{{$result[0]['email_toogle']}}")
            @endif

            @if (isset($result[0]['sms_toogle']))
                visibleDiv('sms', "{{$result[0]['sms_toogle']}}",'transaction_in_day')
            @endif

            @if (isset($result[0]['whatsapp_toogle']))
                visibleDiv('whatsapp', "{{$result[0]['whatsapp_toogle']}}",'transaction_in_day')
            @endif

            //For transaction in week
            divMain('transaction_in_week','{{$result[1]['fraud_settings_status']}}')

            @if (isset($result[1]['auto_suspend_status']))
                checkboxAction('checkbox_auto_suspend-transaction_in_week')
            @endif

            @if (isset($result[1]['forward_admin_status']))
                checkboxAction('checkbox_forward_admin-transaction_in_week')
            @endif

            @if (isset($result[1]['email_toogle']))
                visibleDiv('email', "{{$result[1]['email_toogle']}}",'transaction_in_week')
                $('#email_toogle_transaction_in_week').val("{{$result[1]['email_toogle']}}")
            @endif

            @if (isset($result[1]['sms_toogle']))
                visibleDiv('sms', "{{$result[1]['sms_toogle']}}",'transaction_in_week')
            @endif

            @if (isset($result[1]['whatsapp_toogle']))
                visibleDiv('whatsapp', "{{$result[1]['whatsapp_toogle']}}",'transaction_in_week')
            @endif

            //For transaction point
            divMain('transaction_point','{{$result[4]['fraud_settings_status']}}')

            @if (isset($result[4]['auto_suspend_status']))
            checkboxAction('checkbox_auto_suspend-transaction_point')
            @endif

            @if (isset($result[4]['forward_admin_status']))
            checkboxAction('checkbox_forward_admin-transaction_point')
            @endif

            @if (isset($result[4]['email_toogle']))
            visibleDiv('email', "{{$result[4]['email_toogle']}}",'transaction_point')
            $('#email_toogle_transaction_point').val("{{$result[4]['email_toogle']}}")
            @endif

            @if (isset($result[4]['sms_toogle']))
            visibleDiv('sms', "{{$result[4]['sms_toogle']}}",'transaction_point')
            @endif

            @if (isset($result[4]['whatsapp_toogle']))
            visibleDiv('whatsapp', "{{$result[4]['whatsapp_toogle']}}",'transaction_point')
            @endif

            //For transaction between
            divMain('transaction_in_between','{{$result[3]['fraud_settings_status']}}')

            @if (isset($result[3]['auto_suspend_status']))
            checkboxAction('checkbox_auto_suspend-transaction_in_between')
            @endif

            @if (isset($result[3]['forward_admin_status']))
            checkboxAction('checkbox_forward_admin-transaction_in_between')
            @endif

            @if (isset($result[3]['email_toogle']))
            visibleDiv('email', "{{$result[3]['email_toogle']}}",'transaction_in_between')
            $('#email_toogle_transaction_in_between').val("{{$result[3]['email_toogle']}}")
            @endif

            @if (isset($result[3]['sms_toogle']))
            visibleDiv('sms', "{{$result[3]['sms_toogle']}}",'transaction_in_between')
            @endif

            @if (isset($result[3]['whatsapp_toogle']))
            visibleDiv('whatsapp', "{{$result[3]['whatsapp_toogle']}}",'transaction_in_between')
            @endif

            //For check promo code
            divMain('check_promo_code','{{$result[5]['fraud_settings_status']}}')

            @if (isset($result[5]['auto_suspend_status']))
            checkboxAction('checkbox_auto_suspend-check_promo_code')
            @endif

            @if (isset($result[5]['forward_admin_status']))
            checkboxAction('checkbox_forward_admin-check_promo_code')
            @endif

            @if (isset($result[5]['email_toogle']))
            visibleDiv('email', "{{$result[5]['email_toogle']}}",'check_promo_code')
            $('#email_toogle_transaction_in_between').val("{{$result[5]['email_toogle']}}")
            @endif

            @if (isset($result[5]['sms_toogle']))
            visibleDiv('sms', "{{$result[5]['sms_toogle']}}",'check_promo_code')
            @endif

            @if (isset($result[5]['whatsapp_toogle']))
            visibleDiv('whatsapp', "{{$result[5]['whatsapp_toogle']}}",'check_promo_code')
            @endif

            //For check referral
            divMain('referral','{{$result[6]['fraud_settings_status']}}')
            @if (isset($result[6]['auto_suspend_status']))
            checkboxAction('checkbox_auto_suspend-referral')
            @endif
            @if (isset($result[6]['forward_admin_status']))
            checkboxAction('checkbox_forward_admin-referral')
            @endif
            @if (isset($result[6]['email_toogle']))
            visibleDiv('email', "{{$result[6]['email_toogle']}}",'referral')
            $('#email_toogle_transaction_in_between').val("{{$result[6]['email_toogle']}}")
            @endif
            @if (isset($result[6]['sms_toogle']))
            visibleDiv('sms', "{{$result[6]['sms_toogle']}}",'referral')
            @endif
            @if (isset($result[6]['whatsapp_toogle']))
            visibleDiv('whatsapp', "{{$result[6]['whatsapp_toogle']}}",'referral')
            @endif

            //For check referral user
            divMain('check_referral_user','{{$result[7]['fraud_settings_status']}}')

            @if (isset($result[7]['auto_suspend_status']))
            checkboxAction('checkbox_auto_suspend-check_referral_user')
            @endif

            @if (isset($result[7]['forward_admin_status']))
            checkboxAction('checkbox_forward_admin-check_referral_user')
            @endif

            @if (isset($result[7]['email_toogle']))
            visibleDiv('email', "{{$result[7]['email_toogle']}}",'check_referral_user')
            $('#email_toogle_transaction_in_between').val("{{$result[7]['email_toogle']}}")
            @endif

            @if (isset($result[7]['sms_toogle']))
            visibleDiv('sms', "{{$result[7]['sms_toogle']}}",'check_referral_user')
            @endif

            @if (isset($result[7]['whatsapp_toogle']))
            visibleDiv('whatsapp', "{{$result[7]['whatsapp_toogle']}}",'check_referral_user')
            @endif
        });

        function divMain(element_id,status){
            if(status == 'Active'){
                document.getElementById('div_main_'+element_id).style.display = 'block';
            }else{
                document.getElementById('div_main_'+element_id).style.display = 'none';
                $('.field_'+element_id).prop('required', false);
                $('.field_email_'+element_id).prop('required', false);
                $('.field_sms_'+element_id).prop('required', false);
                $('.field_whatsapp_'+element_id).prop('required', false);
            }
        }

        function addEmailContent(param,type){
            var id = type;
            var textvalue = $('#email_content_'+id).val();

            var textvaluebaru = textvalue+" "+param;
            $('#email_content_'+id).val(textvaluebaru);
            $('#email_content_'+id).summernote('editor.saveRange');
            $('#email_content_'+id).summernote('editor.restoreRange');
            $('#email_content_'+id).summernote('editor.focus');
            $('#email_content_'+id).summernote('editor.insertText', param);
        }

        function addEmailSubject(param, type){
            var id = type;
            var textvalue = $('#email_subject_'+id).val();
            var textvaluebaru = textvalue+" "+param;
            $('#email_subject_'+id).val(textvaluebaru);
        }

        function addSmsContent(param, type){
            var id = type;
            var textvalue = $('#sms_content_'+id).val();
            var textvaluebaru = textvalue+" "+param;
            $('#sms_content_'+id).val(textvaluebaru);
        }

        function addWhatsappContent(para, type){
            var id = type;
            var textvalue = $('#whatsapp_content_'+id).val();
            var textvaluebaru = textvalue+" "+param;
            $('#whatsapp_content_'+id).val(textvaluebaru);
        }

        function visibleDiv(apa,nilai,type){
            var id = type;

            if(apa == 'email'){
                @if(MyHelper::hasAccess([38], $configs))
                if(nilai=='1'){
                    document.getElementById('div_email_recipient_'+id).style.display = 'block';
                    document.getElementById('div_email_subject_'+id).style.display = 'block';
                    document.getElementById('div_email_content_'+id).style.display = 'block';
                    $('.field_email_'+id).prop('required', true);
                } else {
                    document.getElementById('div_email_recipient_'+id).style.display = 'none';
                    document.getElementById('div_email_subject_'+id).style.display = 'none';
                    document.getElementById('div_email_content_'+id).style.display = 'none';
                    $('.field_email_'+id).prop('required', false);
                }
                @endif
            }
            if(apa == 'sms'){
                @if(MyHelper::hasAccess([39], $configs))
                if(nilai=='1'){
                    document.getElementById('div_sms_content_'+id).style.display = 'block';
                    document.getElementById('div_sms_recipient_'+id).style.display = 'block';
                    $('.field_sms_'+id).prop('required', true);
                } else {
                    document.getElementById('div_sms_content_'+id).style.display = 'none';
                    document.getElementById('div_sms_recipient_'+id).style.display = 'none';
                    $('.field_sms_'+id).prop('required', false);
                }
                @endif
            }

            if(apa == 'whatsapp'){
                @if(MyHelper::hasAccess([74], $configs))
                        @if($api_key_whatsapp)
                if(nilai=='1'){
                    document.getElementById('div_whatsapp_content_'+id).style.display = 'block';
                    document.getElementById('div_whatsapp_recipient_'+id).style.display = 'block';
                    $('.field_whatsapp_'+id).prop('required', true);
                } else {
                    document.getElementById('div_whatsapp_content_'+id).style.display = 'none';
                    document.getElementById('div_whatsapp_recipient_'+id).style.display = 'none';
                    $('.field_whatsapp_'+id).prop('required', false);
                }
                @endif
                @endif
            }
        }

        function checkboxAction(id){
            var replace = id.replace('checkbox', "");
            var div_id = 'div'+replace;
            var split = id.split("-");

            if($('#' + id).is(":checked")){
                if(document.getElementById(div_id)) {
                    document.getElementById(div_id).style.display = 'block';
                }
                if(id.indexOf('forward_admin') < 0){
                    $('.field_'+split[1]).prop('required', true);
                }
            }else{
                if(document.getElementById(div_id)){
                    document.getElementById(div_id).style.display = 'none';
                    if (id.indexOf('forward_admin') >= 0) {
                        $('.field_email_' + split[1]).prop('required', false);
                        $('.field_sms_' + split[1]).prop('required', false);
                        $('.field_whatsapp_' + split[1]).prop('required', false);
                    } else {
                        $('.field_' + split[1]).prop('required', false);
                    }
                }
            }
        }

        $('.checkbox').on('ifChanged', function(event) {
            var id = this.id;
            var replace = id.replace('checkbox', "");
            var div_id = 'div'+replace;
            var split = id.split("-");

            if($('#' + this.id).is(":checked")){
                if(document.getElementById(div_id)){
                    document.getElementById(div_id).style.display = 'block';
                }

                if(id.indexOf('forward_admin') < 0){
                    $('.field_'+split[1]).prop('required', true);
                }
            }else{
                if(document.getElementById(div_id)){
                    document.getElementById(div_id).style.display = 'none';
                    if(id.indexOf('forward_admin') >= 0){
                        $('.field_email_'+split[1]).prop('required', false);
                        $('.field_sms_'+split[1]).prop('required', false);
                        $('.field_whatsapp_'+split[1]).prop('required', false);
                    }else{
                        $('.field_'+split[1]).prop('required', false);
                    }
                }
            }
        });

        $('.switch').on('click', function(e){
            var state = $(this).attr('aria-pressed');
            var id_fraud_settings = $(this).attr('data-id');
            var id = this.id;
            var split = id.split('-');
            var token  = "{{ csrf_token() }}";
            if(state === 'false'){
                state = 'Active'
            }else{
                state = 'Inactive'
            }

            $.ajax({
                type : "POST",
                url : "{{ url('setting-fraud-detection/update/status') }}",
                data : "_token="+token+"&id_fraud_setting="+id_fraud_settings+"&fraud_settings_status="+state,
                success : function(result) {
                    if (result.status == "success") {
                        toastr.info("Fraud status has been updated.");
                        if(state == 'Active'){
                            document.getElementById('div_main_'+split[2]).style.display = 'block';
                        }else{
                            document.getElementById('div_main_'+split[2]).style.display = 'none';
                            $('.field_'+split[2]).prop('required', false);
                            $('.field_email_'+split[2]).prop('required', false);
                            $('.field_sms_'+split[2]).prop('required', false);
                            $('.field_whatsapp_'+split[2]).prop('required', false);
                        }
                    }
                    else {
                        toastr.warning(result.messages);
                    }
                },
                error: function (jqXHR, exception) {
                    toastr.warning('Failed update status');
                }
            });
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
        <div class="tab-pane">
            <div class="row">
                <div class="col-md-3">
                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                        <li class=" @if(!isset($tipe)) active @endif">
                            <a data-toggle="tab" href="#fraud_device"><i class="fa fa-cog"></i> Device </a>
                        </li>
                        <li class=" @if(isset($tipe) && $tipe == 'fraud_transaction_point') active @endif">
                            <a data-toggle="tab" href="#fraud_transaction_point"><i class="fa fa-cog"></i> Transaction Point </a>
                        </li>
                        <li class=" @if(isset($tipe) && $tipe == 'fraud_transaction_in_day') active @endif">
                            <a data-toggle="tab" href="#fraud_transaction_in_day"><i class="fa fa-cog"></i> Transaction in day </a>
                        </li>
                        <li class=" @if(isset($tipe) && $tipe == 'fraud_transaction_in_week') active @endif">
                            <a data-toggle="tab" href="#fraud_transaction_in_week"><i class="fa fa-cog"></i> Transaction in week </a>
                        </li>
                        <li class=" @if(isset($tipe) && $tipe == 'fraud_transaction_in_between') active @endif">
                            <a data-toggle="tab" href="#fraud_transaction_in_between"><i class="fa fa-cog"></i> Transaction in between </a>
                        </li>
                        <li class=" @if(isset($tipe) && $tipe == 'fraud_check_promo_code') active @endif">
                            <a data-toggle="tab" href="#fraud_check_promo_code"><i class="fa fa-cog"></i> Check Promo Code </a>
                        </li>
                        <li class=" @if(isset($tipe) && $tipe == 'fraud_check_referral_user') active @endif">
                            <a data-toggle="tab" href="#fraud_check_referral_user"><i class="fa fa-cog"></i> Check Referral User </a>
                        </li>
                        <li class=" @if(isset($tipe) && $tipe == 'fraud_referral') active @endif">
                            <a data-toggle="tab" href="#fraud_referral"><i class="fa fa-cog"></i> Check Referral </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane @if(!isset($tipe)) active @endif" id="fraud_device">
                            @include('settingfraud::form_fraud_device')
                        </div>
                        <div class="tab-pane @if(isset($tipe) && $tipe == 'fraud_transaction_point') active @endif" id="fraud_transaction_point">
                            @include('settingfraud::form_fraud_transaction_point')
                        </div>
                        <div class="tab-pane @if(isset($tipe) && $tipe == 'fraud_transaction_in_day') active @endif" id="fraud_transaction_in_day">
                            @include('settingfraud::form_fraud_transaction_day')
                        </div>

                        <div class="tab-pane @if(isset($tipe) && $tipe == 'fraud_transaction_in_week') active @endif" id="fraud_transaction_in_week">
                            @include('settingfraud::form_fraud_transaction_week')
                        </div>

                        <div class="tab-pane @if(isset($tipe) && $tipe == 'fraud_transaction_in_between') active @endif" id="fraud_transaction_in_between">
                            @include('settingfraud::form_fraud_transaction_in_between')
                        </div>

                        <div class="tab-pane @if(isset($tipe) && $tipe == 'fraud_check_promo_code') active @endif" id="fraud_check_promo_code">
                            @include('settingfraud::form_fraud_check_promo_code')
                        </div>

                        <div class="tab-pane @if(isset($tipe) && $tipe == 'fraud_check_referral_user') active @endif" id="fraud_check_referral_user">
                            @include('settingfraud::form_fraud_check_referral_user')
                        </div>

                        <div class="tab-pane @if(isset($tipe) && $tipe == 'fraud_referral') active @endif" id="fraud_referral">
                            @include('settingfraud::form_fraud_referral')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection