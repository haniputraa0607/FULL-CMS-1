<?php
use App\Lib\MyHelper;
$configs = session('configs');
?>
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gear"></i>Fraud Device</div>
        <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
        </div>
    </div>
    <div class="portlet-body">
        <p>Setting Fraud Detection Device adalah mengatur maksimal akun yang dapat digunakan dalam 1 device ID. Jika user sudah terkena fraud maka akan otomatis tidak bisa masuk.</p>
        <p>Anda bisa memberikan action untuk setiap tipe, action dibagi menjadi 2 yaitu :</p>
        <ul>
            <li>Auto Suspend : jika user melakukan pelanggaran sesuai dengan aturan yang ada maka account tersebut akan secara otomatis disuspend</li>
            <li>Forward Admin : jika user melakukan pelanggaran sesuai dengan aturan yang ada maka akan mengirimkan notifikasi keadmin  </li>
        </ul>
    </div>
</div>

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
                                            <textarea name="sms_recipient" id="sms_recipient" class="form-control field_sms_device_id" placeholder="Phone number recipient">@if(isset($result[2]['sms_recipient'])){{ $result[2]['sms_recipient'] }}@endif</textarea>
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
                                            <textarea name="sms_content" id="sms_content_device_id" class="form-control field_sms_device_id" placeholder="SMS Content">@if(!empty(old('sms_content'))) {{old('sms_content')}} @else @if(isset($result[2]['sms_content']) && $result[2]['sms_content'] != '') {{$result[2]['sms_content']}} @endif @endif</textarea>
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
                                        <div class="form-group" id="div_whatsapp_content_device_id" style="display:none">
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