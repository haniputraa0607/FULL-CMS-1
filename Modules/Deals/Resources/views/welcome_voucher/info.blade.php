<div class="portlet-body form">
    <form id="form" class="form-horizontal" role="form" action=" @if($deals_type == "Deals") {{ url('deals/update') }} @else {{ url('welcome-voucher/update') }} @endif" method="post" enctype="multipart/form-data">
        @foreach ($deals as $key => $val)

            @if ($val['deals_type'] != "Point")
                <div class="form-body">
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
                                        <option value="{{ $brand['id_brand'] }}" @if (old('id_brand',$val['id_brand'])) @if($brand['id_brand'] == old('id_brand',$val['id_brand'])) selected @endif @endif>{{ $brand['name_brand'] }}</option>
                                    @endforeach
                                @endif
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
                            <input type="text" class="form-control" name="deals_title" value="{{ $val['deals_title'] }}" placeholder="Title" required>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Second Title
                            <i class="fa fa-question-circle tooltips" data-original-title="Sub judul deals jika ada" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="deals_second_title" value="{{ $val['deals_second_title'] }}" placeholder="Second Title" maxlength="20">
                        </div>
                    </div> -->


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

<!--                     <div class="form-group">
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
                    </div> -->

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
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Terms and Conditions
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Syarat dan ketentuan mengenai deals" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <textarea name="deals_tos" id="field_tos" class="form-control summernote" placeholder="Deals Terms and Conditions">{{ old('deals_tos',$val['deals_tos']) }}</textarea>
                            </div>
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
                                <textarea name="custom_outlet_text" id="field_tos" class="form-control summernote" placeholder="Custom Outlet Available Text">{{ old('custom_outlet_text',$val['custom_outlet_text']) }}</textarea>
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
                            <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[]" multiple data-value="{{json_encode($outletselected)}}">
                            </select>
                        </div>
                    </div>

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
                                    <input type="text" class="form_datetime form-control" name="deals_voucher_start" value="{{ ($start_date=old('deals_voucher_start',$val['deals_voucher_start']))?date('d-M-Y H:i',strtotime($start_date)):'' }}" >
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
                                <input type="number" class="form-control" min="1" name="deals_voucher_duration" value="{{$val['deals_voucher_duration']}}" placeholder="Voucher Expired">
                                <span class="input-group-addon">
                                    day
                                </span>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" class="form-control"  name="user_limit" value="0" placeholder="User limit">

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
                <input type="hidden" value="Unlimited" name="deals_voucher_type">
            <input type="hidden" name="id_deals" value="{{ $val['id_deals'] }}">
            <input type="hidden" name="deals_type" value="{{ $val['deals_type'] }}">
        @endforeach
    </form>
</div>