@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        function addTextReplace(id ,param){
            if (id == 'mobile') {
                var textvalue = $('#display_text_mobile').val();
                var textvaluebaru = textvalue+" "+param;
                $('#display_text_mobile').val(textvaluebaru);
            } else if (id == 'outlet') {
                var textvalue = $('#display_text_outlet').val();
                var textvaluebaru = textvalue+" "+param;
                $('#display_text_outlet').val(textvaluebaru);
            }
        }
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
                <span class="caption-subject font-blue bold uppercase">Version Control Setting</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="form-body">
                <div class="portlet-body">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_Android" data-toggle="tab" aria-expanded="true"> Android Setting </a>
                    </li>
                    <li class="">
                        <a href="#tab_IOS" data-toggle="tab" aria-expanded="false"> IOS Setting </a>
                    </li>
{{--                    <li class="">--}}
{{--                        <a href="#tab_OutletApps" data-toggle="tab" aria-expanded="false"> Outlet Apps Setting </a>--}}
{{--                    </li>--}}
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> Display Setting
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="#tab_display_androidios" tabindex="-1" data-toggle="tab"> Android & IOS </a>
                            </li>
                            <li>
                                <a href="#tab_display_outletapps" tabindex="-1" data-toggle="tab"> Outlet Apps </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="tab_Android">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div id="addAndroid">
                                    <div class="mt-repeater" id="Android0">
                                        <div class="mt-repeater-item mt-overflow">
                                            <div class="mt-repeater-cell">
                                                <div class="col-md-12">
                                                    <div class="col-md-1">
                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition('Android0')">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="Android[0][app_version]" required placeholder="Android Version">
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Versi aplikasi Android terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <select name="Android[0][rules]" class="form-control" placeholder="Rules For Different Verion" required>
                                                                <option disabled selected value="">Rules For Different Version</option>
                                                                <option value="1">Allowed</option>
                                                                <option value="0">Not Allowed</option>
                                                            </select>
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Aturan jika versi aplikasi Android yang digunakan berbeda dengan versi aplikasi Android terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:;" class="btn btn-success mt-repeater-add" onclick="addVersion('Android')">
                                <i class="fa fa-plus"></i> Add New Version</a>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Playstore Link
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Link di playstore untuk download aplikasi Android terbaru" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" value="@if(isset($version['version_playstore'])){{ $version['version_playstore'] }}@endif" class="form-control" name="Android[version_playstore]" placeholder="Playstore Link">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Jumlah Versi Disupport
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimum versi aplikasi yang disupport" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" value="@if(isset($version['version_max_android'])){{ $version['version_max_android'] }}@endif" class="form-control" name="Android[version_max_android]" placeholder="Input Jumlah">
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_IOS">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div id="addIOS">
                                    <div class="mt-repeater" id="IOS0">
                                        <div class="mt-repeater-item mt-overflow">
                                            <div class="mt-repeater-cell">
                                                <div class="col-md-12">
                                                    <div class="col-md-1">
                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition('IOS0')">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="IOS[0][app_version]" required placeholder="IOS Version">
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Versi aplikasi IOS terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <select name="IOS[0][rules]" class="form-control" placeholder="Rules For Different Verion" required>
                                                                <option disabled selected value="">Rules For Different Verion</option>
                                                                <option value="1">Allowed</option>
                                                                <option value="0">Not Allowed</option>
                                                            </select>
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Aturan jika versi aplikasi IOS yang digunakan berbeda dengan versi aplikasi IOS terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:;" class="btn btn-success mt-repeater-add" onclick="addVersion('IOS')">
                                <i class="fa fa-plus"></i> Add New Version</a>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Appstore Link
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Link di appstore untuk download aplikasi IOS terbaru" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="IOS[version_appstore]" value="@if(isset($version['version_appstore'])){{ $version['version_appstore'] }}@endif">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Jumlah Versi Disupport
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimum versi aplikasi yang disupport" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" value="@if(isset($version['version_max_ios'])){{ $version['version_max_ios'] }}@endif" class="form-control" name="IOS[version_max_ios]" placeholder="Input Jumlah">
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_OutletApps">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div id="addOutletApp">
                                    <div class="mt-repeater" id="OutletApp0">
                                        <div class="mt-repeater-item mt-overflow">
                                            <div class="mt-repeater-cell">
                                                <div class="col-md-12">
                                                    <div class="col-md-1">
                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition('OutletApp0')">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="OutletApp[0][app_version]" required placeholder="Outlet Apps Version">
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Versi Outlet Apps terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <select name="OutletApp[0][rules]" class="form-control" placeholder="Rules For Different Verion" required="">
                                                                <option disabled selected value="">Rules For Different Verion</option>
                                                                <option value="1">Allowed</option>
                                                                <option value="0">Not Allowed</option>
                                                            </select>
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Aturan jika versi aplikasi Outlet Apps yang digunakan berbeda dengan versi aplikasi Outlet Apps terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:;" class="btn btn-success mt-repeater-add" onclick="addVersion('OutletApp')">
                                <i class="fa fa-plus"></i> Add New Version</a>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Outlet Apps Link
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Link untuk download aplikasi Outlet Apps terbaru" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="OutletApp[version_outletstore]" value="@if(isset($version['version_outletstore'])){{ $version['version_outletstore'] }}@endif">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Jumlah Versi Disupport
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimum versi aplikasi yang disupport" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" value="@if(isset($version['version_max_outletapp'])){{ $version['version_max_outletapp'] }}@endif" class="form-control" name="OutletApp[version_max_outletapp]" placeholder="Input Jumlah">
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_display_androidios">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div class="portlet-body form">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                Image
                                                <span class="required" aria-required="true"> * </span>
                                                <!--<br>-->
                                                <!-- <span class="required" aria-required="true"> (500*500) </span>  -->
                                                <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran persegi ditampilkan pada aplikasi" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                                    @if(isset($version['version_image_mobile']))
                                                    <img src="{{ env('S3_URL_API')}}{{$version['version_image_mobile']}}" alt="">
                                                    @else
                                                    <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                                    @endif
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" id="image_square" style="max-width: 200px; max-height: 200px;"></div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                        <span class="fileinput-new"> Select image </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <input type="file" id="field_image_square" class="file" accept="image/*" data-jenis="square" name="Display[version_image_mobile]">

                                                        </span>

                                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                    Text
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Kalimat yang akan ditampilkan pada aplikasi ketika versi aplikasi yang digunakan berbeda dengan versi terbaru" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea class="form-control" name="Display[version_text_alert_mobile]" required id="display_text_mobile">@if(isset($version['version_text_alert_mobile'])){{ $version['version_text_alert_mobile'] }}@endif</textarea>
                                                <br>
                                                You can use this variables to display version app :
                                                <br><br>
                                                <div class="row">
                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                        <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '%version_app%' with the latest version for the device used" onClick="addTextReplace('mobile', '%version_app%');">version app</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                    Button Text
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Teks pada button yang akan langsung menuju ke playstore / appstore" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="Display[version_text_button_mobile]" value="@if(isset($version['version_text_button_mobile'])){{ $version['version_text_button_mobile'] }}@endif" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_display_outletapps">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div class="portlet-body form">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                Image
                                                <span class="required" aria-required="true"> * </span>
                                                <!--<br>-->
                                                <!-- <span class="required" aria-required="true"> (500*500) </span>  -->
                                                <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran persegi ditampilkan pada aplikasi" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                                    @if(isset($version['version_image_outlet']))
                                                    <img src="{{ env('S3_URL_API')}}{{$version['version_image_outlet']}}" alt="">
                                                    @else
                                                    <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                                    @endif
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" id="image_square" style="max-width: 200px; max-height: 200px;"></div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                        <span class="fileinput-new"> Select image </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <input type="file" id="field_image_square" class="file" accept="image/*" data-jenis="square" name="Display[version_image_outlet]">

                                                        </span>

                                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                    Text
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Kalimat yang akan ditampilkan pada aplikasi ketika versi aplikasi yang digunakan berbeda dengan versi terbaru" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea class="form-control" name="Display[version_text_alert_outlet]" required id="display_text_outlet">@if(isset($version['version_text_alert_outlet'])){{ $version['version_text_alert_outlet'] }}@endif</textarea>
                                                <br>
                                                You can use this variables to display version app :
                                                <br><br>
                                                <div class="row">
                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                        <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '%version_app%' with the latest version for the device used" onClick="addTextReplace('outlet', '%version_app%');">version app</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                    Button Text
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Teks pada button yang akan langsung menuju ke playstore / appstore" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="Display[version_text_button_outlet]" value="@if(isset($version['version_text_button_outlet'])){{ $version['version_text_button_outlet'] }}@endif" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                var noAndroid = 1;
                var noIOS = 1;
                var noOutletApp = 1;

                window.onload = function(event) {
                    var android = JSON.parse('{!! json_encode($version["Android"]) !!}');
                    var ios = JSON.parse('{!! json_encode($version["IOS"]) !!}');
                    var outlet = JSON.parse('{!! json_encode($version["OutletApp"]) !!}');
                    if (android.length != 0) {
                        android.forEach(function(entry) {
                            $('#Android0').remove()
                            appendData('Android', 'Android', noAndroid, 'version_android', entry.app_version, entry.rules);
                            noAndroid++;
                        });
                    } if (ios.length != 0) {
                        ios.forEach(function(entry) {
                            $('#IOS0').remove()
                            appendData('IOS', 'IOS', noIOS, 'version_ios', entry.app_version, entry.rules);
                            noIOS++;
                        });
                    } if (outlet.length != 0) {
                        outlet.forEach(function(entry) {
                            $('#OutletApp0').remove()
                            appendData('OutletApp', 'Outlet Apps', noOutletApp, 'version_outletapp', entry.app_version, entry.rules);
                            noOutletApp++;
                        });
                    }
                };

                function appendData(id, device, number, name, version, rules) {
                    var allow = ''
                    var not_allow = ''
                    if (rules == 1) {
                        var allow = 'selected'
                    } else if (rules == 0) {
                        var not_allow = 'selected'
                    }
                    $("#add"+id).append(
                        '<div class="mt-repeater" id="'+id+number+'">'+
                            '<div class="mt-repeater-item mt-overflow">'+
                                '<div class="mt-repeater-cell">'+
                                    '<div class="col-md-12">'+
                                        '<div class="col-md-1">'+
                                            '<a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition(`'+id+number+'`)">'+
                                                '<i class="fa fa-close"></i>'+
                                            '</a>'+
                                        '</div>'+
                                        '<div class="col-md-5">'+
                                            '<div class="input-group">'+
                                                '<input type="text" class="form-control" name="'+id+'['+number+'][app_version]" value="'+version+'" required placeholder="'+device+' Version">'+
                                                '<span class="input-group-addon">'+
                                                    '<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Versi aplikasi '+device+' terbaru" data-container="body"></i>'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-6">'+
                                            '<div class="input-group">'+
                                                '<select name="'+id+'['+number+'][rules]" class="form-control" placeholder="Rules For Different Verion" required>'+
                                                    '<option disabled selected value="">Rules For Different Version</option>'+
                                                    '<option '+allow+' value="1">Allowed</option>'+
                                                    '<option '+not_allow+' value="0">Not Allowed</option>'+
                                                '</select>'+
                                                '<span class="input-group-addon">'+
                                                    '<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Aturan jika versi aplikasi '+device+' yang digunakan berbeda dengan versi aplikasi '+device+' terbaru" data-container="body"></i>'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );
                    $('.tooltips').tooltip()
                }


                function dataAppend(item) {
                    if (item.app_type == "Android") {
                        appendDiv('Android', 'Android', noAndroid, 'version_android')
                        noAndroid++;
                    } if (item.app_type == "IOS") {
                        appendDiv('IOS', 'IOS', noIOS, 'version_ios')
                        noIOS++;
                    } if (item.app_type == "OutletApp") {
                        appendDiv('OutletApp', 'Outlet Apps', noOutletApp, 'version_outletapp')
                        noOutletApp++;
                    }
                }

                function addVersion(id){
                    if (id == "Android") {
                        appendDiv('Android', 'Android', noAndroid, 'version_android')
                        noAndroid++;
                    } if (id == "IOS") {
                        appendDiv('IOS', 'IOS', noIOS, 'version_ios')
                        noIOS++;
                    } if (id == "OutletApp") {
                        appendDiv('OutletApp', 'Outlet Apps', noOutletApp, 'version_outletapp')
                        noOutletApp++;
                    }
                }

                function appendDiv(id, device, number, name) {
                    $("#add"+id).append(
                        '<div class="mt-repeater" id="'+id+number+'">'+
                            '<div class="mt-repeater-item mt-overflow">'+
                                '<div class="mt-repeater-cell">'+
                                    '<div class="col-md-12">'+
                                        '<div class="col-md-1">'+
                                            '<a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition(`'+id+number+'`)">'+
                                                '<i class="fa fa-close"></i>'+
                                            '</a>'+
                                        '</div>'+
                                        '<div class="col-md-5">'+
                                            '<div class="input-group">'+
                                                '<input type="text" class="form-control" name="'+id+'['+number+'][app_version]" value="@if(isset($version['+name+'])){{ $version['+name+'] }}@endif" required placeholder="'+device+' Version">'+
                                                '<span class="input-group-addon">'+
                                                    '<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Versi aplikasi '+device+' terbaru" data-container="body"></i>'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-6">'+
                                            '<div class="input-group">'+
                                                '<select name="'+id+'['+number+'][rules]" class="form-control" placeholder="Rules For Different Verion" required>'+
                                                    '<option disabled selected value="">Rules For Different Version</option>'+
                                                    '<option value="1">Allowed</option>'+
                                                    '<option value="0">Not Allowed</option>'+
                                                '</select>'+
                                                '<span class="input-group-addon">'+
                                                    '<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Aturan jika versi aplikasi '+device+' yang digunakan berbeda dengan versi aplikasi '+device+' terbaru" data-container="body"></i>'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );
                    $('.tooltips').tooltip()
                }
                function deleteCondition(response) {
                    $('#'+response).remove()
                }
            </script>
            </div>
        </div>
    </div>
@endsection