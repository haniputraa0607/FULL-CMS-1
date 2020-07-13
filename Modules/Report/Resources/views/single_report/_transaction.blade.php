<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject sbold uppercase font-blue">Transaction</span>
        </div>
        <div class="filter-loader" id="trx-loader">
            <div class="spinner"></div>
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-body">

            <div class="bg-grey-steel clearfix" style="padding-top: 15px; padding-bottom: 15px;">
                <div class="col-md-6">
                    <select class="form-control select2" id="trx_id_outlet" name="trx_id_outlet">
                        <option value="0">All Outlets</option>
                        @foreach($outlets as $outlet)
                            <option value="{{ $outlet['id_outlet'] }}" {{ ($outlet['id_outlet']==$filter['trx_id_outlet'] ? 'selected' : '') }}>{{ $outlet['outlet_code'] ." - ". $outlet['outlet_name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        	{{-- Chart --}}
            <div style="margin-top: 30px">
                <div class="tabbable tabbable-tabdrop">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_trx_1" id="tab-menu-trx-1" data-toggle="tab">Transaction</a>
                        </li>
                        {{-- <li>
                            <a href="#tab_trx_2" data-toggle="tab">Gender</a>
                        </li>
                        <li>
                            <a href="#tab_trx_3" data-toggle="tab">Age</a>
                        </li>
                        <li>
                            <a href="#tab_trx_4" data-toggle="tab">Device</a>
                        </li>
                        <li>
                            <a href="#tab_trx_5" data-toggle="tab">Provider</a>
                        </li> --}}
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_trx_1">
                            <div id="trx_chart" style="height:300px;"></div>
                        </div>
                        {{-- <div class="tab-pane" id="tab_trx_2">
                            <div id="trx_gender_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_trx_3">
                            <div id="trx_age_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_trx_4">
                            <div id="trx_device_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_trx_5">
                            <div id="trx_provider_chart" style="height:300px;"></div>
                        </div> --}}
                    </div>
                </div>
            </div>

            <div style="margin-top: 30px">
                <table>
                    <tbody>
                        <tr>
                            <td><b>Date Range</b></td>
                            <td class="semicolon text-center">:</td>
                            <td class="date-range">{{ $date_range }}</td>
                        </tr>
                        <tr>
                            <td><b>Outlet</b></td>
                            <td class="semicolon text-center">:</td>
                            <td id="trx_outlet_name">{{ isset($filter['trx_outlet_name']) ? $filter['trx_outlet_name'] : 'All Outlets' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Card --}}
            <div class="row cards" style="margin-top: 30px">
                <div class="col-md-4" style="margin-bottom: 20px;">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-money"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0" id="card_trx_1">{{ $report['transactions']['total_idr'] }}</span> </div>
                                <div class="desc">
                                Total Transaction ({{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}})
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="margin-bottom: 20px;">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-line-chart"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0" id="card_trx_2">{{ $report['transactions']['total_qty'] }}</span> </div>
                                <div class="desc">
                                Total Transaction (Qty)
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="margin-bottom: 20px;">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-money"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0" id="card_trx_3">{{ $report['transactions']['average_idr'] }}</span> </div>
                                <div class="desc">
                                Avg Transaction ({{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}})
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-male"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0" id="card_trx_4">{{ $report['transactions']['total_male'] }}</span> </div>
                                <div class="desc">
                                Total Male Customer
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-female"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0" id="card_trx_5">{{ $report['transactions']['total_female'] }}</span> </div>
                                <div class="desc">
                                Total Female Customer
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div id="table-trx" class="table-wrapper" style="margin-top: 30px">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th data-data='number'> No </th>
                            <th data-data='date' class="col-date"> Date </th>
                            <th data-data='trx_count'> Total (Qty) </th>
                            <th data-data='trx_grand'> Total ({{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}}) </th>
                            <th data-data='trx_cashback_earned'> User {{env('POINT_NAME', 'Points')}} </th>
                            <th data-data='cust_male'> Male Customer </th>
                            <th data-data='cust_female'> Female Customer </th>
                            <th data-data='cust_android'> Android </th>
                            <th data-data='cust_ios'> iOS </th>
                            <th data-data='cust_telkomsel'> Telkomsel </th>
                            <th data-data='cust_xl'> XL </th>
                            <th data-data='cust_indosat'> Indosat </th>
                            <th data-data='cust_tri'> Tri </th>
                            <th data-data='cust_axis'> Axis </th>
                            <th data-data='cust_smart'> Smart </th>
                            <th data-data='cust_teens'> Teens </th>
                            <th data-data='cust_young_adult'> Young Adult </th>
                            <th data-data='cust_adult'> Adult </th>
                            <th data-data='cust_old'> Old </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report['transactions']['data'] as $key => $trx)
                        <tr class="odd gradeX">
                            <td>{{ $key+1 }}</td>
                            <td class="col-date">{{ $trx['date'] }}</td>
                            <td>{{ $trx['trx_count'] }}</td>
                            <td>{{ $trx['trx_grand'] }}</td>
                            <td>{{ $trx['trx_cashback_earned'] }}</td>
                            <td>{{ $trx['cust_male'] }}</td>
                            <td>{{ $trx['cust_female'] }}</td>
                            <td>{{ $trx['cust_android'] }}</td>
                            <td>{{ $trx['cust_ios'] }}</td>
                            <td>{{ $trx['cust_telkomsel'] }}</td>
                            <td>{{ $trx['cust_xl'] }}</td>
                            <td>{{ $trx['cust_indosat'] }}</td>
                            <td>{{ $trx['cust_tri'] }}</td>
                            <td>{{ $trx['cust_axis'] }}</td>
                            <td>{{ $trx['cust_smart'] }}</td>
                            <td>{{ $trx['cust_teens'] }}</td>
                            <td>{{ $trx['cust_young_adult'] }}</td>
                            <td>{{ $trx['cust_adult'] }}</td>
                            <td>{{ $trx['cust_old'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>