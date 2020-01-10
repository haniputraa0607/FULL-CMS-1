<?php
    use App\Lib\MyHelper;
	$configs = session('configs');
 ?>
<script>
	document.addEventListener("DOMContentLoaded", function(event) { 
		$('.datepicker').datepicker({ 
			'format' : 'yyyy-mm-dd', 
			'todayHighlight' : true, 
			'autoclose' : true 
		});  
	})

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

	function addRule(){
		$("#div-rule").append(
			'<div id="rule'+noRule+'">'+
				'<div class="portlet light bordered" style="margin-top:80px">'+
					'<div class="col-md-12" style="padding: 0; margin-bottom: 15px;">'+
						'<a href="javascript:;" class="btn btn-danger pull-right delete-rule" onClick="deleteRule('+noRule+')">'+
							'<i class="fa fa-trash"></i> Delete Rule'+
						'</a>'+
					'</div>'+
					'<div class="form-group mt-repeater">'+
						'<div id="div-condition'+noRule+'">'+
							'<div data-repeater-item class="mt-repeater-item mt-overflow" id="condition'+noRule+'0">'+
								'<div class="mt-repeater-cell">'+
									'<div class="col-md-12">'+
										'<div class="col-md-1">'+
											'<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition(`'+noRule.toString()+'0`,`'+noRule.toString()+'`)">'+
												'<i class="fa fa-close"></i>'+
											'</a>'+
										'</div>'+
										'<div class="col-md-4">'+
											'<div class="input-group">'+
												'<select id="select2'+noRule+'0" name="conditions['+noRule+'][0][subject]" class="form-control input-sm select2 subject" placeholder="Search Subject" onChange="changeSubject(this.name, '+noRule+')" style="width:100%" required>'+
													'<optgroup label="All">'+
														'<option value="all_user" selected>All User</option>'+
													'</optgroup>'+
													'<optgroup label="Profile">'+
														'<option value="name" selected>Name</option>'+
														'<option value="phone">Phone</option>'+
														'<option value="email">Email</option>'+
														'<option value="city_name">City</option>'+
														'<option value="province_name">Province</option>'+
														'<option value="city_postal_code">Postal Code</option>'+
														'<option value="gender">Gender</option>'+
														'<option value="provider">Provider</option>'+
														'<option value="age">Age</option>'+
														'<option value="birthday_date">Birthday Date</option>'+
														'<option value="birthday_month">Birthday Month</option>'+
														'<option value="birthday_year">Birthday Year</option>'+
														'<option value="birthday_today">Birthday Today</option>'+
														'<option value="phone_verified">Phone Verified</option>'+
														'<option value="email_verified">Email Verified</option>'+
														'<option value="email_unsubscribed">Email Unsubscribed</option>'+
														'<option value="level">Level</option>'+
														'@if(MyHelper::hasAccess([18], $configs))'+
														'<option value="points">Points</option>'+
														'<option value="balance">Balance</option>'+
														'@endif'+
														'<option value="device">Device</option>'+
														'<option value="is_suspended">Suspend Status</option>'+
														'<option value="register_date">Register Date</option>'+
														'<option value="register_today">Register Today</option>'+
													'</optgroup>'+
													'<optgroup label="Transaction">'+
														'<option value="trx_type">Transaction Type</option>'+
														'<option value="trx_outlet">Transaction Outlet</option>'+
														'<option value="trx_outlet_not">Transaction Outlet Not</option>'+
														'<option value="trx_product">Transaction Product</option>'+
														'<option value="trx_product_not">Transaction Product Not</option>'+
														'<option value="trx_product_count">Transaction Product Count</option>'+
												// 		'<option value="trx_product_tag">Transaction Product Tag</option>'+
												// 		'<option value="trx_product_tag_count">Transaction Product Tag Count</option>'+
														'<option value="trx_date">Transaction Date</option>'+
														'<option value="last_trx">Last Transaction</option>'+
														'<option value="trx_count">Transaction Count</option>'+
														'<option value="trx_subtotal">Transaction Sub Total</option>'+
														'<option value="trx_tax">Transaction Tax</option>'+
														'<option value="trx_service">Transaction Service</option>'+
														'<option value="trx_discount">Transaction Discount</option>'+
														// '<option value="trx_shipment_value">Transaction Shipment Value</option>'+
														// '<option value="trx_shipment_courier">Transaction Shipment Courier</option>'+
														'<option value="trx_payment_type">Transaction Payment Type</option>'+
														'<option value="trx_payment_status">Transaction Payment Status</option>'+
														'<option value="trx_void_count">Transaction Void Count</option>'+
														'<option value="trx_grandtotal">Transaction Grand Total</option>'+
													'</optgroup>'+
												'</select>'+
												'<span class="input-group-addon">'+
													'<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Pilih field yang akan dijadikan condition filter" data-container="body"></i>'+
												'</span>'+
											'</div>'+
										'</div>'+
										'<div class="col-md-4">'+
											'<div class="input-group">'+
												'<select name="conditions['+noRule+'][0][operator]" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%">'+
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
												'<input type="text" placeholder="Parameter" class="form-control" name="conditions['+noRule+'][0][parameter]" required/>'+
												// '<span class="input-group-addon" name="conditions['+noRule+'][0][addon-days]" style="display:none">'+
												// 	'Days Ago'+
												// '</span>'+
												'<span class="input-group-addon">'+
													'<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>'+
												'</span>'+
											'</div>'+
										'</div>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'<div class="form-action col-md-12">'+
							'<div class="col-md-12">'+
								'<a id="btnAddCondition'+noRule+'" href="javascript:;" class="btn btn-success mt-repeater-add" onClick="changeSelect();addCondition('+noRule+', 1)">'+
								'<i class="fa fa-plus"></i> Add New Condition</a>'+
							'</div>'+
						'</div>'+
						'<div class="form-action col-md-12" style="margin-top:15px">'+
							'<div class="col-md-7">'+
								'<div class="input-group">'+
									'<select name="conditions['+noRule+'][rule]" class="form-control" placeholder="Search Rule" required>'+
										'<option value="and">Valid when all conditions are met</option>'+
										'<option value="or">Valid when minimum one condition is met</option>'+
									'</select>'+
									'<span class="input-group-addon">'+
										'<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Valid when all conditions are met = melakukan filter pencarian dengan semua kondisi.'+
										
										'Valid when minimum one condition is met = melakukan filter pencarian dengan salah satu kondisi'+
										'" data-container="body"></i>'+
									'</span>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>'+
				'<div class="col-md-3">'+
					'<div class="input-group">'+
						'<select name="conditions['+noRule+'][rule_next]" class="form-control" placeholder="Search Rule" required>'+
							'<option value="and">And</option>'+
							'<option value="or">Or</option>'+
						'</select>'+
						'<span class="input-group-addon">'+
							'<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="And = melakukan filter pencarian dengan semua kondisi.'+
							
							'Or = melakukan filter pencarian dengan salah satu kondisi'+
							'" data-container="body"></i>'+
						'</span>'+
					'</div>'+
				'</div>'+
			'</div>'
		);
		noRule++;
		$('.tooltips').tooltip()
	}

	function deleteRule(no){
		if(confirm('Are you sure you want to delete this rule?')) {
			$('#rule'+no).remove()
		}
		
	}

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
									'<optgroup label="All">'+
										'<option value="all_user" selected>All User</option>'+
									'</optgroup>'+
									'<optgroup label="Profile">'+
										'<option value="name" selected>Name</option>'+
										'<option value="phone">Phone</option>'+
										'<option value="email">Email</option>'+
										'<option value="city_name">City</option>'+
										'<option value="province_name">Province</option>'+
										'<option value="city_postal_code">Postal Code</option>'+
										'<option value="gender">Gender</option>'+
										'<option value="provider">Provider</option>'+
										'<option value="age">Age</option>'+
										'<option value="birthday_date">Birthday Date</option>'+
										'<option value="birthday_month">Birthday Month</option>'+
										'<option value="birthday_year">Birthday Year</option>'+
										'<option value="birthday_today">Birthday Today</option>'+
										'<option value="phone_verified">Phone Verified</option>'+
										'<option value="email_verified">Email Verified</option>'+
										'<option value="email_unsubscribed">Email Unsubscribed</option>'+
										'<option value="level">Level</option>'+
										'@if(MyHelper::hasAccess([18], $configs))'+
										'<option value="points">Points</option>'+
										'<option value="balance">Balance</option>'+
										'@endif'+
										'<option value="device">Device</option>'+
										'<option value="is_suspended">Suspend Status</option>'+
										'<option value="register_date">Register Date</option>'+
										'<option value="register_today">Register Today</option>'+
									'</optgroup>'+
									'<optgroup label="Transaction">'+
										'<option value="trx_type">Transaction Type</option>'+
										'<option value="trx_outlet">Transaction Outlet</option>'+
										'<option value="trx_outlet_not">Transaction Outlet Not</option>'+
										'<option value="trx_product">Transaction Product</option>'+
										'<option value="trx_product_not">Transaction Product Not</option>'+
										'<option value="trx_product_count">Transaction Product Count</option>'+
								// 		'<option value="trx_product_tag">Transaction Product Tag</option>'+
								// 		'<option value="trx_product_tag_count">Transaction Product Tag Count</option>'+
										'<option value="trx_date">Transaction Date</option>'+
										'<option value="last_trx">Last Transaction</option>'+
										'<option value="trx_count">Transaction Count</option>'+
										'<option value="trx_subtotal">Transaction Sub Total</option>'+
										'<option value="trx_tax">Transaction Tax</option>'+
										'<option value="trx_service">Transaction Service</option>'+
										'<option value="trx_discount">Transaction Discount</option>'+
										// '<option value="trx_shipment_value">Transaction Shipment Value</option>'+
										// '<option value="trx_shipment_courier">Transaction Shipment Courier</option>'+
										'<option value="trx_payment_type">Transaction Payment Type</option>'+
										'<option value="trx_payment_status">Transaction Payment Status</option>'+
										'<option value="trx_void_count">Transaction Void Count</option>'+
										'<option value="trx_grandtotal">Transaction Grand Total</option>'+
									'</optgroup>'+
								'</select>'+
								'<span class="input-group-addon">'+
									'<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Pilih field yang akan dijadikan condition filter" data-container="body"></i>'+
								'</span>'+
							'</div>'+
						'</div>'+
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
								// '<span class="input-group-addon" name="addon-days" style="display:none">'+
								// 	'Days Ago'+
								// '</span>'+
								'<span class="input-group-addon">'+
									'<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>'+
								'</span>'+
							'</div>'+
						'</div>'+
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
			if($('#select2'+no).val() == 'trx_product'){
				cekProduct[indexRule] = false;
				if(ProductCount[indexRule] != undefined){
					ProductCount[indexRule].forEach(function(item) {
						$('#condition'+item).remove()
					});
				}
			}
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

	var cekProduct = [];
	var cekProductTag = [];
	var ProductCount = [];
	var ProductTagCount = [];
	
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

		if(subject_value == 'name' || subject_value == 'email' || subject_value == 'phone'){
			var operator = "conditions["+index+"][operator]";
			
			var operator_value = document.getElementsByName(operator)[0];

			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');
			operator_value.options[operator_value.options.length] = new Option('like', 'like');
			
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'none';
			}
		}
		if(subject_value == 'age' || subject_value == 'birthday_date' || subject_value == 'birthday_year' || subject_value == 'points' 
			|| subject_value == 'balance' || subject_value == 'register_date' || subject_value == 'trx_product_count' 
			|| subject_value == 'trx_product_tag_count' || subject_value == 'trx_date' || subject_value == 'trx_count' 
			|| subject_value == 'trx_subtotal' || subject_value == 'trx_tax' || subject_value == 'last_trx' 
			|| subject_value == 'trx_service' || subject_value == 'trx_discount' || subject_value == 'trx_shipment_value' 
			|| subject_value == 'trx_void_count' || subject_value == 'trx_grandtotal' )
		{
			// cek sudah pilih productnya atau belum
			if (cekProduct[indexRule] == undefined){
				cekProduct[indexRule] = false;
			}
			if(subject_value == 'trx_product_count'){
				if(cekProduct[indexRule] == false){
					alert('You must choose the transaction product first');
					$("#select2"+indx).val('').trigger('change');
					document.getElementsByName("conditions["+index+"][subject]")[0].value = ""
				}else{
					if(ProductCount[indexRule] == undefined){
						ProductCount[indexRule] = [indx]
					}else{
						ProductCount[indexRule].push(indx);
					}
				}
			}

			if (cekProductTag[indexRule] == undefined){
				cekProductTag[indexRule] = false;
			}
			console.log(subject_value)
			if(subject_value == 'trx_product_tag_count'){
				if(cekProductTag[indexRule] == false){
					alert('You must choose the transaction product tag first');
					$("#select2"+indx).val('').trigger('change');
					document.getElementsByName("conditions["+index+"][subject]")[0].value = ""
				}else{
					if(ProductTagCount[indexRule] == undefined){
						ProductTagCount[indexRule] = [indx]
					}else{
						ProductTagCount[indexRule].push(indx);
					}
				}
				console.log(ProductTagCount)
			}

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
			} else {
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			}
		}
		
		if(subject_value == 'birthday_month'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('January', '1');
			operator_value.options[operator_value.options.length] = new Option('February', '2');
			operator_value.options[operator_value.options.length] = new Option('March', '3');
			operator_value.options[operator_value.options.length] = new Option('April', '4');
			operator_value.options[operator_value.options.length] = new Option('May', '5');
			operator_value.options[operator_value.options.length] = new Option('June', '6');
			operator_value.options[operator_value.options.length] = new Option('July', '7');
			operator_value.options[operator_value.options.length] = new Option('August', '8');
			operator_value.options[operator_value.options.length] = new Option('September', '9');
			operator_value.options[operator_value.options.length] = new Option('October', '10');
			operator_value.options[operator_value.options.length] = new Option('November', '11');
			operator_value.options[operator_value.options.length] = new Option('December', '12');
			
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}

		if(subject_value == 'birthday_today' || subject_value == 'register_today'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Today', 'Today');
			
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}
		
		if(subject_value == 'provider'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Telkomsel', 'Telkomsel');
			operator_value.options[operator_value.options.length] = new Option('Indosat', 'Indosat');
			operator_value.options[operator_value.options.length] = new Option('XL Axiata', 'XL Axiata');
			operator_value.options[operator_value.options.length] = new Option('Tri', 'Tri');
			operator_value.options[operator_value.options.length] = new Option('Smart', 'Smart');
			operator_value.options[operator_value.options.length] = new Option('Axis', 'Axis');
			
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}
		
		if(subject_value == 'gender'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Male', 'Male');
			operator_value.options[operator_value.options.length] = new Option('Female', 'Female');
			
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}
		
		if(subject_value == 'level'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Super Admin', 'Super Admin');
			operator_value.options[operator_value.options.length] = new Option('Admin', 'Admin');
			operator_value.options[operator_value.options.length] = new Option('Customer', 'Customer');
			
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}
		
		if(subject_value == 'membership'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			<?php
			foreach($memberships as $row){
			?>
			operator_value.options[operator_value.options.length] = new Option('<?php echo $row['membership_name']; ?>', '<?php echo $row['id_membership']; ?>');
			<?php
			}
			?>
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}

		if(subject_value == 'city_name'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			<?php
			foreach($city as $row){
			?>
			operator_value.options[operator_value.options.length] = new Option('<?php echo $row['city_name']; ?>', '<?php echo $row['city_name']; ?>');
			<?php
			}
			?>
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}
		
		if(subject_value == 'city_postal_code'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			<?php
			foreach($city as $row){
			?>
			operator_value.options[operator_value.options.length] = new Option('<?php echo $row['city_postal_code']; ?>', '<?php echo $row['city_postal_code']; ?>');
			<?php
			}
			?>
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}
		
		if(subject_value == 'province_name'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			<?php
			foreach($province as $row){
			?>
			operator_value.options[operator_value.options.length] = new Option('<?php echo $row['province_name']; ?>', '<?php echo $row['province_name']; ?>');
			<?php
			}
			?>
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}
		
		if(subject_value == 'phone_verified' || subject_value == 'email_verified'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Not Verified', '0');
			operator_value.options[operator_value.options.length] = new Option('Verified', '1');
			
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}
		
		if(subject_value == 'email_unsubscribed'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Subscribed', '1');
			operator_value.options[operator_value.options.length] = new Option('Unsubscribed', '0');
			
			
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}
		
		if(subject_value == 'is_suspended'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Not Suspended', '0');
			operator_value.options[operator_value.options.length] = new Option('Suspended', '1');
			
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}
		
		if(subject_value == 'device' ){
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
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}
		
		if(subject_value == 'trx_type'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Offline', 'Offline');
			operator_value.options[operator_value.options.length] = new Option('Delivery', 'Delivery');
			operator_value.options[operator_value.options.length] = new Option('Pickup Order', 'Pickup Order');
			
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}
		
		if(subject_value == 'trx_payment_status'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Pending', 'Pending');
			operator_value.options[operator_value.options.length] = new Option('Paid', 'Paid');
			operator_value.options[operator_value.options.length] = new Option('Completed', 'Completed');
			operator_value.options[operator_value.options.length] = new Option('Cancelled', 'Cancelled');
			
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}
		
		if(subject_value == 'trx_payment_type'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Midtrans', 'Midtrans');
			operator_value.options[operator_value.options.length] = new Option('Manual', 'Manual');
			operator_value.options[operator_value.options.length] = new Option('Offline', 'Offline');
			operator_value.options[operator_value.options.length] = new Option('Balance', 'Balance');
			
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}
		
		if(subject_value == 'trx_shipment_courier'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			<?php
			foreach($couriers as $courier){
			?>
			operator_value.options[operator_value.options.length] = new Option('<?php echo $courier['short_name']." (".$courier['name'].")"; ?>', '<?php echo $courier['short_name']; ?>');
			<?php
			}
			?>
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}
		
		if(subject_value == 'trx_outlet' || subject_value == 'trx_outlet_not'){
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
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}
		
		if(subject_value == 'trx_product' || subject_value == 'trx_product_not'){
			if(subject_value == 'trx_product'){
				cekProduct[indexRule] = true;
			}
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			<?php
			foreach($products as $product){
			?>
			operator_value.options[operator_value.options.length] = new Option("<?php echo $product['product_name'];?>", "<?php echo $product['id_product']; ?>");
			<?php
			}
			?>
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}

		if(subject_value == 'trx_product_tag' || subject_value == 'trx_product_tag_not'){
			if(subject_value == 'trx_product_tag'){
				cekProductTag[indexRule] = true;
			}
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			<?php
			foreach($tags as $tag){
			?>
			operator_value.options[operator_value.options.length] = new Option("<?php echo $tag['tag_name'];?>", "<?php echo $tag['id_tag']; ?>");
			<?php
			}
			?>
			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else {
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}

		if(subject_value == 'birthday_date' || subject_value == 'register_date' || subject_value == 'trx_date'){
			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].setAttribute('class', 'form-control datepicker') 
			document.getElementsByName(parameter)[0].value = "" 
			$('.datepicker').datepicker({ 
				'format' : 'yyyy-mm-dd', 
				'todayHighlight' : true, 
				'autoclose' : true 
			});  
		}else{
			var parameter = "conditions["+index+"][parameter]";
			if($('.datepicker').length > 0){
				$('.datepicker').datepicker('remove'); 
				document.getElementsByName(parameter)[0].setAttribute('class', 'form-control') 
			}
		}

		if(subject_value == 'last_trx'){
			if(document.getElementsByName("conditions["+index+"][addon-days]")[0]){
				document.getElementsByName("conditions["+index+"][addon-days]")[0].style.display = "table-cell" 
			}
			document.getElementsByName(parameter)[0].type = "number" 
		}else{
			document.getElementsByName(parameter)[0].type = "text" 
			if(document.getElementsByName("conditions["+index+"][addon-days]")[0]){
				document.getElementsByName("conditions["+index+"][addon-days]")[0].style.display = "none" 
	
			}
		}

	}
