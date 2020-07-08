@extends('layouts.main')

@section('page-style')
    <link href="{{ url('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />

    <style type="text/css">
    	.cards .number{
    		font-size: 24px;
    	}
    	.semicolon{
    		width: 20px;
    	}
        .col-date{
            min-width: 70px;
        }
        .filter-wrapper{
            position: relative;
        }
        .filter-loader{
            float: left;
            margin-top: 10px;
            margin-left: 15px;
            display: none;
        }
        .spinner{
            width: 16px;
            height: 16px;
            border: solid 2px transparent;
            border-radius: 10px !important;
            border-top-color: #29d;
            border-left-color: #29d;
            -webkit-animation: spin 0.5s infinite; /* Safari 4.0 - 8.0 */
            animation: spin 0.5s linear infinite;
        }
        @-moz-keyframes spin {
            0% { -moz-transform: rotate(0deg); }
            100% { -moz-transform: rotate(360deg); }
        }
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }
        @keyframes spin {
            0% {transform:rotate(0deg);}
            100% {transform:rotate(360deg);}
        }

    	/* date */
    	.datepicker table tr.week:hover{
		    background: #eee;
		}
		.datepicker table tr.week-active,
		.datepicker table tr.week-active td,
		.datepicker table tr.week-active td:hover,
		.datepicker table tr.week-active.week td,
		.datepicker table tr.week-active.week td:hover,
		.datepicker table tr.week-active.week,
		.datepicker table tr.week-active:hover{
		    background-color: #4b8df8;
		    color: #fff;
		}
        .daterangepicker .ranges{
            display: none;
        }

        /*.table-scrollable{
            margin: 20px 0 !important;
        }*/
    </style>
@stop

