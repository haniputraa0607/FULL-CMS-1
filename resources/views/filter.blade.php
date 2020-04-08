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
				// '<option value="city_name">City</option>'+
				'<option value="province_name">Province</option>'+
				// '<option value="city_postal_code">Postal Code</option>'+
				'<option value="gender">Gender</option>'+
				'<option value="provider">Provider</option>'+
				'<option value="age">Age</option>'+
				'<option value="birthday_date">Birthday Date</option>'+
				'<option value="birthday_month">Birthday Month</option>'+
				'<option value="birthday_year">Birthday Year</option>'+
				'<option value="birthday_today">Birthday Today</option>'+
				'<option value="phone_verified">Phone Verified</option>'+
				// '<option value="email_verified">Email Verified</option>'+
				// '<option value="email_unsubscribed">Email Unsubscribed</option>'+
				'<option value="level">Level</option>'+
				'@if(MyHelper::hasAccess([18], $configs))'+
				'<option value="points">Points</option>'+
				'@endif'+
				'@if(MyHelper::hasAccess([19], $configs))'+
				'<option value="balance">{{ENV('POINT_NAME', 'Points')}}</option>'+
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
				'<div id="normalCondition'+noRule+'0">'+
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
				'<div id="specialCondition'+noRule+'0" style="display:none">'+
				'<div class="col-md-3">'+
				'<div class="input-group">'+
				'<select name="conditions['+noRule+'][0][id]" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%">'+
				'</select>'+
				'</div>'+
				'</div>'+

				'<div class="col-md-2">'+
				'<div class="input-group">'+
				'<select name="conditions['+noRule+'][0][operatorSpecialCondition]" id ="operator'+noRule+'0"  class="form-control input-sm select2" placeholder="Search Operator" style="width:100%">'+
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
				'<input type="text" placeholder="0" class="form-control" id ="parameter'+noRule+'0" name="conditions['+noRule+'][0][parameterSpecialCondition]"/>'+
				'<span class="input-group-addon">'+
				'<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>'+
				'</span>'+
				'</div>'+
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
				// '<option value="city_name">City</option>'+
				'<option value="province_name">Province</option>'+
				// '<option value="city_postal_code">Postal Code</option>'+
				'<option value="gender">Gender</option>'+
				'<option value="provider">Provider</option>'+
				'<option value="age">Age</option>'+
				'<option value="birthday_date">Birthday Date</option>'+
				'<option value="birthday_month">Birthday Month</option>'+
				'<option value="birthday_year">Birthday Year</option>'+
				'<option value="birthday_today">Birthday Today</option>'+
				'<option value="phone_verified">Phone Verified</option>'+
				// '<option value="email_verified">Email Verified</option>'+
				// '<option value="email_unsubscribed">Email Unsubscribed</option>'+
				'<option value="level">Level</option>'+
				'@if(MyHelper::hasAccess([18], $configs))'+
				'<option value="points">Points</option>'+
				'@endif'+
				'@if(MyHelper::hasAccess([19], $configs))'+
				'<option value="balance">{{ENV('POINT_NAME', 'Points')}}</option>'+
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
				// '<span class="input-group-addon" name="addon-days" style="display:none">'+
				// 	'Days Ago'+
				// '</span>'+
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

		if(document.getElementById('normalCondition'+indx).style.display === 'none' ){
			var parameter = "conditions["+index+"][parameter]";
			var operator = "conditions["+index+"][operator]";
			var idData = "conditions["+index+"][id]";
			document.getElementById('normalCondition'+indx).style.display = 'block';
			if (document.getElementsByName(parameter)[0] != null) document.getElementsByName(parameter)[0].required = true;
			if (document.getElementsByName(operator)[0] != null) document.getElementsByName(operator)[0].required = true;

			document.getElementById('specialCondition'+indx).style.display = 'none';
			if (document.getElementsByName(idData)[0] != null) document.getElementsByName(idData)[0].required = false;
			if (document.getElementById('operator'+indx) != null) document.getElementById('operator'+indx).required = false;
			if (document.getElementById('parameter'+indx) != null) document.getElementById('parameter'+indx).required = false;
		}

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
			} else if(document.getElementsByName(parameter)[0] != null){
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
			} else if(document.getElementsByName(parameter)[0] != null){
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
			} else if(document.getElementsByName(parameter)[0] != null){
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
			} else if(document.getElementsByName(parameter)[0] != null){
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
			} else if(document.getElementsByName(parameter)[0] != null){
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
			} else if(document.getElementsByName(parameter)[0] != null){
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
			} else if(document.getElementsByName(parameter)[0] != null){
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
			} else if(document.getElementsByName(parameter)[0] != null){
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
			} else if(document.getElementsByName(parameter)[0] != null){
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
			} else if(document.getElementsByName(parameter)[0] != null){
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
			} else if(document.getElementsByName(parameter)[0] != null){
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
			} else if(document.getElementsByName(parameter)[0] != null){
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
			} else if(document.getElementsByName(parameter)[0] != null){
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
			} else if(document.getElementsByName(parameter)[0] != null){
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
			} else if(document.getElementsByName(parameter)[0] != null){
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
			} else if(document.getElementsByName(parameter)[0] != null){
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
			} else if(document.getElementsByName(parameter)[0] != null){
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
			} else if(document.getElementsByName(parameter)[0] != null){
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
			} else if(document.getElementsByName(parameter)[0] != null){
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}

		if(subject_value == 'trx_outlet'){
			var parameter = "conditions["+index+"][parameter]";
			var operator = "conditions["+index+"][operator]";
			var idData = "conditions["+index+"][id]";
			document.getElementById('normalCondition'+indx).style.display = 'none';
			if (document.getElementsByName(parameter)[0] != null) document.getElementsByName(parameter)[0].required = false;
			if (document.getElementsByName(operator)[0] != null) document.getElementsByName(operator)[0].required = false;

			document.getElementById('specialCondition'+indx).style.display = 'block';
			if (document.getElementsByName(idData)[0] != null) document.getElementsByName(idData)[0].required = true;
			if (document.getElementById('operator'+indx) != null) document.getElementById('operator'+indx).required = true;
			if (document.getElementById('parameter'+indx) != null) document.getElementById('parameter'+indx).required = true;

			var data = "conditions["+index+"][id]";
			var elementData = document.getElementsByName(data)[0];
			for(i = elementData.options.length - 1 ; i >= 0 ; i--) elementData.remove(i);
			<?php
					foreach($outlets as $outlet){
					?>
					elementData.options[elementData.options.length] = new Option("<?php echo $outlet['outlet_name'];?>", '<?php echo $outlet['id_outlet']; ?>');
					<?php
					}
					?>

			var operator_value = document.getElementById('operator'+indx);
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');
			operator_value.options[operator_value.options.length] = new Option('>=', '>=');
			operator_value.options[operator_value.options.length] = new Option('>', '>');
			operator_value.options[operator_value.options.length] = new Option('<=', '<=');
			operator_value.options[operator_value.options.length] = new Option('<', '<');

			var parameter = document.getElementById('parameter'+indx);
			if(parameter){
				parameter.style.display = 'block';
				parameter.required = true;
			} else if(document.getElementsByName(parameter)[0] != null){
				parameter.style.display = 'none';
				parameter.required = false;
			}

			var parameter = document.getElementById('parameter'+indx);
			if(parameter){
				parameter.style.display = 'block';
				parameter.required = true;
			} else if(document.getElementsByName(parameter)[0] != null){
				parameter.style.display = 'none';
				parameter.required = false;
			}
		}

		if(subject_value == 'trx_outlet_not'){
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

		if(subject_value == 'trx_product' || subject_value == 'trx_product_not'){
			if(subject_value == 'trx_product'){
				cekProduct[indexRule] = true;

				var parameter = "conditions["+index+"][parameter]";
				var operator = "conditions["+index+"][operator]";
				var idData = "conditions["+index+"][id]";
				document.getElementById('normalCondition'+indx).style.display = 'none';
				if (document.getElementsByName(parameter)[0] != null) document.getElementsByName(parameter)[0].required = false;
				if (document.getElementsByName(operator)[0] != null) document.getElementsByName(operator)[0].required = false;

				document.getElementById('specialCondition'+indx).style.display = 'block';
				if (document.getElementsByName(idData)[0] != null) document.getElementsByName(idData)[0].required = true;
				if (document.getElementById('operator'+indx) != null) document.getElementById('operator'+indx).required = true;
				if (document.getElementById('parameter'+indx) != null) document.getElementById('parameter'+indx).required = true;

				var data = "conditions["+index+"][id]";
				var elementData = document.getElementsByName(data)[0];
				for(i = elementData.options.length - 1 ; i >= 0 ; i--) elementData.remove(i);
				<?php
						foreach($products??[] as $product){
						?>
						elementData.options[elementData.options.length] = new Option("<?php echo $product['product_name'];?>", "<?php echo $product['id_product']; ?>");
						<?php
						}
						?>

				var operator_value = document.getElementById('operator'+indx);
				for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
				operator_value.options[operator_value.options.length] = new Option('=', '=');
				operator_value.options[operator_value.options.length] = new Option('>=', '>=');
				operator_value.options[operator_value.options.length] = new Option('>', '>');
				operator_value.options[operator_value.options.length] = new Option('<=', '<=');
				operator_value.options[operator_value.options.length] = new Option('<', '<');

				var parameter = document.getElementById('parameter'+indx);
				if(parameter){
					parameter.style.display = 'block';
					parameter.required = true;
				} else if(document.getElementsByName(parameter)[0] != null){
					parameter.style.display = 'none';
					parameter.required = false;
				}
				var parameter = document.getElementById('parameter'+indx);
				if(parameter){
					parameter.style.display = 'block';
					parameter.required = true;
				} else if(document.getElementsByName(parameter)[0] != null){
					parameter.style.display = 'none';
					parameter.required = false;
				}
			}else{
				var operator = "conditions["+index+"][operator]";
				var operator_value = document.getElementsByName(operator)[0];
				for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
				<?php
						foreach($products??[] as $product){
						?>
						operator_value.options[operator_value.options.length] = new Option("<?php echo $product['product_name'];?>", "<?php echo $product['id_product']; ?>");
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
		}

		if(subject_value == 'trx_product_tag' || subject_value == 'trx_product_tag_not'){
			if(subject_value == 'trx_product_tag'){
				cekProductTag[indexRule] = true;
			}
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			<?php
					foreach($tags??[] as $tag){
					?>
					operator_value.options[operator_value.options.length] = new Option("<?php echo $tag['tag_name'];?>", "<?php echo $tag['id_tag']; ?>");
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
			if(document.getElementsByName(parameter)[0] != null) document.getElementsByName(parameter)[0].type = "text";
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
{{--														<option value="city_name">City</option>--}}
														<option value="province_name">Province</option>
{{--														<option value="city_postal_code">Postal Code</option>--}}
														<option value="gender">Gender</option>
														<option value="provider">Provider</option>
														<option value="age">Age</option>
														<option value="birthday_date">Birthday Date</option>
														<option value="birthday_month">Birthday Month</option>
														<option value="birthday_year">Birthday Year</option>
														<option value="birthday_today">Birthday Today</option>
														<option value="phone_verified">Phone Verified</option>
{{--														<option value="email_verified">Email Verified</option>--}}
{{--														<option value="email_unsubscribed">Email Unsubscribed</option>--}}
														<option value="level">Level</option>
														@if(MyHelper::hasAccess([20], $configs))
															<option value="membership">Membership</option>
														@endif
														@if(MyHelper::hasAccess([18], $configs))
															<option value="points">Points</option>
														@endif
														@if(MyHelper::hasAccess([19], $configs))
															<option value="balance">{{ENV('POINT_NAME', 'Points')}}</option>
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
										<div id="normalCondition00">
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
															<select id="select2{{$q}}{{$indexnya}}" name="conditions[{{$q}}][{{$indexnya}}][subject]" class="form-control input-sm select2 subject" placeholder="Search Subject" onChange="changeSubject(this.name, {{$indexnya}})" style="width:100%" required>
																<optgroup label="All">
																	<option value="all_user" @if($row['subject'] == 'all_user') selected @endif>All User</option>
																</optgroup>
																<optgroup label="Profile">
																	<option value="name" @if($row['subject'] == 'name') selected @endif>Name</option>
																	<option value="phone" @if($row['subject'] == 'phone') selected @endif>Phone</option>
																	<option value="email" @if($row['subject'] == 'email') selected @endif>Email</option>
{{--																	<option value="city_name" @if($row['subject'] == 'city_name') selected @endif>City</option>--}}
																	<option value="province_name" @if($row['subject'] == 'province_name') selected @endif>Province</option>
{{--																	<option value="city_postal_code" @if($row['subject'] == 'city_postal_code') selected @endif>Postal Code</option>--}}
																	<option value="gender" @if($row['subject'] == 'gender') selected @endif>Gender</option>
																	<option value="provider" @if($row['subject'] == 'provider') selected @endif>Provider</option>
																	<option value="age" @if($row['subject'] == 'age') selected @endif>Age</option>
																	<option value="birthday_date" @if($row['subject'] == 'birthday_date') selected @endif>Birthday Date</option>
																	<option value="birthday_month" @if($row['subject'] == 'birthday_month') selected @endif>Birthday Month</option>
																	<option value="birthday_year" @if($row['subject'] == 'birthday_year') selected @endif>Birthday Year</option>
																	<option value="birthday_today" @if($row['subject'] == 'birthday_today') selected @endif>Birthday Today</option>
																	<option value="phone_verified" @if($row['subject'] == 'phone_verified') selected @endif>Phone Verified</option>
{{--																	<option value="email_verified" @if($row['subject'] == 'email_verified') selected @endif>Email Verified</option>--}}
{{--																	<option value="email_unsubscribed" @if($row['subject'] == 'email_unsubscribed') selected @endif>Email Unsubscribed</option>--}}
																	<option value="level" @if($row['subject'] == 'level') selected @endif>Level</option>
																	<option value="membership" @if($row['subject'] == 'membership') selected @endif>Membership</option>
																	<option value="points" @if($row['subject'] == 'points') selected @endif>Points</option>
																	<option value="balance" @if($row['subject'] == 'balance') selected @endif>{{ENV('POINT_NAME', 'Points')}}</option>
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
																<!--<option value="trx_product_count" @if($row['subject'] == 'trx_product_count') selected @endif>Transaction Product Count</option>-->
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
													<?php
													$operator = '';
													$parameter = '';
													$id_data = '';
													$display_special_condition = 'none';
													$display_normal_condition = 'block';

													if($row['subject'] == 'name' || $row['subject'] == 'email' || $row['subject'] == 'phone' || $row['subject'] == 'all_user'){
														$operator .= '<option value="="'.($row['operator'] == '=' ? 'selected' : '').'>=</option>';
														$operator .= '<option value="like"'.($row['operator'] == 'like' ? 'selected' : '').'>Like</option>';
														$parameter .= '<input type="text" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]" value="'.$row['parameter'].'" '.($row['subject'] != 'all_user' ? 'required' : '').' required/>';
													}elseif($row['subject'] == 'age' || $row['subject'] == 'birthday_date' || $row['subject'] == 'birthday_year'
															|| $row['subject'] == 'points' || $row['subject'] == 'balance' || $row['subject'] == 'register_date'
															|| $row['subject'] == 'trx_product_count' || $row['subject'] == 'trx_product_tag_count'
															|| $row['subject'] == 'trx_date' || $row['subject'] == 'last_trx' || $row['subject'] == 'trx_count'
															|| $row['subject'] == 'trx_subtotal' || $row['subject'] == 'trx_tax' || $row['subject'] == 'trx_service'
															|| $row['subject'] == 'trx_discount' || $row['subject'] == 'trx_discount'
															|| $row['subject'] == 'trx_shipment_value' || $row['subject'] == 'trx_void_count'
															|| $row['subject'] == 'trx_grandtotal'){

														$operator .= '<option value="=" '.($row['operator'] == '=' ? 'selected' : '').'>=</option>';
														$operator .= '<option value=">=" '.($row['operator'] == '>=' ? 'selected' : '').'>=</option>';
														$operator .= '<option value=">" '.($row['operator'] == '>' ? 'selected' : '').'></option>';
														$operator .= '<option value="<=" '.($row['operator'] == '<=' ? 'selected' : '').'><=</option>';
														$operator .= '<option value="<" '.($row['operator'] == '<' ? 'selected' : '').'><</option>';
														$parameter .= '<input type="text" placeholder="Parameter" class="form-control '.($row['subject'] == 'birthday_date' || $row['subject'] == 'register_date' || $row['subject'] == 'trx_date' ? 'datepicker' : '').'" name="conditions['.$q.']['.$indexnya.'][parameter]" value = "'.$row['parameter'].'" required/>';
													}elseif($row['subject'] == 'birthday_month'){

														$operator .= '<option value="1" '.($row['operator'] == 'January' ? 'selected' : '').'>January</option>';
														$operator .= '<option value="2" '.($row['operator'] == 'February' ? 'selected' : '').'>February</option>';
														$operator .= '<option value="3" '.($row['operator'] == 'March' ? 'selected' : '').'>March</option>';
														$operator .= '<option value="4" '.($row['operator'] == 'April' ? 'selected' : '').'>April</option>';
														$operator .= '<option value="5" '.($row['operator'] == 'May' ? 'selected' : '').'>May</option>';
														$operator .= '<option value="6" '.($row['operator'] == 'June' ? 'selected' : '').'>June</option>';
														$operator .= '<option value="7" '.($row['operator'] == 'July' ? 'selected' : '').'>July</option>';
														$operator .= '<option value="8" '.($row['operator'] == 'August' ? 'selected' : '').'>August</option>';
														$operator .= '<option value="9" '.($row['operator'] == 'September' ? 'selected' : '').'>September</option>';
														$operator .= '<option value="10" '.($row['operator'] == 'October' ? 'selected' : '').'>October</option>';
														$operator .= '<option value="11" '.($row['operator'] == 'November' ? 'selected' : '').'>November</option>';
														$operator .= '<option value="12" '.($row['operator'] == 'December' ? 'selected' : '').'>December</option>';
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]" />';
													}elseif($row['subject'] == 'birthday_today' || $row['subject'] == 'register_today'){

														$operator .= '<option value="Today" selected>Today</option>';
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]" />';
													}elseif($row['subject'] == 'provider'){

														$operator .= '<option value="Telkomsel" '.($row['operator'] == 'Telkomsel' ? 'selected' : '').'>Telkomsel</option>';
														$operator .= '<option value="Indosat" '.($row['operator'] == 'Indosat' ? 'selected' : '').'>Indosat</option>';
														$operator .= '<option value="XL Axiata" '.($row['operator'] == 'XL Axiata' ? 'selected' : '').'>XL Axiata</option>';
														$operator .= '<option value="Tri" '.($row['operator'] == 'Tri' ? 'selected' : '').'>Tri</option>';
														$operator .= '<option value="Smart" '.($row['operator'] == 'Smart' ? 'selected' : '').'>Smart</option>';
														$operator .= '<option value="Axis" '.($row['operator'] == 'Axis' ? 'selected' : '').'>Axis</option>';
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'gender'){

														$operator .= '<option value="Male" '.($row['operator'] == 'Male' ? 'selected' : '').'>Male</option>';
														$operator .= '<option value="Female" '.($row['operator'] == 'Female' ? 'selected' : '').'>Female</option>';
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'level'){

														$operator .= '<option value="Super Admin" '.($row['operator'] == 'Super Admin' ? 'selected' : '').'>Super Admin</option>';
														$operator .= '<option value="Admin" '.($row['operator'] == 'Admin' ? 'selected' : '').'>Admin</option>';
														$operator .= '<option value="Customer" '.($row['operator'] == 'Customer' ? 'selected' : '').'>Customer</option>';
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'membership'){
														foreach($memberships as $membership){
															$operator .= '<option value="'.$membership['id_membership'].'" '.($row['parameter'] == $membership['id_membership'] ? 'selected' : '').' >'.$membership['membership_name'].'</option>';
														}
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'city_name'){
														foreach($city as $cities){
															$operator .= '<option value="'.$cities['city_name'].'" '.($row['parameter'] == $cities['city_name'] ? 'selected' : '').'>'.$cities['city_name'].'</option>';
														}
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'city_postal_code'){
														foreach($city as $cities){
															$operator .= '<option value="'.$cities['city_postal_code'].'" '.($row['parameter'] == $cities['city_postal_code'] ? 'selected' : '').'>'.$cities['city_postal_code'].'</option>';
														}
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'province_name'){
														foreach($province as $provinces){
															$operator .= '<option value="'.$provinces['province_name'].'" '.($row['parameter'] == $provinces['province_name'] ? 'selected' : '').'>'.$provinces['province_name'].'</option>';
														}
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'phone_verified' || $row['subject'] == 'email_verified'){

														$operator .= '<option value="0" '.($row['parameter'] == "0" ? 'selected' : '').'>Not Verified</option>';
														$operator .= '<option value="1" '.($row['parameter'] == "1" ? 'selected' : '').'>Verified</option>';
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'email_unsubscribed'){

														$operator .= '<option value="1" '.($row['parameter'] == "1" ? 'selected' : '').'>Subscribed</option>';
														$operator .= '<option value="0" '.($row['parameter'] == "0" ? 'selected' : '').'>Unsubscribed</option>';
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'is_suspended'){

														$operator .= '<option value="0" '.($row['parameter'] == "0" ? 'selected' : '').'>Not Suspended</option>';
														$operator .= '<option value="1" '.($row['parameter'] == "1" ? 'selected' : '').'>Suspended</option>';
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'device'){

														$operator .= '<option value="Android" '.($row['parameter'] == "Android" ? 'selected' : '').'>Android</option>';
														$operator .= '<option value="IOS" '.($row['parameter'] == "IOS" ? 'selected' : '').'>IOS</option>';
														$operator .= '<option value="Both" '.($row['parameter'] == "Both" ? 'selected' : '').'>Both</option>';
														$operator .= '<option value="None" '.($row['parameter'] == "None" ? 'selected' : '').'>None</option>';
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'trx_type'){
														$operator .=  '<option value="Offline" '.($row['parameter'] == "Offline" ? 'selected' : '').'>Offline</option>';
														$operator .=  '<option value="Delivery" '.($row['parameter'] == "Delivery" ? 'selected' : '').'>Delivery</option>';
														$operator .=  '<option value="Pickup Order" '.($row['parameter'] == "Pickup Order" ? 'selected' : '').'>Pickup Order</option>';
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'trx_payment_type'){
														$operator .=  '<option value="Midtrans" '.($row['parameter'] == "Midtrans" ? 'selected' : '').'>Midtrans</option>';
														$operator .=  '<option value="Manual" '.($row['parameter'] == "Manual" ? 'selected' : '').'>Manual</option>';
														$operator .=  '<option value="Offline" '.($row['parameter'] == "Offline" ? 'selected' : '').'>Offline</option>';
														$operator .=  '<option value="Balance" '.($row['parameter'] == "Balance" ? 'selected' : '').'>'.ENV('POINT_NAME', 'Points').'</option>';
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'trx_payment_status'){
														$operator .=  '<option value="Pending" '.($row['parameter'] == "Pending" ? 'selected' : '').'>Pending</option>';
														$operator .=  '<option value="Paid" '.($row['parameter'] == "Paid" ? 'selected' : '').'>Paid</option>';
														$operator .=  '<option value="Completed" '.($row['parameter'] == "Completed" ? 'selected' : '').'>Completed</option>';
														$operator .=  '<option value="Cancelled" '.($row['parameter'] == "Cancelled" ? 'selected' : '').'>Cancelled</option>';
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'trx_shipment_courier'){
														foreach($couriers as $courier){
															$operator .=  '<option value="'.$courier['short_name'].'" '.($row['parameter'] == $courier['id_courier'] ? 'selected' : '').'>'.$courier['short_name'].' ('.$courier['name'].')</option>';
														}
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'trx_outlet'){
														$display_special_condition = 'block';
														$display_normal_condition = 'none';
														foreach($outlets as $outlet){
															$id_data .= '<option value="'.$outlet['id_outlet'].'" '.($row['id'] == $outlet['id_outlet'] ? 'selected' : '').'>'.$outlet['outlet_name'].'</option>';
														}

														if(isset($row['operatorSpecialCondition'])){
															$operator_val = $row['operatorSpecialCondition'];
															$parameter_val = $row['parameterSpecialCondition'];
														}else{
															$operator_val = $row['operator'];
															$parameter_val = $row['parameter'];
														}

														$operator .= '<option value="=" '.($operator_val == '=' ? 'selected' : '').'>=</option>';
														$operator .= '<option value=">=" '.($operator_val == '>=' ? 'selected' : '').'>>=</option>';
														$operator .= '<option value=">" '.($operator_val == '>' ? 'selected' : '').'>></option>';
														$operator .= '<option value="<=" '.($operator_val == '<=' ? 'selected' : '').'><=</option>';
														$operator .= '<option value="<" '.($operator_val == '<' ? 'selected' : '').'><</option>';
														$parameter .= '<input type="text" placeholder="0" class="form-control" id="parameter'.$q.$indexnya.'" name="conditions['.$q.']['.$indexnya.'][parameterSpecialCondition]" value="'.$parameter_val.'" required/>';
													}elseif($row['subject'] == 'trx_outlet_not'){
														foreach($outlets as $outlet){
															$operator .= '<option value="'.$outlet['id_outlet'].'" '.($row['parameter'] == $outlet['id_outlet'] ? 'selected' : '').'>'.$outlet['outlet_name'].'</option>';
														}
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'trx_product'){
														$display_special_condition = 'block';
														$display_normal_condition = 'none';
														foreach($products as $product){
															$id_data .= '<option value="'.$product['id_product'].'" '.($row['id'] == $product['id_product'] ? 'selected' : '').'>'.$product['product_name'].'</option>';
														}

														if(isset($row['operatorSpecialCondition'])){
															$operator_val = $row['operatorSpecialCondition'];
															$parameter_val = $row['parameterSpecialCondition'];
														}else{
															$operator_val = $row['operator'];
															$parameter_val = $row['parameter'];
														}

														$operator .= '<option value="=" '.($operator_val == '=' ? 'selected' : '').'>=</option>';
														$operator .= '<option value=">=" '.($operator_val == '>=' ? 'selected' : '').'>>=</option>';
														$operator .= '<option value=">" '.($operator_val == '>' ? 'selected' : '').'>></option>';
														$operator .= '<option value="<=" '.($operator_val == '<=' ? 'selected' : '').'><=</option>';
														$operator .= '<option value="<" '.($operator_val == '<' ? 'selected' : '').'><</option>';
														$parameter .= '<input type="text" placeholder="0" class="form-control" id="parameter'.$q.$indexnya.'" name="conditions['.$q.']['.$indexnya.'][parameterSpecialCondition]" value="'.$parameter_val.'" required/>';
													}elseif($row['subject'] == 'trx_product_not' ){
														foreach($products as $product){
															$operator .= '<option value="'.$product['id_product'].'" '.($row['parameter'] == $product['id_product'] ? 'selected' : '').'>'.$product['product_name'].'</option>';
														}
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}elseif($row['subject'] == 'trx_product_tag' || $row['subject'] == 'trx_product_tag_not' ){
														foreach($tags as $tag){
															$operator .= '<option value="'.$tag['id_tag'].'" '.($row['parameter'] == $tag['id_tag'] ? 'selected' : '').'>'.$tag['tag_name'].'</option>';
														}
														$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]"/>';
													}
													?>
													<div id="normalCondition{{$q}}{{$indexnya}}" style="display: {{$display_normal_condition}};">
														<div class="col-md-4">
															<div class="input-group">
																<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%" @if($display_normal_condition != 'none') required @endif>
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
															<div class="input-group">
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
																<select name="conditions[{{$q}}][{{$indexnya}}][id]" class="form-control input-sm select2" placeholder="Search Product"  style="width:100%" @if($display_special_condition != 'none') required @endif>
																	<?php echo $id_data ?>
																</select>
															</div>
														</div>
														<div class="col-md-2">
															<div class="input-group">
																<select name="conditions[{{$q}}][{{$indexnya}}][operatorSpecialCondition]" id="operator{{$q}}{{$indexnya}}" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%" @if($display_special_condition != 'none') required @endif>
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