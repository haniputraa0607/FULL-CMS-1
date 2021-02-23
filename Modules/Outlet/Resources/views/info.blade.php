<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
<form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
    @foreach ($outlet as $key => $val)
    <div class="form-body">
        <h4>Info</h4>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                QR Code
                </label>
            </div>
            <div class="col-md-9">
                <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                    <img src="{{$val['qrcode']}}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Code
                <i class="fa fa-question-circle tooltips" data-original-title="Kode outlet bersifat unik" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_code" value="{{ $val['outlet_code'] }}" required placeholder="Outlet Code" readonly>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Name
                <span class="required" aria-required="true"> * </span>  
                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_name" value="{{ $val['outlet_name'] }}" required placeholder="Outlet Name" readonly>
            </div>
        </div>

        @if(MyHelper::hasAccess([97], $configs))
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Brand
                <span class="required" aria-required="true"> * </span>  
                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan brand yang tersedia dalam outlet ini" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <select class="select2 form-control" multiple="multiple" name="outlet_brands[]">
                    <option value="*">All Brands</option>
                    @foreach($brands as $brand)
                    <option value="{{$brand['id_brand']}}" @if(in_array($brand['id_brand'],array_column($val['brands'],'id_brand'))) selected="selected" @endif>{{$brand['name_brand']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif

        <div class="form-group">
            <label class="col-md-3 control-label">Status
                <span class="required" aria-required="true"> * </span>  
                <i class="fa fa-question-circle tooltips" data-original-title="Status outlet. Outlet tidak akan ditampilkan di aplikasi ketika status Inactive" data-container="body"></i>
            </label>
            <div class="col-md-9">
                    <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" id="radio14" name="outlet_status" class="md-radiobtn" value="Active" required @if($val['outlet_status'] == 'Active') checked @endif>
                        <label for="radio14">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Active </label>
                    </div>
                    <div class="md-radio">
                        <input type="radio" id="radio16" name="outlet_status" class="md-radiobtn" value="Inactive" required @if($val['outlet_status'] == 'Inactive') checked @endif>
                        <label for="radio16">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Inactive </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Province
                <span class="required" aria-required="true"> * </span>  
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih provinsi letak outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <select id="province" class="form-control select2-multiple" data-placeholder="Select Province" required>
                    <optgroup label="Province List">
                        <option value="">Select Province</option>
                        @if (!empty($province))
                            @foreach($province as $suw)
                                <option value="{{ $suw['id_province'] }}" @if ($suw['id_province'] == $val['city']['id_province']) selected @endif ) >{{ $suw['province_name'] }}</option>
                            @endforeach
                        @endif
                    </optgroup>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                City
                <span class="required" aria-required="true"> * </span>  
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih kota letak outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <select id="city" class="form-control select2-multiple" data-placeholder="Select City" disabled required>
                    <optgroup label="Province List">
                        <option value="{{ $val['city']['city_name'] }}">{{ $val['city']['city_name'] }}</option>
                    </optgroup>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Address
                <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <textarea name="outlet_address" class="form-control summernote" placeholder="Outlet Address">{{ $val['outlet_address'] }}</textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Phone
                <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_phone" value="{{ $val['outlet_phone'] }}" placeholder="Outlet Phone">
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Deep Link Gojek
                <i class="fa fa-question-circle tooltips" data-original-title="Deep link gojek" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="deep_link_gojek" value="{{ $val['deep_link_gojek'] }}" placeholder="Deep link gojek">
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Deep Link Grab
                <i class="fa fa-question-circle tooltips" data-original-title="Deep link grab" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="deep_link_grab" value="{{ $val['deep_link_grab'] }}" placeholder="Deep link grab">
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Delivery Order
                <i class="fa fa-question-circle tooltips" data-original-title="Jika diaktifkan, maka outlet dapat ddilakukan untuk transaksi delivery order" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="checkbox" name="delivery_order" @if(old('delivery_order',$val['delivery_order']) == '1') checked @endif  class="make-switch switch-change" data-size="small" data-on-text="Active" data-off-text="Inactive" value="1">
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                GO-SEND
                <i class="fa fa-question-circle tooltips" data-original-title="Jika diaktifkan, dapat menggunakan GO-SEND untuk Delivery" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="checkbox" name="available_delivery[]" @if(in_array('GO-SEND', old('available_delivery',$val['available_delivery']))) checked @endif  class="make-switch switch-change" data-size="small" data-on-text="Active" data-off-text="Inactive" value="GO-SEND">
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Internal Delivery
                <i class="fa fa-question-circle tooltips" data-original-title="Jika diaktifkan, dapat menggunakan Delivery Internal untuk Delivery" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="checkbox" name="available_delivery[]" @if(in_array('Internal Delivery', old('available_delivery',$val['available_delivery']))) checked @endif  class="make-switch switch-change" data-size="small" data-on-text="Active" data-off-text="Inactive" value="Internal Delivery">
            </div>
        </div>

        <hr>
        <h4>Maps</h4>

        <div class="form-group">
            <label class="col-md-3 control-label">Latitude</label>
            <div class="col-md-9">
                <input type="text" class="form-control latlong" name="outlet_latitude" value="{{ $val['outlet_latitude'] }}" id="lat">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Longitude</label>
            <div class="col-md-9">
                <input type="text" class="form-control latlong" name="outlet_longitude" value="{{ $val['outlet_longitude'] }}" id="lng">
            </div>
        </div>

        <div class="form-group">
            <label for="multiple" class="control-label col-md-3"></label>
            <div class="col-md-9">
                <input id="pac-input" class="controls" type="text" placeholder="Enter a location" style="padding:10px;width:70%" onkeydown="if (event.keyCode == 13) return false;">
                <div id="map-canvas" style="width:900;height:380px;"></div>
            </div>
        </div>

    </div>
    <div class="form-actions">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                @if(MyHelper::hasAccess([27], $grantedFeature))
                    <button type="submit" class="btn green">Submit</button>
                @endif
                <input type="hidden" name="id_city" id="id_city" value="{{ $val['city']['id_city'] }}">
                <input type="hidden" name="id_outlet" value="{{ $val['id_outlet'] }}">
                <!-- <button type="button" class="btn default">Cancel</button> -->
            </div>
        </div>
    </div>
    @endforeach
</form>