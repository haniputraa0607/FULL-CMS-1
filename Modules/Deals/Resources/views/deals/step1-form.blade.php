<?php
	use App\Lib\MyHelper;
    $configs    		= session('configs');
 ?>
            @if (empty($deals['deals_type']) || $deals['deals_type'] != "Point")
                <div class="form-body">
                	@if(MyHelper::hasAccess([99], $configs) && MyHelper::hasAccess([100], $configs))
                	<div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Deals Type
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih tipe untuk deal ini" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                        	<div class="mt-checkbox-inline">
                                <label class="mt-checkbox mt-checkbox-outline" style="margin-bottom: 0px">
                                    <input class="online_offline" type="checkbox" id="is_online" name="is_online" value="1"
                                    @if ( old('is_online') == "1" )
                                        checked
                                    @elseif ( !empty($deals['is_online']) )
                                        checked
                                    @endif

                                    @if (old('is_online') == 1 || old('is_offline') == 1)
                                    @elseif(empty($deals['is_online']) && empty($deals['is_offline']))
                                    	required
                                    @else
                                    @endif> Online
                                    <span></span>
                                </label>
                                <label class="mt-checkbox mt-checkbox-outline" style="margin-bottom: 0px">
                                    <input class="online_offline" type="checkbox" id="is_offline" name="is_offline" value="1"
                                    @if ( old('is_offline') == "1" )
                                        checked
                                    @elseif ( !empty($deals['is_offline']) )
                                        checked
                                    @endif

                                    @if (old('is_online') == 1 || old('is_offline') == 1)
                                    @elseif(empty($deals['is_online']) && empty($deals['is_offline']))
                                    	required
                                    @else
                                    @endif> Offline
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @elseif(MyHelper::hasAccess([99], $configs))
                    <input type="hidden" name="is_offline" value="1">
                    @elseif(MyHelper::hasAccess([100], $configs))
                    <input type="hidden" name="is_online" value="1">
                    @endif

                    @if(MyHelper::hasAccess([97], $configs))
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Brand
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih brand untuk deal ini" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <select class="form-control select2-multiple" data-placeholder="Select Brand" name="id_brand" required>
                                    <option></option>
                                @if (!empty($brands))
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand['id_brand'] }}" @if ( old('id_brand',($deals['id_brand']??false)) ) @if($brand['id_brand'] == old( 'id_brand',($deals['id_brand']??false) )) selected @endif @endif>{{ $brand['name_brand'] }}</option>
                                    @endforeach
                                @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="form-group" id="product-type-form" @if( empty($deals['is_online']) ) style="display: none;" @endif>
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Product Type
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Tipe produk yang akan dikenakan deal ini" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-2">
                            <div class="input-icon right">
                                <select class="form-control" name="product_type">
									<option value="single" @if(isset($deals['product_type']) && $deals['product_type'] == "single") selected @endif required> Single </option>
									<option value="group" @if(isset($deals['product_type']) && $deals['product_type'] == "group") selected @endif> Group </option>
		                        </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Title
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Judul deals" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="deals_title" value="{{ old('deals_title')??$deals['deals_title']??'' }}" placeholder="Title" required maxlength="45" autocomplete="off">
                        </div>
                    </div>

                    @if(MyHelper::hasAccess([101], $configs))
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Second Title
                            <i class="fa fa-question-circle tooltips" data-original-title="Sub judul deals jika ada" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="deals_second_title" value="{{ old('deals_second_title')??$deals['deals_second_title']??'' }}" placeholder="Second Title" maxlength="20" autocomplete="off">
                        </div>
                    </div>
                    @endif

                    @if ( $deals_type == "Deals" )
                    <div class="form-group">
                        <label class="col-md-3 control-label"> Deals Periode <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="deals_start" value="{{ !empty($deals['deals_start']) || old('deals_start') ? date('d-M-Y H:i', strtotime(old('deals_start')??$deals['deals_start'])) : ''}}" required autocomplete="off">
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
                                    <input type="text" class="form_datetime form-control" name="deals_end" value="{{ !empty($deals['deals_end']) || old('deals_end') ? date('d-M-Y H:i', strtotime(old('deals_end')??$deals['deals_end'])) : ''}}" required autocomplete="off">
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
                    @endif

                    @if ($deals_type == "Deals")
                    <div class="form-group">
                        <label class="col-md-3 control-label"> Publish Periode <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="deals_publish_start" value="{{ !empty($deals['deals_publish_start']) || old('deals_publish_start') ? date('d-M-Y H:i', strtotime(old('deals_publish_start')??$deals['deals_publish_start'])) : '' }}" required autocomplete="off">
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
                                    <input type="text" class="form_datetime form-control" name="deals_publish_end" value="{{ !empty($deals['deals_publish_end']) || old('deals_publish_end') ? date('d-M-Y H:i', strtotime(old('deals_publish_end')??$deals['deals_publish_end'])) : '' }}" required autocomplete="off">
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
                                  <img src="{{ $deals['url_deals_image']??'https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image' }}" alt="Image Deals">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" accept="image/*"  {{ empty($deals['url_deals_image']) ? 'required' : '' }} name="deals_image" id="file">

                                    </span>

                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        if (!empty($deals['outlets'])) {
                            $outletselected = array_pluck($deals['outlets'],'id_outlet');
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
                            <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[]" multiple data-value="{{json_encode(old('id_outlet')??$outletselected??[])}}" data-all-outlet="{{json_encode($outlets??[])}}">
                            	@if(!empty($outlets))
                                    <option value="all">All Outlets</option>
                                    @foreach($outlets as $row)
                                        <option value="{{$row['id_outlet']}}">{{$row['outlet_code']}} - {{$row['outlet_name']}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Custom Outlet Available Text
                            <i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan ditampilkan untuk mengganti daftar outlet untuk penukaran. Kosongkan bila ingin menampilkan daftar outlet saja." data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <textarea name="custom_outlet_text" id="field_tos" class="form-control summernote" placeholder="Custom Outlet Available Text">{{ old('custom_outlet_text') }}</textarea>
                            </div>
                        </div>
                    </div>

                    @if ( $deals_type == "Deals" )
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
                                    <input type="radio" name="prices_by" id="radio6" value="free" class="prices md-radiobtn" required
                                    	@if (old('prices_by'))
	                                    	@if (old('prices_by') == "free") checked
	                                    	@endif
                                    	@elseif (isset($deals['id_deals']) && empty($deals['deals_voucher_price_point']) && empty($deals['deals_voucher_price_cash'])) checked
                                    	@endif>
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
                                    <input type="radio" name="prices_by" id="radio7" value="point" class="prices md-radiobtn" required
                                    	@if (old('prices_by'))
                                    		@if (old('prices_by') == "point") checked
                                    		@endif
                                    	@elseif (!empty($deals['deals_voucher_price_point'])) checked
                                    	@endif>
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
                                    <input type="radio" name="prices_by" id="radio8" value="money" class="prices md-radiobtn" required
                                    	@if (old('prices_by'))
	                                    	@if (old('prices_by') == "money") checked
	                                    	@endif
                                    	@elseif (!empty($deals['deals_voucher_price_cash'])) checked
                                    	@endif>
                                    <label for="radio8">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Money </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="prices"
                    	@if (old('prices_by'))
                    		@if (old('prices_by') == "free")
                    	 		style="display: none;"
                    		@endif
                    	@elseif ( empty($deals['deals_voucher_price_point']) && empty($deals['deals_voucher_price_cash']) )
                    		style="display: none;"
                    	@endif>
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Values <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9 payment" id="point"
                            	@if ( old('prices_by'))
                                    @if ( old('prices_by') != "point" )
                                        style="display: none;"
                                    @endif
                                @elseif ( empty($deals['deals_voucher_price_point']) )
                            		style="display: none;"
                            	@endif>
                                <input type="text" class="form-control point moneyOpp freeOpp digit-mask" name="deals_voucher_price_point" value="{{ $deals['deals_voucher_price_point']??'' }}" placeholder="Input point values" autocomplete="off">
                            </div>
                            <div class="col-md-9 payment" id="money"
                            	@if ( old('prices_by'))
                                    @if ( old('prices_by') != "money" )
                                        style="display: none;"
                                    @endif
                                @elseif ( empty($deals['deals_voucher_price_cash']) )
                            		style="display: none;"
                            	@endif>
                                <input type="text" class="form-control money pointOpp freeOpp price" name="deals_voucher_price_cash" value="{{ $deals['deals_voucher_price_cash']??'' }}" placeholder="Input money values" autocomplete="off">
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
                        <div class="">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="deals_voucher_type" id="radio1" value="Auto generated" class="voucherType"
                                            	@if ( old('deals_voucher_type') )
                                            		@if ( old('deals_voucher_type') == 'Auto generated' ) checked
                                            		@endif
                                            	@elseif (
                                            			($deals['deals_voucher_type']??false) == "Auto generated" ||
                                            			($deals['deals_voucher_type']??false) == "Unlimited"
                                            		) checked
                                            	@endif>
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
                                            <input type="radio" name="deals_voucher_type" id="radio2" value="List Vouchers" class="voucherType"
                                            @if ( old('deals_voucher_type') )
                                            	@if ( old('deals_voucher_type') == 'List Vouchers' ) checked
                                            	@endif
                                            @elseif ( ($deals['deals_voucher_type']??false) == "List Vouchers") checked
                                            @endif required>
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

                    <div class="form-group" id="total-voucher-form"
                    @if( old('deals_voucher_type') == 'Auto generated' || old('deals_voucher_type') == 'Unlimited' || ($deals['deals_voucher_type']??false) == 'Unlimited' || ($deals['deals_voucher_type']??false) == 'Auto generated' )
                    @elseif( old('deals_voucher_type') != 'Auto generated' || empty($deals['deals_voucher_type']) || ($deals['deals_voucher_type'] != 'Auto generated') )
                    	style="display: none;"
                    @endif>
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
                                            <input type="radio" name="total_voucher_type" id="radio-total-limited" value="Auto generated" class="voucherType" @if ( old('total_voucher_type') == 'Auto generated' || ($deals['deals_voucher_type']??false) == "Auto generated") checked @endif>
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
                                            <input type="radio" name="total_voucher_type" id="radio-total-unlimited" value="Unlimited" class="voucherType" @if ( old('total_voucher_type') == 'Unlimited' || ($deals['deals_voucher_type']??false) == "Unlimited") checked @endif>
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
{{--
                    @if ($deals['deals_voucher_type'] == "Auto generated" || $deals['deals_voucher_type'] == "List Vouchers")
                    <div class="form-group">
                        <label class="col-md-3 control-label">Voucher Total <span class="required" aria-required="true"> * </span></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="deals_total_voucher" value="{{ $deals['deals_total_voucher'] }}" placeholder="Total Voucher" required="">

                        </div>
                    </div>
                    @endif
 --}}
					<div class="form-group" id="listVoucher"
						@if (old('voucher_code')||old('deals_voucher_type',($deals['deals_voucher_type']??false)) == "List Vouchers") style="display: block;"
						@else
							style="display: none;"
						@endif>
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Input Voucher
                                    <span class="required" aria-required="true"> * </span>
                                    <br> <small> Separated by new line </small>
                                </label>
                            </div>
                            <div class="col-md-9">
                            	@php 
	                        		$voucher_code = old('voucher_code')??"";

	                        		if(!empty($voucher))
	                        		{
	                        			$voucher_code = "";
	                        			foreach($voucher??[] as $row)
										{
											$voucher_code .= $row['voucher_code']."\n";
										}
										// dd($voucher_code);
	                        		}
	                        	@endphp
	                            <textarea name="voucher_code" class="form-control listVoucher" rows="10">@php 
	                            	if(old('voucher_code'))
	                            	{
	                            		echo old('voucher_code');
	                            	}
	                            	else
	                            	{
										echo $voucher_code;
	                            	}@endphp</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="generateVoucher" @if (!(old('voucher_code')||old('deals_voucher_type',($deals['deals_voucher_type']??false)) == "List Vouchers")&&old('deals_total_voucher',($deals['deals_total_voucher']??false))) style="display: block;" @else style="display: none;" @endif>
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Total Voucher <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control generateVoucher digit-mask" name="deals_total_voucher" value="{{ old('deals_total_voucher',($deals['deals_total_voucher']??false)) }}" min="0" placeholder="Total Voucher" autocomplete="off">
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
                                    <input type="text" class="form_datetime form-control" name="deals_voucher_start" value="{{ ($start_date=old('deals_voucher_start',($deals['deals_voucher_start']??false)))?date('d-M-Y H:i',strtotime($start_date)):'' }}" autocomplete="off">
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
                            <i class="fa fa-question-circle tooltips" data-original-title="Masa berlaku voucher, bisa diatur berdasarkan durasi deal atau tanggal expirednya" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" name="duration" id="radio9" value="dates" class="expiry md-radiobtn" required
                                    	@if ( old('duration') ) checked
                                    		@if ( old('duration') == "dates" ) checked
                                    		@endif
                                    	@elseif (!empty($deals['deals_voucher_expired'])) checked
                                    	@endif>
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
                                    <input type="radio" name="duration" id="radio10" value="duration" class="expiry md-radiobtn" required
                                    	@if ( old('duration') ) checked
                                    		@if ( old('duration') == "duration" ) checked
                                    		@endif
                                    	@elseif ( !empty($deals['deals_voucher_duration']) ) checked
                                    	@endif>
                                    <label for="radio10">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Duration </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="times"
                    	@if (old('duration') || (!empty($deals['deals_voucher_expired']) || !empty($deals['deals_voucher_duration'])) ) style="display: block;"
                    	@else
                    		style="display: none;"
                    	@endif>
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Expiry <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9 voucherTime" id="dates"
                            	@if (old('duration') == "dates") style="display: block;"
                            	@elseif (empty($deals['deals_voucher_expired'])) style="display: none;"
                            	@endif>
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control dates durationOpp" name="deals_voucher_expired" @if (old('deals_voucher_expired') || !empty($deals['deals_voucher_expired'])) value="{{ date('d-M-Y H:i', strtotime(old('deals_voucher_expired')??$deals['deals_voucher_expired'])) }}" @endif autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-9 voucherTime" id="duration"
                            	@if (old('duration') == "duration") style="display: block;"
                            	@elseif (empty($deals['deals_voucher_duration'])) style="display: none;"
                            	@endif>
                                <div class="input-group">
                                    <input type="text" min="1" class="form-control duration datesOpp digit-mask" name="deals_voucher_duration" value="{{ old('deals_voucher_duration')??$deals['deals_voucher_duration']??'' }}" autocomplete="off">
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
                                <input type="text" class="form-control digit-mask" min="0" name="user_limit" value="{{ old('user_limit')??$deals['user_limit']??'' }}" placeholder="User limit" maxlength="30" autocomplete="off">
                            </div>
                        </div>
                    </div>

                </div>
            @else
                @include('deals::deals.info-point')
            @endif
