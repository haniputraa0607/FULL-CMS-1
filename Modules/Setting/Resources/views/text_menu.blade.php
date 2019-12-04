<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs     		= session('configs');
?>
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
	<style>
		.zoom-in {
			cursor: zoom-in;
		}
	</style>
@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script>
		$(".file").change(function(e) {
			var type      = $(this).data('type');
			var widthImg  = 0;
			var heightImg = 0;
			var _URL = window.URL || window.webkitURL;
			var image, file;

			if ((file = this.files[0])) {
				image = new Image();
				var size = file.size/1024;

				image.onload = function() {
					if (this.width !== this.height) {
						toastr.warning("Please check dimension of your photo. Recommended dimensions are 1:1");
						$("#removeImage_"+type).trigger( "click" );
					}
					if (this.width > 100 ||  this.height > 100) {
						toastr.warning("Please check dimension of your photo. The maximum height and width 100px.");
						$("#removeImage_"+type).trigger( "click" );
					}
					if (size > 5) {
						toastr.warning("The maximum size is 10 KB");
						$("#removeImage_"+type).trigger( "click" );
					}
				};
				image.src = _URL.createObjectURL(file);
			}
		});
	</script>
@endsection

@section('content')
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="{{url('/')}}">Home</a>
				<i class="fa fa-circle"></i>
			</li>
			<li>
				Text Menu Setting
			</li>
		</ul>
	</div>
	<br>
	@include('layouts.notifications')
	<div class="portlet-body">
		<div class="tabbable-line tabbable-full-width">
			<ul class="nav nav-tabs">
				<li class=" @if(!isset($tipe)) active @endif">
					<a href="#main_menu" data-toggle="tab"> Main Menu </a>
				</li>
				<li class=" @if(isset($tipe) && $tipe == 'other_menu') active @endif">
					<a href="#other_menu" data-toggle="tab"> Other Menu </a>
				</li>
			</ul>
		</div>
		<div class="tab-content" style="margin-top:20px">
			<div class="tab-pane @if(!isset($tipe)) active @endif" id="main_menu">
				<div class="portlet box green">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-gear"></i>Main Menu Setting</div>
						<div class="tools">
							<a href="javascript:;" class="collapse"> </a>
						</div>
					</div>
					<div class="portlet-body">
						<p>Menu ini digunakan untuk mengatur tulisan menu dan tulisan header pada menu utama aplikasi.</p>
						<ul>
							<li>Gambar (a) adalah urutan menu.</li>
							<li>Gambar (b) adalah contoh tampilan untuk "Text Menu".</li>
							<li>Gambar (c) adalah contoh tampilan untuk "Text Header".</li>
							@if($config_main_menu['is_active'] == 1)<li>Gambar (d) adalah contoh tampilan untuk "Icon".</li>@endif
						</ul>

						<div class="row" style="margin-top: 2%;">
							<div class="col-md-4">
								<img class="zoom-in" src="{{ env('S3_URL_VIEW') }}images/text_menu/main_menu_1.jpg" height="200px" onclick="window.open(this.src)"/>
								<p style="text-align: center">(a)</p>
							</div>
							<div class="col-md-4">
								<img class="zoom-in" src="{{ env('S3_URL_VIEW') }}images/text_menu/main_menu_2.jpg" height="200px" onclick="window.open(this.src)"/>
								<p style="text-align: center">(b)</p>
							</div>
							<div class="col-md-4">
								<img class="zoom-in" src="{{ env('S3_URL_VIEW') }}images/text_menu/main_menu_3.jpg" height="200px" onclick="window.open(this.src)"/>
								<p style="text-align: center">(c)</p>
							</div>
							@if($config_main_menu['is_active'] == 1)
								<div class="col-md-4">
									<img class="zoom-in" src="{{ env('S3_URL_VIEW') }}images/text_menu/main_menu_4.jpg" height="200px" onclick="window.open(this.src)"/>
									<p style="text-align: center">(d)</p>
								</div>
							@endif
						</div>
					</div>
				</div>
				@if(count($menu_list['main_menu']) > 0)
					<div class="portlet-body">
						<form role="form" class="form-horizontal" action="{{url('setting/text_menu/update','main-menu')}}" method="POST" enctype="multipart/form-data">
							<div class="form-body">
								<?php
								//========= start setting column and row =========//
								$countMainMenu = count($menu_list['main_menu']);
								$totalRow = $countMainMenu / 2;
								$countNumberMain = 1;

								if(is_float($totalRow) === true){
									$totalRow = (int)$totalRow + 1;
								}

								$dataMenuMainColumn1 = array_slice($menu_list['main_menu'], 0, $totalRow);
								$dataMenuMainColumn2 = array_slice($menu_list['main_menu'], $totalRow, $totalRow);
								$allDataMenuHome = [$dataMenuMainColumn1, $dataMenuMainColumn2];
								//========= end setting =========//
								?>

								<div class="form-group col-md-12">
									@foreach($allDataMenuHome as $data)
										<div class="col-md-6">
											@foreach($data as $key => $value)

												<div class="portlet light bordered">
													<div class="portlet-title">
														<div class="caption">
															<span class="caption-subject font-dark sbold uppercase">Menu {{$countNumberMain}}</span>
														</div>
													</div>
													<div class="portlet-body form">
														<div class="row" style="margin-left: 1%;margin-right: 1%;">
															<div class="row" style="margin-bottom: 3%;">
																<div class="col-md-4">
																	<p style="margin-top:2%;margin-bottom:1%;"> Text Menu <span class="required" aria-required="true"> * </span></p>
																</div>
																<div class="col-md-8">
																	<input class="form-control" type="text" name="{{$key}}_text_menu" value="{{$value['text_menu']}}" maxlength="10" required>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<p style="margin-top:2%;margin-bottom:1%;"> Text Header <span class="required" aria-required="true"> * </span></p>
																</div>
																<div class="col-md-8">
																	<input class="form-control" type="text" name="{{$key}}_text_header" value="{{$value['text_header']}}" maxlength="20" required>
																</div>
															</div>
															@if($config_main_menu['is_active'] == 1)
																<div class="row" style="margin-top: 4%;">
																	<div class="col-md-4">
																		<p style="margin-top:2%;margin-bottom:1%;"> Icon <span class="required" aria-required="true"> * </span></p>
																		<div style="color: #e02222;font-size: 12px;margin-top: 4%;">
																			- Only PNG <br>
																			- 100 x 100 <br>
																			- max size 5 KB <br>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="fileinput fileinput-new" data-provides="fileinput" style="margin-top: 2%;">
																			<div class="fileinput-new thumbnail" style="width: 40px; height: 40px;">
																				@if(isset($value['icon1']) && $value['icon1'] != "")
																					<img src="{{$value['icon1']}}" id="preview_icon1_{{$key}}" />
																				@endif
																			</div>

																			<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 40px; max-height: 40px;"> </div>
																			<div>
																		<span class="btn default btn-file">
																		<span class="fileinput-new" style="font-size: 12px"> Select icon 1 </span>
																		<span class="fileinput-exists"> Change </span>
																		<input type="file" accept="image/png" name="images[icon1_{{$key}}]" class="file" data-type="{{$key}}"> </span>
																				<a href="javascript:;" id="removeImage_{{$key}}" class="btn red default fileinput-exists" data-dismiss="fileinput"> Remove </a>
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="fileinput fileinput-new" data-provides="fileinput" style="margin-top: 2%;">
																			<div class="fileinput-new thumbnail" style="width: 40px; height: 40px;">
																				@if(isset($value['icon2']) && $value['icon2'] != "")
																					<img src="{{$value['icon2']}}" id="preview_icon2_{{$key}}" />
																				@endif
																			</div>

																			<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 40px; max-height: 40px;"> </div>
																			<div>
																		<span class="btn default btn-file">
																		<span class="fileinput-new" style="font-size: 12px"> Select icon 2 </span>
																		<span class="fileinput-exists"> Change </span>
																		<input type="file" accept="image/png" name="images[icon2_{{$key}}]" class="file" data-type="{{$key}}"> </span>
																				<a href="javascript:;" id="removeImage_{{$key}}" class="btn red default fileinput-exists" data-dismiss="fileinput"> Remove </a>
																			</div>
																		</div>
																	</div>
																</div>
															@endif
														</div>
													</div>
												</div>
												<?php
												$countNumberMain++
												?>
											@endforeach
										</div>
									@endforeach
								</div>
								<div class="form-actions" style="text-align:center">
									{{ csrf_field() }}
									<button type="submit" class="btn blue">Submit</button>
								</div>
							</div>
						</form>
					</div>
				@endif
			</div>

			<div class="tab-pane @if(isset($tipe) && $tipe == 'other_menu') active @endif" id="other_menu">
				<div class="portlet box green">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-gear"></i>Other Menu Setting</div>
						<div class="tools">
							<a href="javascript:;" class="collapse"> </a>
						</div>
					</div>
					<div class="portlet-body">
						<p>Menu ini digunakan untuk mengatur tulisan menu, tulisan header, dan icon yang ada didalam daftar menu other.</p>
						<ul>
							<li>Gambar (a) adalah urutan menu.</li>
							<li>Gambar (b) adalah contoh tampilan untuk "Text Menu".</li>
							<li>Gambar (c) adalah contoh tampilan untuk "Text Header".</li>
							@if($config_other_menu['is_active'] == 1)<li>Gambar (d) adalah contoh tampilan untuk "Icon".</li>@endif
						</ul>
						<div class="row" style="margin-top: 2%;">
							<div class="col-md-3">
								<img class="zoom-in" src="{{ env('S3_URL_VIEW') }}images/text_menu/other_menu_1.jpg" height="280px" onclick="window.open(this.src)"/>
								<p style="text-align: center">(a)</p>
							</div>
							<div class="col-md-4">
								<img class="zoom-in" src="{{ env('S3_URL_VIEW') }}images/text_menu/other_menu_2.jpg" height="150px" onclick="window.open(this.src)"/>
								<p style="text-align: center">(b)</p>
							</div>
							<div class="col-md-4">
								<img class="zoom-in" src="{{ env('S3_URL_VIEW') }}images/text_menu/other_menu_3.jpg" height="150px" onclick="window.open(this.src)"/>
								<p style="text-align: center">(c)</p>
							</div>
						</div>

						@if($config_other_menu['is_active'] == 1)
							<div class="row" style="margin-top: 2%;">
								<div class="col-md-3">
									<img class="zoom-in" src="{{ env('S3_URL_VIEW') }}images/text_menu/other_menu_4.jpg" height="150px" onclick="window.open(this.src)"/>
									<p style="text-align: center">(d)</p>
								</div>
							</div>
						@endif
					</div>
				</div>
				@if(count($menu_list['other_menu']) > 0)
					<div class="portlet-body">
						<form role="form" class="form-horizontal" action="{{url('setting/text_menu/update','other-menu')}}" method="post" enctype="multipart/form-data">
							<div class="form-body">
								<?php
								//========= start setting column and row =========//
								$countOtherMenu = count($menu_list['other_menu']);
								$totalRow = $countOtherMenu / 2;
								$countNumberOther= 1;

								if(is_float($totalRow) === true){
									$totalRow = (int)$totalRow + 1;
								}

								$dataColumn1 = array_slice($menu_list['other_menu'], 0, $totalRow);
								$dataColumn2 = array_slice($menu_list['other_menu'], $totalRow, $totalRow);
								$allData = [$dataColumn1, $dataColumn2];
								//========= end setting =========//
								?>

								<div class="form-group col-md-12">
									@foreach($allData as $data)
										<div class="col-md-6">
											@foreach($data as $key => $value)

												<div class="portlet light bordered">
													<div class="portlet-title">
														<div class="caption">
															<span class="caption-subject font-dark sbold uppercase">Menu {{$countNumberOther}}</span>
														</div>
													</div>
													<div class="portlet-body form">
														<div class="row" style="margin-left: 1%;margin-right: 1%;">
															<div class="row" style="margin-bottom: 3%;">
																<div class="col-md-4">
																	<p style="margin-top:2%;margin-bottom:1%;"> Text Menu <span class="required" aria-required="true"> * </span></p>
																</div>
																<div class="col-md-8">
																	<input class="form-control" type="text" name="{{$key}}_text_menu" value="{{$value['text_menu']}}" maxlength="20" required>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<p style="margin-top:2%;margin-bottom:1%;"> Text Header <span class="required" aria-required="true"> * </span></p>
																</div>
																<div class="col-md-8">
																	<input class="form-control" type="text" name="{{$key}}_text_header" value="{{$value['text_header']}}" maxlength="20" required>
																</div>
															</div>
															@if($config_other_menu['is_active'] == 1)
																<div class="row" style="margin-top: 4%;">
																	<div class="col-md-4">
																		<p style="margin-top:2%;margin-bottom:1%;"> Icon <span class="required" aria-required="true"> * </span></p>
																		<div style="color: #e02222;font-size: 12px;margin-top: 4%;">
																			- Only PNG <br>
																			- 800 x 800 <br>
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
															@endif
														</div>
													</div>
												</div>
												<?php
												$countNumberOther++
												?>
											@endforeach
										</div>
									@endforeach
								</div>
								<div class="form-actions" style="text-align:center">
									{{ csrf_field() }}
									<button type="submit" class="btn blue">Submit</button>
								</div>
							</div>
						</form>
					</div>
				@endif
			</div>
		</div>

	</div>
@endsection