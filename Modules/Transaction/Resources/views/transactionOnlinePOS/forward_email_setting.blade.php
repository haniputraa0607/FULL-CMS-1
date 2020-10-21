@php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');
@endphp

@extends('layouts.main')

@section('page-style')
    <link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Auto Response',
                tabsize: 2,
                height: 120,
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
                            url: "{{url('summernote/picture/delete/autoresponse')}}",
                            success: function(data){
                            }
                        });
                    }
                }
            });
        });

        function visibleDiv(apa,nilai){
            if(apa == 'email'){
                if(nilai=='1'){
                    document.getElementById('div_email_subject').style.display = 'block';
                    document.getElementById('div_email_content').style.display = 'block';
                } else {
                    document.getElementById('div_email_subject').style.display = 'none';
                    document.getElementById('div_email_content').style.display = 'none';
                }
            }
        }

        function addForwardSubject(param){
            var textvalue = $('#autocrm_forward_email_subject').val();
            var textvaluebaru = textvalue+" "+param;
            $('#autocrm_forward_email_subject').val(textvaluebaru);
        }

        function addForwardContent(param){
            var textvalue = $('#autocrm_forward_email_content').val();

            var textvaluebaru = textvalue+" "+param;
            $('#autocrm_forward_email_content').val(textvaluebaru);
            $('#autocrm_forward_email_content').summernote('editor.saveRange');
            $('#autocrm_forward_email_content').summernote('editor.restoreRange');
            $('#autocrm_forward_email_content').summernote('editor.focus');
            $('#autocrm_forward_email_content').summernote('editor.insertText', param);
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
            </li>
        </ul>
    </div><br>
    
    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-dark sbold uppercase font-blue">Auto Response Transaction Online Failed POS</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('transaction/online-pos/autoresponse') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <h4>Email</h4>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Status
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih enabled untuk mengedit template email auto response ketika" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select name="autocrm_forward_toogle" id="autocrm_email_toogle" class="form-control select2" id="email_toogle" onChange="visibleDiv('email',this.value)">
                                <option value="0" @if($result['autocrm_forward_toogle'] == 0) selected @endif>Disabled</option>
                                <option value="1" @if($result['autocrm_forward_toogle'] == 1) selected @endif>Enabled</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" id="div_email_recipient_transaction_in_day">
                        <div class="input-icon right">
                            <label for="multiple" class="control-label col-md-3">
                                Email Recipient
                                <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan alamat email admin yang akan menerima laporan fraud detection, jika lebih dari 1 pisahkan dengan tanda koma (,)" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <textarea name="autocrm_forward_email" id="autocrm_forward_email" class="form-control field_email" placeholder="Email address recipient">@if(isset($result['autocrm_forward_email'])){{ $result['autocrm_forward_email'] }}@endif</textarea>
                            <p class="help-block">Comma ( , ) separated for multiple emails</p>
                        </div>
                    </div>

                    <div class="form-group" id="div_email_subject" @if($result['autocrm_forward_toogle'] == 0) style="display:none;" @endif>
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Subject
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Diisi dengan subjek email, tambahkan text replacer bila perlu" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" placeholder="Email Subject" class="form-control" name="autocrm_forward_email_subject" id="autocrm_forward_email_subject" value="{{$result['autocrm_forward_email_subject']}}">
                            <br>
                            You can use this variables to display user personalized information:
                            <br><br>
                            <div class="row">
                                @foreach($textreplaces as $key=>$row)
                                    <div class="col-md-3" style="margin-bottom:5px;">
                                        <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addForwardSubject('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                    </div>
                                @endforeach
                                @if (isset($custom))
                                    @foreach($custom as $key=>$row)
                                        <div class="col-md-3" style="margin-bottom:5px;">
                                            <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $custom[$key] }}'" onClick="addForwardSubject('{{ $custom[$key] }}');">{{ str_replace('_',' ',$custom[$key]) }}</span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="div_email_content" @if($result['autocrm_forward_toogle'] == 0) style="display:none;" @endif>
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Content
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Diisi dengan konten email, tambahkan text replacer bila perlu" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <textarea name="autocrm_forward_email_content" id="autocrm_forward_email_content" class="form-control summernote"><?php echo $result['autocrm_forward_email_content'];?></textarea>
                            You can use this variables to display user personalized information:
                            <br><br>
                            <div class="row" >
                                @foreach($textreplaces as $key=>$row)
                                    <div class="col-md-3" style="margin-bottom:5px;">
                                        <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addForwardContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                    </div>
                                @endforeach
                                @if (isset($custom))
                                    @foreach($custom as $key=>$row)
                                        <div class="col-md-3" style="margin-bottom:5px;">
                                            <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $custom[$key] }}'" onClick="addForwardContent('{{ $custom[$key] }}');">{{ str_replace('_',' ',$custom[$key]) }}</span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-offset-5 col-md-5">
                                <input type="hidden" name="id_autocrm" value="{{$result['id_autocrm']}}">
                                <button type="submit" class="btn green">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
