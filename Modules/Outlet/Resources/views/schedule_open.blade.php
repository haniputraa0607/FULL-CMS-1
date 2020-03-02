<form class="form-horizontal" role="form" action="{{ url('outlet/schedule/save') }}" method="post" enctype="multipart/form-data">
	<div class="form-body">
			<div class="form-group" id="parent">
				@if (empty($outlet[0]['outlet_schedules']))
					@php
						$sch = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
					@endphp

					@foreach ($sch as $i => $val)
						<div class="row">
						  <div class="col-md-2">
							  <label style="margin-top: 5px;margin-left: 15px;">{{ $val }}</label>
							  <input type="hidden" name="day[]" value="{{ $val }}">
						  </div>
						  <div class="col-md-1">
							  <label style="margin-top: 5px;margin-left: 15px;">:</label>
						  </div>
						  <div class="col-md-2">
							  <input type="text" data-placeholder="select time start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" name="open[]" @if (old('open') != '') value="{{ old('open') }}" @else value="07:00" @endif data-show-meridian="false" readonly>
						  </div>
						  <div class="col-md-2" style="padding-bottom: 5px">
							  <input type="text" data-placeholder="select time end" class="form-control mt-repeater-input-inline kelas-close timepicker timepicker-no-seconds" name="close[]" @if (old('close') != '') value="{{ old('close') }}" @else value="22:00" @endif data-show-meridian="false" readonly>
						  </div>
						  <div class="col-md-2" style="padding-bottom: 5px;margin-top: 5px;">
							  <label class="mt-checkbox mt-checkbox-outline"> Same All
								  <input type="checkbox" name="ampas[]" class="same" data-check="ampas"/>
								  <span></span>
							  </label>
						  </div>
						  <div class="col-md-2" style="padding-bottom: 5px;margin-top: 5px;">
							  <label class="mt-checkbox mt-checkbox-outline"> Closed
								  <input type="checkbox" class="is_closed" data-id="is_closed{{$i}}"/>
								  <input type="hidden" name="is_closed[]" id="is_closed{{$i}}" value="0"/>
								  <span></span>
							  </label>
						  </div>
						  <div class="col-md-12" style="border-bottom: 1px solid #eee;margin-bottom: 5px;margin-left: 15px;width: 95%"></div>
					  </div>
					@endforeach
				@else
					@foreach ($outlet[0]['outlet_schedules'] as $i => $val)
						<div class="row">
						  <div class="col-md-2">
							  <label style="margin-top: 5px;margin-left: 15px;">{{ $val['day'] }}</label>
							  <input type="hidden" name="day[]" value="{{ $val['day'] }}">
						  </div>
						  <div class="col-md-1">
							  <label style="margin-top: 5px;margin-left: 15px;">:</label>
						  </div>
						  <div class="col-md-2">
							  <input type="text" data-placeholder="select time start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" name="open[]" @if(isset($val['open'])) value="{{ date('H:i', strtotime($val['open'])) }}" @endif data-show-meridian="false" readonly>
						  </div>
						  <div class="col-md-2" style="padding-bottom: 5px">
							  <input type="text" data-placeholder="select time end" class="form-control mt-repeater-input-inline kelas-close timepicker timepicker-no-seconds" name="close[]" @if(isset($val['open'])) value="{{ date('H:i', strtotime($val['close'])) }}" @endif data-show-meridian="false" readonly>
						  </div>
						  <div class="col-md-2" style="padding-bottom: 5px;margin-top: 5px;">
							  <label class="mt-checkbox mt-checkbox-outline"> Same All
								  <input type="checkbox" name="ampas[]" class="same" data-check="ampas"/>
								  <span></span>
							  </label>
						  </div>
						  <div class="col-md-2" style="padding-bottom: 5px;margin-top: 5px;">
							  <label class="mt-checkbox mt-checkbox-outline"> Closed
								  <input type="checkbox" class="is_closed" data-id="is_closed{{$i}}" @if(isset($val['is_closed']) && $val['is_closed'] == '1') checked @endif/>
								  <input type="hidden" name="is_closed[]" id="is_closed{{$i}}" value="@if(isset($val['is_closed'])) {{$val['is_closed']}} @else 0 @endif"/>
								  <span></span>
							  </label>
							  <i class="fa fa-question-circle tooltips" data-original-title="Aktifkan checkbox jika outlet tutup. Outlet yang tutup tidak akan ditampilkan pada aplikasi" data-container="body"></i>
						  </div>
						  <div class="col-md-12" style="border-bottom: 1px solid #eee;margin-bottom: 5px;margin-left: 15px;width: 95%"></div>
					  </div>
					@endforeach
				@endif
		  </div>
	</div>
	<div class="form-actions">
		{{ csrf_field() }}
		<div class="row">
			<div class="col-md-offset-3 col-md-9">
			  <input type="hidden" name="id_outlet" value="{{ $outlet[0]['id_outlet'] }}">
			  <button type="submit" class="btn green">Submit</button>
			</div>
		</div>
	</div>
  </form>