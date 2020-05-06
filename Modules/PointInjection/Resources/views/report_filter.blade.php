<script>
	function changeSelect(){
		setTimeout(function(){
			$(".select2").select2({
				placeholder: "Search"
			});
		}, 100);
	}
	function changeSubject(val){
		var subject = val;
		var temp1 = subject.replace("conditions[", "");
		var index = temp1.replace("][subject]", "");
		var subject_value = document.getElementsByName(val)[0].value;

		if(subject_value == 'name' || subject_value == 'phone' || subject_value == 'email'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');
			operator_value.options[operator_value.options.length] = new Option('like', 'like');

			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'text';
		}

		if(subject_value == 'point_received' || subject_value == 'total_point_received'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');
			operator_value.options[operator_value.options.length] = new Option('>=', '>=');
			operator_value.options[operator_value.options.length] = new Option('>', '>');
			operator_value.options[operator_value.options.length] = new Option('<=', '<=');
			operator_value.options[operator_value.options.length] = new Option('<', '<');

			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'text';
		}

		if(subject_value == 'status'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Success', 'Success');
			operator_value.options[operator_value.options.length] = new Option('Failed', 'Failed');

			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'hidden';
		}
	}

</script>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption font-blue ">
			<i class="icon-settings font-blue "></i>
			<span class="caption-subject bold uppercase">Filter</span>
		</div>
	</div>
	<div class="portlet-body form">

		<div class="form-body">
			<div class="form-group">
				<label class="col-md-2 control-label">Date Start :</label>
				<div class="col-md-4">
					<div class="input-group">
						<input type="date" class="form-control" name="date_start" value="{{ $date_start }}">
						<span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
					</div>
				</div>

				<label class="col-md-2 control-label">Date End :</label>
				<div class="col-md-4">
					<div class="input-group">
						<input type="date" class="form-control" name="date_end" value="{{ $date_end }}">
						<span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
					</div>
				</div>
			</div>
		</div><hr>

		<div class="form-body">
			<div class="form-group mt-repeater">
				<div data-repeater-list="conditions">
					@if (!empty($conditions))
						@foreach ($conditions as $key => $con)
							@if(isset($con['subject']))
								<div data-repeater-item class="mt-repeater-item mt-overflow">
									<div class="mt-repeater-cell">
										<div class="col-md-12">
											<div class="col-md-1">
												<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
													<i class="fa fa-close"></i>
												</a>
											</div>
											<div class="col-md-4">
												<select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
													<option value="name" @if ($con['subject'] == 'name') selected @endif>Customer Name</option>
													<option value="phone" @if ($con['subject'] == 'phone') selected @endif>Customer Phone</option>
													<option value="email" @if ($con['subject'] == 'email') selected @endif>Customer Email</option>
													<option value="status" @if ($con['subject'] == 'status') selected @endif>Status</option>
													<option value="point_received" @if ($con['subject'] == 'point_received') selected @endif>Point Received</option>
													<option value="total_point_received" @if ($con['subject'] == 'total_point_received') selected @endif>Total Point Received</option>
												</select>
											</div>
											<div class="col-md-4">
												<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" onChange="changeSubject(this.name)" style="width:100%">
													@if ($con['subject'] == 'point_received' || $con['subject'] == 'total_point_received')
														<option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
														<option value=">=" @if ($con['operator'] == '>=') selected @endif>>=</option>
														<option value=">" @if ($con['operator'] == '>') selected @endif>></option>
														<option value="<=" @if ($con['operator'] == '<=') selected @endif><=</option>
														<option value="<" @if ($con['operator'] == '<') selected @endif><</option>
													@elseif($con['subject'] == 'status')
														<option value="Failed" @if ($con['operator'] == 'Failed') selected @endif>Failed</option>
														<option value="Success" @if ($con['operator']  == 'Success') selected @endif>Success</option>
													@else
														<option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
														<option value="like" @if ($con['operator']  == 'like') selected @endif>Like</option>
													@endif
												</select>
											</div>

											@if ($con['subject'] == 'status')
												<div class="col-md-3">
													<input type="hidden" placeholder="Keyword" class="form-control" name="parameter" required @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
												</div>
											@else
												<div class="col-md-3">
													<input type="text" placeholder="Keyword" class="form-control" name="parameter" required @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
												</div>
											@endif
										</div>
									</div>
								</div>
							@else
								<div data-repeater-item class="mt-repeater-item mt-overflow">
									<div class="mt-repeater-cell">
										<div class="col-md-12">
											<div class="col-md-1">
												<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
													<i class="fa fa-close"></i>
												</a>
											</div>
											<div class="col-md-4">
												<select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
													<option value="" selected disabled>Search Subject</option>
													<option value="name">Customer Name</option>
													<option value="phone">Customer Phone</option>
													<option value="email">Customer Email</option>
													<option value="status">Status</option>
													<option value="point_received">Point Received</option>
													<option value="total_point_received">Total Point Received</option>
												</select>
											</div>
											<div class="col-md-4">
												<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" onChange="changeSubject(this.name)" style="width:100%">
													<option value="=" selected>=</option>
													<option value="like">Like</option>
												</select>
											</div>
											<div class="col-md-3">
												<input type="text" placeholder="Keyword" class="form-control" name="parameter" />
											</div>
										</div>
									</div>
								</div>
							@endif
						@endforeach
					@else
						<div data-repeater-item class="mt-repeater-item mt-overflow">
							<div class="mt-repeater-cell">
								<div class="col-md-12">
									<div class="col-md-1">
										<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
											<i class="fa fa-close"></i>
										</a>
									</div>
									<div class="col-md-4">
										<select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
											<option value="" selected disabled>Search Subject</option>
											<option value="name">Customer Name</option>
											<option value="phone">Customer Phone</option>
											<option value="email">Customer Email</option>
											<option value="status">Status</option>
											<option value="point_received">Point Received</option>
											<option value="total_point_received">Total Point Received</option>
										</select>
									</div>
									<div class="col-md-4">
										<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" onChange="changeSubject(this.name)" style="width:100%">
											<option value="=" selected>=</option>
											<option value="like">Like</option>
										</select>
									</div>
									<div class="col-md-3">
										<input type="text" placeholder="Keyword" class="form-control" name="parameter" />
									</div>
								</div>
							</div>
						</div>
					@endif
				</div>
				<div class="form-action col-md-12">
					<div class="col-md-12">
						<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add" onClick="changeSelect();">
							<i class="fa fa-plus"></i> Add New Condition</a>
					</div>
				</div>

				<div class="form-action col-md-12" style="margin-top:15px">
					<div class="col-md-5">
						<select name="rule" class="form-control input-sm " placeholder="Search Rule" required>
							<option value="and" @if (isset($rule) && $rule == 'and') selected @endif>Valid when all conditions are met</option>
							<option value="or" @if (isset($rule) && $rule == 'or') selected @endif>Valid when minimum one condition is met</option>
						</select>
					</div>
					<div class="col-md-4">
						{{ csrf_field() }}
						<button type="submit" class="btn yellow"><i class="fa fa-search"></i> Search</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>