@section('page-script')
    <script src="{{ url('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	
    <script src="{{ url('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    
    <script src="{{ url('assets/global/plugins/amcharts/amcharts4/core.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/amcharts/amcharts4/charts.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/amcharts/amcharts4/themes/animated.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/daterangepicker/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>

    {{-- page scripts --}}
    <script type="text/javascript">
    	// define filter type
    	var filter = {!! json_encode($filter) !!};
    	var time_type = filter.time_type_select;
    	var week_date = comp_week_date = "";

        var csrf_token = "{{ csrf_token() }}";
        console.log('filter', filter)

    	// init default filter
    	if (time_type == 'day') {
    		$('#filter-day-1').val(filter.param1_str +" - "+ filter.param2_str);
            $('#comp-filter-day-1').val(filter.param3_str);
    		$('#comp-filter-day-2').val(filter.param4_str);
    	}
    	else if (time_type == 'week') {
    		var week_str = filter.param1_str+ ' to ' + filter.param2_str;
    		$('#filter-week-1').val(week_str);
    	}
    	else if (time_type == 'month') {
    		$('#filter-month-1').val(filter.param1);
    		$('#filter-month-2').val(filter.param2);
    		$('#filter-month-3').val(filter.param3);
            $('#comp-filter-month-1').val(filter.param4);
            $('#comp-filter-month-2').val(filter.param5);
            $('#comp-filter-month-3').val(filter.param6);
    	}
    	else if (time_type == 'quarter') {
            var quarter_str = filter.param1 + '-' + filter.param2;
    		var comp_quarter_str = filter.param4 + '-' + filter.param5;
    		$('#filter-quarter-1').val(quarter_str);
    		$('#filter-quarter-2').val(filter.param3);
            $('#comp-filter-quarter-1').val(comp_quarter_str);
            $('#comp-filter-quarter-2').val(filter.param6);
    	}
    	else if (time_type == 'year') {
    		$('#filter-year-1').val(filter.param1);
    		$('#filter-year-2').val(filter.param2);
            $('#comp-filter-year-1').val(filter.param3);
            $('#comp-filter-year-2').val(filter.param4);
    	}

    	// init global var
    	var gender_series = age_series = device_series =
	    	provider_series =
            trx_series = trx_qty_series = trx_point_series =
            product_series =
            mem_series = {};
	    var trx_idr_data = trx_qty_data = trx_kopi_point_data = {};
	    var product_data = product_gender_data =
	    	product_age_data = product_device_data =
	    	product_provider_data = {};
	    var reg_gender_data = reg_age_data =
	    	reg_device_data = reg_provider_data = {};
	    var mem_data = mem_gender_data = mem_age_data =
	    	mem_device_data = mem_provider_data = {};
	    var voucher_data = voucher_gender_data = voucher_age_data =
	    	voucher_device_data = voucher_provider_data = {};

    	$('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true });
    	$('.select2').select2();
    	$('.table').DataTable({
    		lengthChange: false,
    		info: false,
    		ordering: false,
    		searching: false
    	});

        $(function() {
            // date range picker
            $('.date-range-picker').daterangepicker({
                'autoApply': true,
                'locale': {
                    'format': 'DD/MM/YYYY'
                }
            });
        });

    	// week picker 
    	$('.week-picker').datepicker({
    		format: 'dd/mm/yyyy',
    		autoclose: true
    	}).on('show', function(e){
		    var tr = $('body').find('.datepicker-days table tbody tr');
		    tr.mouseover(function(){
		        $(this).addClass('week');
		    });
		    tr.mouseout(function(){
		        $(this).removeClass('week');
		    });
		    calculate_week_range(e);
		}).on('hide', function(e){
		    calculate_week_range(e, 1);
		});

		var calculate_week_range = function(e, ajax=0){
		    var input = e.currentTarget;
		    // remove all active class
		    $('body').find('.datepicker-days table tbody tr').removeClass('week-active');
		    // add active class
		    var tr = $('body').find('.datepicker-days table tbody tr td.active.day').parent();
		    tr.addClass('week-active');
		    // find start and end date of the week
		    var date = e.date;

		    var start_date = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
		    var end_date = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);

		    // make a friendly string
		    var friendly_string = start_date.getDate() + '/' + (start_date.getMonth() + 1) + '/' + start_date.getFullYear() + ' to '
		        + end_date.getDate() + '/' + (end_date.getMonth() + 1) + '/' + end_date.getFullYear();

            var input_val = $(input).val();

            // if week_date change
		    if (ajax == 1 && (input_val!=friendly_string)) {
                $(input).val(friendly_string);

                check_filter().then(function(check) {
                    if (check.status==true) {
                        var filter = check.filter;
                        ajax_get_report(filter);
                    }
                    else if (check.status==false) {
                        toastr.warning(check.message);
                    }
                });
			}
		}

    	$('#time_type').val(time_type).trigger('change');
    	filter_type(time_type);

    	$('#time_type').on('change', function() {
    		time_type = $(this).val();
    		filter_type(time_type);
    	});

    	// change filter based on time_type
    	function filter_type(time_type) {
    		if(time_type == "week") {
    			$('#filter-day').hide();
    			$('#filter-month').hide();
    			$('#filter-quarter').hide();
    			$('#filter-year').hide();
    			$('#filter-week').show();
    		}
    		else if (time_type == "month") {
    			$('#filter-day').hide();
    			$('#filter-week').hide();
    			$('#filter-quarter').hide();
    			$('#filter-year').hide();
    			$('#filter-month').show();
    		}
    		else if(time_type == "quarter") {
    			$('#filter-day').hide();
    			$('#filter-week').hide();
    			$('#filter-month').hide();
    			$('#filter-year').hide();
    			$('#filter-quarter').show();
    		}
    		else if(time_type == "year") {
    			$('#filter-day').hide();
    			$('#filter-week').hide();
    			$('#filter-month').hide();
    			$('#filter-quarter').hide();
    			$('#filter-year').show();
    		}
    		else {
    			$('#filter-week').hide();
    			$('#filter-month').hide();
    			$('#filter-quarter').hide();
    			$('#filter-year').hide();
    			$('#filter-day').show();
    		}
    	}

    	// validate time filter
    	async function check_filter() {
    		time_type = $('#time_type').val();
    		if (time_type == "month") {
    			var start_month = $('#filter-month-1').val();
    			var end_month = $('#filter-month-2').val();
    			var year = $('#filter-month-3').val();

                var comp_start_month = $('#comp-filter-month-1').val();
                var comp_end_month = $('#comp-filter-month-2').val();
                var comp_year = $('#comp-filter-month-3').val();

    			if (start_month!="" && end_month!="" && year!="" &&
                comp_start_month!="" && comp_end_month!="" && comp_year!="") {
    				if (start_month > end_month) {
    					return {
    						status: false,
    						message: "End Month should not less than Start Month"
    					};
    				}
    				else{
    					return {
    						status: true,
    						filter: [
                                time_type,
                                start_month, end_month, year,
                                comp_start_month, comp_end_month, comp_year
                            ]
    					};
    				}
    			}
    		}
    		else if (time_type == "quarter") {
    			var month = $('#filter-quarter-1').val();
    			month = month.split('-');
    			var start_month = month[0];
    			var end_month = month[1];
    			var year = $('#filter-quarter-2').val();

                var comp_month = $('#filter-quarter-3').val();
                comp_month = comp_month.split('-');
                var comp_start_month = comp_month[0];
                var comp_end_month = comp_month[1];
                var comp_year = $('#filter-quarter-4').val();
    			if (start_month!="" && end_month!="" && year!="" &&
                    comp_start_month!="" && comp_end_month!="" && comp_year!="") {
					return {
						status: true,
						filter: [
                                time_type,
                                start_month, end_month, year,
                                comp_start_month, comp_end_month, comp_year
                            ]
					};
    			}
    		}
    		else if (time_type == "year") {
    			var start_year = $('#filter-year-1').val();
    			var end_year = $('#filter-year-2').val();

                var comp_start_year = $('#comp-filter-year-1').val();
                var comp_end_year = $('#comp-filter-year-2').val();

    			if (start_year!="" && end_year!="" &&
                    comp_start_year!="" && comp_end_year!="") {
    				if (start_year > end_year) {
    					return {
    						status: false,
    						message: "End Year should not less than Start Year"
    					};
    				}
    				else{
	    				return {
							status: true,
							filter: [time_type, start_year, end_year, comp_start_year, comp_end_year]
						};
					}
    			}
    		}
    		else if (time_type == "week") {
                var week = $('#filter-week-1').val();
                var comp_week = $('#comp-filter-week-1').val();

                if (week!="" && comp_week!=""){
                    week = week.split(' to ');
                    comp_week = comp_week.split(' to ');
                    var start_date = week[0];
                    var end_date = week[1];
                    var comp_start_date = comp_week[0];
                    var comp_end_date = comp_week[1];

                    if (start_date!="" && end_date!="" && comp_start_date!="" && comp_end_date!="") {
                        return {
                            status: true,
                            filter: [time_type, start_date, end_date, comp_start_date, comp_end_date]
                        };
                    }
                }
    		}
    		else {
    			// day
                var date_range = $('#filter-day-1').val();
                date_range = date_range.split(' - ');
    			var start_date = date_range[0];
    			var end_date = date_range[1];
                var comp_start_date = $('#comp-filter-day-1').val();
                var comp_end_date = $('#comp-filter-day-2').val();

    			if (start_date!="" && end_date!="" && comp_start_date!="" && comp_end_date!="") {
					return {
						status: true,
						filter: [time_type, start_date, end_date, comp_start_date, comp_end_date]
					};
    			}
    		}
    	}

        // when filter-day-1's date range picker is hidden
        $('#filter-day-1').on('hide.daterangepicker', function(e, picker) {
            var comp_start_date = $('#comp-filter-day-1').val();
            if (comp_start_date != '') {
                autoCompleteCompDate2();

                check_filter().then(function(check) {
                    if (check.status==true) {
                        var filter = check.filter;
                        ajax_get_report(filter);
                    }
                    else if (check.status==false) {
                        toastr.warning(check.message);
                    }
                });
            }
        });
        function autoCompleteCompDate2() {
            var date_range = $('#filter-day-1').val();
            date_range = date_range.split(' - ');
            // convert dd/mm/yyyy to mm/dd/yyyy
            var start_date = format_date(date_range[0]);
            var end_date = format_date(date_range[1]);
            start_date = new Date(start_date);
            end_date = new Date(end_date);
            // count diff days
            var diff = 0;
            diff = Math.floor((end_date.getTime() - start_date.getTime()) / 86400000);

            var comp_start_date = $('#comp-filter-day-1').val();
            comp_start_date = format_date(comp_start_date);

            var date = new Date(comp_start_date);
            date.setDate(date.getDate() + diff);

            // revert mm/dd/yyyy to dd/mm/yyyy
            var dd = ('0' + date.getDate()).slice(-2);
            var mm = ('0' + (date.getMonth() + 1)).slice(-2);
            var yyyy = date.getFullYear().toString();
            $("#comp-filter-day-2").val(dd+'/'+mm+'/'+yyyy);
        }

    	// call ajax when filter change
    	$('.filter-1, .filter-2, .filter-3, .comp-filter-1, .comp-filter-2, .comp-filter-3')
        .on('change', function(e) {
            // if compared start day change, auto set compared end date
            if ($(e.target).is("#comp-filter-day-1")) {
                autoCompleteCompDate2();
            }

            // if compared start month change, auto set compared end month
            if ($(e.target).is("#comp-filter-month-1")) {
                var start_month = $('#filter-month-1').val();
                var end_month = $('#filter-month-2').val();
                // if end_month null, show alert
                if (start_month=="" || end_month=="") {
                    $('#comp-filter-month-1').val(null);
                    toastr.warning("Please select Start & End Month in first row.");
                }
                else {
                    var comp_start_month = $('#comp-filter-month-1').val();
                    var month_diff = parseInt(end_month) - parseInt(start_month);
                    var comp_end_month = parseInt(comp_start_month) + month_diff;
                    $('#comp-filter-month-2').val(comp_end_month);
                    $('#comp-filter-month-2').trigger('change');
                }
            }
            // if start or end month change, auto set compared end month
            if ($(e.target).is("#filter-month-1") || $(e.target).is("#filter-month-2")) {
                var start_month = $('#filter-month-1').val();
                var end_month = $('#filter-month-2').val();
                var comp_start_month = $('#comp-filter-month-1').val();
                // if end_month change & start_month null, show alert
                if ($(e.target).is("#filter-month-2") && start_month=="") {
                    $('#filter-month-2').val(null);
                    toastr.warning("Please select Start Month in first row.");
                }
                else if(comp_start_month!="") {
                    var month_diff = parseInt(end_month) - parseInt(start_month);
                    var comp_end_month = parseInt(comp_start_month) + month_diff;
                    $('#comp-filter-month-2').val(comp_end_month);
                    $('#comp-filter-month-2').trigger('change');
                }
            }

            // if compared start year change, auto set compared end year
            if ($(e.target).is("#comp-filter-year-1")) {
                var start_year = $('#filter-year-1').val();
                var end_year = $('#filter-year-2').val();
                // if start_year or end_year null, show alert
                if (start_year=="" || end_year=="") {
                    $('#comp-filter-year-1').val(null);
                    toastr.warning("Please select Start & End Year in first row.");
                }
                else {
                    var comp_start_year = $('#comp-filter-year-1').val();
                    var year_diff = parseInt(end_year) - parseInt(start_year);
                    var comp_end_year = parseInt(comp_start_year) + year_diff;
                    $('#comp-filter-year-2').val(comp_end_year);
                    $('#comp-filter-year-2').trigger('change');
                }
            }
            // if start or end year change & compared start year not null, auto set compared end year
            if ($(e.target).is("#filter-year-1") || $(e.target).is("#filter-year-2")) {
                var start_year = $('#filter-year-1').val();
                var end_year = $('#filter-year-2').val();
                var comp_start_year = $('#comp-filter-year-1').val();
                if(comp_start_year!="") {
                    var year_diff = parseInt(end_year) - parseInt(start_year);
                    var comp_end_year = parseInt(comp_start_year) + year_diff;
                    $('#comp-filter-year-2').val(comp_end_year);
                    $('#comp-filter-year-2').trigger('change');
                }
            }

    		// use then for wait check_filter result
    		check_filter().then(function(check) {
	    		if (check.status==true) {
	    			var filter = check.filter;
	    			// filter week will be handling at datepicker on hide
	    			if (filter[0] != 'week') {
                        ajax_get_report(filter);
	    			}
	    		}
	    		else if (check.status==false) {
	    			toastr.warning(check.message);
	    		}
    		});
    	});

        // convert dd/mm/yyyy to mm/dd/yyyy
        function format_date(date) {
            date = date.split('/');
            date = date[1] + '/' + date[0] + '/' + date[2];
            return date;
        }

    	// ajax all report
        function ajax_get_report(filter) {
    	// function ajax_get_report(time_type, param1, param2, param3=null) {
            // display loader
            $('#date-filter-loader').fadeIn('fast');
            var post = {
                _token : csrf_token,
                report_type : 'all',
                time_type : filter[0],
                param1 : filter[1],
                param2 : filter[2],
                param3 : filter[3],
                param4 : filter[4]
            };
            if (filter[0] == 'month' || filter[0] == 'quarter'){
                post['param5'] = filter[5];
                post['param6'] = filter[6];
            }
    		$.ajax({
                type : "POST",
                data : post,
                /*data : {
                	_token : "{{ csrf_token() }}",
                	report_type : 'all',
                	time_type : time_type,
                	param1 : param1,
                	param2 : param2,
                	param3 : param3
                },*/
                url : "{{ url('/report/compare/ajax') }}",
                success: function(result) {
                    
                    if (result.status == "success") {
                        $('.date-range-1').text(result.date_range_1);
                        $('.date-range-2').text(result.date_range_2);

                        console.log('result', result.result);

                        update_trx_report(result.result);
                        // update_product_report(result.result);
                        // update_reg_report(result.result);
                        // update_mem_report(result.result);
                        // update_voucher_report(result.result);

                        toastr.info("Fetch data success");
                    }
                    else {
                        toastr.warning(result.messages);
                    }
                    // hide loader
                    $('#date-filter-loader').fadeOut('fast');
                },
                fail: function(xhr, textStatus, errorThrown){
    				toastr.warning("Something went wrong. Could not fetch data");
                    // hide loader
                    $('#date-filter-loader').fadeOut('fast');
			    }
            });
    	}
    	// update trx section after data fetched
    	function update_trx_report(result) {
    		// tell script to redraw chart when tab active
            tab_trx = tab_trx_qty = tab_trx_kopi_point = 1;

            var trx = result.transactions;
            var transactions = trx['data'];
            trx_data = trx['trx_idr_chart'];
            trx_qty_data = trx['trx_qty_chart'];
            trx_kopi_point_data = trx['trx_kopi_point_chart'];
            // draw chart in first tab
            $('#tab-menu-trx-1').tab('show');
            column_chart(trx_data, "trx_chart", trx_series);
			tab_trx = 0;
            // update table
			$('#table-trx .table').DataTable().clear();
			$('#table-trx .table').DataTable().rows.add(transactions);
			$('#table-trx .table').DataTable().draw();
    	}
    	// update product section after data fetched
    	function update_product_report(result) {
    		// tell script to redraw chart when tab active
            tab_product = tab_product_gender =
	    	tab_product_age = tab_product_device =
	    	tab_product_provider = 1;

            var product = result.products;
            var products = product['data'];
            product_data = product['product_chart'];
            product_gender_data = product['product_gender_chart'];
            product_age_data = product['product_age_chart'];
            product_device_data = product['product_device_chart'];
            product_provider_data = product['product_provider_chart'];
            // draw chart in first tab
            $('#tab-menu-product-1').tab('show');
            column_chart(product_data, "product_chart", product_series);
			tab_product = 0;
            // update card value
            $('#card_product_1').text(product['product_total_nominal']);
            $('#card_product_2').text(product['product_total_qty']);
            $('#card_product_3').text(product['product_total_male']);
            $('#card_product_4').text(product['product_total_female']);
            // update table
            $('#table-product .table').DataTable().clear();
            $('#table-product .table').DataTable().rows.add(products);
            $('#table-product .table').DataTable().draw();
    	}
    	// update registration section after data fetched
    	function update_reg_report(result) {
    		// tell script to redraw chart when tab active
    		tab_reg_gender = tab_reg_age =
			tab_reg_device = tab_reg_provider = 1;

			var reg = result.registrations;
            var registrations = reg['data'];
            reg_gender_data = reg['reg_gender_chart'];
            reg_age_data = reg['reg_age_chart'];
            reg_device_data = reg['reg_device_chart'];
            reg_provider_data = reg['reg_provider_chart'];
            // draw chart in first tab
            $('#tab-menu-reg-1').tab('show');
            single_axis_chart(reg_gender_data, "reg_gender_chart", "Quantity", gender_series);
			tab_reg_gender = 0;
            // update card value
            $('#card_reg_1').text(reg['reg_total_male']);
            $('#card_reg_2').text(reg['reg_total_female']);
            $('#card_reg_3').text(reg['reg_total_android']);
            $('#card_reg_4').text(reg['reg_total_ios']);
            // update table
            $('#table-reg .table').DataTable().clear();
            $('#table-reg .table').DataTable().rows.add(registrations);
            $('#table-reg .table').DataTable().draw();
    	}
    	// update membership section after data fetched
    	function update_mem_report(result) {
    		// tell script to redraw chart when tab active
    		tab_mem = tab_mem_gender = tab_mem_age =
			tab_mem_device = tab_mem_provider = 1;

            var mem = result.memberships;
            var memberships = mem['data'];
            mem_data = mem['mem_chart'];
            mem_gender_data = mem['mem_gender_chart'];
            mem_age_data = mem['mem_age_chart'];
            mem_device_data = mem['mem_device_chart'];
            mem_provider_data = mem['mem_provider_chart'];
            // draw chart in first tab
            $('#tab-menu-mem-1').tab('show');
            column_chart(mem_data, "mem_chart", mem_series);
			tab_mem = 0;
            // update card value
            $('#card_mem_1').text(mem['mem_total_male']);
            $('#card_mem_2').text(mem['mem_total_female']);
            $('#card_mem_3').text(mem['mem_total_android']);
            $('#card_mem_4').text(mem['mem_total_ios']);
            // update table
            $('#table-mem .table').DataTable().clear();
            $('#table-mem .table').DataTable().rows.add(memberships);
            $('#table-mem .table').DataTable().draw();
    	}
    	// update voucher section after data fetched
    	function update_voucher_report(result) {
    		// tell script to redraw chart when tab active
    		tab_voucher = tab_voucher_gender = tab_voucher_age =
			tab_voucher_device = tab_voucher_provider = 1;

            var voucher = result.vouchers;
            var vouchers = voucher['data'];
            voucher_data = voucher['voucher_chart'];
            voucher_gender_data = voucher['voucher_gender_chart'];
            voucher_age_data = voucher['voucher_age_chart'];
            voucher_device_data = voucher['voucher_device_chart'];
            voucher_provider_data = voucher['voucher_provider_chart'];
            // draw chart in first tab
            $('#tab-menu-voucher-1').tab('show');
            column_chart(voucher_data, "voucher_chart", voucher_series);
			tab_voucher = 0;
            // update card value
            $('#card_voucher_1').text(voucher['voucher_total_qty']);
            $('#card_voucher_2').text(voucher['voucher_total_male']);
            $('#card_voucher_3').text(voucher['voucher_total_female']);
            // $('#card_voucher_4').text(voucher['voucher_total_ios']);
            // update table
            $('#table-voucher .table').DataTable().clear();
            $('#table-voucher .table').DataTable().rows.add(vouchers);
            $('#table-voucher .table').DataTable().draw();
    	}

    	// get trx report
    	$('#trx_id_outlet').on('change', function(){
			var trx_id_outlet = $(this).val();
			var trx_outlet_select = $(this).select2('data');
			var trx_outlet_name = trx_outlet_select[0].text;

    		// use then for wait check_filter result
    		check_filter().then(function(check) {
	    		if (check == undefined) {
	    			toastr.warning("Please check the date filter");
	    		}
	    		else if (check.status==true) {
	    			var filter = check.filter;
	    			if (filter[0] == 'month') {
	    				ajax_trx_report(filter[0], filter[1], filter[2], filter[3], trx_id_outlet, trx_outlet_name);
	    			}
                    else if (filter[0] == 'week') {
                        if (week_date == "") {
                            week_date = $('#filter-week-1').val();
                        }
                        var split_date = week_date.split(' to ');
                        ajax_trx_report(filter[0], split_date[0], split_date[1], null, trx_id_outlet, trx_outlet_name);
                    }
	    			else {
	    				ajax_trx_report(filter[0], filter[1], filter[2], null, trx_id_outlet, trx_outlet_name);
	    			}
	    			// set outlet name
	    			$('#trx_outlet_name').text(trx_outlet_name);
	    		}
	    		else if (check.status==false) {
	    			toastr.warning(check.message);
	    		}

    		});
    	});
    	// ajax trx report
    	function ajax_trx_report(time_type, param1, param2, param3=null, trx_id_outlet, trx_outlet_name) {
            // display loader
            $('#trx-loader').fadeIn('fast');

    		$.ajax({
                type : "POST",
                data : {
                	_token : "{{ csrf_token() }}",
                	report_type: 'trx',
                	time_type : time_type,
                	param1 : param1,
                	param2 : param2,
                	param3 : param3,
                    trx_id_outlet : trx_id_outlet,
                	trx_outlet_name : trx_outlet_name
                },
                url : "{{ url('/report/ajax') }}",
                success: function(result) {
                	// console.log('trx_result', result);
                    if (result.status == "success"){
                    	toastr.info("Fetch transaction data success");
                        $('.date-range-1').text(result.date_range_1);
                        $('.date-range-2').text(result.date_range_2);
                    	update_trx_report(result.result);
                    }
                    else {
                        toastr.warning(result.messages);
                    }
                    // hide loader
                    $('#trx-loader').fadeOut('fast');
                },
                fail: function(xhr, textStatus, errorThrown){
    				toastr.warning("Something went wrong. Could not fetch data");
                    // hide loader
                    $('#trx-loader').fadeOut('fast');
			    }
            });
    	}

    	// get product report
    	$('#product_id_outlet, #id_product').on('change', function(){
			var product_id_outlet = $('#product_id_outlet').val();
			var id_product = $('#id_product').val();

			var product_outlet_select = $('#product_id_outlet').select2('data');
			var product_outlet_name = product_outlet_select[0].text;

			var product_select = $('#id_product').select2('data');
			var product_name = product_select[0].text;

    		// use then for wait check_filter result
    		check_filter().then(function(check) {
	    		if (check == undefined) {
	    			toastr.warning("Please check the date filter");
	    		}
	    		else if (check.status==true) {
	    			var filter = check.filter;
	    			if (filter[0] == 'month') {
	    				ajax_product_report(filter[0], filter[1], filter[2], filter[3], product_id_outlet, id_product, product_outlet_name, product_name);
	    			}
                    else if (filter[0] == 'week') {
                        if (week_date == "") {
                            week_date = $('#filter-week-1').val();
                        }
                        var split_date = week_date.split(' to ');
                        ajax_product_report(filter[0], split_date[0], split_date[1], null, product_id_outlet, id_product, product_outlet_name, product_name);
                    }
	    			else {
	    				ajax_product_report(filter[0], filter[1], filter[2], null, product_id_outlet, id_product, product_outlet_name, product_name);
	    			}
	    			// set product & outlet name
	    			$('#product_outlet_name').text(product_outlet_name);
	    			$('#product_name').text(product_name);
	    		}
	    		else if (check.status==false) {
	    			toastr.warning(check.message);
	    		}

    		});
    	});
    	// ajax product report
    	function ajax_product_report(time_type, param1, param2, param3=null,
    		product_id_outlet, id_product, product_outlet_name, product_name) {
    		// display loader
            $('#product-loader').fadeIn('fast');

            $.ajax({
                type : "POST",
                data : {
                	_token : "{{ csrf_token() }}",
                	report_type: 'product',
                	time_type : time_type,
                	param1 : param1,
                	param2 : param2,
                	param3 : param3,
                	product_id_outlet : product_id_outlet,
                	id_product: id_product,
                    product_outlet_name : product_outlet_name,
                    product_name : product_name
                },
                url : "{{ url('/report/ajax') }}",
                success: function(result) {
                	// console.log('product_result', result);
                    if (result.status == "success"){
                    	toastr.info("Fetch product data success");
                        $('.date-range-1').text(result.date_range_1);
                        $('.date-range-2').text(result.date_range_2);
                    	update_product_report(result.result);
                    }
                    else {
                        toastr.warning(result.messages);
                    }
                    // hide loader
                    $('#product-loader').fadeOut('fast');
                },
                fail: function(xhr, textStatus, errorThrown){
    				toastr.warning("Something went wrong. Could not fetch data");
                    // hide loader
                    $('#product-loader').fadeOut('fast');
			    }
            });
    	}

    	// get membership report
    	$('#id_membership').on('change', function(){
			var id_membership = $(this).val();

			var membership_select = $(this).select2('data');
			var membership_name = membership_select[0].text;

    		// use then for wait check_filter result
    		check_filter().then(function(check) {
	    		if (check == undefined) {
	    			toastr.warning("Please check the date filter");
	    		}
	    		else if (check.status==true) {
	    			var filter = check.filter;
	    			if (filter[0] == 'month') {
	    				ajax_mem_report(filter[0], filter[1], filter[2], filter[3], id_membership, membership_name);
	    			}
                    else if (filter[0] == 'week') {
                        if (week_date == "") {
                            week_date = $('#filter-week-1').val();
                        }
                        var split_date = week_date.split(' to ');
                        ajax_mem_report(filter[0], split_date[0], split_date[1], null, id_membership, membership_name);
                    }
	    			else {
	    				ajax_mem_report(filter[0], filter[1], filter[2], null, id_membership, membership_name);
	    			}
	    			// set mem & outlet name
	    			$('#membership_name').text(membership_name);
	    		}
	    		else if (check.status==false) {
	    			toastr.warning(check.message);
	    		}
    		});
    	});
    	// ajax membership report
    	function ajax_mem_report(time_type, param1, param2, param3=null, id_membership, membership_name) {
            // display loader
            $('#mem-loader').fadeIn('fast');

    		$.ajax({
                type : "POST",
                data : {
                	_token : "{{ csrf_token() }}",
                	report_type: 'membership',
                	time_type : time_type,
                	param1 : param1,
                	param2 : param2,
                	param3 : param3,
                	id_membership : id_membership,
                    membership_name : membership_name
                },
                url : "{{ url('/report/ajax') }}",
                success: function(result) {
                	// console.log('membership_result', result);
                    
                    if (result.status == "success"){
                    	toastr.info("Fetch membership data success");
                        $('.date-range-1').text(result.date_range_1);
                        $('.date-range-2').text(result.date_range_2);
                    	update_mem_report(result.result);
                    }
                    else {
                        toastr.warning(result.messages);
                    }
                    // hide loader
                    $('#mem-loader').fadeOut('fast');
                },
                fail: function(xhr, textStatus, errorThrown){
    				toastr.warning("Something went wrong. Could not fetch data");
                    // hide loader
                    $('#mem-loader').fadeOut('fast');
			    }
            });
    	}

    	// get voucher report
    	$('#voucher_id_outlet, #id_deals').on('change', function(){
			var voucher_id_outlet = $('#voucher_id_outlet').val();
			var id_deals = $('#id_deals').val();

			var voucher_outlet_select = $('#voucher_id_outlet').select2('data');
			var voucher_outlet_name = voucher_outlet_select[0].text;

			var deals_select = $('#id_deals').select2('data');
			var deals_title = deals_select[0].text;

    		// use then for wait check_filter result
    		check_filter().then(function(check) {
	    		if (check == undefined) {
	    			toastr.warning("Please check the date filter");
	    		}
	    		else if (check.status==true) {
	    			var filter = check.filter;
	    			if (filter[0] == 'month') {
	    				ajax_voucher_report(filter[0], filter[1], filter[2], filter[3], voucher_id_outlet, id_deals, voucher_outlet_name, deals_title);
	    			}
                    else if (filter[0] == 'week') {
                        if (week_date == "") {
                            week_date = $('#filter-week-1').val();
                        }
                        var split_date = week_date.split(' to ');
                        ajax_voucher_report(filter[0], split_date[0], split_date[1], null, voucher_id_outlet, id_deals, voucher_outlet_name, deals_title);
                    }
	    			else {
	    				ajax_voucher_report(filter[0], filter[1], filter[2], null, voucher_id_outlet, id_deals, voucher_outlet_name, deals_title);
	    			}
	    			// set voucher & outlet name
	    			$('#voucher_outlet_name').text(voucher_outlet_name);
	    			$('#deals_title').text(deals_title);
	    		}
	    		else if (check.status==false) {
	    			toastr.warning(check.message);
	    		}

    		});
    	});
    	// ajax voucher report
    	function ajax_voucher_report(time_type, param1, param2, param3=null,
    		voucher_id_outlet, id_deals, voucher_outlet_name, deals_title) {
    		// display loader
            $('#voucher-loader').fadeIn('fast');

            $.ajax({
                type : "POST",
                data : {
                	_token : "{{ csrf_token() }}",
                	report_type: 'voucher',
                	time_type : time_type,
                	param1 : param1,
                	param2 : param2,
                	param3 : param3,
                	voucher_id_outlet : voucher_id_outlet,
                	id_deals : id_deals,
                    voucher_outlet_name: voucher_outlet_name,
                    deals_title: deals_title
                },
                url : "{{ url('/report/ajax') }}",
                success: function(result) {
                	// console.log('voucher_result', result);
                    if (result.status == "success"){
                    	toastr.info("Fetch voucher data success");
                        $('.date-range-1').text(result.date_range_1);
                        $('.date-range-2').text(result.date_range_2);
                    	update_voucher_report(result.result);
                    }
                    else {
                        toastr.warning(result.messages);
                    }
                    // hide loader
                    $('#voucher-loader').fadeOut('fast');
                },
                fail: function(xhr, textStatus, errorThrown){
    				toastr.warning("Something went wrong. Could not fetch data");
                    // hide loader
                    $('#voucher-loader').fadeOut('fast');
			    }
            });
    	}


    	// flag if chart need to redraw or not
    	var tab_trx = tab_trx_qty = tab_trx_kopi_point =
	    	tab_trx_device = tab_trx_provider = 0;
	    var tab_product = tab_product_gender =
	    	tab_product_age = tab_product_device =
	    	tab_product_provider = 0;
	    var tab_reg_gender = tab_reg_age =
	    	tab_reg_device = tab_reg_provider = 0;
	    var tab_mem = tab_mem_gender = tab_mem_age =
	    	tab_mem_device = tab_mem_provider = 0;
	    var tab_voucher = tab_voucher_gender = tab_voucher_age =
	    	tab_voucher_device = tab_voucher_provider = 0;

    	// draw chart once when tab active every data fetched
		$(".nav-tabs a").on("shown.bs.tab", function() {
			var tab = $(this).attr('href');
			switch (tab) {
				case "#tab_trx_1":
					if (tab_trx) {
						column_chart(trx_idr_data, "trx_chart", trx_series);
						tab_trx = 0;
					}
					break;
				case "#tab_trx_2":
					if (tab_trx_qty) {
						column_chart(trx_qty_data, "trx_qty_chart", trx_qty_series);
						tab_trx_qty = 0;
					}
					break;
				case "#tab_trx_3":
					if (tab_trx_kopi_point) {
						column_chart(trx_kopi_point_data, "trx_kopi_point_chart", trx_point_series);
						tab_trx_kopi_point = 0;
					}
					break;
				// product
				/*case "#tab_product_1":
					if (tab_product) {
						column_chart(product_data, "product_chart", product_series);
						tab_product = 0;
					}
					break;*/
				case "#tab_product_2":
					if (tab_product_gender) {
						single_axis_chart(product_gender_data, "product_gender_chart", "Quantity", gender_series);
						tab_product_gender = 0;
					}
					break;
				case "#tab_product_3":
					if (tab_product_age) {
						single_axis_chart(product_age_data, "product_age_chart", "Quantity", age_series);
						tab_product_age = 0;
					}
					break;
				case "#tab_product_4":
					if (tab_product_device) {
						single_axis_chart(product_device_data, "product_device_chart", "Quantity", device_series);
						tab_product_device = 0;
					}
					break;
				case "#tab_product_5":
					if (tab_product_provider) {
						single_axis_chart(product_age_data, "product_age_chart", "Quantity", age_series);
						single_axis_chart(product_provider_data, "product_provider_chart", "Quantity", provider_series);
						tab_product_provider = 0;
					}
					break;
				// reg
				/*case "#tab_reg_1":
					if (tab_reg_gender) {
						single_axis_chart(reg_gender_data, "reg_gender_chart", "Quantity", gender_series);
						tab_reg_gender = 0;
					}
					break;*/
				case "#tab_reg_2":
					if (tab_reg_age) {
						single_axis_chart(reg_age_data, "reg_age_chart", "Quantity", age_series);
						tab_reg_age = 0;
					}
					break;
				case "#tab_reg_3":
					if (tab_reg_device) {
						single_axis_chart(reg_device_data, "reg_device_chart", "Quantity", device_series);
						tab_reg_device = 0;
					}
					break;
				case "#tab_reg_4":
					if (tab_reg_provider) {
						single_axis_chart(reg_provider_data, "reg_provider_chart", "Quantity", provider_series);
						tab_reg_provider = 0;
					}
					break;
				// mem
				/*case "#tab_mem_1":
					if (tab_mem) {
						column_chart(mem_data, "mem_chart", mem_series);
						tab_mem = 0;
					}
					break;*/
				/*case "#tab_mem_2":
					if (tab_mem_gender) {
						single_axis_chart(mem_gender_data, "mem_gender_chart", "Quantity", gender_series);
						tab_mem_gender = 0;
					}
					break;
				case "#tab_mem_3":
					if (tab_mem_age) {
						single_axis_chart(mem_age_data, "mem_age_chart", "Quantity", age_series);
						tab_mem_age = 0;
					}
					break;
				case "#tab_mem_4":
					if (tab_mem_device) {
						single_axis_chart(mem_device_data, "mem_device_chart", "Quantity", device_series);
						tab_mem_device = 0;
					}
					break;
				case "#tab_mem_5":
					if (tab_mem_provider) {
						single_axis_chart(mem_provider_data, "mem_provider_chart", "Quantity", provider_series);
						tab_mem_provider = 0;
					}
					break;*/
				// voucher
				case "#tab_voucher_2":
					if (tab_voucher_gender) {
						single_axis_chart(voucher_gender_data, "voucher_gender_chart", "Quantity", gender_series);
						tab_voucher_gender = 0;
					}
					break;
				case "#tab_voucher_3":
					if (tab_voucher_age) {
						single_axis_chart(voucher_age_data, "voucher_age_chart", "Quantity", age_series);
						tab_voucher_age = 0;
					}
					break;
				case "#tab_voucher_4":
					if (tab_voucher_device) {
						single_axis_chart(voucher_device_data, "voucher_device_chart", "Quantity", device_series);
						tab_voucher_device = 0;
					}
					break;
				case "#tab_voucher_5":
					if (tab_voucher_provider) {
						single_axis_chart(voucher_provider_data, "voucher_provider_chart", "Quantity", provider_series);
						tab_voucher_provider = 0;
					}
					break;
				default:
					break;
			}
		});

    	/*===== Chart Scripts =====*/
    	// draw chart with multi y axis
	    // series param: related with api data properties
    	function multi_axis_chart(data, id_element, series) {
    		/* chart */
	    	am4core.useTheme(am4themes_animated);
	    	// create chart instance
			var chart = am4core.create(id_element, am4charts.XYChart);
			
			// Increase contrast by taking evey second color
			chart.colors.step = 2;

			chart.data = data;

			// create x axes
			// var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "date";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 30;

			// up-down label
			if (data.length >= 7) {
				categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
					if (target.dataItem && target.dataItem.index & 2 == 2) {
				    	return dy + 25;
					}
					return dy;
				});
			}

			// Create series
			jQuery.each(series, function(index, item) {
				createAxisAndSeries(chart, index, item[0], item[1]);
			});

			// Add cursor
			chart.cursor = new am4charts.XYCursor();

			// Add legend
			chart.legend = new am4charts.Legend();
			chart.legend.position = "top";
    	}
    	// create line series with multi y axis
		function createAxisAndSeries(chart, field, name, opposite) {
			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

			var series = chart.series.push(new am4charts.LineSeries());
			series.dataFields.valueY = field;
			series.dataFields.categoryX = "date";
			series.strokeWidth = 2;
			series.yAxis = valueAxis;
			series.name = name;
			series.tooltipText = "{name}: [bold]{valueY}[/]";
			series.tensionX = 0.8;

			var interfaceColors = new am4core.InterfaceColorSet();
			var bullet = series.bullets.push(new am4charts.CircleBullet());
			bullet.circle.stroke = interfaceColors.getFor("background");
			bullet.circle.strokeWidth = 2;

			valueAxis.renderer.line.strokeOpacity = 1;
			valueAxis.renderer.line.strokeWidth = 2;
			valueAxis.renderer.line.stroke = series.stroke;
			valueAxis.renderer.labels.template.fill = series.stroke;
			valueAxis.renderer.opposite = opposite;
			valueAxis.renderer.grid.template.disabled = true;
		}

    	// draw chart with 1 y axis
    	// series param: related with api data properties
    	function single_axis_chart(data, id_element, axis_title, series) {
    		/* chart */
	    	am4core.useTheme(am4themes_animated);
	    	// create chart instance
			var chart = am4core.create(id_element, am4charts.XYChart);
			
			// increase contrast by taking evey second color
			chart.colors.step = 2;

			chart.data = data;

			// create x axis
			// var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "date";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 30;

			// up-down label
			if (data.length >= 7) {
				categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
					if (target.dataItem && target.dataItem.index & 2 == 2) {
				    	return dy + 25;
					}
					return dy;
				});
			}

			// Create value axis
			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			// valueAxis.renderer.inversed = true;
			valueAxis.title.text = axis_title;
			valueAxis.renderer.minLabelPosition = 0.01;

			// Create series
			jQuery.each(series, function(index, item) {
				createSeries(chart, index, item);
			});

			// Add cursor
			chart.cursor = new am4charts.XYCursor();

			// Add legend
			chart.legend = new am4charts.Legend();
			chart.legend.position = "top";
    	}
    	// create line series with one y axis
		function createSeries(chart, field, name) {
			// create series
			var series = chart.series.push(new am4charts.LineSeries());
			series.dataFields.valueY = field;
			series.dataFields.categoryX = "date";
			series.name = name;
			series.strokeWidth = 2;
			series.bullets.push(new am4charts.CircleBullet());
			series.tooltipText = "{name}: [bold]{valueY}[/]";
			series.visible  = false;
		}

    	// draw column chart
    	function column_chart(data, id_element, series) {
			am4core.useTheme(am4themes_animated);
			var chart = am4core.create(id_element, am4charts.XYChart);
			chart.dateFormatter.dateFormat = "yyyy-MM-dd";

			chart.data = data;
			chart.colors.step = 2;

			// create x axis
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "date";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 30;

			// up-down label
			if (data.length >= 7) {
				categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
					if (target.dataItem && target.dataItem.index & 2 == 2) {
				    	return dy + 25;
					}
					return dy;
				});
			}

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			jQuery.each(series, function(index, value) {
				createColumnSeries(chart, index, value);
			});

            // Add cursor
            chart.cursor = new am4charts.XYCursor();

            // Add legend
            chart.legend = new am4charts.Legend();
            chart.legend.position = "top";
    	}
    	// create column series with one y axis
		function createColumnSeries(chart, key, value) {
			var series = chart.series.push(new am4charts.ColumnSeries());
			series.dataFields.valueY = key; 
			series.dataFields.categoryX = "date";
			series.name = value;
			series.columns.template.tooltipText = "[bold]{valueY}[/]";
			series.columns.template.fillOpacity = 0.8;

			var columnTemplate = series.columns.template;
			columnTemplate.strokeWidth = 2;
			columnTemplate.strokeOpacity = 1;
		}

        // draw layered column chart
        function layered_column_chart(data, id_element, series) {
            am4core.useTheme(am4themes_animated);
            var chart = am4core.create(id_element, am4charts.XYChart);

            chart.data = data;
            chart.colors.step = 2;

            // create x axis
            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "date";
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.renderer.minGridDistance = 10;

            // up-down label
            if (data.length >= 7) {
                categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
                    if (target.dataItem && target.dataItem.index & 2 == 2) {
                        return dy + 25;
                    }
                    return dy;
                });
            }

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            jQuery.each(series, function(index, value) {
                createLayeredColumnSeries(chart, index, value);
            });

            // Add cursor
            chart.cursor = new am4charts.XYCursor();

            // Add legend
            chart.legend = new am4charts.Legend();
            chart.legend.position = "top";

            // Add scrollbar
            // chart.scrollbarX = new am4charts.XYChartScrollbar();
            // chart.scrollbarX.series.push(series1);
            // chart.scrollbarX.parent = chart.bottomAxesContainer;
        }
        function createLayeredColumnSeries(chart, key, value) {
            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.valueY = key;
            series.dataFields.categoryX = "date";
            series.name = value[0];
            series.clustered = value[1];    // original is false
            series.tooltipText = "{name}: [bold]{valueY}[/]";
            // series.columns.template.fillOpacity = 0.8;
            if (value[1] == false) {
                series.columns.template.width = am4core.percent(50);
            }
            // series.columns.template.fill = am4core.color();

            // var columnTemplate = series.columns.template;
            // columnTemplate.strokeWidth = 2;
            // columnTemplate.strokeOpacity = 1;
        }

		// generate chart
		$(document).ready(function(){
			// series: related with api data properties
			gender_series = {
				male_1: ["Male 1", true],
                male_2: ["Male 2", false],
                female_1: ["Female 1", true],
                female_2: ["Female 2", false]
			};
			age_series = {
				teens_1: ["Teens 1", true],
                teens_2: ["Teens 2", false],
                young_adult_1: ["Young Adult 1", true],
                young_adult_2: ["Young Adult 2", false],
                adult_1: ["Adult 1", true],
                adult_2: ["Adult 2", false],
                old_1: ["Old 1", true],
                old_2: ["Old 2", false]
			};
			device_series = {
				android_1: "Android 1",
                android_2: "Android 2",
                ios_1: "iOS 1",
                ios_2: "iOS 2"
			};
			provider_series = {
				telkomsel: "Telkomsel",
				xl: "XL",
				indosat: "Indosat",
				tri: "Tri",
				axis: "Axis",
				smart: "Smart"
			};
            trx_series = {
                total_idr_1: "{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}} 1",
                total_idr_2: "{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}} 2"
            };
            trx_qty_series = {
                total_qty_1: "Quantity 1",
                total_qty_2: "Quantity 2"
            };
            trx_point_series = {
                kopi_point_1: "Kenangan Point 1",
                kopi_point_2: "Kenangan Point 2"
            };
		   	product_series = {
                total_qty_1: "Quantity 1",
                total_qty_2: "Quantity 2"
            };
	    	mem_series = {
                cust_total_1: "Total Customer 1",
                cust_total_2: "Total Customer 2"
            };
	    	voucher_series = {
                total_1: "Total Voucher 1",
                total_2: "Total Voucher 2"
            };

			@if (!empty($report['transactions']))
                trx_idr_data = {!! json_encode($report['transactions']['trx_idr_chart']) !!};
                trx_qty_data = {!! json_encode($report['transactions']['trx_qty_chart']) !!};
		    	trx_kopi_point_data = {!! json_encode($report['transactions']['trx_kopi_point_chart']) !!};

                column_chart(trx_idr_data, "trx_chart", trx_series)
                column_chart(trx_qty_data, "trx_qty_chart", trx_qty_series)
                column_chart(trx_kopi_point_data, "trx_kopi_point_chart", trx_point_series)
	    	@endif

			@if (!empty($report['products']))
                product = {!! json_encode($report['products']) !!};
                product_data = {!! json_encode($report['products']['product_chart']) !!};
                product_gender_data = {!! json_encode($report['products']['product_gender_chart']) !!};
                product_age_data = {!! json_encode($report['products']['product_age_chart']) !!};
		    	product_device_data = {!! json_encode($report['products']['product_device_chart']) !!};
                console.log('product_device_data', product_device_data);
                console.log('device_series', device_series);

                /*product_gender_data = [
                    {
                        date: "a vs b",
                        male_1: 9,
                        male_2: 8,
                        female_1: 10,
                        female_2: 12
                    },
                    {
                        date: "b vs c",
                        male_1: 4,
                        male_2: 3,
                        female_1: 6,
                        female_2: 2
                    },
                    {
                        date: "c vs d",
                        male_1: 2,
                        male_2: 7,
                        female_1: 5,
                        female_2: 3
                    },
                    {
                        date: "d vs e",
                        male_1: 4,
                        male_2: 1,
                        female_1: 5,
                        female_2: 8
                    },
                    {
                        date: "e vs f",
                        male_1: 9,
                        male_2: 8,
                        female_1: 4,
                        female_2: 6
                    }
                ];

                product_age_data = [
                    {
                        date: "a vs b",
                        teens_1: 9, young_adult_1: 8, adult_1: 10, old_1: 12,
                        teens_2: 10, young_adult_2: 12, adult_2: 10, old_2: 12
                    },
                    {
                        date: "b vs c",
                        teens_1: 2, young_adult_1: 1, adult_1: 3, old_1: 0,
                        teens_2: 4, young_adult_2: 3, adult_2: 2, old_2: 1
                    },
                    {
                        date: "c vs d",
                        teens_1: 5, young_adult_1: 8, adult_1: 2, old_1: 0,
                        teens_2: 2, young_adult_2: 5, adult_2: 0, old_2: 3
                    },
                    {
                        date: "d vs e",
                        teens_1: 1, young_adult_1: 4, adult_1: 6, old_1: 1,
                        teens_2: 0, young_adult_2: 5, adult_2: 3, old_2: 3
                    },
                    {
                        date: "e vs f",
                        teens_1: 6, young_adult_1: 3, adult_1: 6, old_1: 1,
                        teens_2: 3, young_adult_2: 2, adult_2: 9, old_2: 0
                    }
                ];*/
                
		    	// product charts
				column_chart(product_data, "product_chart", product_series);
                layered_column_chart(product_gender_data, "product_gender_chart", gender_series);
                layered_column_chart(product_age_data, "product_age_chart", age_series);
				layered_column_chart(product_device_data, "product_device_chart", device_series);
				// single_axis_chart(product_provider_data, "product_provider_chart", "Quantity", provider_series);
	    	@endif

			@if (!empty($report['registrations']))
		    	/*reg_gender_data = {!! json_encode($report['registrations']['reg_gender_chart']) !!};
		    	reg_age_data = {!! json_encode($report['registrations']['reg_age_chart']) !!};
		    	reg_device_data = {!! json_encode($report['registrations']['reg_device_chart']) !!};
		    	reg_provider_data = {!! json_encode($report['registrations']['reg_provider_chart']) !!};

				// registration charts 
				single_axis_chart(reg_gender_data, "reg_gender_chart", "Quantity", gender_series);
				single_axis_chart(reg_age_data, "reg_age_chart", "Quantity", age_series);
				single_axis_chart(reg_device_data, "reg_device_chart", "Quantity", device_series);
				single_axis_chart(reg_provider_data, "reg_provider_chart", "Quantity", provider_series);*/
	    	@endif

	    	@if (!empty($report['memberships']))
		    	/*mem_data = {!! json_encode($report['memberships']['mem_chart']) !!};

				// membership charts 
				column_chart(mem_data, "mem_chart", mem_series);
				single_axis_chart(mem_gender_data, "mem_gender_chart", "Quantity", gender_series);
				single_axis_chart(mem_age_data, "mem_age_chart", "Quantity", age_series);
				single_axis_chart(mem_device_data, "mem_device_chart", "Quantity", device_series);
				single_axis_chart(mem_provider_data, "mem_provider_chart", "Quantity", provider_series);*/
	    	@endif

	    	@if (!empty($report['vouchers']))
		    	/*voucher_data = {!! json_encode($report['vouchers']['voucher_chart']) !!};
		    	voucher_gender_data = {!! json_encode($report['vouchers']['voucher_gender_chart']) !!};
		    	voucher_age_data = {!! json_encode($report['vouchers']['voucher_age_chart']) !!};
		    	voucher_device_data = {!! json_encode($report['vouchers']['voucher_device_chart']) !!};
		    	voucher_provider_data = {!! json_encode($report['vouchers']['voucher_provider_chart']) !!};

				// voucher charts 
				column_chart(voucher_data, "voucher_chart", voucher_series);
				single_axis_chart(voucher_gender_data, "voucher_gender_chart", "Quantity", gender_series);
				single_axis_chart(voucher_age_data, "voucher_age_chart", "Quantity", age_series);
				single_axis_chart(voucher_device_data, "voucher_device_chart", "Quantity", device_series);
				single_axis_chart(voucher_provider_data, "voucher_provider_chart", "Quantity", provider_series);*/
	    	@endif
		});

    </script>
