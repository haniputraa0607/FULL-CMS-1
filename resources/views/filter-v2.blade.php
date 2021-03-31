@section('filter_script')
<script>
	rules={
		all_data:{
			display:'All Data',
			operator:[],
			opsi:[]
		},
	};
	database={
		operator: 'or',
		value: {!!json_encode(array_values($rule??[]))!!}
	};
	var updatedatetime=false;
	function optionWriter(value,show,option=''){
		return '<option value="'+value+'" '+option+'>'+show+'</option>'
	}
	function selectSubjectBuilder(rules,selected='',id='::n::'){
		var html='<select name="rule['+id+'][subject]" class="form-control input-sm select2a inputSubject" placeholder="Search Subject" style="width:100%" required>';
		ruless=Object.entries(rules);
		ruless.forEach(function(x){
			if(selected==x[0]){
				html+=optionWriter(x[0],x[1].display,'selected');
			}else{
				html+=optionWriter(x[0],x[1].display);
			}
		});
		html+='</select>';
		return html;
	}
	function selectOperatorBuilder(rules,selected='',id='::n::', rule={}){
		var html=`<select name="rule[${id}][operator]" class="form-control input-sm select2a inputOperator" placeholder="Select Operator" style="width:100%" required>`;
		if (typeof(rules) == 'object' && rules.length === undefined) {
			for (i in rules) {
				html += `<optgroup label="${i}">`;
				rules[i].forEach(x => {
					if(selected==x[0]){
						html+=optionWriter(x[0],x[1],'selected');
					}else{
						html+=optionWriter(x[0],x[1]);
					}
				});
				html = '</optgroup>';
			}
		} else {
			rules.forEach(function(x){
				if(selected==x[0]){
					html+=optionWriter(x[0],x[1],'selected');
				}else{
					html+=optionWriter(x[0],x[1]);
				}
			});
		}
		html+='</select>';
		return html;
	}
	function selectOpsiBuilder(rules,selected='',id='::n::', rule={}){
		var html=`<select name="rule[${id}][parameter]${rule.type == 'multiple_select'?'[]':''}" class="form-control input-sm select2a inputOpsi" data-placeholder="${rule.placeholder ? rule.placeholder : 'Select value'}" style="width:100%" required ${rule.type == 'multiple_select' ? 'multiple' : ''}>`;
		if (typeof(rules) == 'object' && rules.length === undefined) {
			for (i in rules) {
				html += `<optgroup label="${i}">`;
				rules[i].forEach(x => {
					if (rule.type == 'multiple_select') {
						if(selected.includes(x[0])){
							html += optionWriter(x[0],x[1],'selected');
						}else{
							html += optionWriter(x[0],x[1]);
						}
					} else {
						if(selected==x[0]){
							html += optionWriter(x[0],x[1],'selected');
						}else{
							html += optionWriter(x[0],x[1]);
						}
					}
				});
				html += '</optgroup>';
			}
		} else {
			rules.forEach(function(x){
				if(selected==x[0]){
					html+=optionWriter(x[0],x[1],'selected');
				}else{
					html+=optionWriter(x[0],x[1]);
				}
			});
		}
		html+='</select>';
		return html;
	}
	function inputBuilder(type,value='',id='::n::',rule){
		let input;
		if(type==undefined){
			type='text';
		}
		if(type=='datetime'){
			updatedatetime=true;
			input = `<input type="text" placeholder="${(rule?.placeholder) ? rule.placeholder : rule.display}" class="form-control datetime" name="rule['+id+'][parameter]" value="'+value+'"  required/>`;
		} else {
			input = `<input type="${type}" placeholder="${rule?.placeholder ? rule.placeholder : rule.display}" class="form-control" onchange="$(this).val($(this).val().trim())" name="rule[${id}][parameter]" value="${value}"  required/>`;			
		}
		if (rule?.prepend_text) {
			input = `
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1">${rule.prepend_text}</span>
				</div>
				${input}
			</div>`;
		}
		return input;
	}
	function rowBuilder(val){
		if (val[3]) {
			if (val[1] == '<=') {
				$(['#', val[0], '_', 'loe'].join('')).val(val[2]);
			} else if (val[1] == '>=') {
				$(['#', val[0], '_', 'boe'].join('')).val(val[2]);
			}
			return '';
		}
		var html='<div class="mt-repeater-cell" style="padding-bottom:10px" data-id="::n::">\
		<div class="row">\
		<div class="col-md-1">\
		<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline btnDelete">\
		<i class="fa fa-times"></i>\
		</a>\
		</div>\
		<div class="col-md-4">\
		::subjectOption::\
		</div>\
		<div class="col-md-4 optionCol">\
		::operatorOption::\
		</div>\
		<div class="col-md-3 valCol">\
		::otherVal::\
		</div>\
		</div>\
		</div>';
		html=html.replace('::subjectOption::',selectSubjectBuilder(rules,val[0]));
		if(Object.keys(rules[val[0]].operator).length>0){//is operator exist
			html=html.replace('::operatorOption::',selectOperatorBuilder(rules[val[0]].operator,val[1],'::n::',rules[val[0]]));
			if(rules[val[0]].opsi.length>0){
				html=html.replace('::otherVal::',selectOpsiBuilder(
					rules[val[0]].opsi,
					val[2]),
					'::n::',
					rules[val[0]]
				);
			}else{
				html=html.replace('::otherVal::',inputBuilder(rules[val[0]].type,val[2],'::n::',rules[val[0]]));
			}
		}else if(Object.keys(rules[val[0]].opsi).length>0){
			html=html.replace(
				'::operatorOption::',
				selectOpsiBuilder(
					rules[val[0]].opsi,
					val[1],
					'::n::',
					rules[val[0]]
				)
			);
			html=html.replace('::otherVal::','');
		}else{
			html=html.replace('::operatorOption::','');
			html=html.replace('::otherVal::','');
		}
		var lastId=$('#repeaterContainer .mt-repeater-cell').last().data('id');
		if(lastId==undefined){lastId=-1};
		html=html.replace(/::n::/g,lastId+1);
		return html;
	}
	function updateColumn(data){
		if(data.length<1){
			return add();
		}
		data.forEach(function(i){
			add(i);
		});
		@if($filter_date ?? false)
		if(data.length<3){
			return add();
		}
		@endif
	}
	function add(newValue){
		if(newValue==undefined){
			var defaultCol=Object.keys(rules)[0];
			var defaultOperator='';
			if(rules[defaultCol].operator[0]){
				defaultOperator=rules[defaultCol].operator[0][0];
			}
			var newValue=[defaultCol,defaultOperator,''];
		}
		$('#repeaterContainer').append(rowBuilder(newValue));
		$('.select2a').select2();
		if(updatedatetime){
			$('.datetime').datetimepicker({
		        format: "dd M yyyy hh:ii",
		        autoclose: true,
		        todayBtn: true,
		        minuteStep:5
		    });
			updatedatetime=false;
		}
	}
	$(document).ready(function(){
		updateColumn(database.value);
		$('#addNewBtn').on('click',function(){add()});
		$('.form-body').on('click','.btnDelete',function(x){
			$(this).parents('.mt-repeater-cell').first().fadeOut(500,function(){$(this).remove()});
		});
		$('.form-body').on('change','.inputSubject',function(){
			var value=$(this).val();
			var parId=$(this).parents('.mt-repeater-cell').first().data('id');
			if(Object.keys(rules[value].operator).length>0){
				var oprview=selectOperatorBuilder(rules[value].operator,'',parId,rules[value]);
				$(this).parents('.mt-repeater-cell').first().find('.optionCol').show();
				$(this).parents('.mt-repeater-cell').first().find('.optionCol').html(oprview);
				if(rules[value].opsi.length>0){
					var opsiview=selectOpsiBuilder(rules[value].opsi,'',parId,rules[value]);
					$(this).parents('.mt-repeater-cell').first().find('.valCol').html(opsiview);
				}else{
					$(this).parents('.mt-repeater-cell').first().find('.valCol').html(inputBuilder(rules[value].type,'',parId,rules[value]));
				}
				$(this).parents('.mt-repeater-cell').first().find('.valCol').show();
				$('.select2a').select2();
			}else if(Object.keys(rules[value].opsi).length>0){
				var oprview=selectOpsiBuilder(
					rules[value].opsi,
					'',
					parId,
					rules[value]
				);
				$(this).parents('.mt-repeater-cell').first().find('.optionCol').show();
				$(this).parents('.mt-repeater-cell').first().find('.optionCol').html(oprview);
				$(this).parents('.mt-repeater-cell').first().find('.valCol').hide();
				$(this).parents('.mt-repeater-cell').first().find('.valCol').html('');
				$('.select2a').select2();
			}else{
				$(this).parents('.mt-repeater-cell').first().find('.optionCol').hide();
				$(this).parents('.mt-repeater-cell').first().find('.optionCol').html('');
				$(this).parents('.mt-repeater-cell').first().find('.valCol').hide();
				$(this).parents('.mt-repeater-cell').first().find('.valCol').html('');
			}
			if(updatedatetime){
				$('.datetime').datetimepicker({
			        format: "dd M yyyy hh:ii",
			        autoclose: true,
			        todayBtn: true,
			        minuteStep:5
			    });
				updatedatetime=false;
			}
		});
		$('input[name="operator"]').val(database.operator);

		@if($filter_date_today ?? false)
		$('input[name=filter_type]').on('change', function() {
			if ($(this).prop('checked')) {
				if ($(this).val() == 'today') {
					$('#filter-date-range').addClass('hidden');
				} else {
					$('#filter-date-range').removeClass('hidden');
				}
			}
		}).change();
		@endif
	})
