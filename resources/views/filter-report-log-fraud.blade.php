<?php
use App\Lib\MyHelper;
$configs = session('configs');
?>
<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		@if(empty($conditions))
			changeSubject('conditions[0][0][subject]', 0)
		@endif
	});

	function changeSelect(){
		setTimeout(function(){
			$(".select2").select2({
				placeholder: "Search"
			});
		}, 100);
	}

	@if(!is_array($conditions) || count($conditions) <= 0)
	var noRule = 1;
	@else
	var noRule = {{count($conditions)}};
	@endif

	function addCondition(no, noCond){
		$(
				'<div data-repeater-item class="mt-repeater-item mt-overflow" id="condition'+no+noCond+'">'+
				'<div class="mt-repeater-cell">'+
				'<div class="col-md-12">'+
				'<div class="col-md-1">'+
				'<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition(`'+no+noCond+'`,`'+no+'`)">'+
				'<i class="fa fa-close"></i>'+
				'</a>'+
				'</div>'+
				'<div class="col-md-4">'+
				'<div class="input-group">'+
				'<select id="select2'+no+noCond+'" name="conditions['+no+']['+noCond+'][subject]" class="form-control input-sm select2 subject" placeholder="Search Subject" onChange="changeSubject(this.name, '+no+')" style="width:100%" required>'+
				'<option value="all_user">All User</option>'+
				'<option value="name" selected>Name</option>'+
				'<option value="phone">Phone</option>'+
				@if($type == 'device')
				'<option value="device_type">Device Type</option>'+
				@endif
				@if($type != 'device' && $type != 'suspend')
				'<option value="outlet">Outlet</option>'+
				'<option value="number_of_breaking">Number of breaking</option>'+
				@endif
				'</select>'+
				'<span class="input-group-addon">'+
				'<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Pilih field yang akan dijadikan condition filter" data-container="body"></i>'+
				'</span>'+
				'</div>'+
				'</div>'+
				'<div id="normalCondition'+no+noCond+'">'+
				'<div class="col-md-4">'+
				'<div class="input-group">'+
				'<select name="conditions['+no+']['+noCond+'][operator]" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%">'+
				'<option value="=" selected>=</option>'+
				'<option value="like">Like</option>'+
				'</select>'+
				'<span class="input-group-addon">'+
				'<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="(1). Operator = untuk mendapatkan hasil pencarian yang sama persis dengan keyword.'+

				'(2). Operator like untuk mendapatkan hasil pencarian yang mirip atau mengandung keyword'+
				'" data-container="body"></i>'+
				'</span>'+
				'</div>'+
				'</div>'+
				'<div class="col-md-3">'+
				'<div class="input-group">'+
				'<input type="text" placeholder="Parameter" class="form-control" name="conditions['+no+']['+noCond+'][parameter]" required/>'+
				'<span class="input-group-addon">'+
				'<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>'+
				'</span>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'<div id="specialCondition'+no+noCond+'" style="display:none">'+
				'<div class="col-md-3">'+
				'<div class="input-group">'+
				'<select name="conditions['+no+']['+noCond+'][id]" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%">'+
				'</select>'+
				'</div>'+
				'</div>'+

				'<div class="col-md-2">'+
				'<div class="input-group">'+
				'<select name="conditions['+no+']['+noCond+'][operatorSpecialCondition]"  id ="operator'+no+noCond+'"  class="form-control input-sm select2" placeholder="Search Operator" style="width:100%">'+
				'<option value="=" selected>=</option>'+
				'<option value=">=">>=</option>'+
				'<option value=">">></option>'+
				'<option value="<="><=</option>'+
				'<option value="<"><</option>'+
				'</select>'+
				'<span class="input-group-addon">'+
				'<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="(1). Operator = untuk mendapatkan hasil pencarian yang sama persis dengan keyword.'+

				'(2). Operator like untuk mendapatkan hasil pencarian yang mirip atau mengandung keyword'+
				'" data-container="body"></i>'+
				'</span>'+
				'</div>'+
				'</div>'+

				'<div class="col-md-2">'+
				'<div class="input-group">'+
				'<input type="text" placeholder="0" class="form-control" id ="parameter'+no+noCond+'" name="conditions['+no+']['+noCond+'][parameterSpecialCondition]"/>'+
				'<span class="input-group-addon">'+
				'<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>'+
				'</span>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'<input type="hidden" name="conditions['+no+']['+noCond+']" value="and">'+
				'</div>'+
				'</div>'+
				'</div>'
		).appendTo($('#div-condition'+no)).slideDown("slow")
		noCond = parseInt(noCond) + 1
		$('#btnAddCondition'+no).attr('onclick', 'changeSelect();addCondition('+no+','+noCond+')');
		$('.tooltips').tooltip()
	}

	function deleteCondition(no, indexRule){
		if(confirm('Are you sure you want to delete this condition?')) {
			if($('#select2'+no).val() == 'trx_product_tag'){
				cekProductTag[indexRule] = false;
				if(ProductTagCount[indexRule] != undefined){
					ProductTagCount[indexRule].forEach(function(item) {
						$('#condition'+item).remove()
					});
				}
			}
			$('#condition'+no).remove()
		}
	}

	function changeSubject(val, indexRule){
		var subject = val;
		var temp1 = subject.replace("conditions[", "");
		var index = temp1.replace("][subject]", "");
		var subject_value = document.getElementsByName(val)[0].value;
		var indx = index.replace("[", "");
		var indx = indx.replace("]", "");

		var parameter = "conditions["+index+"][parameter]";
		var operator = "conditions["+index+"][operator]";

		if(subject_value == 'all_user'){
			document.getElementsByName(parameter)[0].required = false;
			document.getElementsByName(operator)[0].required = false;
			$('[name="'+parameter+'"]').closest('.input-group').hide()
			$('[name="'+operator+'"]').closest('.input-group').hide()
		}else{
			$('[name="'+parameter+'"]').closest('.input-group').show()
			$('[name="'+operator+'"]').closest('.input-group').show()
		}

		if(subject_value == 'outlet'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			<?php
					foreach($outlets as $outlet){
					?>
					operator_value.options[operator_value.options.length] = new Option("<?php echo $outlet['outlet_name'];?>", '<?php echo $outlet['id_outlet']; ?>');
					<?php
					}
					?>
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else if(document.getElementsByName(parameter)[0] != null){
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}

		if(subject_value == 'device_type' ){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Android', 'Android');
			operator_value.options[operator_value.options.length] = new Option('IOS', 'IOS');
			operator_value.options[operator_value.options.length] = new Option('Both', 'Both');
			operator_value.options[operator_value.options.length] = new Option('None', 'None');

			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else if(document.getElementsByName(parameter)[0] != null){
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}

		if(subject_value == 'name' || subject_value == 'phone'){
			var operator = "conditions["+index+"][operator]";

			var operator_value = document.getElementsByName(operator)[0];

			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');
			operator_value.options[operator_value.options.length] = new Option('like', 'like');

			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			} else if(document.getElementsByName(parameter)[0] != null){
				document.getElementsByName(parameter)[0].style.display = 'none';
			}
		}

		if(subject_value == 'number_of_breaking'){
			var operator = "conditions["+index+"][operator]";

			var operator_value = document.getElementsByName(operator)[0];

			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');
			operator_value.options[operator_value.options.length] = new Option('>=', '>=');
			operator_value.options[operator_value.options.length] = new Option('>', '>');
			operator_value.options[operator_value.options.length] = new Option('<=', '<=');
			operator_value.options[operator_value.options.length] = new Option('<', '<');

			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			} else if(document.getElementsByName(parameter)[0] != null){
				document.getElementsByName(parameter)[0].style.display = 'none';
			}
		}
	}

