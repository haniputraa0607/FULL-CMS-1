<?php
use App\Lib\MyHelper;
$configs = session('configs');
?>
<div class="form-group">
    <div class="input-icon right">
        <label class="col-md-3 control-label">
        Voucher Type
        <span class="required" aria-required="true"> * </span>
        <i class="fa fa-question-circle tooltips" data-original-title="Tipe pembuatan voucher, di list secara manual, auto generate atau unlimited" data-container="body"></i>
        </label>
    </div>
    <div class="">
        <div class="input-icon right">
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="deals_voucher_type" id="radio1" value="Auto generated" class="voucherType">
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
                        <input type="radio" name="deals_voucher_type" id="radio2" value="List Vouchers" class="voucherType"  required>
                        <label for="radio2">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> List Voucher </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group" id="total-voucher-form" style="display: none;">
    <div class="input-icon right">
        <label class="col-md-3 control-label">
        Total Voucher Type
        <span class="required" aria-required="true"> * </span>
        <i class="fa fa-question-circle tooltips" data-original-title="Total voucher yang dibuat, limited atau unlimited" data-container="body"></i>
        </label>
    </div>
    <div class="">
        <div class="input-icon right">
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="total_voucher_type" id="radio-total-limited" value="Auto generated" class="voucherType" required>
                        <label for="radio-total-limited">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Limited </label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="total_voucher_type" id="radio-total-unlimited" value="Unlimited" class="voucherType" required>
                        <label for="radio-total-unlimited">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Unlimited </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group" id="listVoucher" @if (old('voucher_code')) style="display: block;" @else style="display: none;" @endif>
    <label class="col-md-3 control-label"></label>
    <div class="col-md-9">
        <div class="col-md-3">
            <label class="control-label">Input Voucher 
                <span class="required" aria-required="true"> * </span> 
                <br> <small> Separated by new line </small>
            </label>
        </div>
        <div class="col-md-9">
            <textarea name="voucher_code" class="form-control listVoucher" rows="10">{{ old('voucher_code') }}</textarea>
        </div>
    </div>
</div>

<div class="form-group" id="generateVoucher" @if (old('deals_total_voucher')) style="display: block;" @else style="display: none;" @endif>
    <label class="col-md-3 control-label"></label>
    <div class="col-md-9">
        <div class="col-md-3">
            <label class="control-label">Total Voucher <span class="required" aria-required="true"> * </span> </label>
        </div>
        <div class="col-md-9">
            <input type="text" class="form-control generateVoucher" name="deals_total_voucher" value="{{ old('deals_total_voucher') }}" placeholder="Total Voucher">
        </div>
    </div>
</div>

<br>
<div class="form-group">
    <div class="input-icon right">
        <label class="col-md-3 control-label">
        Voucher Price
        <span class="required" aria-required="true"> * </span>  
        <i class="fa fa-question-circle tooltips" data-original-title="Tipe pembayaran voucher (gratis, menggunakan point, atau menggunakan uang)" data-container="body"></i>
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-icon right">
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="prices_by" id="radio6" value="free" class="prices md-radiobtn" required @if (old('prices_by') == "free") checked @endif>
                        <label for="radio6">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Free </label>
                    </div>
                </div>
            </div>
            @if(MyHelper::hasAccess([19], $configs))
            <div class="col-md-3">
                    <div class="md-radio-inline">
                        <div class="md-radio">
                            <input type="radio" name="prices_by" id="radio7" value="point" class="prices md-radiobtn" required @if (old('prices_by') == "point") checked @endif>
                            <label for="radio7">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> Point </label>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="prices_by" id="radio8" value="money" class="prices md-radiobtn" required @if (old('prices_by') == "money") checked @endif>
                        <label for="radio8">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Money </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group" id="prices" @if (old('prices_by')!='free') style="display: block;" @else style="display: none;" @endif>
    <label class="col-md-3 control-label"></label>
    <div class="col-md-9">
        <div class="col-md-3">
            <label class="control-label price-label" style="display: none;">Values <span class="required" aria-required="true"> * </span> </label>
        </div>
        <div class="col-md-9 payment" id="point"  @if (old('prices_by') == "point") style="display: block;" @else style="display: none;" @endif>
            <input type="text" class="form-control point moneyOpp freeOpp" name="deals_voucher_price_point" value="{{ old('deals_voucher_price_point') }}" placeholder="Input point values">
        </div>
        <div class="col-md-9 payment" id="money" @if (old('prices_by') == "money") style="display: block;" @else style="display: none;" @endif>
            <input type="text" class="form-control money pointOpp freeOpp price" name="deals_voucher_price_cash" value="{{ old('deals_voucher_price_cash') }}" placeholder="Input money values">
        </div>
    </div>
</div>

<br>

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
                <input type="text" class="form_datetime form-control" name="deals_voucher_start" value="{{ old('deals_voucher_start') }}">
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
        Voucher Expiry
        <span class="required" aria-required="true"> * </span>  
        <i class="fa fa-question-circle tooltips" data-original-title="Masa berlaku voucher, bisa diatur berdasarkan durasi deal atau tanggal expirednya." data-container="body"></i>
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-icon right">
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="duration" id="radio9" value="dates" class="expiry md-radiobtn" required @if (old('duration') == "dates") checked @endif required>
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
                        <input type="radio" name="duration" id="radio10" value="duration" class="expiry md-radiobtn" required @if (old('duration') == "duration") checked @endif required>
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

<div class="form-group" id="times"  @if (old('duration')) style="display: block;" @else style="display: none;" @endif>
    <label class="col-md-3 control-label"></label>
    <div class="col-md-9">
        <div class="col-md-3">
            <label class="control-label">Expiry <span class="required" aria-required="true"> * </span> </label>
        </div>
        <div class="col-md-9 voucherTime" id="dates" @if (old('duration') == "dates") style="display: block;" @else style="display: none;" @endif>
            <div class="input-group">
                <input type="text" class="form_datetime form-control dates durationOpp" name="deals_voucher_expired" value="{{ old('deals_voucher_expired') }}" @if(old('duration') == "dates") required @endif>
                <span class="input-group-btn">
                    <button class="btn default" type="button">
                        <i class="fa fa-calendar"></i>
                    </button>
                </span>
            </div>
        </div>
        <div class="col-md-9 voucherTime" id="duration" @if (old('duration') == "duration") style="display: block;" @else style="display: none;" @endif>
            <div class="input-group">
                <input type="number" class="form-control duration datesOpp" name="deals_voucher_duration" value="{{ old('deals_voucher_duration') }}" @if(old('duration') == "duration") required @endif>
                <span class="input-group-btn">
                    <button class="btn default" type="button">
                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah hari masa berlaku voucher. Jika voucher start date diisi, maka dihitung berdasarkan voucher start date. Jika tidak, berdasarkan tanggal claim voucher" data-container="body"></i>
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>