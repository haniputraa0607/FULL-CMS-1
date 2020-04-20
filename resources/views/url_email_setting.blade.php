@foreach($allData as $dt)
	<div class="col-md-6">
		@foreach($dt as $key => $value)
			<?php
			$value = (array)$value;
			?>
			<div class="portlet light bordered" @if($value['use'] == 0)style="display: none" @endif id="div_{{$key}}">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-dark sbold uppercase">{{$value['text']}}</span>
					</div>
				</div>
				<div class="portlet-body form">
					<div class="row" style="margin-left: 1%;margin-right: 1%;">
						<div class="row" style="margin-bottom: 3%;">
							<div class="col-md-4">
								<p style="margin-top:2%;margin-bottom:1%;"> URL <span class="required" aria-required="true"> * </span></p>
							</div>
							<div class="col-md-8">
								<input class="form-control" type="text" name="{{$key}}" id="input_{{$key}}" value="{{$value['url']}}">
							</div>
						</div>
						<div class="row" style="margin-top: 4%;">
							<div class="col-md-4">
								<p style="margin-top:2%;margin-bottom:1%;"> Icon <span class="required" aria-required="true"> * </span></p>
								<div style="color: #e02222;font-size: 12px;margin-top: 4%;">
									- PNG Only <br>
									- max dimension 100 x 100 <br>
									- max size 10 KB <br>
								</div>
							</div>
							<div class="col-md-8">
								<div class="fileinput fileinput-new" data-provides="fileinput" style="margin-top: 2%;">
									<div class="fileinput-new thumbnail" style="width: 40px; height: 40px;">
										@if(isset($value['icon']) && $value['icon'] != "")
											<img src="{{$value['icon']}}" id="preview_icon_{{$key}}" />
										@endif
									</div>

									<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 40px; max-height: 40px;"> </div>
									<div>
																	<span class="btn default btn-file">
																	<span class="fileinput-new" style="font-size: 12px"> Select icon </span>
																	<span class="fileinput-exists"> Change </span>
																	<input type="file" accept="image/png" name="images[icon_{{$key}}]" class="file" data-type="{{$key}}"> </span>
										<a href="javascript:;" id="removeImage_{{$key}}" class="btn red default fileinput-exists" data-dismiss="fileinput"> Remove </a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			$countNumberOther++
			?>
		@endforeach
	</div>
@endforeach