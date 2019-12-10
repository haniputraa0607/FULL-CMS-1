<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs    		= session('configs');
?>
@extends('layouts.main')

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

            @if (isset($result[0]['auto_suspend_status']))
                checkboxAction('checkbox_auto_suspend-transaction_in_week')
            @endif

            @if (isset($result[0]['forward_admin_status']))
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
            if(type === 'device_id'){
                var textvalue = $('#email_content_device_id').val();

                var textvaluebaru = textvalue+" "+param;
                $('#email_content_device_id').val(textvaluebaru);
                $('#email_content_device_id').summernote('editor.saveRange');
                $('#email_content_device_id').summernote('editor.restoreRange');
                $('#email_content_device_id').summernote('editor.focus');
                $('#email_content_device_id').summernote('editor.insertText', param);
            }else if(type === 'transaction_in_day'){
                var textvalue = $('#email_content_transaction_in_day').val();

                var textvaluebaru = textvalue+" "+param;
                $('#email_content_transaction_in_day').val(textvaluebaru);
                $('#email_content_transaction_in_day').summernote('editor.saveRange');
                $('#email_content_transaction_in_day').summernote('editor.restoreRange');
                $('#email_content_transaction_in_day').summernote('editor.focus');
                $('#email_content_transaction_in_day').summernote('editor.insertText', param);
            }else if(type === 'transaction_in_week'){
                var textvalue = $('#email_content_transaction_in_week').val();

                var textvaluebaru = textvalue+" "+param;
                $('#email_content_transaction_in_week').val(textvaluebaru);
                $('#email_content_transaction_in_week').summernote('editor.saveRange');
                $('#email_content_transaction_in_week').summernote('editor.restoreRange');
                $('#email_content_transaction_in_week').summernote('editor.focus');
                $('#email_content_transaction_in_week').summernote('editor.insertText', param);
            }

        }

        function addEmailSubject(param, type){
            if(type === 'device_id'){
                var textvalue = $('#email_subject_device_id').val();
                var textvaluebaru = textvalue+" "+param;
                $('#email_subject_device_id').val(textvaluebaru);
            }else if(type === 'transaction_in_day'){
                var textvalue = $('#email_subject_transaction_in_day').val();
                var textvaluebaru = textvalue+" "+param;
                $('#email_subject_transaction_in_day').val(textvaluebaru);
            }else if(type === 'transaction_in_week'){
                var textvalue = $('#email_subject_transaction_in_week').val();
                var textvaluebaru = textvalue+" "+param;
                $('#email_subject_transaction_in_week').val(textvaluebaru);
            }
        }

        function addSmsContent(param, type){
            if(type === 'device_id'){
                var textvalue = $('#sms_content_device_id').val();
                var textvaluebaru = textvalue+" "+param;
                $('#sms_content_device_id').val(textvaluebaru);
            }else if(type === 'transaction_in_day'){
                var textvalue = $('#sms_content_transaction_in_day').val();
                var textvaluebaru = textvalue+" "+param;
                $('#sms_content_transaction_in_day').val(textvaluebaru);
            }else if(type === 'transaction_in_week'){
                var textvalue = $('#sms_content_transaction_in_week').val();
                var textvaluebaru = textvalue+" "+param;
                $('#sms_content_transaction_in_week').val(textvaluebaru);
            }
        }

        function addWhatsappContent(para, type){
            if(type === 'device_id'){
                var textvalue = $('#whatsapp_content_device_id').val();
                var textvaluebaru = textvalue+" "+param;
                $('#whatsapp_content_device_id').val(textvaluebaru);
            }else if(type === 'transaction_in_day'){
                var textvalue = $('#whatsapp_content_transaction_in_day').val();
                var textvaluebaru = textvalue+" "+param;
                $('#whatsapp_content_transaction_in_day').val(textvaluebaru);
            }else if(type === 'transaction_in_week'){
                var textvalue = $('#whatsapp_content_transaction_in_week').val();
                var textvaluebaru = textvalue+" "+param;
                $('#whatsapp_content_transaction_in_week').val(textvaluebaru);
            }
        }

        function visibleDiv(apa,nilai,type){
            if(type === 'device_id'){
                if(apa == 'email'){
                    @if(MyHelper::hasAccess([38], $configs))
                    if(nilai=='1'){
                        document.getElementById('div_email_recipient_device_id').style.display = 'block';
                        document.getElementById('div_email_subject_device_id').style.display = 'block';
                        document.getElementById('div_email_content_device_id').style.display = 'block';
                        $('.field_email_device_id').prop('required', true);
                    } else {
                        document.getElementById('div_email_recipient_device_id').style.display = 'none';
                        document.getElementById('div_email_subject_device_id').style.display = 'none';
                        document.getElementById('div_email_content_device_id').style.display = 'none';
                        $('.field_email_device_id').prop('required', false);
                    }
                    @endif
                }
                if(apa == 'sms'){
                    @if(MyHelper::hasAccess([39], $configs))
                    if(nilai=='1'){
                        document.getElementById('div_sms_content_device_id').style.display = 'block';
                        document.getElementById('div_sms_recipient_device_id').style.display = 'block';
                        $('.field_sms_devie_id').prop('required', true);
                    } else {
                        document.getElementById('div_sms_content_device_id').style.display = 'none';
                        document.getElementById('div_sms_recipient_device_id').style.display = 'none';
                        $('.field_sms_devie_id').prop('required', false);
                    }
                    @endif
                }

                if(apa == 'whatsapp'){
                    @if(MyHelper::hasAccess([74], $configs))
                            @if($api_key_whatsapp)
                    if(nilai=='1'){
                        document.getElementById('div_whatsapp_content_devie_id').style.display = 'block';
                        document.getElementById('div_whatsapp_recipient_device_id').style.display = 'block';
                        $('.field_whatsapp_device_id').prop('required', true);
                    } else {
                        document.getElementById('div_whatsapp_content_devie_id').style.display = 'none';
                        document.getElementById('div_whatsapp_recipient_device_id').style.display = 'none';
                        $('.field_whatsapp_device_id').prop('required', false);
                    }
                    @endif
                    @endif
                }
            }else if(type === 'transaction_in_day'){
                if(apa == 'email'){
                    @if(MyHelper::hasAccess([38], $configs))
                    if(nilai=='1'){
                        document.getElementById('div_email_recipient_transaction_in_day').style.display = 'block';
                        document.getElementById('div_email_subject_transaction_in_day').style.display = 'block';
                        document.getElementById('div_email_content_transaction_in_day').style.display = 'block';
                        $('.field_email_transaction_in_day').prop('required', true);
                    } else {
                        document.getElementById('div_email_recipient_transaction_in_day').style.display = 'none';
                        document.getElementById('div_email_subject_transaction_in_day').style.display = 'none';
                        document.getElementById('div_email_content_transaction_in_day').style.display = 'none';
                        $('.field_email_transaction_in_day').prop('required', false);
                    }
                    @endif
                }
                if(apa == 'sms'){
                    @if(MyHelper::hasAccess([39], $configs))
                    if(nilai=='1'){
                        document.getElementById('div_sms_content_transaction_in_day').style.display = 'block';
                        document.getElementById('div_sms_recipient_transaction_in_day').style.display = 'block';
                        $('.field_sms_transaction_in_day').prop('required', true);
                    } else {
                        document.getElementById('div_sms_content_transaction_in_day').style.display = 'none';
                        document.getElementById('div_sms_recipient_transaction_in_day').style.display = 'none';
                        $('.field_sms_transaction_in_day').prop('required', false);
                    }
                    @endif
                }

                if(apa == 'whatsapp'){
                    @if(MyHelper::hasAccess([74], $configs))
                        @if($api_key_whatsapp)
                        if(nilai=='1'){
                            document.getElementById('div_whatsapp_content_transaction_in_day').style.display = 'block';
                            document.getElementById('div_whatsapp_recipient_transaction_in_day').style.display = 'block';
                            $('.field_whatsapp_transaction_in_day').prop('required', true);
                        } else {
                            document.getElementById('div_whatsapp_content_transaction_in_day').style.display = 'none';
                            document.getElementById('div_whatsapp_recipient_transaction_in_day').style.display = 'none';
                            $('.field_whatsapp_transaction_in_day').prop('required', false);
                        }
                        @endif
                    @endif
                }
            }else if(type === 'transaction_in_week'){
                if(apa == 'email'){
                    @if(MyHelper::hasAccess([38], $configs))
                    if(nilai=='1'){
                        document.getElementById('div_email_recipient_transaction_in_week').style.display = 'block';
                        document.getElementById('div_email_subject_transaction_in_week').style.display = 'block';
                        document.getElementById('div_email_content_transaction_in_week').style.display = 'block';
                        $('.field_email_transaction_in_week').prop('required', true);
                    } else {
                        document.getElementById('div_email_recipient_transaction_in_week').style.display = 'none';
                        document.getElementById('div_email_subject_transaction_in_week').style.display = 'none';
                        document.getElementById('div_email_content_transaction_in_week').style.display = 'none';
                        $('.field_email_transaction_in_week').prop('required', false);
                    }
                    @endif
                }
                if(apa == 'sms'){
                    @if(MyHelper::hasAccess([39], $configs))
                    if(nilai=='1'){
                        document.getElementById('div_sms_content_transaction_in_week').style.display = 'block';
                        document.getElementById('div_sms_recipient_transaction_in_week').style.display = 'block';
                        $('.field_sms_transaction_in_week').prop('required', true);
                    } else {
                        document.getElementById('div_sms_content_transaction_in_week').style.display = 'none';
                        document.getElementById('div_sms_recipient_transaction_in_week').style.display = 'none';
                        $('.field_sms_transaction_in_week').prop('required', false);
                    }
                    @endif
                }

                if(apa == 'whatsapp'){
                    @if(MyHelper::hasAccess([74], $configs))
                        @if($api_key_whatsapp)
                        if(nilai=='1'){
                            document.getElementById('div_whatsapp_content_transaction_in_week').style.display = 'block';
                            document.getElementById('div_whatsapp_recipient_transaction_in_week').style.display = 'block';
                            $('.field_whatsapp_transaction_in_week').prop('required', true);
                        } else {
                            document.getElementById('div_whatsapp_content_transaction_in_week').style.display = 'none';
                            document.getElementById('div_whatsapp_recipient_transaction_in_week').style.display = 'none';
                            $('.field_whatsapp_transaction_in_week').prop('required', false);
                        }
                        @endif
                    @endif
                }
            }
        }

        function checkboxAction(id){
            var replace = id.replace('checkbox', "");
            var div_id = 'div'+replace;
            var split = id.split("-");

            if($('#' + id).is(":checked")){
                document.getElementById(div_id).style.display = 'block';
                if(id.indexOf('forward_admin') < 0){
                    $('.field_'+split[1]).prop('required', true);
                }
            }else{
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

        $('.checkbox').on('ifChanged', function(event) {
            var id = this.id;
            var replace = id.replace('checkbox', "");
            var div_id = 'div'+replace;
            var split = id.split("-");

            if($('#' + this.id).is(":checked")){
                document.getElementById(div_id).style.display = 'block';

                if(id.indexOf('forward_admin') < 0){
                    $('.field_'+split[1]).prop('required', true);
                }
            }else{
                document.getElementById(div_id).style.display = 'none';
                if(id.indexOf('forward_admin') >= 0){
                    $('.field_email_'+split[1]).prop('required', false);
                    $('.field_sms_'+split[1]).prop('required', false);
                    $('.field_whatsapp_'+split[1]).prop('required', false);
                }else{
                    $('.field_'+split[1]).prop('required', false);
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
                        console.log(state);
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

    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gear"></i>{{$sub_title}}</div>
            <div class="tools">
                <a href="javascript:;" class="collapse"> </a>
            </div>
        </div>
        <div class="portlet-body">
            <p>Setting Fraud Detection memiliki 3 tipe yaitu :</p>
            <ul>
                <li>Device : mengatur maksimal akun yang dapat digunakan dalam 1 device ID. Jika user sudah terkena fraud maka akan otomatis tidak bisa masuk.</li>
                <li>Transaction in day : maksimal jumlah transaksi yang diperbolehkan dalam 1 hari untuk semua user</li>
                <li>Transaction in week : mengatur maksimal jumlah transaksi yang diperbolehkan  dalam 1 minggu untuk semua user </li>
            </ul>
            <p>Anda bisa memberikan action untuk setiap tipe, action dibagi menjadi 2 yaitu :</p>
            <ul>
                <li>Auto Suspend : jika user melakukan pelanggaran sesuai dengan aturan yang ada maka account tersebut akan secara otomatis disaspend</li>
                <li>Forward Admin : jika user melakukan pelanggaran sesuai dengan aturan yang ada maka akan mengirimkan notifikasi keadmin  </li>
            </ul>
        </div>
    </div>
    <div class="portlet-body">
        <div class="tabbable-line tabbable-full-width">
            <ul class="nav nav-tabs">
                <li class=" @if(!isset($tipe)) active @endif">
                    <a href="#fraud_device" data-toggle="tab"> Device</a>
                </li>
                <li class=" @if(isset($tipe) && $tipe == 'fraud_transaction_in_day') active @endif">
                    <a href="#fraud_transaction_in_day" data-toggle="tab"> Transaction in day </a>
                </li>
                <li class=" @if(isset($tipe) && $tipe == 'fraud_transaction_in_week') active @endif">
                    <a href="#fraud_transaction_in_week" data-toggle="tab"> Transaction in week </a>
                </li>
            </ul>
        </div>
        <div class="tab-content" style="margin-top:20px">
            <div class="tab-pane @if(!isset($tipe)) active @endif" id="fraud_device">
                <form role="form" class="form-horizontal" action="{{url()->current()}}" method="POST" enctype="multipart/form-data" id="form">
                    <br>
                    <div class="form-group">
                        <div class="col-md-4" style="margin-left: 2.5%;margin-top: 7px;">
                            <button type="button" class="btn btn-lg btn-toggle switch @if($result[2]['fraud_settings_status'] == 'Active')active @endif" id="switch-change-device_id" data-id="{{ $result[2]['id_fraud_setting'] }}" data-toggle="button" aria-pressed="<?=($result[2]['fraud_settings_status'] == 'Active' ? 'true' : 'false')?>" autocomplete="off">
                                <div class="handle"></div>
                            </button>
                        </div>
                    </div>
                    <div id="div_main_device_id">
                        <div class="portlet light bordered" id="trigger">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-dark sbold uppercase font-yellow">Parameter</span>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Fraud Detection Parameter <i class="fa fa-question-circle tooltips" data-original-title="fraud terjadi ketika device ID digunakan melebihi jumlah maximum account yang sudah ditentukan" data-container="body"></i></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="parameter_detail" value="{{$result[2]['parameter']}}" disabled>
                                    </div>
                                </div>

                                <div class="form-group" id="type-detail" >
                                    <label class="col-md-4 control-label" ></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
									<span class="input-group-addon">
										maximum
									</span>
                                            <input type="number" class="form-control price" min="1" name="parameter_detail" value="{{$result[2]['parameter_detail']}}">
                                            <span class="input-group-addon">
										Account
									</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-dark sbold uppercase font-yellow">Action</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="icheck-list">
                                    <label>
                                        <input type="checkbox" class="icheck checkbox" name="auto_suspend_status" id="checkbox_auto_suspend-device_id" data-checkbox="icheckbox_square-blue" @if(isset($result[2]['auto_suspend_status']) && $result[2]['auto_suspend_status'] == "1") checked @endif> Auto Suspend
                                    </label>
                                    <div class="portlet light bordered" id="div_auto_suspend-device_id" style="margin-bottom: 2%;display: none;">
                                        <div class="portlet-title tabbable-line">
                                            <div class="caption font-green">
                                                <i class="icon-settings font-green"></i>
                                                <span class="caption-subject bold uppercase"> Auto Suspend </span>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-body">
                                                <div class="input-group">
                                                    <div class="icheck-inline">
                                                        <label>
                                                            <input type="radio" name="auto_suspend_value" class="icheck" data-radio="iradio_square-red" @if(isset($result[2]['auto_suspend_value']) && $result[2]['auto_suspend_value'] == "last_login") checked @endif value="last_login"> Last account login
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="auto_suspend_value" class="icheck" data-radio="iradio_square-red" @if(isset($result[2]['auto_suspend_value']) && $result[2]['auto_suspend_value'] == "all_account") checked @endif value="all_account"> All account
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <label>
                                        <input type="checkbox" class="icheck checkbox" name="forward_admin_status" id="checkbox_forward_admin-device_id" data-checkbox="icheckbox_square-blue" @if(isset($result[2]['forward_admin_status']) && $result[2]['forward_admin_status'] == "1") checked @endif> Forward Admin
                                    </label>
                                    <div class="portlet light bordered" id="div_forward_admin-device_id" style="margin-bottom: 2%;display: none;">
                                        <div class="portlet-title tabbable-line">
                                            <div class="caption font-green">
                                                <i class="icon-settings font-green"></i>
                                                <span class="caption-subject bold uppercase"> Forward Admin </span>
                                            </div>
                                        </div>
                                        <div class="portlet-body form">
                                            <div class="form-body">
                                                @if(MyHelper::hasAccess([38], $configs))
                                                    <h4>Email</h4>
                                                    <div class="form-group">
                                                        <div class="input-icon right">
                                                            <label class="col-md-3 control-label">
                                                                Status
                                                                <i class="fa fa-question-circle tooltips" data-original-title="pilih enabled untuk mengaktifkan email sebagai media pengiriman laporan fraud detection" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <select name="email_toogle" id="email_toogle_device_id" class="form-control select2" onChange="visibleDiv('email',this.value, 'device_id')">
                                                                <option value="0" @if(old('email_toogle') == '0') selected @else @if(isset($result[2]['email_toogle']) && $result[2]['email_toogle'] == "0") selected @endif @endif>Disabled</option>
                                                                <option value="1" @if(old('email_toogle') == '1') selected @else @if(isset($result[2]['email_toogle']) && $result[2]['email_toogle'] == "1") selected @endif @endif>Enabled</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group" id="div_email_recipient_device_id" style="display:none">
                                                        <div class="input-icon right">
                                                            <label for="multiple" class="control-label col-md-3">
                                                                Email Recipient
                                                                <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan alamat email admin yang akan menerima laporan fraud detection, jika lebih dari 1 pisahkan dengan tanda koma (,)" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <textarea name="email_recipient" id="email_recipient" class="form-control field_email_device_id" placeholder="Email address recipient">@if(isset($result[2]['email_recipient'])){{ $result[2]['email_recipient'] }}@endif</textarea>
                                                            <p class="help-block">Comma ( , ) separated for multiple emails</p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group" id="div_email_subject_device_id" style="display:none">
                                                        <div class="input-icon right">
                                                            <label class="col-md-3 control-label">
                                                                Subject
                                                                <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan subjek email, tambahkan text replacer bila perlu" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" placeholder="Email Subject" class="form-control field_email_device_id" name="email_subject" id="email_subject_device_id" @if(!empty(old('email_subject'))) value="{{old('email_subject')}}" @else @if(isset($result[2]['email_subject']) && $result[2]['email_subject'] != '') value="{{$result[2]['email_subject']}}" @endif @endif>
                                                            <br>
                                                            You can use this variables to display user personalized information:
                                                            <br><br>
                                                            <div class="row">
                                                                @foreach($textreplaces_device as $key=>$row)
                                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                                        <span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailSubject('{{ $row['keyword'] }}','device_id');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="div_email_content_device_id" style="display:none">
                                                        <div class="input-icon right">
                                                            <label for="multiple" class="control-label col-md-3">
                                                                Content
                                                                <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten email, tambahkan text replacer bila perlu" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <textarea name="email_content" id="email_content_device_id" class="form-control summernote">@if(!empty(old('email_content'))) <?php echo old('email_content'); ?> @else @if(isset($result[2]['email_content']) && $result[2]['email_content'] != '') <?php echo $result[2]['email_content'];?> @endif @endif</textarea>
                                                            You can use this variables to display user personalized information:
                                                            <br><br>
                                                            <div class="row" >
                                                                @foreach($textreplaces_device as $key=>$row)
                                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                                        <span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailContent('{{ $row['keyword'] }}','device_id');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                @endif
                                                @if(MyHelper::hasAccess([39], $configs))
                                                    <h4>SMS</h4>
                                                    <div class="form-group" >
                                                        <div class="input-icon right">
                                                            <label class="col-md-3 control-label">
                                                                Status
                                                                <i class="fa fa-question-circle tooltips" data-original-title="pilih enabled untuk mengaktifkan sms sebagai media pengiriman auto crm ini" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <select name="sms_toogle" id="sms_toogle" class="form-control select2" onChange="visibleDiv('sms',this.value, 'device_id')">
                                                                <option value="0" @if(old('sms_toogle') == '0') selected @else @if(isset($result[2]['sms_toogle']) && $result[2]['sms_toogle'] == "0") selected @endif @endif>Disabled</option>
                                                                <option value="1" @if(old('sms_toogle') == '1') selected @else @if(isset($result[2]['sms_toogle']) && $result[2]['sms_toogle'] == "1") selected @endif @endif>Enabled</option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="div_sms_recipient_device_id" style="display:none">
                                                        <div class="input-icon right">
                                                            <label for="multiple" class="control-label col-md-3">
                                                                SMS Recipient
                                                                <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan no handphone admin yang akan menerima laporan fraud detection, jika lebih dari 1 pisahkan dengan tanda koma (,)" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <textarea name="sms_recipient" id="sms_recipient" class="form-control field_sms_devie_id" placeholder="Phone number recipient">@if(isset($result[2]['sms_recipient'])){{ $result[2]['sms_recipient'] }}@endif</textarea>
                                                            <p class="help-block">Comma ( , ) separated for multiple phone number</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="div_sms_content_device_id" style="display:none">
                                                        <div class="input-icon right">
                                                            <label for="multiple" class="control-label col-md-3">
                                                                SMS Content
                                                                <i class="fa fa-question-circle tooltips" data-original-title="isi pesan sms, tambahkan text replacer bila perlu" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <textarea name="sms_content" id="sms_content_device_id" class="form-control field_sms_devie_id" placeholder="SMS Content">@if(!empty(old('sms_content'))) {{old('sms_content')}} @else @if(isset($result[2]['sms_content']) && $result[2]['sms_content'] != '') {{$result[2]['sms_content']}} @endif @endif</textarea>
                                                            <br>
                                                            You can use this variables to display user personalized information:
                                                            <br><br>
                                                            <div class="row">
                                                                @foreach($textreplaces_device as $key=>$row)
                                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                                        <span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addSmsContent('{{ $row['keyword'] }}','device_id');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                @endif

                                                @if(MyHelper::hasAccess([74], $configs))
                                                    @if(!$api_key_whatsapp)
                                                        <div class="alert alert-warning deteksi-trigger">
                                                            <p> To use WhatsApp channel you have to set the api key in <a href="{{url('setting/whatsapp')}}">WhatsApp Setting</a>. </p>
                                                        </div>
                                                    @endif
                                                    <h4>WhatsApp</h4>
                                                    <div class="form-group">
                                                        <div class="input-icon right">
                                                            <label class="col-md-3 control-label">
                                                                Status
                                                                <i class="fa fa-question-circle tooltips" data-original-title="pilih enabled untuk mengaktifkan whatsApp sebagai media pengiriman auto crm ini" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <select name="whatsapp_toogle" id="whatsapp_toogle" class="form-control select2 field_whatsapp_device_id" onChange="visibleDiv('whatsapp',this.value, 'device_id')" @if(!$api_key_whatsapp) disabled @endif>
                                                                <option value="0" @if(old('whatsapp_toogle') == '0') selected @else @if(isset($result[2]['whatsapp_toogle']) && $result[2]['whatsapp_toogle'] == "0") selected @endif @endif>Disabled</option>
                                                                <option value="1" @if($api_key_whatsapp) @if(old('whatsapp_toogle') == '1') selected @else @if(isset($result[2]['whatsapp_toogle']) && $result[2]['whatsapp_toogle'] == "1") selected @endif @endif @endif>Enabled</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @if($api_key_whatsapp)
                                                        <div class="form-group" id="div_whatsapp_recipient_device_id" style="display:none">
                                                            <div class="input-icon right">
                                                                <label for="multiple" class="control-label col-md-3">
                                                                    WhatsApp Recipient
                                                                    <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan no WhatsApp admin yang akan menerima laporan fraud detection, jika lebih dari 1 pisahkan dengan tanda koma (,)" data-container="body"></i>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <textarea name="whatsapp_recipient" id="whatsapp_recipient" class="form-control field_whatsapp_device_id" placeholder="WhatsApp number recipient">@if(isset($result[2]['whatsapp_recipient'])){{ $result[2]['whatsapp_recipient'] }}@endif</textarea>
                                                                <p class="help-block">Comma ( , ) separated for multiple whatsApp number</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" id="div_whatsapp_content_devie_id" style="display:none">
                                                            <div class="input-icon right">
                                                                <label for="multiple" class="control-label col-md-3">
                                                                    WhatsApp Content
                                                                    <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten whatsapp, tambahkan text replacer bila perlu" data-container="body"></i>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <textarea id="whatsapp_content_device_id" name="whatsapp_content" rows="3" style="white-space: normal" class="form-control whatsapp-content" placeholder="WhatsApp Content">{{$result[2]['whatsapp_content']}}</textarea>
                                                                <br>
                                                                You can use this variables to display user personalized information:
                                                                <br><br>
                                                                <div class="row">
                                                                    @foreach($textreplaces_device as $key=>$row)
                                                                        <div class="col-md-3" style="margin-bottom:5px;">
                                                                            <span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal; height:40px" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addWhatsappContent('{{ $row['keyword'] }}','device_id');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$result[2]['id_fraud_setting']}}" name="id_fraud_setting">
                            <input type="hidden" value="fraud_device_id" name="type">
                            <div class="row" style="text-align: center">
                                <button type="submit" class="btn blue" id="checkBtn">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane @if(isset($tipe) && $tipe == 'fraud_transaction_in_day') active @endif" id="fraud_transaction_in_day">
                <form role="form" class="form-horizontal" action="{{url()->current()}}" method="POST" enctype="multipart/form-data" id="form">
                    <br>
                    <div class="form-group">
                        <div class="col-md-4" style="margin-left: 2.5%;margin-top: 7px;">
                            <button type="button" class="btn btn-lg btn-toggle switch @if($result[0]['fraud_settings_status'] == 'Active')active @endif" id="switch-change-transaction_in_day" data-id="{{ $result[0]['id_fraud_setting'] }}" data-toggle="button" aria-pressed="<?=($result[0]['fraud_settings_status'] == 'Active' ? 'true' : 'false')?>" autocomplete="off">
                                <div class="handle"></div>
                            </button>
                        </div>
                    </div>
                    <div id="div_main_transaction_in_day">
                        <div class="portlet light bordered" id="trigger">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-dark sbold uppercase font-yellow">Parameter</span>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="form-group">
                                    <label class="col-md-4 control-label" >Fraud Detection Parameter <i class="fa fa-question-circle tooltips" data-original-title="fraud terjadi ketika transaction dalam 1 hari melewati jumlah maximum yang sudah di tentukan" data-container="body"></i></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="parameter_detail" value="{{$result[0]['parameter']}}" disabled>
                                    </div>
                                </div>

                                <div class="form-group" id="type-detail" @if(strpos($result[0]['parameter'], 'transaction') === false) style="display:none" @endif>
                                    <label class="col-md-4 control-label" ></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
									<span class="input-group-addon">
										maximum
									</span>
                                            <input type="number" class="form-control price" min="1" name="parameter_detail" value="{{$result[0]['parameter_detail']}}">
                                            <span class="input-group-addon">
										Transactions / @if(strpos($result[0]['parameter'], 'week') !== false) Week @elseif(strpos($result[0]['parameter'], 'day') !== false) Day @endif
									</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-dark sbold uppercase font-yellow">Action</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="icheck-list">
                                    <label>
                                        <input type="checkbox" class="icheck checkbox"  name="auto_suspend_status" id="checkbox_auto_suspend-transaction_in_day" data-checkbox="icheckbox_square-blue" @if(isset($result[0][ 'auto_suspend_status']) && $result[0][ 'auto_suspend_status']=="1" ) checked @endif> Auto Suspend
                                    </label>
                                    <div class="portlet light bordered" id="div_auto_suspend-transaction_in_day" style="margin-bottom: 2%;display: none;">
                                        <div class="portlet-title tabbable-line">
                                            <div class="caption font-green">
                                                <i class="icon-settings font-green"></i>
                                                <span class="caption-subject bold uppercase"> Auto Suspend </span>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group" >
                                                        <div class="input-icon right">
                                                            <label class="col-md-6 control-label">
                                                                Number of violations
                                                                <i class="fa fa-question-circle tooltips" data-original-title="maksimum jumlah pelanggaran" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    maximum
                                                                </span>
                                                                <input type="number" class="form-control field_transaction_in_week price" min="1" name="auto_suspend_value" value="{{$result[0]['auto_suspend_value']}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group" >
                                                        <div class="input-icon right">
                                                            <label class="col-md-4 control-label">
                                                                Time Period
                                                                <i class="fa fa-question-circle tooltips" data-original-title="jangka waktu perhitungan pelanggaran" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control field_transaction_in_week price" min="1" name="auto_suspend_time_period" value="{{$result[0]['auto_suspend_time_period']}}">
                                                                <span class="input-group-addon">
                                                        hari
                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <label>
                                        <input type="checkbox" class="icheck checkbox"  name="forward_admin_status" id="checkbox_forward_admin-transaction_in_day" data-checkbox="icheckbox_square-blue" @if(isset($result[0][ 'forward_admin_status']) && $result[0][ 'forward_admin_status']=="1" ) checked @endif> Forward Admin
                                    </label>
                                    <div class="portlet light bordered" id="div_forward_admin-transaction_in_day" style="margin-bottom: 2%;display: none;">
                                        <div class="portlet-title tabbable-line">
                                            <div class="caption font-green">
                                                <i class="icon-settings font-green"></i>
                                                <span class="caption-subject bold uppercase"> Forward Admin </span>
                                            </div>
                                        </div>
                                        <div class="portlet-body form">
                                            <div class="form-body">
                                                @if(MyHelper::hasAccess([38], $configs))
                                                    <h4>Email</h4>
                                                    <div class="form-group">
                                                        <div class="input-icon right">
                                                            <label class="col-md-3 control-label">
                                                                Status
                                                                <i class="fa fa-question-circle tooltips" data-original-title="pilih enabled untuk mengaktifkan email sebagai media pengiriman laporan fraud detection" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <select name="email_toogle" id="email_toogle_transaction_in_day" class="form-control select2" onChange="visibleDiv('email',this.value,'transaction_in_day')">
                                                                <option value="0" @if(old('email_toogle') == '0') selected @else @if(isset($result[0]['email_toogle']) && $result[0]['email_toogle'] == "0") selected @endif @endif>Disabled</option>
                                                                <option value="1" @if(old('email_toogle') == '1') selected @else @if(isset($result[0]['email_toogle']) && $result[0]['email_toogle'] == "1") selected @endif @endif>Enabled</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group" id="div_email_recipient_transaction_in_day" style="display:none">
                                                        <div class="input-icon right">
                                                            <label for="multiple" class="control-label col-md-3">
                                                                Email Recipient
                                                                <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan alamat email admin yang akan menerima laporan fraud detection, jika lebih dari 1 pisahkan dengan tanda koma (,)" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <textarea name="email_recipient" id="email_recipient" class="form-control field_email_transaction_in_day" placeholder="Email address recipient">@if(isset($result[0]['email_recipient'])){{ $result[0]['email_recipient'] }}@endif</textarea>
                                                            <p class="help-block">Comma ( , ) separated for multiple emails</p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group" id="div_email_subject_transaction_in_day" style="display:none">
                                                        <div class="input-icon right">
                                                            <label class="col-md-3 control-label">
                                                                Subject
                                                                <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan subjek email, tambahkan text replacer bila perlu" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" placeholder="Email Subject" class="form-control field_email_transaction_in_day" name="email_subject" id="email_subject_transaction_in_day" @if(!empty(old('email_subject'))) value="{{old('email_subject')}}" @else @if(isset($result[0]['email_subject']) && $result[0]['email_subject'] != '') value="{{$result[0]['email_subject']}}" @endif @endif>
                                                            <br>
                                                            You can use this variables to display user personalized information:
                                                            <br><br>
                                                            <div class="row">
                                                                @foreach($textreplaces_day as $key=>$row)
                                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                                        <span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailSubject('{{ $row['keyword'] }}','transaction_in_day');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="div_email_content_transaction_in_day" style="display:none">
                                                        <div class="input-icon right">
                                                            <label for="multiple" class="control-label col-md-3">
                                                                Content
                                                                <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten email, tambahkan text replacer bila perlu" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <textarea name="email_content" id="email_content_transaction_in_day" class="form-control summernote">@if(!empty(old('email_content'))) <?php echo old('email_content'); ?> @else @if(isset($result[0]['email_content']) && $result[0]['email_content'] != '') <?php echo $result[0]['email_content'];?> @endif @endif</textarea>
                                                            You can use this variables to display user personalized information:
                                                            <br><br>
                                                            <div class="row" >
                                                                @foreach($textreplaces_day as $key=>$row)
                                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                                        <span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailContent('{{ $row['keyword'] }}','transaction_in_day');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                @endif
                                                @if(MyHelper::hasAccess([39], $configs))
                                                    <h4>SMS</h4>
                                                    <div class="form-group" >
                                                        <div class="input-icon right">
                                                            <label class="col-md-3 control-label">
                                                                Status
                                                                <i class="fa fa-question-circle tooltips" data-original-title="pilih enabled untuk mengaktifkan sms sebagai media pengiriman auto crm ini" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <select name="sms_toogle" id="sms_toogle" class="form-control select2" onChange="visibleDiv('sms',this.value,'transaction_in_day')">
                                                                <option value="0" @if(old('sms_toogle') == '0') selected @else @if(isset($result[0]['sms_toogle']) && $result[0]['sms_toogle'] == "0") selected @endif @endif>Disabled</option>
                                                                <option value="1" @if(old('sms_toogle') == '1') selected @else @if(isset($result[0]['sms_toogle']) && $result[0]['sms_toogle'] == "1") selected @endif @endif>Enabled</option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="div_sms_recipient_transaction_in_day" style="display:none">
                                                        <div class="input-icon right">
                                                            <label for="multiple" class="control-label col-md-3">
                                                                SMS Recipient
                                                                <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan no handphone admin yang akan menerima laporan fraud detection, jika lebih dari 1 pisahkan dengan tanda koma (,)" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <textarea name="sms_recipient" id="sms_recipient" class="form-control field_sms_transaction_in_day" placeholder="Phone number recipient">@if(isset($result[0]['sms_recipient'])){{ $result[0]['sms_recipient'] }}@endif</textarea>
                                                            <p class="help-block">Comma ( , ) separated for multiple phone number</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="div_sms_content_transaction_in_day" style="display:none">
                                                        <div class="input-icon right">
                                                            <label for="multiple" class="control-label col-md-3">
                                                                SMS Content
                                                                <i class="fa fa-question-circle tooltips" data-original-title="isi pesan sms, tambahkan text replacer bila perlu" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <textarea name="sms_content" id="sms_content_transaction_in_day" class="form-control field_sms_transaction_in_day" placeholder="SMS Content">@if(!empty(old('sms_content'))) {{old('sms_content')}} @else @if(isset($result[0]['sms_content']) && $result[0]['sms_content'] != '') {{$result[0]['sms_content']}} @endif @endif</textarea>
                                                            <br>
                                                            You can use this variables to display user personalized information:
                                                            <br><br>
                                                            <div class="row">
                                                                @foreach($textreplaces_day as $key=>$row)
                                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                                        <span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addSmsContent('{{ $row['keyword'] }}','transaction_in_day');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                @endif

                                                @if(MyHelper::hasAccess([74], $configs))
                                                    @if(!$api_key_whatsapp)
                                                        <div class="alert alert-warning deteksi-trigger">
                                                            <p> To use WhatsApp channel you have to set the api key in <a href="{{url('setting/whatsapp')}}">WhatsApp Setting</a>. </p>
                                                        </div>
                                                    @endif
                                                    <h4>WhatsApp</h4>
                                                    <div class="form-group">
                                                        <div class="input-icon right">
                                                            <label class="col-md-3 control-label">
                                                                Status
                                                                <i class="fa fa-question-circle tooltips" data-original-title="pilih enabled untuk mengaktifkan whatsApp sebagai media pengiriman auto crm ini" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <select name="whatsapp_toogle" id="whatsapp_toogle" class="form-control select2 field_whatsapp_transaction_in_day" onChange="visibleDiv('whatsapp',this.value,'transaction_in_day')" @if(!$api_key_whatsapp) disabled @endif>
                                                                <option value="0" @if(old('whatsapp_toogle') == '0') selected @else @if(isset($result[0]['whatsapp_toogle']) && $result[0]['whatsapp_toogle'] == "0") selected @endif @endif>Disabled</option>
                                                                <option value="1" @if($api_key_whatsapp) @if(old('whatsapp_toogle') == '1') selected @else @if(isset($result[0]['whatsapp_toogle']) && $result[0]['whatsapp_toogle'] == "1") selected @endif @endif @endif>Enabled</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @if($api_key_whatsapp)
                                                        <div class="form-group" id="div_whatsapp_recipient_transaction_in_day" style="display:none">
                                                            <div class="input-icon right">
                                                                <label for="multiple" class="control-label col-md-3">
                                                                    WhatsApp Recipient
                                                                    <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan no WhatsApp admin yang akan menerima laporan fraud detection, jika lebih dari 1 pisahkan dengan tanda koma (,)" data-container="body"></i>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <textarea name="whatsapp_recipient" id="whatsapp_recipient" class="form-control field_whatsapp_transaction_in_day" placeholder="WhatsApp number recipient">@if(isset($result[0]['whatsapp_recipient'])){{ $result[0]['whatsapp_recipient'] }}@endif</textarea>
                                                                <p class="help-block">Comma ( , ) separated for multiple whatsApp number</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" id="div_whatsapp_content_transaction_in_day" style="display:none">
                                                            <div class="input-icon right">
                                                                <label for="multiple" class="control-label col-md-3">
                                                                    WhatsApp Content
                                                                    <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten whatsapp, tambahkan text replacer bila perlu" data-container="body"></i>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <textarea id="whatsapp_content_transaction_in_day" name="whatsapp_content" rows="3" style="white-space: normal" class="form-control whatsapp-content" placeholder="WhatsApp Content">{{$result[0]['whatsapp_content']}}</textarea>
                                                                <br>
                                                                You can use this variables to display user personalized information:
                                                                <br><br>
                                                                <div class="row">
                                                                    @foreach($textreplaces_day as $key=>$row)
                                                                        <div class="col-md-3" style="margin-bottom:5px;">
                                                                            <span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal; height:40px" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addWhatsappContent('{{ $row['keyword'] }}','transaction_in_day');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$result[0]['id_fraud_setting']}}" name="id_fraud_setting">
                            <input type="hidden" value="fraud_transaction_in_day" name="type">
                            <div class="row" style="text-align: center">
                                <button type="submit" class="btn blue" id="checkBtn">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane @if(isset($tipe) && $tipe == 'fraud_transaction_in_week') active @endif" id="fraud_transaction_in_week">
                <form role="form" class="form-horizontal" action="{{url()->current()}}" method="POST" enctype="multipart/form-data" id="form">
                    <br>
                    <div class="form-group">
                        <div class="col-md-4" style="margin-left: 2.5%;margin-top: 7px;">
                            <button type="button" class="btn btn-lg btn-toggle switch @if($result[1]['fraud_settings_status'] == 'Active')active @endif" id="switch-change-transaction_in_week" data-id="{{ $result[1]['id_fraud_setting'] }}" data-toggle="button" aria-pressed="<?=($result[1]['fraud_settings_status'] == 'Active' ? 'true' : 'false')?>" autocomplete="off">
                                <div class="handle"></div>
                            </button>
                        </div>
                    </div>
                    <div id="div_main_transaction_in_week">
                        <div class="portlet light bordered" id="trigger">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-dark sbold uppercase font-yellow">Parameter</span>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="form-group">
                                    <label class="col-md-4 control-label" >Fraud Detection Parameter <i class="fa fa-question-circle tooltips" data-original-title="Fraud terjadi ketika transaction dalam 1 minggu melewati jumlah maximum yang sudah di tentukan. Perhitungan 1 minggu adalah hari Senin - Minggu." data-container="body"></i></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control field_transaction_in_day" name="parameter_detail" value="{{$result[1]['parameter']}}" disabled>
                                    </div>
                                </div>

                                <div class="form-group" id="type-detail" @if(strpos($result[1]['parameter'], 'transaction') === false) style="display:none" @endif>
                                    <label class="col-md-4 control-label" ></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
									<span class="input-group-addon">
										maximum
									</span>
                                            <input type="number" class="form-control field_transaction_in_day" min="1" name="parameter_detail" value="{{$result[1]['parameter_detail']}}">
                                            <span class="input-group-addon">
										Transactions / @if(strpos($result[1]['parameter'], 'week') !== false) Week @elseif(strpos($result[1]['parameter'], 'day') !== false) Day @endif
									</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-dark sbold uppercase font-yellow">Action</span>
                                </div>
                            </div>

                            <div class="portlet-body">
                                <div class="icheck-list">
                                    <label>
                                        <input type="checkbox" class="icheck checkbox" name="auto_suspend_status" id="checkbox_auto_suspend-transaction_in_week" data-checkbox="icheckbox_square-blue" @if(isset($result[1][ 'auto_suspend_status']) && $result[1][ 'auto_suspend_status']=="1" ) checked @endif> Auto Suspend
                                    </label>
                                    <div class="portlet light bordered" id="div_auto_suspend-transaction_in_week" style="margin-bottom: 2%;display: none;">
                                        <div class="portlet-title tabbable-line">
                                            <div class="caption font-green">
                                                <i class="icon-settings font-green"></i>
                                                <span class="caption-subject bold uppercase"> Auto Suspend </span>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group" >
                                                        <div class="input-icon right">
                                                            <label class="col-md-6 control-label">
                                                                Number of violations
                                                                <i class="fa fa-question-circle tooltips" data-original-title="maksimum jumlah pelanggaran" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    maximum
                                                                </span>
                                                                <input type="number" class="form-control field_transaction_in_week price" min="1" name="auto_suspend_value" value="{{$result[1]['auto_suspend_value']}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group" >
                                                        <div class="input-icon right">
                                                            <label class="col-md-4 control-label">
                                                                Time Period
                                                                <i class="fa fa-question-circle tooltips" data-original-title="jangka waktu perhitungan pelanggaran" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control field_transaction_in_week price" min="1" name="auto_suspend_time_period" value="{{$result[1]['auto_suspend_time_period']}}">
                                                                <span class="input-group-addon">
                                                        hari
                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <label>
                                        <input type="checkbox" class="icheck checkbox" name="forward_admin_status" id="checkbox_forward_admin-transaction_in_week" data-checkbox="icheckbox_square-blue" @if(isset($result[1][ 'forward_admin_status']) && $result[1][ 'forward_admin_status']=="1" ) checked @endif> Forward Admin
                                    </label>
                                    <div class="portlet light bordered" id="div_forward_admin-transaction_in_week" style="margin-bottom: 2%;display: none;">
                                        <div class="portlet-title tabbable-line">
                                            <div class="caption font-green">
                                                <i class="icon-settings font-green"></i>
                                                <span class="caption-subject bold uppercase"> Forward Admin </span>
                                            </div>
                                        </div>
                                        <div class="portlet-body form">
                                            <div class="form-body">
                                                @if(MyHelper::hasAccess([38], $configs))
                                                    <h4>Email</h4>
                                                    <div class="form-group">
                                                        <div class="input-icon right">
                                                            <label class="col-md-3 control-label">
                                                                Status
                                                                <i class="fa fa-question-circle tooltips" data-original-title="pilih enabled untuk mengaktifkan email sebagai media pengiriman laporan fraud detection" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <select name="email_toogle" id="email_toogle_transaction_in_week" class="form-control select2" onChange="visibleDiv('email',this.value,'transaction_in_week')">
                                                                <option value="0" @if(old('email_toogle') == '0') selected @else @if(isset($result[1]['email_toogle']) && $result[1]['email_toogle'] == "0") selected @endif @endif>Disabled</option>
                                                                <option value="1" @if(old('email_toogle') == '1') selected @else @if(isset($result[1]['email_toogle']) && $result[1]['email_toogle'] == "1") selected @endif @endif>Enabled</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group" id="div_email_recipient_transaction_in_week" style="display:none">
                                                        <div class="input-icon right">
                                                            <label for="multiple" class="control-label col-md-3">
                                                                Email Recipient
                                                                <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan alamat email admin yang akan menerima laporan fraud detection, jika lebih dari 1 pisahkan dengan tanda koma (,)" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <textarea name="email_recipient" id="email_recipient" class="form-control field_email_transaction_in_week" placeholder="Email address recipient">@if(isset($result[1]['email_recipient'])){{ $result[1]['email_recipient'] }}@endif</textarea>
                                                            <p class="help-block">Comma ( , ) separated for multiple emails</p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group" id="div_email_subject_transaction_in_week" style="display:none">
                                                        <div class="input-icon right">
                                                            <label class="col-md-3 control-label">
                                                                Subject
                                                                <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan subjek email, tambahkan text replacer bila perlu" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" placeholder="Email Subject" class="form-control field_email_transaction_in_week" name="email_subject" id="email_subject_transaction_in_week" @if(!empty(old('email_subject'))) value="{{old('email_subject')}}" @else @if(isset($result[1]['email_subject']) && $result[1]['email_subject'] != '') value="{{$result[1]['email_subject']}}" @endif @endif>
                                                            <br>
                                                            You can use this variables to display user personalized information:
                                                            <br><br>
                                                            <div class="row">
                                                                @foreach($textreplaces_week as $key=>$row)
                                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                                        <span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailSubject('{{ $row['keyword'] }}','transaction_in_week');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="div_email_content_transaction_in_week" style="display:none">
                                                        <div class="input-icon right">
                                                            <label for="multiple" class="control-label col-md-3">
                                                                Content
                                                                <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten email, tambahkan text replacer bila perlu" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <textarea name="email_content" id="email_content_transaction_in_week" class="form-control summernote">@if(!empty(old('email_content'))) <?php echo old('email_content'); ?> @else @if(isset($result[1]['email_content']) && $result[1]['email_content'] != '') <?php echo $result[1]['email_content'];?> @endif @endif</textarea>
                                                            You can use this variables to display user personalized information:
                                                            <br><br>
                                                            <div class="row" >
                                                                @foreach($textreplaces_week as $key=>$row)
                                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                                        <span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailContent('{{ $row['keyword'] }}','transaction_in_week');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                @endif
                                                @if(MyHelper::hasAccess([39], $configs))
                                                    <h4>SMS</h4>
                                                    <div class="form-group" >
                                                        <div class="input-icon right">
                                                            <label class="col-md-3 control-label">
                                                                Status
                                                                <i class="fa fa-question-circle tooltips" data-original-title="pilih enabled untuk mengaktifkan sms sebagai media pengiriman auto crm ini" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <select name="sms_toogle" id="sms_toogle" class="form-control select2" onChange="visibleDiv('sms',this.value,'transaction_in_week')">
                                                                <option value="0" @if(old('sms_toogle') == '0') selected @else @if(isset($result[1]['sms_toogle']) && $result[1]['sms_toogle'] == "0") selected @endif @endif>Disabled</option>
                                                                <option value="1" @if(old('sms_toogle') == '1') selected @else @if(isset($result[1]['sms_toogle']) && $result[1]['sms_toogle'] == "1") selected @endif @endif>Enabled</option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="div_sms_recipient_transaction_in_week" style="display:none">
                                                        <div class="input-icon right">
                                                            <label for="multiple" class="control-label col-md-3">
                                                                SMS Recipient
                                                                <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan no handphone admin yang akan menerima laporan fraud detection, jika lebih dari 1 pisahkan dengan tanda koma (,)" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <textarea name="sms_recipient" id="sms_recipient" class="form-control field_sms_transaction_in_week" placeholder="Phone number recipient">@if(isset($result[1]['sms_recipient'])){{ $result[1]['sms_recipient'] }}@endif</textarea>
                                                            <p class="help-block">Comma ( , ) separated for multiple phone number</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="div_sms_content_transaction_in_week" style="display:none">
                                                        <div class="input-icon right">
                                                            <label for="multiple" class="control-label col-md-3">
                                                                SMS Content
                                                                <i class="fa fa-question-circle tooltips" data-original-title="isi pesan sms, tambahkan text replacer bila perlu" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <textarea name="sms_content" id="sms_content_transaction_in_week" class="form-control field_sms_transaction_in_week" placeholder="SMS Content">@if(!empty(old('sms_content'))) {{old('sms_content')}} @else @if(isset($result[1]['sms_content']) && $result[1]['sms_content'] != '') {{$result[1]['sms_content']}} @endif @endif</textarea>
                                                            <br>
                                                            You can use this variables to display user personalized information:
                                                            <br><br>
                                                            <div class="row">
                                                                @foreach($textreplaces_week as $key=>$row)
                                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                                        <span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addSmsContent('{{ $row['keyword'] }}','transaction_in_week');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                @endif

                                                @if(MyHelper::hasAccess([74], $configs))
                                                    @if(!$api_key_whatsapp)
                                                        <div class="alert alert-warning deteksi-trigger">
                                                            <p> To use WhatsApp channel you have to set the api key in <a href="{{url('setting/whatsapp')}}">WhatsApp Setting</a>. </p>
                                                        </div>
                                                    @endif
                                                    <h4>WhatsApp</h4>
                                                    <div class="form-group">
                                                        <div class="input-icon right">
                                                            <label class="col-md-3 control-label">
                                                                Status
                                                                <i class="fa fa-question-circle tooltips" data-original-title="pilih enabled untuk mengaktifkan whatsApp sebagai media pengiriman auto crm ini" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <select name="whatsapp_toogle" id="whatsapp_toogle" class="form-control select2 field_whatsapp_transaction_in_week" onChange="visibleDiv('whatsapp',this.value,'transaction_in_week')" @if(!$api_key_whatsapp) disabled @endif>
                                                                <option value="0" @if(old('whatsapp_toogle') == '0') selected @else @if(isset($result[1]['whatsapp_toogle']) && $result[1]['whatsapp_toogle'] == "0") selected @endif @endif>Disabled</option>
                                                                <option value="1" @if($api_key_whatsapp) @if(old('whatsapp_toogle') == '1') selected @else @if(isset($result[1]['whatsapp_toogle']) && $result[1]['whatsapp_toogle'] == "1") selected @endif @endif @endif>Enabled</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @if($api_key_whatsapp)
                                                        <div class="form-group" id="div_whatsapp_recipient_transaction_in_week" style="display:none">
                                                            <div class="input-icon right">
                                                                <label for="multiple" class="control-label col-md-3">
                                                                    WhatsApp Recipient
                                                                    <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan no WhatsApp admin yang akan menerima laporan fraud detection, jika lebih dari 1 pisahkan dengan tanda koma (,)" data-container="body"></i>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <textarea name="whatsapp_recipient" id="whatsapp_recipient" class="form-control field_whatsapp_transaction_in_week" placeholder="WhatsApp number recipient">@if(isset($result[1]['whatsapp_recipient'])){{ $result[1]['whatsapp_recipient'] }}@endif</textarea>
                                                                <p class="help-block">Comma ( , ) separated for multiple whatsApp number</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" id="div_whatsapp_content_transaction_in_week" style="display:none">
                                                            <div class="input-icon right">
                                                                <label for="multiple" class="control-label col-md-3">
                                                                    WhatsApp Content
                                                                    <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten whatsapp, tambahkan text replacer bila perlu" data-container="body"></i>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <textarea id="whatsapp_content_transaction_in_week" name="whatsapp_content" rows="3" style="white-space: normal" class="form-control whatsapp-content" placeholder="WhatsApp Content">{{$result[1]['whatsapp_content']}}</textarea>
                                                                <br>
                                                                You can use this variables to display user personalized information:
                                                                <br><br>
                                                                <div class="row">
                                                                    @foreach($textreplaces_week as $key=>$row)
                                                                        <div class="col-md-3" style="margin-bottom:5px;">
                                                                            <span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal; height:40px" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addWhatsappContent('{{ $row['keyword'] }}','transaction_in_week');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$result[1]['id_fraud_setting']}}" name="id_fraud_setting">
                            <input type="hidden" value="fraud_transaction_in_week" name="type">
                            <div class="row" style="text-align: center">
                                <button type="submit" class="btn blue" id="checkBtn">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>


@endsection