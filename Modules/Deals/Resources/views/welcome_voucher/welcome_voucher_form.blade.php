<?php
use App\Lib\MyHelper;
$configs = session('configs');
?>
<input type="hidden" value="Unlimited" name="deals_voucher_type">

<div class="form-group">
    <div class="input-icon right">
        <label class="col-md-3 control-label">
        Voucher Start Date
        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal voucher mulai dapat digunakan, kosongkan bila voucher tidak memiliki minimal tanggal penggunaan" data-container="body"></i>
        </label>
    </div>
    <div class="col-md-4">
        <div class="input-icon right">
            <div class="input-group">
                <input type="text" class="form_datetime form-control" name="deals_voucher_start" value="{{ old('deals_voucher_start') }}" placeholder="Voucher start date">
                <span class="input-group-btn">
                    <button class="btn default" type="button">
                        <i class="fa fa-calendar"></i>
                    </button>
                    <button class="btn default" type="button">
                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal voucher mulai dapat digunakan" data-container="body"></i>
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="input-icon right">
        <label class="col-md-3 control-label">
        Voucher Duration
        <i class="fa fa-question-circle tooltips" data-original-title="Masa berlaku voucher, bisa diatur berdasarkan durasi. Kosongkan jika voucher tidak memiliki expired." data-container="body"></i>
        </label>
    </div>
    <div class="col-md-4">
        <div class="input-group">
            <input type="number" class="form-control price" min="1" name="deals_voucher_duration" value="{{ old('deals_voucher_duration') }}" placeholder="Voucher Expired">
            <span class="input-group-addon">
                day
            </span>
        </div>
    </div>
</div>
