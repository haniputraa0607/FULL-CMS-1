<div class="portlet-body form">
    <form id="form" class="form-horizontal" role="form" action=" @if($deals_type == "Deals") {{ url('deals/update') }} @else {{ url('hidden-deals/update') }} @endif" method="post" enctype="multipart/form-data">
        @foreach ($deals as $key => $val)

            @if ($val['deals_type'] != "Point")
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
                            <input type="text" class="form-control" name="deals_title" value="{{ $val['deals_title'] }}" placeholder="Title" required maxlength="20">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Second Title
                            <i class="fa fa-question-circle tooltips" data-original-title="Sub judul deals jika ada" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="deals_second_title" value="{{ $val['deals_second_title'] }}" placeholder="Second Title" maxlength="20">
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
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" id="radio14" name="deals_promo_id_type" class="md-radiobtn dealsPromoType" value="promoid" required @if ($val['deals_promo_id_type'] == "promoid") checked @endif>
                                    <label for="radio14">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Promo ID </label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="radio16" name="deals_promo_id_type" class="md-radiobtn dealsPromoType" value="nominal" required @if ($val['deals_promo_id_type'] == "nominal") checked @endif>
                                    <label for="radio16">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Nominal </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group dealsPromoTypeShow">
                        <label class="col-md-3 control-label"> </label>
                        <div class="col-md-9">
                            <input type="text" class="form-control dealsPromoTypeValuePromo" name="deals_promo_id_promoid" value="{{ $val['deals_promo_id'] }}" placeholder="Input Promo ID" @if ($val['deals_promo_id_type'] == "nominal") style="display: none;" @endif>

                            <input type="text" class="form-control dealsPromoTypeValuePrice price" name="deals_promo_id_nominal" value="{{ $val['deals_promo_id'] }}" placeholder="Input nominal" @if ($val['deals_promo_id_type'] == "promoid") style="display: none;" @endif>
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
                            <textarea name="deals_short_description" class="form-control" required>{{ $val['deals_short_description'] }}</textarea>
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
                            <textarea name="deals_description" id="field_content_long" class="form-control summernote">{{ $val['deals_description'] }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"> Deals Periode <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="deals_start" value="{{ date('d-M-Y H:i', strtotime($val['deals_start'])) }}" required>
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
                                    <input type="text" class="form_datetime form-control" name="deals_end" value="{{ date('d-M-Y H:i', strtotime($val['deals_end'])) }}" required>
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

                    @if ($val['deals_type'] == "Deals")
                    <div class="form-group">
                        <label class="col-md-3 control-label"> Publish Periode <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="deals_publish_start" value="{{ date('d-M-Y H:i', strtotime($val['deals_publish_start'])) }}" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai deals dipublish" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="deals_publish_end" value="{{ date('d-M-Y H:i', strtotime($val['deals_publish_end'])) }}" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai deals dipublish" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

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
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                  <img src="{{ $val['url_deals_image'] }}" alt="Image Deals">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" accept="image/*" name="deals_image" id="file">

                                    </span>

                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        if (!empty($val['outlets'])) {
                            $outletselected = array_pluck($val['outlets'],'id_outlet');
                        }
                        else {
                            $outletselected = [];
                        }
                    @endphp

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Outlet Available
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang memberlakukan deals tersebut" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[]" multiple>
                                <optgroup label="Outlet List">
                                    @if (!empty($outlets))
                                        @php
                                            $jmlOutlet = count($outlets);
                                            $jmlOutletSelected = count($outletselected);
                                        @endphp

                                        @if ($jmlOutlet == $jmlOutletSelected)
                                            <option value="all" selected>All Outlets</option>
                                            @foreach($outlets as $suw)
                                                <option value="{{ $suw['id_outlet'] }}" >{{ $suw['outlet_code'] }} - {{ $suw['outlet_name'] }}</option>
                                            @endforeach
                                        @else
                                            @foreach($outlets as $suw)
                                                <option value="{{ $suw['id_outlet'] }}" @if (!empty($outletselected)) @if (in_array($suw['id_outlet'], $outletselected)) selected @endif  @endif>{{ $suw['outlet_code'] }} - {{ $suw['outlet_name'] }}</option>
                                            @endforeach
                                        @endif

                                    @endif
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    @if ($val['deals_type'] != "Hidden")
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Voucher Price
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Tipe pembayaran voucher (gratis, menggunakan point, atau menggunakan uang)" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" name="prices_by" id="radio6" value="free" class="prices md-radiobtn" required @if (empty($val['deals_voucher_price_point']) && empty($val['deals_voucher_price_cash'])) checked @endif>
                                    <label for="radio6">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Free </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" name="prices_by" id="radio7" value="point" class="prices md-radiobtn" required @if (!empty($val['deals_voucher_price_point'])) checked @endif>
                                    <label for="radio7">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Point </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" name="prices_by" id="radio8" value="money" class="prices md-radiobtn" required @if (!empty($val['deals_voucher_price_cash'])) checked @endif>
                                    <label for="radio8">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Money </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="prices" @if (empty($val['deals_voucher_price_point']) && empty($val['deals_voucher_price_cash'])) style="display: none;" @endif>
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Values <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9 payment" id="point" @if (empty($val['deals_voucher_price_point'])) style="display: none;" @endif>
                                <input type="text" class="form-control point moneyOpp freeOpp" name="deals_voucher_price_point" value="{{ $val['deals_voucher_price_point'] }}" placeholder="Input point values">
                            </div>
                            <div class="col-md-9 payment" id="money" @if (empty($val['deals_voucher_price_cash'])) style="display: none;" @endif>
                                <input type="text" class="form-control money pointOpp freeOpp price" name="deals_voucher_price_cash" value="{{ $val['deals_voucher_price_cash'] }}" placeholder="Input money values">
                            </div>
                        </div>
                    </div>
                    @endif

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
                                            <input type="radio" name="deals_voucher_type" id="radio1" value="Auto generated" class="voucherType" @if ($val['deals_voucher_type'] == "Auto generated") checked @endif>
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
                                            <input type="radio" name="deals_voucher_type" id="radio2" value="List Vouchers" class="voucherType" @if ($val['deals_voucher_type'] == "List Vouchers") checked @endif required>
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
                                            <input type="radio" name="deals_voucher_type" id="radio3" value="Unlimited" class="voucherType" @if ($val['deals_voucher_type'] == "Unlimited") checked @endif required>
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

                    @if ($val['deals_voucher_type'] == "Auto generated" || $val['deals_voucher_type'] == "List Vouchers")
                    <div class="form-group">
                        <label class="col-md-3 control-label">Voucher Total <span class="required" aria-required="true"> * </span></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="deals_total_voucher" value="{{ $val['deals_total_voucher'] }}" placeholder="Total Voucher" required="">

                        </div>
                    </div>
                    @endif

                    <br>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Voucher Expiry
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masa berlaku voucher, bisa diatur berdasarkan durasi deal atau tanggal expirednya" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" name="duration" id="radio9" value="dates" class="expiry md-radiobtn" required @if (!empty($val['deals_voucher_expired'])) checked @endif>
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
                                    <input type="radio" name="duration" id="radio10" value="duration" class="expiry md-radiobtn" required @if (!empty($val['deals_voucher_duration'])) checked @endif>
                                    <label for="radio10">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Duration </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="times" >
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Expiry <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9 voucherTime" id="dates"  @if (empty($val['deals_voucher_expired'])) style="display: none;" @endif>
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control dates durationOpp" name="deals_voucher_expired" @if (!empty($val['deals_voucher_expired'])) value="{{ date('d-M-Y H:i', strtotime($val['deals_voucher_expired'])) }}" @endif>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-9 voucherTime" id="duration" @if (empty($val['deals_voucher_duration'])) style="display: none;" @endif>
                                <div class="input-group">
                                    <input type="number" min="1" class="form-control duration datesOpp" name="deals_voucher_duration" value="{{ $val['deals_voucher_duration'] }}">
                                    <span class="input-group-addon">
                                        day after claimed
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            User Limit
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Batasan user untuk claim voucher, input 0 untuk unlimited" data-container="body"></i>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="number" class="form-control" min="0" name="user_limit" value="{{ $val['user_limit'] }}" placeholder="User limit" maxlength="30">
                            </div>
                        </div>
                    </div>

                </div>
            @else
                @include('deals::deals.info-point')
            @endif
            <div class="form-actions">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn green">Submit</button>
                        <!-- <button type="button" class="btn default">Cancel</button> -->
                    </div>
                </div>
            </div>
            <input type="hidden" name="id_deals" value="{{ $val['id_deals'] }}">
            <input type="hidden" name="deals_type" value="{{ $val['deals_type'] }}">
        @endforeach
    </form>
</div>