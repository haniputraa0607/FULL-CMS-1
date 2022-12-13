<?php
	use App\Lib\MyHelper;
    $configs    		= session('configs');
 ?>
            @if (empty($deals['deals_type']) || $deals['deals_type'] != "Point")
                <div class="form-body">

                	{{-- Deals Type, Offline, Online --}}
                    <input type="hidden" name="is_offline" value="0">
                    <input type="hidden" name="is_online" value="1">

                    {{-- Brand --}}
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

                    {{-- Title --}}
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

                    {{-- Second Title --}}
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

                    {{-- Deals Periode --}}
                    @if ( $deals_type == "Deals" || $deals_type == "WelcomeVoucher" )
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

                    {{-- Publish Periode --}}
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

                    {{-- Image --}}
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

                    {{-- Outlet --}}
                    @php
                        if (!empty($deals['outlets'])) {
                            $outletselected = array_pluck($deals['outlets'],'id_outlet');
                        }
                        elseif(!empty($deals['deals_list_outlet'])) {
                            $outletselected = explode(',',$deals['deals_list_outlet']);
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
                            <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[]" multiple data-value="{{json_encode(old('id_outlet')??$outletselected??[])}}" data-all-outlet="{{json_encode($outlets??[])}}" required>
                            	@if(!empty($outlets))
                                    <option value="all">All Outlets</option>
                                    @foreach($outlets as $row)
                                        <option value="{{$row['id_outlet']}}">{{$row['outlet_code']}} - {{$row['outlet_name']}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    {{-- Custom Outlet Text --}}
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Custom Outlet Available Text
                            <i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan ditampilkan untuk mengganti daftar outlet untuk penukaran. Kosongkan bila ingin menampilkan daftar outlet saja." data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <textarea name="custom_outlet_text" id="field_tos" class="form-control summernote" placeholder="Custom Outlet Available Text">{{ old('custom_outlet_text')??$deals['custom_outlet_text']??'' }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Voucher Price --}}
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
                                <input type="text" class="form-control point moneyOpp freeOpp {{env('COUNTRY_CODE') == 'SG' ? 'dinamic_price' : 'digit-mask'}}" name="deals_voucher_price_point" value="{{ $deals['deals_voucher_price_point']??'' }}" placeholder="Input point values" autocomplete="off">
                            </div>
                            <div class="col-md-9 payment" id="money"
                            	@if ( old('prices_by'))
                                    @if ( old('prices_by') != "money" )
                                        style="display: none;"
                                    @endif
                                @elseif ( empty($deals['deals_voucher_price_cash']) )
                            		style="display: none;"
                            	@endif>
                                <input type="text" class="form-control money pointOpp freeOpp dinamic_price" name="deals_voucher_price_cash" value="{{ $deals['deals_voucher_price_cash']??'' }}" placeholder="Input money values" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- AutoGenerate --}}

                    {{-- Voucher Expiry --}}
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Voucher Expiry
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masa berlaku voucher, bisa diatur berdasarkan durasi deal atau tanggal expirednya" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" min="1" class="form-control duration datesOpp digit-mask" name="deals_voucher_duration" value="{{ old('deals_voucher_duration')??$deals['deals_voucher_duration']??'' }}" autocomplete="off">
                                <span class="input-group-addon">
                                    day after claimed
                                </span>
                            </div>

                        </div>
                    </div>
                    
                    {{-- days --}}
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Voucher Day
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Voucher hanya akan berlaku pada hari yang dipilih" data-container="body"></i>
                            </label>
                        </div>
                        <div class="">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="is_all_days" id="radio1" value="1" class="voucherDay"
                                            	@if ( old('is_all_days') )
                                            		@if ( old('is_all_days') == "1" ) checked
                                            		@endif
                                            	@elseif (
                                                        isset($deals['is_all_days']) &&
                                            			($deals['is_all_days']??false) == "1" 
                                            		) checked
                                            	@endif>
                                            <label for="radio1">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> All Days </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="is_all_days" id="radio2" value="0" class="voucherDay"
                                            @if ( old('is_all_days') )
                                            	@if ( old('is_all_days') == "0" ) checked
                                            	@endif
                                            @elseif ( isset($deals['is_all_days']) && ($deals['is_all_days']??false) == "0") checked
                                            @endif required>
                                            <label for="radio2">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Selected Day </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Product type --}}
                    <div class="form-group" id="selectedDay" @if( isset($deals['is_all_days']) && ($deals['is_all_days']??false) == "0" ) hidden @endif>
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Select Days
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih hari voucher dapat digunakan" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                @php
									$selected_days = [];
									if (old('selected_day[]')) {
										$selected_days = old('selected_day[]');
									}
									elseif (!empty($result['deals_days'])) {
										$selected_days = array_column($result['deals_days'], 'day');
									}
								@endphp
								<select	select id="select-day" name="selected_day[]" class="form-control select2-multiple select2-hidden-accessible" multiple="multiple" tabindex="-1" aria-hidden="true">
									<option value="Monday" @if ($selected_days) @if(in_array('Monday', $selected_days)) selected @endif @endif>Monday</option>
									<option value="Tuesday" @if ($selected_days) @if(in_array('Tuesday', $selected_days)) selected @endif @endif>Tuesday</option>
									<option value="Wednesday" @if ($selected_days) @if(in_array('Wednesday', $selected_days)) selected @endif @endif>Wednesday</option>
									<option value="Thursday" @if ($selected_days) @if(in_array('Thursday', $selected_days)) selected @endif @endif>Thursday</option>
									<option value="Friday" @if ($selected_days) @if(in_array('Friday', $selected_days)) selected @endif @endif>Friday</option>
									<option value="Saturday" @if ($selected_days) @if(in_array('Saturday', $selected_days)) selected @endif @endif>Saturday</option>
									<option value="Sunday" @if ($selected_days) @if(in_array('Sunday', $selected_days)) selected @endif @endif>Sunday</option>
								</select>
                            </div>
                        </div>
                    </div>


                </div>
            @else
                @include('deals::deals.info-point')
            @endif
