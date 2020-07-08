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
                <div class="clearfix form-group">
                    <div class="col-md-6">
                        <select class="form-control select2" id="trx_id_outlet_1" name="trx_id_outlet_1">
                            <option value="0">All Outlets</option>
                            @foreach($outlets as $outlet)
                                <option value="{{ $outlet['id_outlet'] }}" {{ ($outlet['id_outlet']==$filter['trx_id_outlet_1'] ? 'selected' : '') }}>{{ $outlet['outlet_code'] ." - ". $outlet['outlet_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="clearfix">
                    <div class="col-md-6">
                        <select class="form-control select2" id="trx_id_outlet_2" name="trx_id_outlet_2">
                            <option value="0">All Outlets</option>
                            @foreach($outlets as $outlet)
                                <option value="{{ $outlet['id_outlet'] }}" {{ ($outlet['id_outlet']==$filter['trx_id_outlet_2'] ? 'selected' : '') }}>{{ $outlet['outlet_code'] ." - ". $outlet['outlet_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        	{{-- Chart --}}
            <div style="margin-top: 30px">
                <div class="tabbable tabbable-tabdrop">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_trx_1" id="tab-menu-trx-1" data-toggle="tab">Transaction</a>
                        </li>
                        <li>
                            <a href="#tab_trx_2" data-toggle="tab">Quantity Transaction</a>
                        </li>
                        <li>
                            <a href="#tab_trx_3" data-toggle="tab">{{env('POINT_NAME', 'Points')}}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_trx_1">
                            <div id="trx_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_trx_2">
                            <div id="trx_qty_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_trx_3">
                            <div id="trx_kopi_point_chart" style="height:300px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-top: 30px" class="clearfix">
                <table class="col-md-6">
                    <tbody>
                        <tr>
                            <td><b>Filter 1</b></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>Date Range</b></td>
                            <td class="semicolon text-center">:</td>
                            <td class="date-range-1">{{ $date_range_1 }}</td>
                        </tr>
                        <tr>
                            <td><b>Outlet</b></td>
                            <td class="semicolon text-center">:</td>
                            <td id="trx_outlet_name_1">{{ isset($filter['trx_outlet_name_1']) ? $filter['trx_outlet_name_1'] : 'All Outlets' }}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="col-md-6">
                    <tbody>
                        <tr>
                            <td><b>Filter 2</b></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>Date Range</b></td>
                            <td class="semicolon text-center">:</td>
                            <td class="date-range-2">{{ $date_range_2 }}</td>
                        </tr>
                        <tr>
                            <td><b>Outlet</b></td>
                            <td class="semicolon text-center">:</td>
                            <td id="trx_outlet_name_2">{{ isset($filter['trx_outlet_name_2']) ? $filter['trx_outlet_name_2'] : 'All Outlets' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Table --}}
            <div id="table-trx" class="table-wrapper" style="margin-top: 30px">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th data-data='number'> No </th>
                            <th data-data='date' class="col-date"> Date </th>
                            <th data-data='trx_grand'> Total ({{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}}) </th>
                            <th data-data='trx_count'> Total (Qty) </th>
                            <th data-data='trx_cashback_earned'> User Kenangan Point </th>
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
                            <td>{{ number_format($trx['trx_grand'] , 0, '', ',') }}</td>
                            <td>{{ $trx['trx_count'] }}</td>
                            <td>{{ number_format($trx['trx_cashback_earned'] , 0, '', ',') }}</td>
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