</script>
@endsection
@section('filter_view')

<form action="{{$filter_action ?? '#'}}" method="post">
	<div class="portlet light bordered" id="card-filter">
		<div class="portlet-title">
			<div class="caption font-blue">
				<i class="icon-settings font-blue "></i>
				<span class="caption-subject bold uppercase">{{$filter_title}}</span>
			</div>
		</div>
		<div class="portlet-body form">
			<div class="form-body collapse show">
				@if($filter_date ?? false)
				@if($filter_date_today ?? false)
				<div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <div class="col-md-9 col-form-label">
                        <label class="radio-inline">
                            <input type="radio" name="filter_type" @if($is_today ?? false) checked @endif id="filter-date-type" value="today">
                            <span></span> Today
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="filter_type" @if(!($is_today ?? false)) checked @endif id="filter-date-type" value="range_date">
                            <span></span> Range Date
                        </label>
                    </div>
                </div>
                @endif
				<div class="row" id="filter-date-range">
					<div class="col-md-2 text-right pt-3">Date Start:</div>
					<div class="col-md-3">
						<div class="input-group">
							<input type="hidden" name="rule[9998][subject]" value="transaction_date">
							<input type="hidden" name="rule[9998][operator]" value=">=">
							<input type="date" name="rule[9998][parameter]" class="form-control" required id="transaction_date_boe">
							<input type="hidden" name="rule[9998][hide]" value="1">
							<div class="input-group-addon">
								<span class="input-group-text"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
					</div>
					<div class="col-md-2 text-right pt-3">Date End:</div>
					<div class="col-md-3">
						<div class="input-group">
							<input type="hidden" name="rule[9999][subject]" value="transaction_date">
							<input type="hidden" name="rule[9999][operator]" value="<=">
							<input type="date" name="rule[9999][parameter]" class="form-control" required id="transaction_date_loe">
							<input type="hidden" name="rule[9999][hide]" value="1">
							<div class="input-group-addon">
								<span class="input-group-text"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
					</div>
				</div>
				<hr>
				@endif
				<div class="form-group mt-repeater">
					<div data-repeater-list="conditions">
						<div data-repeater-item class="mt-repeater-item" id="repeaterContainer">
						</div>
					</div>
					<div class="form-action row">
						<div class="col-md-12">
							<button class="btn btn-success mt-repeater-add" type="button" id="addNewBtn">
								<i class="fa fa-plus"></i> Add New Condition
							</button>
						</div>
					</div>
					<hr>
					<div class="form-action row" style="margin-top:15px">
						<div class="col-md-5">
							<select name="operator" class="form-control input-sm " placeholder="Search Rule" required>
								<option value="and" @if (isset($operator) && $operator == 'and') selected @endif>Valid when all conditions are met</option>
								<option value="or" @if (isset($operator) && $operator == 'or') selected @endif>Valid when minimum one condition is met</option>
							</select>
						</div>
						<div class="col-md-4">
							{{ csrf_field() }}
							<button type="submit" class="btn btn-warning">{!!$filter_button ?? '<i class="fa fa-search"></i> Search'!!}</button>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</form>
@if(isset($rule) && !($hide_record_total??false))
<div class="alert alert-block alert-info show">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="alert-heading">Record found : <strong id="list-filter-result-counter">{{$total??'counting...'}}</strong></h4>
	<form action="{{ url('#') }}" method="post" class="form-inline">
		{{csrf_field()}}
		<button class="btn btn-sm btn-warning" name="clear" value="session">Reset</button>
	</form>
</div>
@endif
@endsection