@extends('layouts.main')

@section('page-style')
    <link href="{{ url('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />

    <style type="text/css">
    	.table-wrapper{
    		overflow-x: auto;
    	}
    	.cards .number{
    		font-size: 24px;
    	}
    	.semicolon{
    		width: 20px;
    	}
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

    {{-- page scripts --}}
    <script type="text/javascript">
    	// define filter type
    	var time_type = "{{ $filter['time_type'] }}";

    	// init global var
    	var gender_series, age_series, device_series,
	    	provider_series, trx_series, product_series,
	    	mem_series = {};
	    var trx_data = trx_gender_data = trx_age_data =
	    	trx_device_data = trx_provider_data = {};
	    var product_data = product_gender_data =
	    	product_age_data = product_device_data =
	    	product_provider_data = {};
	    var reg_gender_data = reg_age_data =
	    	reg_device_data = reg_provider_data = {};
	    var mem_data = mem_gender_data = mem_age_data =
	    	mem_device_data = mem_provider_data = {};

    	$('.datepicker').datepicker({ autoClose: true });
    	$('.select2').select2();
    	
    	$('#time_type').val(time_type).trigger('change');
    	filter_type(time_type);

    	$('#time_type').on('change', function() {
    		time_type = $(this).val();
    		filter_type(time_type);
    	});

    	// change filter based on time_type
    	function filter_type(time_type) {
    		if (time_type == "month") {
    			$('#filter-day').hide();
    			$('#filter-year').hide();
    			$('#filter-month').show();
    		}
    		else if(time_type == "year") {
    			$('#filter-day').hide();
    			$('#filter-month').hide();
    			$('#filter-year').show();
    		}
    		else {
    			$('#filter-year').hide();
    			$('#filter-month').hide();
    			$('#filter-day').show();
    		}
    	}

    	// call ajax when filter change
    	$('.filter-1, .filter-2, .filter-3').on('change', function(e) {
    		time_type = $('#time_type').val();

    		if (time_type == "month") {
    			var start_month = $('#filter-month-1').val();
    			var end_month = $('#filter-month-2').val();
    			var year = $('#filter-month-3').val();

    			if (start_month!="" && end_month!="" && year!="") {
    				if (start_month > end_month) {
    					toastr.warning("End Month should not less than Start Month");
    				}
    				else{
    					ajax_get_report(time_type, start_month, end_month, year);
    				}
    			}
    		}
    		else if (time_type == "year") {
    			var start_year = $('#filter-year-1').val();
    			var end_year = $('#filter-year-2').val();
    			
    			if (start_year!="" && end_year!="") {
    				ajax_get_report(time_type, start_year, end_year);
    			}
    		}
    		else {
    			// day
    			var start_date = $('#filter-day-1').val();
    			var end_date = $('#filter-day-2').val();
    			
    			if (start_date!="" && end_date!="") {
    				if (start_date > end_date) {
    					toastr.warning("End Date should not less than Start Date");
    				}
    				else{
    					ajax_get_report(time_type, start_date, end_date);
    				}
    			}
    		}
    	});

    	// the ajax
    	function ajax_get_report(time_type, param1, param2, param3=null) {
    		$.ajax({
                type : "POST",
                data : {
                	_token : "{{ csrf_token() }}",
                	time_type : time_type,
                	param1 : param1,
                	param2 : param2,
                	param3 : param3
                },
                url : "{{ url('/report/ajax') }}",
                success: function(result) {
                	console.log('result', result);
                    
                    if (result.status == "success") {
                        toastr.info("Fetch data success");
                        $('.date-range').text(result.date_range);

                        // tell script to redraw chart when tab active
                        tab_trx = tab_trx_gender = tab_trx_age =
                        tab_trx_device = tab_trx_provider = 1;

				    	tab_product = tab_product_gender =
				    	tab_product_age = tab_product_device =
				    	tab_product_provider = 1;

				    	tab_reg_gender = tab_reg_age =
				    	tab_reg_device = tab_reg_provider = 1;

				    	tab_mem = tab_mem_gender = tab_mem_age =
				    	tab_mem_device = tab_mem_provider = 1;

                        // trx
                        var trx = result.result.transactions;
                        var transactions = trx['data'];
                        trx_data = trx['trx_chart'];
                        trx_gender_data = trx['trx_gender_chart'];
                        trx_age_data = trx['trx_age_chart'];
                        trx_device_data = trx['trx_device_chart'];
                        trx_provider_data = trx['trx_provider_chart'];
                        // draw chart in first tab
                        $('#tab-menu-trx-1').tab('show');
                        multi_axis_chart(trx_data, "trx_chart", trx_series);
						tab_trx = 0;
                        // update card value
                        $('#card_trx_1').text(trx['total_idr']);
                        $('#card_trx_2').text(trx['average_idr']);
                        $('#card_trx_3').text(trx['total_male']);
                        $('#card_trx_4').text(trx['total_female']);
                        // update table
                        $('#table-trx tbody').html('');
                        $.each(transactions, function(index, item){
                        	var row = "<tr>\
	                            <td>"+(index+1)+"</td>\
	                            <td>"+item['date']+"</td>\
	                            <td>"+item['trx_count']+"</td>\
	                            <td>"+item['trx_grand']+"</td>\
	                            <td>"+item['trx_cashback_earned']+"</td>\
	                            <td>"+item['cust_male']+"</td>\
	                            <td>"+item['cust_female']+"</td>\
	                            <td>"+item['cust_android']+"</td>\
	                            <td>"+item['cust_ios']+"</td>\
	                            <td>"+item['cust_telkomsel']+"</td>\
	                            <td>"+item['cust_xl']+"</td>\
	                            <td>"+item['cust_indosat']+"</td>\
	                            <td>"+item['cust_tri']+"</td>\
	                            <td>"+item['cust_axis']+"</td>\
	                            <td>"+item['cust_smart']+"</td>\
	                            <td>"+item['cust_teens']+"</td>\
	                            <td>"+item['cust_young_adult']+"</td>\
	                            <td>"+item['cust_adult']+"</td>\
	                            <td>"+item['cust_old']+"</td>\
                        	</tr>";
                        	$('#table-trx tbody').append(row);
                        });

                        // product
                        var product = result.result.products;
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
                        $('#table-product tbody').html('');
                        $.each(products, function(index, item){
                        	var row = "<tr>\
	                            <td>"+(index+1)+"</td>\
	                            <td>"+item['date']+"</td>\
	                            <td>"+item['total_rec']+"</td>\
	                            <td>"+item['total_qty']+"</td>\
	                            <td>"+item['total_nominal']+"</td>\
	                            <td>"+item['cust_male']+"</td>\
	                            <td>"+item['cust_female']+"</td>\
	                            <td>"+item['cust_android']+"</td>\
	                            <td>"+item['cust_ios']+"</td>\
	                            <td>"+item['cust_telkomsel']+"</td>\
	                            <td>"+item['cust_xl']+"</td>\
	                            <td>"+item['cust_indosat']+"</td>\
	                            <td>"+item['cust_tri']+"</td>\
	                            <td>"+item['cust_axis']+"</td>\
	                            <td>"+item['cust_smart']+"</td>\
	                            <td>"+item['cust_teens']+"</td>\
	                            <td>"+item['cust_young_adult']+"</td>\
	                            <td>"+item['cust_adult']+"</td>\
	                            <td>"+item['cust_old']+"</td>\
                        	</tr>";
                        	$('#table-product tbody').append(row);
                        });

                        // registration
                        var reg = result.result.registrations;
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
                        $('#table-reg tbody').html('');
                        $.each(registrations, function(index, item){
                        	var row = "<tr>\
	                            <td>"+(index+1)+"</td>\
	                            <td>"+item['date']+"</td>\
	                            <td>"+item['cust_male']+"</td>\
	                            <td>"+item['cust_female']+"</td>\
	                            <td>"+item['cust_android']+"</td>\
	                            <td>"+item['cust_ios']+"</td>\
	                            <td>"+item['cust_telkomsel']+"</td>\
	                            <td>"+item['cust_xl']+"</td>\
	                            <td>"+item['cust_indosat']+"</td>\
	                            <td>"+item['cust_tri']+"</td>\
	                            <td>"+item['cust_axis']+"</td>\
	                            <td>"+item['cust_smart']+"</td>\
	                            <td>"+item['cust_teens']+"</td>\
	                            <td>"+item['cust_young_adult']+"</td>\
	                            <td>"+item['cust_adult']+"</td>\
	                            <td>"+item['cust_old']+"</td>\
                        	</tr>";
                        	$('#table-reg tbody').append(row);
                        });

                        // membership
                        var mem = result.result.memberships;
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
                        $('#table-mem tbody').html('');
                        $.each(memberships, function(index, item){
                        	var row = "<tr>\
	                            <td>"+(index+1)+"</td>\
	                            <td>"+item['date']+"</td>\
	                            <td>"+item['cust_total']+"</td>\
	                            <td>"+item['cust_male']+"</td>\
	                            <td>"+item['cust_female']+"</td>\
	                            <td>"+item['cust_android']+"</td>\
	                            <td>"+item['cust_ios']+"</td>\
	                            <td>"+item['cust_telkomsel']+"</td>\
	                            <td>"+item['cust_xl']+"</td>\
	                            <td>"+item['cust_indosat']+"</td>\
	                            <td>"+item['cust_tri']+"</td>\
	                            <td>"+item['cust_axis']+"</td>\
	                            <td>"+item['cust_smart']+"</td>\
	                            <td>"+item['cust_teens']+"</td>\
	                            <td>"+item['cust_young_adult']+"</td>\
	                            <td>"+item['cust_adult']+"</td>\
	                            <td>"+item['cust_old']+"</td>\
                        	</tr>";
                        	$('#table-mem tbody').append(row);
                        });
                    }
                    else {
                        toastr.warning(result.messages);
                    }
                },
                fail: function(xhr, textStatus, errorThrown){
    				toastr.warning("Something went wrong. Could not fetch data");
			    }
            });
    	}

    	// flag if chart need to redraw or not
    	var tab_trx = tab_trx_gender = tab_trx_age =
	    	tab_trx_device = tab_trx_provider = 0;
	    var tab_product = tab_product_gender =
	    	tab_product_age = tab_product_device =
	    	tab_product_provider = 0;
	    var tab_reg_gender = tab_reg_age =
	    	tab_reg_device = tab_reg_provider = 0;
	    var tab_mem = tab_mem_gender = tab_mem_age =
	    	tab_mem_device = tab_mem_provider = 0;

    	// draw chart once when tab active every data fetched
		jQuery(".nav-tabs a").on("shown.bs.tab", function() {
			var tab = $(this).attr('href');
			switch (tab) {
				/*case "#tab_trx_1":
					if (tab_trx) {
						multi_axis_chart(trx_data, "trx_chart", trx_series);
						tab_trx = 0;
					}
					break;*/
				case "#tab_trx_2":
					if (tab_trx_gender) {
						single_axis_chart(trx_gender_data, "trx_gender_chart", "Quantity", gender_series);
						tab_trx_gender = 0;
					}
					break;
				case "#tab_trx_3":
					if (tab_trx_age) {
						single_axis_chart(trx_age_data, "trx_age_chart", "Quantity", age_series);
						tab_trx_age = 0;
					}
					break;
				case "#tab_trx_4":
					if (tab_trx_device) {
						single_axis_chart(trx_device_data, "trx_device_chart", "Quantity", device_series);
						tab_trx_device = 0;
					}
					break;
				case "#tab_trx_5":
					if (tab_trx_provider) {
						single_axis_chart(trx_provider_data, "trx_provider_chart", "Quantity", provider_series);
						tab_trx_provider = 0;
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
				case "#tab_mem_2":
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
			// chart.colors.step = 2;

			// create x axis
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "date";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 30;

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			jQuery.each(series, function(index, value) {
				createColumnSeries(chart, index, value);
			});
    	}
    	// create column series with one y axis
		function createColumnSeries(chart, field, name) {
			var series = chart.series.push(new am4charts.ColumnSeries());
			series.dataFields.valueY = field; 
			series.dataFields.categoryX = "date";
			series.name = name;
			series.columns.template.tooltipText = "[bold]{valueY}[/]";
			series.columns.template.fillOpacity = 0.8;

			var columnTemplate = series.columns.template;
			columnTemplate.strokeWidth = 2;
			columnTemplate.strokeOpacity = 1;
		}

		// generate chart
		$(document).ready(function(){
			// series: related with api data properties
			gender_series = {
				male: "Male",
				female: "Female"
			};
			age_series = {
				teens: "Teens",
				young_adult: "Young Adult",
				adult: "Adult",
				old: "Old"
			};
			device_series = {
				android: "Android",
				ios: "iOS"
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
				total_qty: ["Quantity", false],
				total_idr: ["IDR", true],
				kopi_point: ["Kopi Point", true]
			};
		   	product_series = { total_qty: "Quantity" };
	    	mem_series = { cust_total: "Total Customer" };

			@if (!empty($report['transactions']))
		    	trx_data = {!! json_encode($report['transactions']['trx_chart']) !!};
		    	trx_gender_data = {!! json_encode($report['transactions']['trx_gender_chart']) !!};
		    	trx_age_data = {!! json_encode($report['transactions']['trx_age_chart']) !!};
		    	trx_device_data = {!! json_encode($report['transactions']['trx_device_chart']) !!};
		    	trx_provider_data = {!! json_encode($report['transactions']['trx_provider_chart']) !!};

		    	// trx_chart(trx_data);
				multi_axis_chart(trx_data, "trx_chart", trx_series);
				single_axis_chart(trx_gender_data, "trx_gender_chart", "Quantity", gender_series)
				single_axis_chart(trx_age_data, "trx_age_chart", "Quantity", age_series)
				single_axis_chart(trx_device_data, "trx_device_chart", "Quantity", device_series);
				single_axis_chart(trx_provider_data, "trx_provider_chart", "Quantity", provider_series);
	    	@endif

			@if (!empty($report['products']))
		    	product_data = {!! json_encode($report['products']['product_chart']) !!};
		    	product_gender_data = {!! json_encode($report['products']['product_gender_chart']) !!};
		    	product_age_data = {!! json_encode($report['products']['product_age_chart']) !!};
		    	product_device_data = {!! json_encode($report['products']['product_device_chart']) !!};
		    	product_provider_data = {!! json_encode($report['products']['product_provider_chart']) !!};

		    	// product charts
				column_chart(product_data, "product_chart", product_series);
    			// multi_column_chart("product_chart");
				single_axis_chart(product_gender_data, "product_gender_chart", "Quantity", gender_series);
				single_axis_chart(product_age_data, "product_age_chart", "Quantity", age_series);
				single_axis_chart(product_device_data, "product_device_chart", "Quantity", device_series);
				single_axis_chart(product_provider_data, "product_provider_chart", "Quantity", provider_series);
	    	@endif

			@if (!empty($report['registrations']))
		    	reg_gender_data = {!! json_encode($report['registrations']['reg_gender_chart']) !!};
		    	reg_age_data = {!! json_encode($report['registrations']['reg_age_chart']) !!};
		    	reg_device_data = {!! json_encode($report['registrations']['reg_device_chart']) !!};
		    	reg_provider_data = {!! json_encode($report['registrations']['reg_provider_chart']) !!};

				// registration charts 
				single_axis_chart(reg_gender_data, "reg_gender_chart", "Quantity", gender_series)
				single_axis_chart(reg_age_data, "reg_age_chart", "Quantity", age_series)
				single_axis_chart(reg_device_data, "reg_device_chart", "Quantity", device_series);
				single_axis_chart(reg_provider_data, "reg_provider_chart", "Quantity", provider_series);
	    	@endif

	    	@if (!empty($report['memberships']))
		    	mem_data = {!! json_encode($report['memberships']['mem_chart']) !!};
		    	mem_gender_data = {!! json_encode($report['memberships']['mem_gender_chart']) !!};
		    	mem_age_data = {!! json_encode($report['memberships']['mem_age_chart']) !!};
		    	mem_device_data = {!! json_encode($report['memberships']['mem_device_chart']) !!};
		    	mem_provider_data = {!! json_encode($report['memberships']['mem_provider_chart']) !!};

				// membership charts 
				column_chart(mem_data, "mem_chart", mem_series);
				// single_axis_chart(mem_data, "mem_chart", "Quantity", mem_series)
				single_axis_chart(mem_gender_data, "mem_gender_chart", "Quantity", gender_series)
				single_axis_chart(mem_age_data, "mem_age_chart", "Quantity", age_series)
				single_axis_chart(mem_device_data, "mem_device_chart", "Quantity", device_series);
				single_axis_chart(mem_provider_data, "mem_provider_chart", "Quantity", provider_series);
	    	@endif
		});

    </script>
@stop

@section('content')
	<div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/">Home</a>
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
        </div>
        <div class="portlet-body">
            <div class="filter-wrapper">
                <div class="row">
                	<div class="col-md-2">
                    	<select id="time_type" class="form-control select2" name="time_type">
							<option value="day" {{ ($filter['time_type']=='day' ? 'selected' : '') }}>Day</option>
							<option value="month" {{ ($filter['time_type']=='month' ? 'selected' : '') }}>Month</option>
							<option value="year" {{ ($filter['time_type']=='year' ? 'selected' : '') }}>Year</option>
						</select>
					</div>
					<div id="filter-day" class="col-md-8" style="padding-left:0; padding-right:0">
	                	<div class="col-md-4">
	                		<div class="input-group">
	                            <input type="text" id="filter-day-1" class="form-control datepicker filter-1" name="start_date" placeholder="Start">
	                            <span class="input-group-addon">
	                                <i class="fa fa-calendar"></i>
	                            </span>
	                        </div>
	                	</div>
	                	<div class="col-md-4">
	                		<div class="input-group">
	                            <input type="text" id="filter-day-2" class="form-control datepicker filter-2" name="end_date" placeholder="End">
	                            <span class="input-group-addon">
	                                <i class="fa fa-calendar"></i>
	                            </span>
	                        </div>
	                	</div>
	                </div>
					<div id="filter-month" class="col-md-8" style="padding-left:0; padding-right:0; display:none;">
	                	<div class="col-md-4">
	                		<select id="filter-month-1" class="form-control select2 filter-1" name="start_month" data-placeholder="Select Month">
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
	                		<select id="filter-month-2" class="form-control select2 filter-2" name="end_month" data-placeholder="Select Month">
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
					<div id="filter-year" class="col-md-8" style="padding-left:0; padding-right:0; display:none;">
	                	<div class="col-md-4">
	                		<select id="filter-year-1" class="form-control select2 filter-1" name="start_year" data-placeholder="Select Year">
	                			<option></option>
	                			@foreach($year_list as $year)
	                				<option value="{{ $year }}">{{ $year }}</option>
	                			@endforeach
	                		</select>
	                	</div>
	                	<div class="col-md-4">
	                		<select id="filter-year-2" class="form-control select2 filter-2" name="end_year" data-placeholder="Select Year">
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

    @if(empty($report))
    	<div class="alert alert-warning">
    		Data not found
    	</div>
    @else
    	{{-- Date Range --}}
        @php
            if ($filter['time_type']=='month') {
                $date_range = date('F', strtotime($filter['param1'])) ." - ". date('F', strtotime($filter['param2'])) ." ". $filter['param3'];
            }
            elseif ($filter['time_type']=='year') {
                $date_range = $filter['param1'] ." - ". $filter['param2'];
            }
            else {
                $date_range = date('d M Y', strtotime($filter['param1'])) ." - ". date('d M Y', strtotime($filter['param2']));
            }
        @endphp

	    {{-- Transaction --}}
	    @include('report::single_report._transaction')

	    {{-- Product --}}
	    @include('report::single_report._product')

	    {{-- Customer Registration --}}
	    @include('report::single_report._registration')

	    {{-- Customer Membership --}}
	    @include('report::single_report._membership')
	    {{-- <div class="portlet light bordered">
	        <div class="portlet-title">
	            <div class="caption ">
	                <span class="caption-subject sbold uppercase font-blue">Customer Data</span>
	            </div>
	        </div>
	        <div class="portlet-body form">
	            <div class="form-body">
	                <div class="row">
	                </div>
	            </div>
	        </div>
	    </div> --}}

	    {{-- Voucher Redemption --}}
	    {{-- <div class="portlet light bordered">
	        <div class="portlet-title">
	            <div class="caption ">
	                <span class="caption-subject sbold uppercase font-blue">Voucher Redemption</span>
	            </div>
	        </div>
	        <div class="portlet-body form">
	            <div class="form-body">
	                <div class="row">
	                </div>
	            </div>
	        </div>
	    </div> --}}
    @endif
@stop