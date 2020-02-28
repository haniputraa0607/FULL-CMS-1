@section('warning-image')
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption font-blue ">
			<span class="caption-subject bold uppercase">{{ 'Warning Image' }}</span>
		</div>
	</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<div class="fileinput fileinput-new col-md-6" data-provides="fileinput">
						<div class="mt-checkbox-inline">
                            <label class="mt-checkbox mt-checkbox-outline" style="margin-bottom: 0px">
                                <input type="checkbox" id="use_global" name="use_global" value="1" 
                                @if ( old('use_global') == "1" || empty($result['promo_campaign_warning_image']) )
                                    checked 
                                @endif> Use GLobal
                            	<i class="fa fa-question-circle tooltips" data-original-title="Gambar warning akan menggunakan gambar promo warning global. Gambar yang sudah disimpan pada deals ini akan dihapus" data-container="body"></i>
                                <span></span>
                            </label>
                        </div>
						<label class="control-label">Image
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar yang akan ditampilkan ketika ada peringatan error pada penggunaan voucher, jika tidak diisi maka akan menggunakan gambar promo warning global" data-container="body"></i>
							<br>
							<span class="required" aria-required="true"> (100 * 100) (PNG Only) </span>
						</label><br>
						<div class="fileinput-new thumbnail">
							@if(!empty($result['promo_campaign_warning_image']))
								<img src="{{ env('S3_URL_API').$result['promo_campaign_warning_image'] }}" alt="">
							@else
								<img src="https://www.placehold.it/100x100/EFEFEF/AAAAAA&amp;text=no+image" alt="">
							@endif
						</div>
						<div class="fileinput-preview fileinput-exists thumbnail" id="div_image" style="max-width: 500px; max-height: 250px;"></div>
						<div>
							<span class="btn default btn-file">
							<span class="fileinput-new"> Select image </span>
							<span class="fileinput-exists"> Change </span>
							<input type="file" class="file file-image" id="field_image" accept="image/*" name="promo_warning_image">
							</span>
							<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
						</div>
					</div>
					<div class="preview col-md-6 pull-right" style="right: 0;top: 70px; position: sticky">
		                <img id="img_preview" src="{{env('S3_URL_VIEW')}}img/setting/warning_image_preview.png" class="img-responsive">
		            </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('warning-image-script')
<script type="text/javascript">
	$(".file-image").change(function(e) {
		var widthImg  = 100;
		var heightImg = 100;

		var _URL = window.URL || window.webkitURL;
		var image, file;

		if ((file = this.files[0])) {
			image = new Image();

			image.onload = function() {
				if ( this.width == widthImg && this.height == heightImg ) {
					$('#use_global').prop('checked',false);
				}
				else {
					$('#use_global').prop('checked',true);
					toastr.warning("Please check dimension of your image.");
					$(this).val("");
					// $('#remove_square').click()
					// image.src = _URL.createObjectURL();

					$('#field_image').val("");
					$('#div_image').children('img').attr('src', 'https://www.placehold.it/100x100/EFEFEF/AAAAAA&amp;text=no+image');

					console.log($(this).val())
					// console.log(document.getElementsByName('news_image_luar'))
				}
			};

			image.src = _URL.createObjectURL(file);
		}
	});
</script>
@endsection