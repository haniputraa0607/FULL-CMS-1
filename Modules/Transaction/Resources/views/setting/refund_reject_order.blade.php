@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
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
                if(nilai === '1'){
                    document.getElementById('autoresponse-wrapper').style.display = 'none';
                } else {
                    document.getElementById('autoresponse-wrapper').style.display = 'block';
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

<form class="form-horizontal" action="#" method="post" id="form">
<div class="portlet light form-fit bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class=" icon-layers font-green"></i>
            <span class="caption-subject font-green bold uppercase">Setting Refund Failed Delivery</span>
        </div>
    </div>
    <div class="portlet-body form">
        {{ csrf_field() }}
        <div class="form-body">
            <div class="form-group">
                <div class="input-icon right">
                    <label class="col-md-3 control-label">
                        Midtrans
                    <span class="required" aria-required="true"> * </span>  
                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih metode refund pembayaran apabila transaksi yang menggunakan metode pembayaran Midtrans dibatalkan" data-container="body"></i>
                    </label>
                </div>
                <div class="col-md-3">
                    <select class="select2 form-control" name="refund_midtrans">
                        <option value="0">{{env('POINT_NAME', 'Points')}}</option>
                        <option value="1" {{$status['refund_midtrans'] ? 'selected' : ''}}>Void Midtrans</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="input-icon right">
                    <label class="col-md-3 control-label">
                        Ovo
                    <span class="required" aria-required="true"> * </span>  
                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih metode refund pembayaran apabila transaksi yang menggunakan metode pembayaran Ovo dibatalkan" data-container="body"></i>
                    </label>
                </div>
                <div class="col-md-3">
                    <select class="select2 form-control" name="refund_ovo">
                        <option value="0">{{env('POINT_NAME', 'Points')}}</option>
                        <option value="1" {{$status['refund_ovo'] ? 'selected' : ''}}>Void Ovo</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="input-icon right">
                    <label class="col-md-3 control-label">
                        Shopeepay
                    <span class="required" aria-required="true"> * </span>  
                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih metode refund pembayaran apabila transaksi yang menggunakan metode pembayaran Shopeepay dibatalkan" data-container="body"></i>
                    </label>
                </div>
                <div class="col-md-3">
                    <select class="select2 form-control" name="refund_shopeepay">
                        <option value="0">{{env('POINT_NAME', 'Points')}}</option>
                        <option value="1" {{$status['refund_shopeepay'] ? 'selected' : ''}}>Void Shopeepay</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="portlet light form-fit bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class=" icon-layers font-green"></i>
            <span class="caption-subject font-green bold uppercase">Failed Refund Action</span>
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-body">
            <div class="form-group">
                <div class="input-icon right">
                    <label class="col-md-3 control-label">
                        Action
                    <span class="required" aria-required="true"> * </span>  
                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih metode yang akan dilakukan saat void/refund pembayaran (apabila diaktifkan) gagal" data-container="body"></i>
                    </label>
                </div>
                <div class="col-md-4">
                    <select class="select2 form-control" name="refund_failed_process_balance" onChange="visibleDiv('email',this.value)">
                        <option value="0">Notify Admin for Manual Refund</option>
                        <option value="1" {{$status['refund_failed_process_balance'] ? 'selected' : ''}}>Refund to {{env('POINT_NAME', 'Points')}}</option>
                    </select>
                </div>
            </div>
            <input type="hidden" name="id_autocrm" value="{{$result['id_autocrm']}}"/>
            <div id="autoresponse-wrapper" style="display: {{$status['refund_failed_process_balance'] ? 'none' : 'block'}}">
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

                <div class="form-group" id="div_email_subject">
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
                <div class="form-group" id="div_email_content">
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
            </div>
        </div>
    </div>
</div>
<div class="text-center">
    <button class="btn green" type="submit">
        <i class="fa fa-check"></i> Save
    </button>    
</div>
</form>
@endsection