</script>

<div class="form-body">
	<div class="form-group">
		<label class="col-md-2 control-label" style="text-align:left;">Date Start :</label>
		<div class="col-md-4">
			<div class="input-group">
				<input type="text" class="form-control form-control-inline date-picker" name="date_start" id="date_start" data-date-format="dd-mm-yyyy" value="@if(isset($date_start)) {{$date_start}} @else {{date('d-m-Y')}} @endif" readonly>
				<span class="input-group-btn">
					<button class="btn default" type="button">
						<i class="fa fa-calendar"></i>
					</button>
				</span>
			</div>
		</div>

		<label class="col-md-2 control-label" style="text-align:left">Date End :</label>
		<div class="col-md-4">
			<div class="input-group">
				<input type="text" class="form-control form-control-inline date-picker" name="date_end"  id="date_end"  data-date-format="dd-mm-yyyy" value="@if(isset($date_end)) {{$date_end}} @else {{date('d-m-Y')}} @endif" readonly>
				<span class="input-group-btn">
					<button class="btn default" type="button">
						<i class="fa fa-calendar"></i>
					</button>
				</span>
			</div>
		</div>
	</div>
</div>

<div id="manualFilter<?php if(!isset($show) || $show){echo "1";} ?>" class="collapse  @if(!isset($show) || $show) show @endif">
	<div id="div-rule">
		@if(!is_array($conditions) || count($conditions) <= 0)
			<div id="rule0">
				<div class="portlet light bordered">
					<div class="form-group mt-repeater">
						<div id="div-condition0">
							<div data-repeater-item class="mt-repeater-item mt-overflow" id="condition00">
								<div class="mt-repeater-cell">
									<div class="col-md-12">
										<div class="col-md-1">
											<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition('00','0')">
												<i class="fa fa-close"></i>
											</a>
										</div>
										<div class="col-md-4">
											<div class="input-group">
												<select id="select200"  name="conditions[0][0][subject]" class="form-control input-sm select2 subject" placeholder="Search Subject" onChange="changeSubject(this.name, 0)" style="width:100%" required>
													<option value="all_user" selected>All User</option>
													<option value="name">Name</option>
													<option value="phone">Phone</option>
													@if($type == 'device')
													<option value="device_type">Device Type</option>
													@endif
													@if($type != 'device' && $type != 'suspend')
													<option value="outlet">Outlet</option>
													<option value="number_of_breaking">Number of breaking</option>
													@endif
												</select>
												<span class="input-group-addon">
													<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Pilih field yang akan dijadikan condition filter" data-container="body"></i>
												</span>
											</div>
										</div>

										<div id="normalCondition00">
											<div class="col-md-4">
												<div class="input-group">
													<select name="conditions[0][0][operator]" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%">
														<option value="=" selected>=</option>
														<option value="like">Like</option>
													</select>
													<span class="input-group-addon">
													<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="(1). Operator '=' untuk mendapatkan hasil pencarian yang sama persis dengan keyword.

													(2). Operator 'like' untuk mendapatkan hasil pencarian yang mirip atau mengandung keyword
													" data-container="body"></i>
												</span>
												</div>
											</div>
											<div class="col-md-3">
												<div class="input-group">
													<input type="text" placeholder="Parameter" class="form-control" name="conditions[0][0][parameter]"/>
													<span class="input-group-addon">
													<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
												</span>
												</div>
											</div>
										</div>
										<div id="specialCondition00" style="display:none">
											<div class="col-md-3">
												<div class="input-group">
													<select name="conditions[0][0][id]" class="form-control input-sm select2"  placeholder="Search Operator" style="width:100%">
													</select>
													</span>
												</div>
											</div>
											<div class="col-md-2">
												<div class="input-group">
													<select name="conditions[0][0][operatorSpecialCondition]" class="form-control input-sm select2" id="operator00" placeholder="Search Operator" style="width:100%">
														<option value="=" selected>=</option>
														<option value=">=">>=</option>
														<option value=">">></option>
														<option value="<="><=</option>
														<option value="<"><</option>
													</select>
													<span class="input-group-addon">
													<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="(1). Operator '=' untuk mendapatkan hasil pencarian yang sama persis dengan keyword.

													(2). Operator 'like' untuk mendapatkan hasil pencarian yang mirip atau mengandung keyword
													" data-container="body"></i>
												</span>
												</div>
											</div>
											<div class="col-md-2">
												<div class="input-group">
													<input type="text" placeholder="0" class="form-control" name="conditions[0][0][parameterSpecialCondition]" id="parameter00"/>
													<span class="input-group-addon">
													<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
												</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-action col-md-12">
							<div class="col-md-12">
								<a id="btnAddCondition0" href="javascript:;" class="btn btn-success mt-repeater-add" onClick="changeSelect();addCondition(0, 1)">
									<i class="fa fa-plus"></i> Add New Condition</a>
							</div>
						</div>
						<div class="form-action col-md-12" style="margin-top:15px">
							<div class="col-md-7">
								<div class="input-group">
									<select name="conditions[0][rule]" class="form-control" placeholder="Search Rule">
										<option value="and">Valid when all conditions are met</option>
										<option value="or">Valid when minimum one condition is met</option>
									</select>
									<span class="input-group-addon">
									<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Valid when all conditions are met = melakukan filter pencarian dengan semua kondisi.

									Valid when minimum one condition is met = melakukan filter pencarian dengan salah satu kondisi
									" data-container="body"></i>
								</span>
								</div>
							</div>
							<input type="hidden" name="conditions[0][rule_next]" value="and">
							<div class="col-md-5">
								{{ csrf_field() }}
								<button type="submit" class="btn yellow"><i class="fa fa-search"></i> Search</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		@else
			<?php $q = 0; ?>
			@foreach($conditions as $key => $cond)
				<div id="rule{{$q}}" @if($q > 0) style="margin-top:80px;" @endif>
					<div class="portlet light bordered">
						<div class="form-group mt-repeater">
							<div id="div-condition{{$q}}">
								<?php
								$indexnya = 0;
								?>
								@if(isset($cond['rules']))
									<?php $cond = $cond['rules']; ?>
								@endif

								@foreach($cond as $row)
									@if(isset($row['subject']) && $row['subject'] != 'date_suspend')
										<?php
										if($row['subject'] != '' && $row['subject'] != 'all_user'){
											$arrayOp = ['=','like','<','<=','>','>='];
											if(isset($row['operator']) && !in_array($row['operator'],$arrayOp)){
												$row['parameter'] = $row['operator'];
											}
										}else{
											$row['operator'] = "";
											$row['parameter'] = $row['operator'];

										}
										?>
										<div data-repeater-item class="mt-repeater-item mt-overflow" id="condition{{$q}}{{$indexnya}}">
											<div class="mt-repeater-cell">
												<div class="col-md-12">
													<div class="col-md-1">
														<a href="javascript:;" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition('{{$q}}{{$indexnya}}','{{$q}}')">
															<i class="fa fa-close"></i>
														</a>
													</div>
													<div class="col-md-4">
														<div class="input-group">
															<select id="select2{{$q}}{{$indexnya}}" name="conditions[{{$q}}][{{$indexnya}}][subject]" class="form-control input-sm select2 subject" placeholder="Search Subject" onChange="changeSubject(this.name, {{$indexnya}})" style="width:100%">
																<option value="all_user" @if($row['subject'] == 'all_user') selected @endif>All User</option>
																<option value="name" @if($row['subject'] == 'name') selected @endif>Name</option>
																<option value="phone" @if($row['subject'] == 'phone') selected @endif>Phone</option>
																@if($type == 'device')
																	<option value="device_type" @if($row['subject'] == 'device_type') selected @endif>Device Type</option>
																@endif
																@if($type != 'device')
																	<option value="outlet" @if($row['subject'] == 'outlet') selected @endif>Outlet</option>
																	<option value="number_of_breaking" @if($row['subject'] == 'number_of_breaking') selected @endif>Number of breaking</option>
																@endif
															</select>
															<span class="input-group-addon">
															<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Pilih field yang akan dijadikan condition filter" data-container="body"></i>
														</span>
														</div>
													</div>
													<?php
													$operator = '';
													$parameter = '';
													$id_data = '';
													$display_special_condition = 'none';
													$display_normal_condition = 'block';
													$display_input = 0;

													if($row['subject'] == 'all_user'){
														if($row['subject'] == 'all_user'){
															$display_input = 1;
														}

														$operator .= '<option value="="'.($row['operator'] == '=' ? 'selected' : '').'>=</option>';
														$operator .= '<option value="like"'.($row['operator'] == 'like' ? 'selected' : '').'>Like</option>';
														$parameter .= '<input type="text" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]" value="'.$row['parameter'].'"/>';
													}elseif($row['subject'] == 'name' || $row['subject'] == 'phone'){

														$operator .= '<option value="="'.($row['operator'] == '=' ? 'selected' : '').'>=</option>';
														$operator .= '<option value="like"'.($row['operator'] == 'like' ? 'selected' : '').'>Like</option>';
														$parameter .= '<input type="text" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]" value="'.$row['parameter'].'" required/>';
													}elseif($row['subject'] == 'device_type'){

														$operator .= '<option value="Android" '.($row['parameter'] == "Android" ? 'selected' : '').'>Android</option>';
														$operator .= '<option value="IOS" '.($row['parameter'] == "IOS" ? 'selected' : '').'>IOS</option>';
														$operator .= '<option value="Both" '.($row['parameter'] == "Both" ? 'selected' : '').'>Both</option>';
														$operator .= '<option value="None" '.($row['parameter'] == "None" ? 'selected' : '').'>None</option>';
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'outlet'){
														foreach($outlets as $outlet){
															$operator .= '<option value="'.$outlet['id_outlet'].'" '.($row['parameter'] == $outlet['id_outlet'] ? 'selected' : '').'>'.$outlet['outlet_name'].'</option>';
														}
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'number_of_breaking'){
                                                        $operator .= '<option value="=" '.($row['operator'] == '=' ? 'selected' : '').'>=</option>';
                                                        $operator .= '<option value=">=" '.($row['operator'] == '>=' ? 'selected' : '').'>>=</option>';
                                                        $operator .= '<option value=">" '.($row['operator'] == '>' ? 'selected' : '').'>></option>';
                                                        $operator .= '<option value="<=" '.($row['operator'] == '<=' ? 'selected' : '').'><=</option>';
                                                        $operator .= '<option value="<" '.($row['operator'] == '<' ? 'selected' : '').'><</option>';
                                                        $parameter .= '<input type="text" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]" value="'.$row['parameter'].'" '.($row['subject'] !== 'all_user' ? 'required' : '').' required/>';
                                                    }
													?>

													<div id="normalCondition{{$q}}{{$indexnya}}" style="display: {{$display_normal_condition}};">
														<div class="col-md-4">
															<div class="input-group" @if($display_input == 1) style="display: none;" @endif>
																<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%">
																	@if($display_normal_condition != 'none')
																		<?php echo $operator ?>
																	@else
																		<option value="=" selected>=</option>
																		<option value="like">Like</option>
																	@endif
																</select>
																<span class="input-group-addon">
																<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="(1). Operator '=' untuk mendapatkan hasil pencarian yang sama persis dengan keyword.

																(2). Operator 'like' untuk mendapatkan hasil pencarian yang mirip atau mengandung keyword
																" data-container="body"></i>
															</span>
															</div>
														</div>
														<div class="col-md-3">
															<div class="input-group" @if($display_input == 1) style="display: none;" @endif>
																@if($display_normal_condition != 'none')
																	<?php echo $parameter ?>
																@else
																	<input type="text" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]"/>
																@endif
																<span class="input-group-addon">
																	<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
															</span>
															</div>
														</div>
													</div>
													<div id="specialCondition{{$q}}{{$indexnya}}" style="display: {{$display_special_condition}};">
														<div class="col-md-3">
															<div class="input-group">
																<select name="conditions[{{$q}}][{{$indexnya}}][id]" class="form-control input-sm select2" placeholder="Search Product"  style="width:100%">
																	<?php echo $id_data ?>
																</select>
															</div>
														</div>
														<div class="col-md-2">
															<div class="input-group">
																<select name="conditions[{{$q}}][{{$indexnya}}][operatorSpecialCondition]" id="operator{{$q}}{{$indexnya}}" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%">
																	<?php echo $operator ?>
																</select>
																<span class="input-group-addon">
															<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="(1). Operator '=' untuk mendapatkan hasil pencarian yang sama persis dengan keyword.

															(2). Operator 'like' untuk mendapatkan hasil pencarian yang mirip atau mengandung keyword
															" data-container="body"></i>
														</span>
															</div>
														</div>
														<div class="col-md-2">
															<div class="input-group">
																@if($display_special_condition != 'none')
																	<?php echo $parameter ?>
																@else
																	<input type="text" placeholder="0" class="form-control" id="parameter{{$q}}{{$indexnya}}" name="conditions[{{$q}}][{{$indexnya}}][parameterSpecialCondition]"/>
																@endif
																<span class="input-group-addon">
																<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
															</span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<?php
										$indexnya++;
										?>
									@endif
								@endforeach
							</div>
							<div class="form-action col-md-12">
								<div class="col-md-12">
									<a id="btnAddCondition{{$q}}" href="javascript:;" class="btn btn-success mt-repeater-add" onClick="changeSelect();addCondition({{$q}},{{$indexnya}})">
										<i class="fa fa-plus"></i> Add New Condition</a>
								</div>
							</div>
							<div class="form-action col-md-12" style="margin-top:15px">
								<div class="col-md-7">
									<div class="input-group">
										<select name="conditions[{{$q}}][rule]" class="form-control" placeholder="Search Rule">
											<option value="and" @if($conditions[$key]['rule'] == 'and') selected @endif>Valid when all conditions are met</option>
											<option value="or" @if($conditions[$key]['rule'] == 'or') selected @endif>Valid when minimum one condition is met</option>
										</select>
										<span class="input-group-addon">
										<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Valid when all conditions are met = melakukan filter pencarian dengan semua kondisi.

										Valid when minimum one condition is met = melakukan filter pencarian dengan salah satu kondisi
										" data-container="body"></i>
									</span>
									</div>
								</div>
								<input type="hidden" name="conditions[{{$q}}][rule_next]" value="and">
								<div class="col-md-5">
									{{ csrf_field() }}
									<button type="submit" class="btn yellow"><i class="fa fa-search"></i> Search</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php $q++	; ?>
			@endforeach
		@endif
	</div>
</div>