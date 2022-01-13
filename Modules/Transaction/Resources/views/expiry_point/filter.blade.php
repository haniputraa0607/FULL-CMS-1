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

		if(subject_value == 'total_customer' || subject_value == 'email_count_sent' || subject_value == 'sms_count_sent' || subject_value == 'push_count_sent' || subject_value == 'inbox_count_sent'
		   || subject_value == 'whatsapp_count_sent'){
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
	}

</script>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption font-blue ">
			<i class="icon-settings font-blue "></i>
			<span class="caption-subject bold uppercase">Filter Log</span>
		</div>
	</div>
	<div class="portlet-body form">

		<div class="form-body">
            <div class="form-group">
                <label class="col-md-2 control-label">Date Start :</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="date" class="form-control" name="date_start" value="{{ $date_start??'' }}">
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
                        <input type="date" class="form-control" name="date_end" value="{{ $date_end??'' }}">
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
												<option value="total_customer" @if ($con['subject'] == 'total_customer') selected @endif>Total Customer</option>
												<option value="email_count_sent" @if ($con['subject'] == 'email_count_sent') selected @endif>Email Count Sent</option>
												<option value="sms_count_sent" @if ($con['subject'] == 'sms_count_sent') selected @endif>SMS Count Sent</option>
												<option value="push_count_sent" @if ($con['subject'] == 'push_count_sent') selected @endif>Push Count Sent</option>
												<option value="inbox_count_sent" @if ($con['subject'] == 'inbox_count_sent') selected @endif>Inbox Count Sent</option>
												<option value="whatsapp_count_sent" @if ($con['subject'] == 'whatsapp_count_sent') selected @endif>Whatsapp Count Sent</option>
											</select>
										</div>
										<div class="col-md-4">
										<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" onChange="changeSubject(this.name)" style="width:100%">
											<option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
											<option value=">=" @if ($con['operator'] == '>=') selected @endif>>=</option>
											<option value=">" @if ($con['operator'] == '>') selected @endif>></option>
											<option value="<=" @if ($con['operator'] == '<=') selected @endif><=</option>
											<option value="<" @if ($con['operator'] == '<') selected @endif><</option>
										</select>
										</div>

										<div class="col-md-3">
											<input type="text" placeholder="Keyword" class="form-control" name="parameter" required @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
										</div>
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
												<option value="" selected disabled></option>
												<option value="total_customer">Total Customer</option>
												<option value="email_count_sent">Email Count Sent</option>
												<option value="sms_count_sent">SMS Count Sent</option>
												<option value="push_count_sent">Push Count Sent</option>
												<option value="inbox_count_sent">Inbox Count Sent</option>
												<option value="whatsapp_count_sent">Whatsapp Count Sent</option>
											</select>
										</div>
										<div class="col-md-4">
										<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" onChange="changeSubject(this.name)" style="width:100%">
											<option value="=" selected>=</option>ororororor
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
											<option value="" selected disabled></option>
											<option value="total_customer">Total Customer</option>
											<option value="email_count_sent">Email Count Sent</option>
											<option value="sms_count_sent">SMS Count Sent</option>
											<option value="push_count_sent">Push Count Sent</option>
											<option value="inbox_count_sent">Inbox Count Sent</option>
											<option value="whatsapp_count_sent">Whatsapp Count Sent</option>
										</select>
									</div>
									<div class="col-md-4">
									<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" onChange="changeSubject(this.name)" style="width:100%">
										<option value="=" selected>=</option>ororororor
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