</script>

<div id="manualFilter<?php if(!isset($show) || $show){echo "1";} ?>" class="collapse  @if(!isset($show) || $show) show @endif">
<div id="div-rule">
	@if(!is_array($conditions) || count($conditions) <= 0)
		<div id="rule0">
			<div class="portlet light bordered">
				<div class="col-md-12" style="padding: 0; margin-bottom: 15px;">
					<a href="javascript:;" class="btn btn-danger pull-right delete-rule" onclick="deleteRule(0)">
						<i class="fa fa-trash"></i> Delete Rule
					</a>
				</div>
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
													<optgroup label="All">
														<option value="all_user">All User</option>
													</optgroup>
													<optgroup label="Profile">
														<option value="name" selected>Name</option>
														<option value="phone">Phone</option>
														<option value="email">Email</option>
														<option value="city_name">City</option>
														<option value="province_name">Province</option>
														<option value="city_postal_code">Postal Code</option>
														<option value="gender">Gender</option>
														<option value="provider">Provider</option>
														<option value="age">Age</option>
														<option value="birthday_date">Birthday Date</option>
														<option value="birthday_month">Birthday Month</option>
														<option value="birthday_year">Birthday Year</option>
														<option value="birthday_today">Birthday Today</option>
														<option value="phone_verified">Phone Verified</option>
														<option value="email_verified">Email Verified</option>
														<option value="email_unsubscribed">Email Unsubscribed</option>
														<option value="level">Level</option>
														@if(MyHelper::hasAccess([20], $configs))
														<option value="membership">Membership</option>
														@endif
														@if(MyHelper::hasAccess([18], $configs))
														<option value="points">Points</option>
														<option value="balance">Balance</option>
														@endif
														<option value="device">Device</option>
														<option value="is_suspended">Suspend Status</option>
														<option value="register_date">Register Date</option>
														<option value="register_today">Register Today</option>
													</optgroup>
													<optgroup label="Transaction">
														<option value="trx_type">Transaction Type</option>
														<option value="trx_outlet">Transaction Outlet</option>
														<option value="trx_outlet_not">Transaction Outlet Not</option>
														<option value="trx_product">Transaction Product</option>
														<option value="trx_product_not">Transaction Product Not</option>
														<option value="trx_product_count">Transaction Product Count</option>
														<!--<option value="trx_product_tag">Transaction Product Tag</option>-->
														<!--<option value="trx_product_tag_count">Transaction Product Tag Count</option>-->
														<option value="trx_date">Transaction Date</option>
														<option value="last_trx">Last Transaction</option>
														<option value="trx_count">Transaction Count</option>
														<option value="trx_subtotal">Transaction Sub Total</option>
														<option value="trx_tax">Transaction Tax</option>
														<option value="trx_service">Transaction Service</option>
														<option value="trx_discount">Transaction Discount</option>
												<!--	<option value="trx_shipment_value">Transaction Shipment Value</option> -->
												<!--	<option value="trx_shipment_courier">Transaction Shipment Courier</option> -->
														<option value="trx_payment_type">Transaction Payment Type</option>
														<option value="trx_payment_status">Transaction Payment Status</option>
														<option value="trx_void_count">Transaction Void Count</option>
														<option value="trx_grandtotal">Transaction Grand Total</option>
													</optgroup>
												</select>
												<span class="input-group-addon">
													<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Pilih field yang akan dijadikan condition filter" data-container="body"></i>
												</span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="input-group">
												<select name="conditions[0][0][operator]" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%" required>
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
												<input type="text" placeholder="Parameter" class="form-control" name="conditions[0][0][parameter]" required/>
												{{-- <span class="input-group-addon" name="conditions[0][0][addon-days]" style="display:none">
													Days Ago
												</span> --}}
												<span class="input-group-addon">
													<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
												</span>
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
								<select name="conditions[0][rule]" class="form-control" placeholder="Search Rule" required>
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
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="input-group">
					<select name="conditions[0][rule_next]" class="form-control" placeholder="Search Rule" required>
						<option value="and">And</option>
						<option value="or">Or</option>
					</select>
					<span class="input-group-addon">
						<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="And = melakukan filter pencarian dengan semua kondisi.
						
						Or = melakukan filter pencarian dengan salah satu kondisi
						" data-container="body"></i>
					</span>
				</div>
			</div>
		</div>
	@else
		<?php $q = 0; ?>
		@foreach($conditions as $key => $cond)
			<div id="rule{{$q}}" @if($q > 0) style="margin-top:80px;" @endif>
				<div class="portlet light bordered">
					<div class="col-md-12" style="padding: 0; margin-bottom: 15px;">
						<a href="javascript:;" class="btn btn-danger pull-right delete-rule" onclick="deleteRule({{$q}})">
							<i class="fa fa-trash"></i> Delete Rule
						</a>
					</div>
					<div class="form-group mt-repeater">
						<div id="div-condition{{$q}}">
							<?php
							$indexnya = 0;
							?>
							@if(isset($cond['rules']))
								<?php $cond = $cond['rules']; ?>	
							@endif

							@foreach($cond as $row)
								@if(isset($row['subject']))
									@if($row['subject'] == 'trx_product')
										<script>
											cekProduct["{{$q}}"] = true;
										</script>
									@elseif($row['subject'] == 'trx_product_count')
										<script>
											if(ProductCount["{{$q}}"] == undefined){
												ProductCount["{{$q}}"] = ["{{$q}}{{$indexnya}}"]
											}else{
												ProductCount["{{$q}}"].push("{{$q}}{{$indexnya}}");
											}
										</script>
									@elseif($row['subject'] == 'trx_product_tag')
										<script>
											cekProductTag["{{$q}}"] = true;
										</script>
									@elseif($row['subject'] == 'trx_product_tag_count')
										<script>
											if(ProductTagCount["{{$q}}"] == undefined){
												ProductTagCount["{{$q}}"] = ["{{$q}}{{$indexnya}}"]
											}else{
												ProductTagCount["{{$q}}"].push("{{$q}}{{$indexnya}}");
											}
										</script>
									@endif
									<?php 
									if($row['subject'] != '' && $row['subject'] != 'all_user'){
										$arrayOp = ['=','like','<','<=','>','>='];
										if(!in_array($row['operator'],$arrayOp)){
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
														<select id="select2{{$q}}{{$indexnya}}" name="conditions[{{$q}}][{{$indexnya}}][subject]" class="form-control input-sm select2 subject" placeholder="Search Subject" onChange="changeSubject(this.name, {{$indexnya}})" style="width:100%" required>
															<optgroup label="All">
																<option value="all_user" @if($row['subject'] == 'all_user') selected @endif>All User</option>
															</optgroup>
															<optgroup label="Profile">
																<option value="name" @if($row['subject'] == 'name') selected @endif>Name</option>
																<option value="phone" @if($row['subject'] == 'phone') selected @endif>Phone</option>
																<option value="email" @if($row['subject'] == 'email') selected @endif>Email</option>
																<option value="city_name" @if($row['subject'] == 'city_name') selected @endif>City</option>
																<option value="province_name" @if($row['subject'] == 'province_name') selected @endif>Province</option>
																<option value="city_postal_code" @if($row['subject'] == 'city_postal_code') selected @endif>Postal Code</option>
																<option value="gender" @if($row['subject'] == 'gender') selected @endif>Gender</option>
																<option value="provider" @if($row['subject'] == 'provider') selected @endif>Provider</option>
																<option value="age" @if($row['subject'] == 'age') selected @endif>Age</option>
																<option value="birthday_date" @if($row['subject'] == 'birthday_date') selected @endif>Birthday Date</option>
																<option value="birthday_month" @if($row['subject'] == 'birthday_month') selected @endif>Birthday Month</option>
																<option value="birthday_year" @if($row['subject'] == 'birthday_year') selected @endif>Birthday Year</option>
																<option value="birthday_today" @if($row['subject'] == 'birthday_today') selected @endif>Birthday Today</option>
																<option value="phone_verified" @if($row['subject'] == 'phone_verified') selected @endif>Phone Verified</option>
																<option value="email_verified" @if($row['subject'] == 'email_verified') selected @endif>Email Verified</option>
																<option value="email_unsubscribed" @if($row['subject'] == 'email_unsubscribed') selected @endif>Email Unsubscribed</option>
																<option value="level" @if($row['subject'] == 'level') selected @endif>Level</option>
																<option value="membership" @if($row['subject'] == 'membership') selected @endif>Membership</option>
																<option value="points" @if($row['subject'] == 'points') selected @endif>Points</option>
																<option value="balance" @if($row['subject'] == 'balance') selected @endif>Balance</option>
																<option value="device" @if($row['subject'] == 'device') selected @endif>Device</option>
																<option value="is_suspended" @if($row['subject'] == 'is_suspended') selected @endif>Suspend Status</option>
																<option value="register_date" @if($row['subject'] == 'register_date') selected @endif>Register Date</option>
																<option value="register_today" @if($row['subject'] == 'register_today') selected @endif>Register Today</option>
															</optgroup>
															<optgroup label="Transaction">
																<option value="trx_type" @if($row['subject'] == 'trx_type') selected @endif>Transaction Type</option>
																<option value="trx_outlet" @if($row['subject'] == 'trx_outlet') selected @endif>Transaction Outlet</option>
																<option value="trx_outlet_not" @if($row['subject'] == 'trx_outlet_not') selected @endif>Transaction Outlet Not</option>
																<option value="trx_product" @if($row['subject'] == 'trx_product') selected @endif>Transaction Product</option>
																<option value="trx_product_not" @if($row['subject'] == 'trx_product_not') selected @endif>Transaction Product Not</option>
																<option value="trx_product_count" @if($row['subject'] == 'trx_product_count') selected @endif>Transaction Product Count</option>
																<!--<option value="trx_product_tag" @if($row['subject'] == 'trx_product_tag') selected @endif>Transaction Product Tag</option>-->
																<!--<option value="trx_product_tag_count" @if($row['subject'] == 'trx_product_tag_count') selected @endif>Transaction Product Tag Count</option>-->
																<option value="trx_date" @if($row['subject'] == 'trx_date') selected @endif>Transaction Date</option>
																<option value="last_trx" @if($row['subject'] == 'last_trx') selected @endif>Last Transaction</option>
																<option value="trx_count" @if($row['subject'] == 'trx_count') selected @endif>Transaction Count</option>
																<option value="trx_subtotal" @if($row['subject'] == 'trx_subtotal') selected @endif>Transaction Sub Total</option>
																<option value="trx_tax" @if($row['subject'] == 'trx_tax') selected @endif>Transaction Tax</option>
																<option value="trx_service" @if($row['subject'] == 'trx_service') selected @endif>Transaction Service</option>
																<option value="trx_discount" @if($row['subject'] == 'trx_discount') selected @endif>Transaction Discount</option>
																<!-- <option value="trx_shipment_value" @if($row['subject'] == 'trx_shipment_value') selected @endif>Transaction Shipment Value</option> -->
																<!-- <option value="trx_shipment_courier" @if($row['subject'] == 'trx_shipment_courier') selected @endif>Transaction Shipment Courier</option> -->
																<option value="trx_payment_type" @if($row['subject'] == 'trx_payment_type') selected @endif>Transaction Payment Type</option>
																<option value="trx_payment_status" @if($row['subject'] == 'trx_payment_status') selected @endif>Transaction Payment Status</option>
																<option value="trx_void_count" @if($row['subject'] == 'trx_void_count') selected @endif>Transaction Void Count</option>
																<option value="trx_grandtotal" @if($row['subject'] == 'trx_grandtotal') selected @endif>Transaction Grand Total</option>
															</optgroup>
														</select>
														<span class="input-group-addon">
															<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Pilih field yang akan dijadikan condition filter" data-container="body"></i>
														</span>
													</div>
												</div>
												@if($row['subject'] == 'name' || $row['subject'] == 'email' || $row['subject'] == 'phone' || $row['subject'] == 'all_user')
												<div class="col-md-4">
													<div class="input-group" @if($row['subject'] == 'all_user') style="display:none" @endif>
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%" @if($row['subject'] != 'all_user') required @endif>
															<option value="=" @if($row['operator'] == "=") selected @endif>=</option>
															<option value="like" @if($row['operator'] == "like") selected @endif>Like</option>
														</select>
														<span class="input-group-addon">
															<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="(1). Operator '=' untuk mendapatkan hasil pencarian yang sama persis dengan keyword.

															(2). Operator 'like' untuk mendapatkan hasil pencarian yang mirip atau mengandung keyword
															" data-container="body"></i>
														</span>
													</div>
												</div>
												<div class="col-md-3" id="parameter{{$indexnya}}">
													<div class="input-group" @if($row['subject'] == 'all_user') style="display:none" @endif>
														<input type="text" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]" value="{{$row['parameter']}}" @if($row['subject'] != 'all_user') required @endif/>
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
															</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'age' || $row['subject'] == 'birthday_date' || $row['subject'] == 'birthday_year' 
													|| $row['subject'] == 'points' || $row['subject'] == 'balance' || $row['subject'] == 'register_date' 
													|| $row['subject'] == 'trx_product_count' || $row['subject'] == 'trx_product_tag_count' 
													|| $row['subject'] == 'trx_date' || $row['subject'] == 'last_trx' || $row['subject'] == 'trx_count' 
													|| $row['subject'] == 'trx_subtotal' || $row['subject'] == 'trx_tax' || $row['subject'] == 'trx_service' 
													|| $row['subject'] == 'trx_discount' || $row['subject'] == 'trx_discount' 
													|| $row['subject'] == 'trx_shipment_value' || $row['subject'] == 'trx_void_count' 
													|| $row['subject'] == 'trx_grandtotal')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%" required>
															<option value="=" @if($row['operator'] == "=") selected @endif>=</option>
															<option value=">=" @if($row['operator'] == ">=") selected @endif>>=</option>
															<option value=">" @if($row['operator'] == ">") selected @endif>></option>
															<option value="<=" @if($row['operator'] == "<=") selected @endif><=</option>
															<option value="<" @if($row['operator'] == "<") selected @endif><</option>
														</select>
														<span class="input-group-addon">
															<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="(1). Operator '=' untuk mendapatkan hasil pencarian yang sama persis dengan keyword.

															(2). Operator 'like' untuk mendapatkan hasil pencarian yang mirip atau mengandung keyword
															" data-container="body"></i>
														</span>
													</div>
												</div>
												<div class="col-md-3" id="parameter{{$indexnya}}">
													<div class="input-group">
														<input type="text" placeholder="Parameter" class="form-control @if($row['subject'] == 'birthday_date' || $row['subject'] == 'register_date' || $row['subject'] == 'trx_date') datepicker @endif" name="conditions[{{$q}}][{{$indexnya}}][parameter]" value = {{$row['parameter']}} required/>
														{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" @if($row['subject'] == 'last_trx') style="display:table-cell" @else style="display:none" @endif>
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'birthday_month')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Month" style="width:100%" required>
															<option value="1" @if($row['parameter'] == "January") selected @endif>January</option>
															<option value="2" @if($row['parameter'] == "February") selected @endif>February</option>
															<option value="3" @if($row['parameter'] == "March") selected @endif>March</option>
															<option value="4" @if($row['parameter'] == "April") selected @endif>April</option>
															<option value="5" @if($row['parameter'] == "May") selected @endif>May</option>
															<option value="6" @if($row['parameter'] == "June") selected @endif>June</option>
															<option value="7" @if($row['parameter'] == "July") selected @endif>July</option>
															<option value="8" @if($row['parameter'] == "August") selected @endif>August</option>
															<option value="9" @if($row['parameter'] == "September") selected @endif>September</option>
															<option value="10" @if($row['parameter'] == "October") selected @endif>October</option>
															<option value="11" @if($row['parameter'] == "November") selected @endif>November</option>
															<option value="12" @if($row['parameter'] == "December") selected @endif>December</option>
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]" />
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'birthday_today' || $row['subject'] == 'register_today')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" style="width:100%" required>
															<option value="Today" selected>Today</option>
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]" />
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'provider')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Provider" style="width:100%" required>
															<option value="Telkomsel" @if($row['parameter'] == "Telkomsel") selected @endif>Telkomsel</option>
															<option value="Indosat" @if($row['parameter'] == "Indosat") selected @endif>Indosat</option>
															<option value="XL Axiata" @if($row['parameter'] == "XL Axiata") selected @endif>XL Axiata</option>
															<option value="Tri" @if($row['parameter'] == "Tri") selected @endif>Tri</option>
															<option value="Smart" @if($row['parameter'] == "Smart") selected @endif>Smart</option>
															<option value="Axis" @if($row['parameter'] == "Axis") selected @endif>Axis</option>
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]"/>
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'gender')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Gender" style="width:100%" required>
															<option value="Male" @if($row['parameter'] == "Male") selected @endif>Male</option>
															<option value="Female" @if($row['parameter'] == "Female") selected @endif>Female</option>
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]"/>
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'level')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Level" style="width:100%" required>
															<option value="Super Admin" @if($row['parameter'] == "Super Admin") selected @endif>Super Admin</option>
															<option value="Admin" @if($row['parameter'] == "Admin") selected @endif>Admin</option>
															<option value="Customer" @if($row['parameter'] == "Customer") selected @endif>Customer</option>
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]"/>
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'membership')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Level" style="width:100%" required>
															@foreach($memberships as $membership)
																<option value="{{$membership['id_membership']}}" @if($row['parameter'] == $membership['id_membership']) selected @endif>{{$membership['membership_name']}}</option>
															@endforeach
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]"/>
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'city_name')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Cities Name" style="width:100%" required>
															@foreach($city as $cities)
															<option value="{{$cities['city_name']}}" @if($row['parameter'] == $cities['city_name']) selected @endif>{{$cities['city_name']}}</option>
															@endforeach
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]"/>
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'city_postal_code')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Cities Postal Code"  style="width:100%" required>
															@foreach($city as $cities)
															<option value="{{$cities['city_postal_code']}}" @if($row['parameter'] == $cities['city_postal_code']) selected @endif>{{$cities['city_postal_code']}}</option>
															@endforeach
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]"/>
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'province_name')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Province Name" style="width:100%" required>
															@foreach($province as $provinces)
															<option value="{{$provinces['province_name']}}" @if($row['parameter'] == $provinces['province_name']) selected @endif>{{$provinces['province_name']}}</option>
															@endforeach
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]"/>
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'phone_verified' || $row['subject'] == 'email_verified')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search verify status" style="width:100%" required>
															<option value="0" @if($row['parameter'] == "0") selected @endif>Not Verified</option>
															<option value="1" @if($row['parameter'] == "1") selected @endif>Verified</option>
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]"/>
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'email_unsubscribed')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Subscribe Status" style="width:100%" required>
															<option value="1" @if($row['parameter'] == "1") selected @endif>Subscribed</option>
															<option value="0" @if($row['parameter'] == "0") selected @endif>Unsubscribed</option>
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]"/>
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'is_suspended')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Suspend Status"  style="width:100%" required>
															<option value="0" @if($row['parameter'] == "0") selected @endif>Not Suspended</option>
															<option value="1" @if($row['parameter'] == "1") selected @endif>Suspended</option>
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]" />
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span> 
													</div>
												</div>
												@elseif($row['subject'] == 'device')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Devices" style="width:100%" required>
															<option value="Android" @if($row['parameter'] == "Android") selected @endif>Android</option>
															<option value="IOS" @if($row['parameter'] == "IOS") selected @endif>IOS</option>
															<option value="Both" @if($row['parameter'] == "Both") selected @endif>Both</option>
															<option value="None" @if($row['parameter'] == "None") selected @endif>None</option>
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]" />
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'trx_type')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Transaction Type" style="width:100%" required>
															<option value="Offline" @if($row['parameter'] == "Offline") selected @endif>Offline</option>
															<option value="Delivery" @if($row['parameter'] == "Delivery") selected @endif>Delivery</option>
															<option value="Pickup Order" @if($row['parameter'] == "Pickup Order") selected @endif>Pickup Order</option>
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]" />
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'trx_payment_type')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Payment type" style="width:100%" required>
															<option value="Midtrans" @if($row['parameter'] == "Midtrans") selected @endif>Midtrans</option>
															<option value="Manual" @if($row['parameter'] == "Manual") selected @endif>Manual</option>
															<option value="Offline" @if($row['parameter'] == "Offline") selected @endif>Offline</option>
															<option value="Balance" @if($row['parameter'] == "Balance") selected @endif>Balance</option>
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]" />
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												
												@elseif($row['subject'] == 'trx_payment_status')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Payment Status" style="width:100%" required>
															<option value="Pending" @if($row['parameter'] == "Pending") selected @endif>Pending</option>
															<option value="Paid" @if($row['parameter'] == "Paid") selected @endif>Paid</option>
															<option value="Completed" @if($row['parameter'] == "Completed") selected @endif>Completed</option>
															<option value="Cancelled" @if($row['parameter'] == "Cancelled") selected @endif>Cancelled</option>
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]" />
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'trx_shipment_courier')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Shipment Courier"  style="width:100%" required>
															@foreach($couriers as $courier)
															<option value="{{$courier['short_name']}}" @if($row['parameter'] == $courier['id_courier']) selected @endif>{{$courier['short_name']}} ({{$courier['name']}})</option>
															@endforeach
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]"/>
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'trx_outlet' || $row['subject'] == 'trx_outlet_not')
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Outlet"  style="width:100%" required>
															@foreach($outlets as $outlet)
															<option value="{{$outlet['id_outlet']}}" @if($row['parameter'] == $outlet['id_outlet']) selected @endif>{{$outlet['outlet_name']}}</option>
															@endforeach
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]"/>
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'trx_product' || $row['subject'] == 'trx_product_not' )
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Product"  style="width:100%" required>
															@foreach($products as $product)
															<option value="{{$product['id_product']}}" @if($row['parameter'] == $product['id_product']) selected @endif>{{$product['product_name']}}</option>
															@endforeach
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]" />
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@elseif($row['subject'] == 'trx_product_tag' || $row['subject'] == 'trx_product_tag_not' )
												<div class="col-md-4">
													<div class="input-group">
														<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Tag Product"  style="width:100%" required>
															@foreach($tags as $tag)
															<option value="{{$tag['id_tag']}}" @if($row['parameter'] == $tag['id_tag']) selected @endif>{{$tag['tag_name']}}</option>
															@endforeach
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
														<input type="hidden" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]"/>
															{{-- <span class="input-group-addon" name="conditions[{{$q}}][{{$indexnya}}][addon-days]" style="display:none">
															Days Ago
														</span> --}}
														<span class="input-group-addon">
															<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
														</span>
													</div>
												</div>
												@endif
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
									<select name="conditions[{{$q}}][rule]" class="form-control" placeholder="Search Rule" required>
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
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="input-group">
						<select name="conditions[{{$q}}][rule_next]" class="form-control" placeholder="Search Rule" required>
							<option @if($conditions[$key]['rule_next'] == 'and') selected @endif value="and">And</option>
							<option @if($conditions[$key]['rule_next'] == 'or') selected @endif value="or">Or</option>
						</select>
						<span class="input-group-addon">
							<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="And = melakukan filter pencarian dengan semua kondisi.
							
							Or = melakukan filter pencarian dengan salah satu kondisi
							" data-container="body"></i>
						</span>
					</div>
				</div>
			</div>
		<?php $q++	; ?>
		@endforeach
	@endif
	</div>
	<div class="col-md-3">
		<a href="javascript:;" class="btn btn-success mt-repeater-add" onClick="addRule();changeSelect()">
		<i class="fa fa-plus"></i> Add New Rule</a>
	</div>
	<div class="form-group mt-repeater">
		@if(isset($tombolsubmit))
		@else
		<div class="form-action col-md-12" style="margin-top:15px">
			<div class="col-md-12">
			{{ csrf_field() }}
				<button type="submit" class="btn yellow"><i class="fa fa-search"></i> Search</button>
			</div>
		</div>
		@endif
	</div>
</div>