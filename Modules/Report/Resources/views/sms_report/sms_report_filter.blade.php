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

		if(subject_value == 'response'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Success', '1');
			operator_value.options[operator_value.options.length] = new Option('Missing Parameter', '2');
			operator_value.options[operator_value.options.length] = new Option('Invalid User Id or Password', '3');
			operator_value.options[operator_value.options.length] = new Option('Invalid Message', '4');
			operator_value.options[operator_value.options.length] = new Option('Invalid MSISDN', '5');
			operator_value.options[operator_value.options.length] = new Option('Invalid Sender', '6');
			operator_value.options[operator_value.options.length] = new Option('Client’s IP Address is not allowed', '7');
			operator_value.options[operator_value.options.length] = new Option('Internal Server Error', '8');
			operator_value.options[operator_value.options.length] = new Option('Invalid division', '9');
			operator_value.options[operator_value.options.length] = new Option('Invalid Channel', '21');
			operator_value.options[operator_value.options.length] = new Option('Token Not Enough', '22');
			operator_value.options[operator_value.options.length] = new Option('Token Not Available', '23');

			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'hidden';
		}

		if(subject_value == 'status'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Success', 'success');
			operator_value.options[operator_value.options.length] = new Option('Fail', 'fail');

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
													<option value="response" @if ($con['subject'] == 'response') selected @endif>Response</option>
													<option value="status" @if ($con['subject'] == 'status') selected @endif>Status</option>
												</select>
											</div>
											<div class="col-md-4">
												<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" onChange="changeSubject(this.name)" style="width:100%">
													@if($con['subject'] == 'response')
														<option value="1" @if ($con['operator'] == '1') selected @endif>Success</option>
														<option value="2" @if ($con['operator']  == '2') selected @endif>Missing Parameter</option>
														<option value="3" @if ($con['operator'] == '3') selected @endif>Invalid User Id or Password</option>
														<option value="4" @if ($con['operator']  == '4') selected @endif>Invalid Messag</option>
														<option value="5" @if ($con['operator'] == '5') selected @endif>Invalid MSISDN</option>
														<option value="6" @if ($con['operator']  == '6') selected @endif>Invalid Sender</option>
														<option value="7" @if ($con['operator'] == '7') selected @endif>Client’s IP Address is not allowed</option>
														<option value="8" @if ($con['operator']  == '8') selected @endif>Internal Server Error</option>
														<option value="9" @if ($con['operator']  == '9') selected @endif>Invalid division</option>
														<option value="20" @if ($con['operator']  == '20') selected @endif>Invalid Channel</option>
														<option value="21" @if ($con['operator']  == '21') selected @endif>Token Not Enough</option>
														<option value="22" @if ($con['operator']  == '22') selected @endif>Token Not Available</option>
													@elseif($con['subject'] == 'status')
														<option value="success" @if ($con['operator'] == 'success') selected @endif>Success</option>
														<option value="fail" @if ($con['operator']  == 'fail') selected @endif>Fail</option>
													@else
														<option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
														<option value="like" @if ($con['operator']  == 'like') selected @endif>Like</option>
													@endif
												</select>
											</div>

											@if ($con['subject'] == 'response' || $con['subject'] == 'status')
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
													<option value="response">Response</option>
													<option value="status">Status</option>
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
											<option value="response">Response</option>
											<option value="status">Status</option>
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