@stop

@section('content')
	<div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{ url('/home') }}">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ $title }}</span>
                @if (!empty($sub_title))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @if (!empty($sub_title))
            <li>
                <span>{{ $sub_title }}</span>
            </li>
            @endif
        </ul>
    </div><br>
    
    @include('layouts.notifications')

	<div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption ">
                <span class="caption-subject sbold uppercase font-blue">Filter</span>
            </div>
            <div class="filter-loader" id="date-filter-loader">
                <div class="spinner"></div>
            </div>
        </div>
        <div class="portlet-body">
            <div class="filter-wrapper">
                <div class="row">
                	<div class="col-md-2">
                    	<select id="time_type" class="form-control select2" name="time_type">
							<option value="day" {{ ($filter['time_type_select']=='day' ? 'selected' : '') }}>Day</option>
							<option value="week" {{ ($filter['time_type_select']=='week' ? 'selected' : '') }}>Week</option>
							<option value="month" {{ ($filter['time_type_select']=='month' ? 'selected' : '') }}>Month</option>
							<option value="quarter" {{ ($filter['time_type_select']=='quarter' ? 'selected' : '') }}>Quarter</option>
							<option value="year" {{ ($filter['time_type_select']=='year' ? 'selected' : '') }}>Year</option>
						</select>
					</div>
					<div id="filter-day" class="col-md-8" style="padding-left:0; padding-right:0">
                        <div class="clearfix">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" id="filter-day-1" class="form-control date-range-picker" name="date_range" placeholder="Date Range">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix" style="margin-top: 15px;">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" id="comp-filter-day-1" class="form-control datepicker comp-filter-1" name="comp_start_date" placeholder="Start">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" id="comp-filter-day-2" class="form-control" name="comp_end_date" placeholder="End" readonly>
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
	                </div>
					<div id="filter-week" class="col-md-8" style="padding-left:0; padding-right:0; display:none;">
                        <div class="clearfix">
    	                	<div class="col-md-6">
    	                		<div class="input-group">
    	                            <input type="text" id="filter-week-1" class="form-control week-picker" name="week_date" placeholder="Week Date">
    	                            <span class="input-group-addon">
    	                                <i class="fa fa-calendar"></i>
    	                            </span>
    	                        </div>
    	                	</div>
                        </div>
                        <div class="clearfix" style="margin-top: 15px;">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" id="comp-filter-week-1" class="form-control week-picker" name="comp_week_date" placeholder="Week Date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
	                </div>
					<div id="filter-month" class="col-md-8" style="padding-left:0; padding-right:0; display:none;">
                        <div class="clearfix">
    	                	<div class="col-md-4">
    	                		<select id="filter-month-1" class="form-control select2 filter-1" name="start_month" data-placeholder="Start Month">
    								<option></option>
    								<option value="1">January</option>
    								<option value="2">February</option>
    								<option value="3">March</option>
    								<option value="4">April</option>
    								<option value="5">May</option>
    								<option value="6">June</option>
    								<option value="7">July</option>
    								<option value="8">August</option>
    								<option value="9">September</option>
    								<option value="10">October</option>
    								<option value="11">November</option>
    								<option value="12">December</option>
    							</select>
    	                	</div>
    	                	<div class="col-md-4">
    	                		<select id="filter-month-2" class="form-control select2 filter-2" name="end_month" data-placeholder="End Month">
    	                			<option></option>
    								<option value="1">January</option>
    								<option value="2">February</option>
    								<option value="3">March</option>
    								<option value="4">April</option>
    								<option value="5">May</option>
    								<option value="6">June</option>
    								<option value="7">July</option>
    								<option value="8">August</option>
    								<option value="9">September</option>
    								<option value="10">October</option>
    								<option value="11">November</option>
    								<option value="12">December</option>
    							</select>
    	                	</div>
    	                	<div class="col-md-4">
    	                		<select id="filter-month-3" class="form-control select2 filter-3" name="month_year" data-placeholder="Select Year">
    	                			<option></option>
    	                			@foreach($year_list as $year)
    	                				<option value="{{ $year }}">{{ $year }}</option>
    	                			@endforeach
    	                		</select>
    	                	</div>
                        </div>
                        <div class="clearfix" style="margin-top: 15px;">
                            <div class="col-md-4">
                                <select id="comp-filter-month-1" class="form-control select2 comp-filter-1" name="comp_start_month" data-placeholder="Start Month">
                                    <option></option>
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select id="comp-filter-month-2" class="form-control select2 comp-filter-2" name="comp_end_month" data-placeholder="End Month" disabled>
                                    <option></option>
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select id="comp-filter-month-3" class="form-control select2 comp-filter-3" name="comp_month_year" data-placeholder="Select Year">
                                    <option></option>
                                    @foreach($year_list as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
	                </div>
					<div id="filter-quarter" class="col-md-8" style="padding-left:0; padding-right:0; display:none;">
                        <div class="clearfix">
    	                	<div class="col-md-4">
    	                		<select id="filter-quarter-1" class="form-control select2 filter-1" name="quarter" data-placeholder="Select Quarter">
    								<option value="1-3">Jan - Mar</option>
    								<option value="4-6">Apr - Jun</option>
    								<option value="7-9">Jul - Sept</option>
    								<option value="10-12">Oct - Dec</option>
    							</select>
    	                	</div>
    	                	<div class="col-md-4">
    	                		<select id="filter-quarter-2" class="form-control select2 filter-2" name="quarter_year" data-placeholder="Select Year">
    	                			<option></option>
    	                			@foreach($year_list as $year)
    	                				<option value="{{ $year }}">{{ $year }}</option>
    	                			@endforeach
    	                		</select>
    	                	</div>
                        </div>
                        <div class="clearfix" style="margin-top: 15px;">
                            <div class="col-md-4">
                                <select id="comp-filter-quarter-1" class="form-control select2 comp-filter-1" name="comp_quarter" data-placeholder="Select Quarter">
                                    <option value="1-3">Jan - Mar</option>
                                    <option value="4-6">Apr - Jun</option>
                                    <option value="7-9">Jul - Sept</option>
                                    <option value="10-12">Oct - Dec</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select id="comp-filter-quarter-2" class="form-control select2 comp-filter-2" name="comp_quarter_year" data-placeholder="Select Year">
                                    <option></option>
                                    @foreach($year_list as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
	                </div>
					<div id="filter-year" class="col-md-8" style="padding-left:0; padding-right:0; display:none;">
                        <div class="clearfix">
    	                	<div class="col-md-4">
    	                		<select id="filter-year-1" class="form-control select2 filter-1" name="start_year" data-placeholder="Start Year">
    	                			<option></option>
    	                			@foreach($year_list as $year)
    	                				<option value="{{ $year }}">{{ $year }}</option>
    	                			@endforeach
    	                		</select>
    	                	</div>
    	                	<div class="col-md-4">
    	                		<select id="filter-year-2" class="form-control select2 filter-2" name="end_year" data-placeholder="End Year">
    	                			<option></option>
    	                			@foreach($year_list as $year)
    	                				<option value="{{ $year }}">{{ $year }}</option>
    	                			@endforeach
    	                		</select>
    	                	</div>
                        </div>
                        <div class="clearfix" style="margin-top: 15px;">
                            <div class="col-md-4">
                                <select id="comp-filter-year-1" class="form-control select2 comp-filter-1" name="comp_start_year" data-placeholder="Start Year">
                                    <option></option>
                                    @foreach($year_list as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select id="comp-filter-year-2" class="form-control select2 comp-filter-2" name="comp_end_year" data-placeholder="End Year" disabled>
                                    <option></option>
                                    @foreach($year_list as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
	                </div>
                </div>
            </div>
        </div>
    </div>

    @if(empty($report))
    	<div class="alert alert-warning">
    		Data not found
    	</div>
    @else
    	{{-- Date Range --}}
        @php
            if ($filter['time_type']=='month') {
                $date_range_1 = date('F', strtotime($filter['param1'])) ." - ". date('F', strtotime($filter['param2'])) ." ". $filter['param3'];
                $date_range_2 = date('F', strtotime($filter['param4'])) ." - ". date('F', strtotime($filter['param5'])) ." ". $filter['param6'];
            }
            elseif ($filter['time_type']=='year') {
                $date_range_1 = $filter['param1'] ." - ". $filter['param2'];
                $date_range_2 = $filter['param3'] ." - ". $filter['param4'];
            }
            else {
                $date_range_1 = date('d M Y', strtotime($filter['param1'])) ." - ". date('d M Y', strtotime($filter['param2']));
                $date_range_2 = date('d M Y', strtotime($filter['param3'])) ." - ". date('d M Y', strtotime($filter['param4']));
            }
        @endphp

	    {{-- Transaction --}}
	    @include('report::compare_report._transaction')

	    {{-- Product --}}
	    @include('report::compare_report._product')

	    {{-- Customer Registration --}}
	    {{-- @include('report::compare_report._registration') --}}

	    {{-- Customer Membership --}}
	    {{-- @include('report::compare_report._membership') --}}
	    
	    {{-- Voucher Redemption --}}
	    {{-- @include('report::compare_report._voucher_redemption') --}}
	    
    @endif
@stop