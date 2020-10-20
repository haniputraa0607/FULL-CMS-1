<?php
use App\Lib\MyHelper;
$configs = session('configs');
?>
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gear"></i>Fraud Detection Point</div>
        <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
        </div>
    </div>
    <div class="portlet-body">
        <p>Admin can provide action for users who get points exceeding the limit.</p>
        <p>You can provide actions for each type, actions are divided into 2 :</p>
        <ul>
            <li>Auto Suspend : if the user violates the rules, the account will be automatically suspended </li>
            <li>Forward Admin : send notification to admin if user is exposed to fraud </li>
        </ul>
    </div>
</div>
<form role="form" class="form-horizontal" action="{{url()->current()}}" method="POST" enctype="multipart/form-data" id="form">
    <br>
    <div class="form-group">
        <div class="col-md-4" style="margin-left: 2.5%;margin-top: 7px;">
            <button type="button" class="btn btn-lg btn-toggle switch @if($result[4]['fraud_settings_status'] == 'Active')active @endif" id="switch-change-transaction_point" data-id="{{ $result[4]['id_fraud_setting'] }}" data-toggle="button" aria-pressed="<?=($result[4]['fraud_settings_status'] == 'Active' ? 'true' : 'false')?>" autocomplete="off">
                <div class="handle"></div>
            </button>
        </div>
    </div>
    <div id="div_main_transaction_point">
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
                        <input type="text" class="form-control field_transaction_point" name="parameter_detail" value="{{$result[4]['parameter']}}" disabled>
                    </div>
                </div>

                <div class="form-group" id="type-detail">
                    <label class="col-md-4 control-label" ></label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                above
                            </span>
                        <input type="text" class="form-control field_transaction_point price" min="1"  name="parameter_detail" value="{{$result[4]['parameter_detail']}}">
                        <span class="input-group-addon">
                                point
                        </span>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="type-detail">
                    <label class="col-md-4 control-label" ></label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control  price" min="1"  name="parameter_detail_time" value="{{$result[4]['parameter_detail_time']}}">
                            <span class="input-group-addon">
                                day
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
                        <input type="checkbox" class="icheck checkbox" name="auto_suspend_status" id="checkbox_auto_suspend-transaction_point" data-checkbox="icheckbox_square-blue" @if(isset($result[4][ 'auto_suspend_status']) && $result[4][ 'auto_suspend_status']=="1" ) checked @endif> Auto Suspend
                    </label>
                    <div class="portlet light bordered" id="div_auto_suspend-transaction_point" style="margin-bottom: 2%;display: none;">
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
                                                <input type="number" class="form-control field_transaction_point price" min="1" name="auto_suspend_value" value="{{$result[4]['auto_suspend_value']}}">
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
                                                <input type="number" class="form-control field_transaction_point price" min="1" name="auto_suspend_time_period" value="{{$result[4]['auto_suspend_time_period']}}">
                                                <span class="input-group-addon">
                                                        day
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
                        <input type="checkbox" class="icheck checkbox" name="forward_admin_status" id="checkbox_forward_admin-transaction_point" data-checkbox="icheckbox_square-blue" @if(isset($result[4][ 'forward_admin_status']) && $result[4][ 'forward_admin_status']=="1" ) checked @endif> Forward Admin
                    </label>
                    <div class="portlet light bordered" id="div_forward_admin-transaction_point" style="margin-bottom: 2%;display: none;">
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
                                            <select name="email_toogle" id="email_toogle_transaction_point" class="form-control select2" onChange="visibleDiv('email',this.value,'transaction_point')">
                                                <option value="0" @if(old('email_toogle') == '0') selected @else @if(isset($result[4]['email_toogle']) && $result[4]['email_toogle'] == "0") selected @endif @endif>Disabled</option>
                                                <option value="1" @if(old('email_toogle') == '1') selected @else @if(isset($result[4]['email_toogle']) && $result[4]['email_toogle'] == "1") selected @endif @endif>Enabled</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group" id="div_email_recipient_transaction_point" style="display:none">
                                        <div class="input-icon right">
                                            <label for="multiple" class="control-label col-md-3">
                                                Email Recipient
                                                <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan alamat email admin yang akan menerima laporan fraud detection, jika lebih dari 1 pisahkan dengan tanda koma (,)" data-container="body"></i>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea name="email_recipient" id="email_recipient" class="form-control field_email_transaction_point" placeholder="Email address recipient">@if(isset($result[4]['email_recipient'])){{ $result[4]['email_recipient'] }}@endif</textarea>
                                            <p class="help-block">Comma ( , ) separated for multiple emails</p>
                                        </div>
                                    </div>

                                    <div class="form-group" id="div_email_subject_transaction_point" style="display:none">
                                        <div class="input-icon right">
                                            <label class="col-md-3 control-label">
                                                Subject
                                                <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan subjek email, tambahkan text replacer bila perlu" data-container="body"></i>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="Email Subject" class="form-control field_email_transaction_point" name="email_subject" id="email_subject_transaction_point" @if(!empty(old('email_subject'))) value="{{old('email_subject')}}" @else @if(isset($result[4]['email_subject']) && $result[4]['email_subject'] != '') value="{{$result[4]['email_subject']}}" @endif @endif>
                                            <br>
                                            You can use this variables to display user personalized information:
                                            <br><br>
                                            <div class="row">
                                                @foreach($textreplaces_point as $key=>$row)
                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                        <span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailSubject('{{ $row['keyword'] }}','transaction_point');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="div_email_content_transaction_point" style="display:none">
                                        <div class="input-icon right">
                                            <label for="multiple" class="control-label col-md-3">
                                                Content
                                                <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten email, tambahkan text replacer bila perlu" data-container="body"></i>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea name="email_content" id="email_content_transaction_point" class="form-control summernote">@if(!empty(old('email_content'))) <?php echo old('email_content'); ?> @else @if(isset($result[4]['email_content']) && $result[4]['email_content'] != '') <?php echo $result[4]['email_content'];?> @endif @endif</textarea>
                                            You can use this variables to display user personalized information:
                                            <br><br>
                                            <div class="row" >
                                                @foreach($textreplaces_point as $key=>$row)
                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                        <span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailContent('{{ $row['keyword'] }}','transaction_point');">{{ str_replace('_',' ',$row['keyword']) }}</span>
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
                                            <select name="sms_toogle" id="sms_toogle" class="form-control select2" onChange="visibleDiv('sms',this.value,'transaction_point')">
                                                <option value="0" @if(old('sms_toogle') == '0') selected @else @if(isset($result[4]['sms_toogle']) && $result[4]['sms_toogle'] == "0") selected @endif @endif>Disabled</option>
                                                <option value="1" @if(old('sms_toogle') == '1') selected @else @if(isset($result[4]['sms_toogle']) && $result[4]['sms_toogle'] == "1") selected @endif @endif>Enabled</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group" id="div_sms_recipient_transaction_point" style="display:none">
                                        <div class="input-icon right">
                                            <label for="multiple" class="control-label col-md-3">
                                                SMS Recipient
                                                <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan no handphone admin yang akan menerima laporan fraud detection, jika lebih dari 1 pisahkan dengan tanda koma (,)" data-container="body"></i>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea name="sms_recipient" id="sms_recipient" class="form-control field_sms_transaction_point" placeholder="Phone number recipient">@if(isset($result[4]['sms_recipient'])){{ $result[4]['sms_recipient'] }}@endif</textarea>
                                            <p class="help-block">Comma ( , ) separated for multiple phone number</p>
                                        </div>
                                    </div>
                                    <div class="form-group" id="div_sms_content_transaction_point" style="display:none">
                                        <div class="input-icon right">
                                            <label for="multiple" class="control-label col-md-3">
                                                SMS Content
                                                <i class="fa fa-question-circle tooltips" data-original-title="isi pesan sms, tambahkan text replacer bila perlu" data-container="body"></i>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea name="sms_content" id="sms_content_transaction_point" class="form-control field_sms_transaction_point" placeholder="SMS Content">@if(!empty(old('sms_content'))) {{old('sms_content')}} @else @if(isset($result[4]['sms_content']) && $result[4]['sms_content'] != '') {{$result[4]['sms_content']}} @endif @endif</textarea>
                                            <br>
                                            You can use this variables to display user personalized information:
                                            <br><br>
                                            <div class="row">
                                                @foreach($textreplaces_point as $key=>$row)
                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                        <span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addSmsContent('{{ $row['keyword'] }}','transaction_point');">{{ str_replace('_',' ',$row['keyword']) }}</span>
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
                                            <select name="whatsapp_toogle" id="whatsapp_toogle" class="form-control select2 field_whatsapp_transaction_point" onChange="visibleDiv('whatsapp',this.value,'transaction_point')" @if(!$api_key_whatsapp) disabled @endif>
                                                <option value="0" @if(old('whatsapp_toogle') == '0') selected @else @if(isset($result[4]['whatsapp_toogle']) && $result[4]['whatsapp_toogle'] == "0") selected @endif @endif>Disabled</option>
                                                <option value="1" @if($api_key_whatsapp) @if(old('whatsapp_toogle') == '1') selected @else @if(isset($result[4]['whatsapp_toogle']) && $result[4]['whatsapp_toogle'] == "1") selected @endif @endif @endif>Enabled</option>
                                            </select>
                                        </div>
                                    </div>
                                    @if($api_key_whatsapp)
                                        <div class="form-group" id="div_whatsapp_recipient_transaction_point" style="display:none">
                                            <div class="input-icon right">
                                                <label for="multiple" class="control-label col-md-3">
                                                    WhatsApp Recipient
                                                    <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan no WhatsApp admin yang akan menerima laporan fraud detection, jika lebih dari 1 pisahkan dengan tanda koma (,)" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-9">
                                                <textarea name="whatsapp_recipient" id="whatsapp_recipient" class="form-control field_whatsapp_transaction_point" placeholder="WhatsApp number recipient">@if(isset($result[4]['whatsapp_recipient'])){{ $result[4]['whatsapp_recipient'] }}@endif</textarea>
                                                <p class="help-block">Comma ( , ) separated for multiple whatsApp number</p>
                                            </div>
                                        </div>
                                        <div class="form-group" id="div_whatsapp_content_transaction_point" style="display:none">
                                            <div class="input-icon right">
                                                <label for="multiple" class="control-label col-md-3">
                                                    WhatsApp Content
                                                    <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten whatsapp, tambahkan text replacer bila perlu" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-9">
                                                <textarea id="whatsapp_content_transaction_point" name="whatsapp_content" rows="3" style="white-space: normal" class="form-control whatsapp-content" placeholder="WhatsApp Content">{{$result[4]['whatsapp_content']}}</textarea>
                                                <br>
                                                You can use this variables to display user personalized information:
                                                <br><br>
                                                <div class="row">
                                                    @foreach($textreplaces_point as $key=>$row)
                                                        <div class="col-md-3" style="margin-bottom:5px;">
                                                            <span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal; height:40px" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addWhatsappContent('{{ $row['keyword'] }}','transaction_point');">{{ str_replace('_',' ',$row['keyword']) }}</span>
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
            <input type="hidden" value="{{$result[4]['id_fraud_setting']}}" name="id_fraud_setting">
            <input type="hidden" value="fraud_transaction_point" name="type">
            <div class="row" style="text-align: center">
                <button type="submit" class="btn blue" id="checkBtn">Save</button>
            </div>
        </div>
    </div>
</form>
