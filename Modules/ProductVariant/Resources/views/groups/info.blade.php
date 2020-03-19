        <div class="row">
            <div class="col-md-8">
                <form role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <label class="col-md-4 text-right control-label">Code</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="product_group_code" value="{{$product_group['product_group_code']}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 text-right control-label">Category</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="id_product_category" class="select2 form-control" data-placeholder="Select category" required>
                                        <option value="0">Uncategorized</option>
                                        @foreach($categories as $category)
                                        <option value="{{$category['id_product_category']}}" @if($product_group['id_product_category'] == $category['id_product_category']) selected @endif>{{$category['product_category_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 text-right control-label">Promo Category</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="id_product_promo_category[]" class="select2 form-control" data-placeholder="Select category" multiple>
                                        <option value=""></option>
                                        @foreach($promo_categories as $category)
                                        <option value="{{$category['id_product_promo_category']}}" @if(in_array($category['id_product_promo_category'],$product_group['promo_category'])) selected @endif>{{$category['product_promo_category_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 text-right control-label">Name</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="product_group_name" value="{{$product_group['product_group_name']}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 text-right control-label">Short Description</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea class="form-control" name="product_group_description" required>{{$product_group['product_group_description']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row img-photo">
                            <label class="col-md-4 control-label text-right">
                                Image
                                <span class="required" aria-required="true"> * </span>
                                <br>
                                <span class="required" aria-required="true"> (200 * 200) (PNG Only) </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Gambar yang akan ditampilkan di daftar produk" data-container="body"></i>
                            </label>
                            <div class="col-md-7">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
                                        @if(strpos($product_group['product_group_photo'],'default') === false)
                                        <img id="preview_image" src="{{$product_group['product_group_photo']}}"/>
                                         @else
                                        <img id="preview_image" src="https://www.placehold.it/200x200/EFEFEF/AAAAAA"/>
                                        @endif
                                    </div>

                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                    <div>
                                        <span class="btn default btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" accept="image/png" class="file" name="product_group_photo" data-type="photo" @if(strpos($product_group['product_group_photo'],'default') !== false) required @endif> 
                                        </span>
                                        <a href="javascript:;" class="btn red default fileinput-exists removeImage" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px; margin-bottom: 10px">
                            <label class="col-md-4 control-label text-right">
                                Image Detail
                                <span class="required" aria-required="true"> * </span>
                                <br>
                                <span class="required" aria-required="true"> (720 * 360) (PNG Only) </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Gambar yang akan ditampilkan di detail produk" data-container="body"></i>
                            </label>
                            <div class="col-md-7">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 144px; height: 78px;">
                                        @if(strpos($product_group['product_group_image_detail'],'default') === false)
                                        <img id="preview_image" src="{{$product_group['product_group_image_detail']}}"/>
                                         @else
                                        <img id="preview_image" src="https://www.placehold.it/720x360/EFEFEF/AAAAAA"/>
                                        @endif
                                    </div>

                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                    <div>
                                        <span class="btn default btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" accept="image/png" class="file" name="product_group_image_detail" data-type="image_detail" @if(strpos($product_group['product_group_photo'],'default') !== false) required @endif> 
                                        </span>
                                        <a href="javascript:;" class="btn red default fileinput-exists removeImage" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px">
                            <label class="col-md-4 control-label text-right">
                                Product Variant
                                <span class="required" aria-required="true"> * </span>
                                <br>
                                <i class="fa fa-question-circle tooltips" data-original-title="Jenis produk variant. Multiple memungkinkan memiliki banyak jenis varian, sedangkan single tidak memiliki varian" data-container="body"></i>
                            </label>
                            <div class="col-md-7">
                                <div class="row" id="variant-selector">
                                    <div class="col-md-5">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" name="variant_type" id="radio4" value="multiple" checked>
                                                <label for="radio4">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Multiple
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" name="variant_type" id="radio3" value="single" @if($is_general) checked @endif>
                                                <label for="radio3">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Single
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row single-only" style="margin-bottom: 10px">
                            <label class="col-md-4 control-label text-right">
                                Product
                                <span class="required" aria-required="true"> * </span>
                                <br>
                                <i class="fa fa-question-circle tooltips" data-original-title="Produk" data-container="body"></i>
                            </label>
                            <div class="col-md-7">
                                <select name="id_product" id="product-selector" class="select2" data-placeholder="Select Product">
                                    <option></option>
                                    @foreach($products as $product)
                                    <option value="{{$product['id_product']}}" @if($id_product == $product['id_product']) selected @endif>{{$product['product_code']}} - {{$product['product_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-actions">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-offset-4 col-md-8">
                                    <button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="preview col-md-4 pull-right" style="right: 0;top: 70px; position: sticky">
                <img id="img_preview" src="{{env('S3_URL_VIEW')}}img/setting/product_group_preview.png" class="img-responsive">
            </div>
        </div>
