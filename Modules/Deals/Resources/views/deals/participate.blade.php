@include('deals::deals.participate_filter')
@section('detail-participate')
@if ($deals_type != 'Promotion' && $deals['deals_type'] == "Hidden" && $deals['step_complete'] == 1)
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-yellow sbold uppercase">Add Participant</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('deals/update') }}" method="post" enctype="multipart/form-data">
                <!-- <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Import File : </label>
                            <div class="col-md-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="input-group input-large">
                                        <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                            <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                            <span class="fileinput-filename"> </span>
                                        </div>
                                        <span class="input-group-addon btn default btn-file">
                                            <span class="fileinput-new"> Select file </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" name="import_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" onChange="this.form.submit();"> </span>
                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="multiple" class="control-label col-md-3"> </label>
                            <div class="col-md-9">
                                Import data customer from excel. To filter customer please <a href="{{ url('user') }}" target="_blank"> click. </a>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="col-md-3 control-label">To 
                                <span class="required" aria-required="true"> * </span> 
                                <br> <small> Separated by coma (,) </small>
                            </label>
                            <div class="col-md-9">
                                <textarea name="to" class="form-control" rows="5" required>@if(Session::get('deals_recipient')){{ Session::get('deals_recipient') }} @else{{ old('to') }}@endif</textarea>
                            </div>
                        </div>
                </div> -->
            
                <?php $tombolsubmit = 'hidden'; ?>
                @include('filter') 
                @include('filter-csv') 

                <div class="form-group">
                    <label class="col-md-3 control-label">Voucher Amount 
                        <span class="required" aria-required="true"> * </span> 
                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah voucher yang akan diterima oleh masing - masing user" data-container="body"></i>
                    </label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="number" class="form-control" name="amount" min="1" required>
                            <span class="input-group-addon">
                            Vouchers for each user
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="col-md-offset-3 col-md-9">
                        <input type="hidden" name="id_deals" value="{{ $deals['id_deals'] }}">
                        <button type="submit" class="btn yellow">Submit</button>
                    </div>
                </div>
            </form> 
        </div>
    </div>

<hr>
@endif
<div class="portlet-body form">
	@yield('filter')
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Participant</span>
            </div>
        </div>
        <div class="portlet-body form">
        	<div class="table-scrollable">
				<table class="table table-striped table-bordered table-hover">
            {{-- <table class="table table-striped table-bordered table-hover order-column" id="participate_tables"> --}}
	                <thead>
	                    <tr>
	                        <th> User </th>
	                        <th> Status </th>
	                        <th> Voucher Code </th>
	                        <th> Claimed At </th>
	                        <th> Used At </th>
	                        <th> Receipt Number </th>
	                        <th> Outlet Redeem </th>
	                        <th> Redeem At </th>
	                        <th> Expired At </th>
	                        <th> Payment </th>
	                        <th> Grand Total </th>
	                    </tr>
	                </thead>
	                <tbody>
	                @if (!empty($user))
	                @foreach($user as $value)
	                    <tr>
	                        <td nowrap> {{ $value['user']['name'] }} - {{ $value['user']['phone'] }} </td>
	                        <td nowrap>
	                        	@if (!empty($value['used_at']))
		                        	{{ 'Used' }}
		                        @elseif ( !empty($value['voucher_expired_at']) && $value['voucher_expired_at'] < date("Y-m-d H:i:s"))
		                        	{{ 'Expired' }}
		                        @elseif ( !empty($value['redeemed_at']))
		                        	{{ 'Redeemed' }}
		                        @else
		                        	{{ 'Claimed' }}
		                        @endif 
		                    </td>
	                        <td nowrap> {{ $value['voucher_code'] }} </td>
	                        <td nowrap> @if (empty($value['claimed_at'])) -  @else {{ date('d M Y', strtotime($value['claimed_at'])) }} @endif</td>
	                        <td nowrap> @if (empty($value['used_at'])) -  @else {{ date('d M Y', strtotime($value['used_at'])) }} @endif</td>
	                        @php
	                        	$trx_url = url('transaction/detail/'.$value['deal_voucher']['transaction_voucher']['transaction']['id_transaction'].'/'.strtolower($value['deal_voucher']['transaction_voucher']['transaction']['trasaction_type']));
	                        @endphp
	                        <td nowrap> @if (empty($value['deal_voucher']['transaction_voucher']['transaction']['transaction_receipt_number'])) -  @else <a target="_blank" href="{{ $trx_url }}">{{ $value['deal_voucher']['transaction_voucher']['transaction']['transaction_receipt_number'] }}</a> @endif</td>
	                        <td nowrap> @if(empty($value['outlet'])) - @else {{ $value['outlet']['outlet_code'] }} - {{ $value['outlet']['outlet_name'] }} @endif </td>
	                        <td nowrap> @if (empty($value['redeemed_at'])) -  @else {{ date('d M Y', strtotime($value['redeemed_at'])) }} @endif</td>
	                        <td nowrap> @if (empty($value['voucher_expired_at'])) -  @else {{ date('d M Y', strtotime($value['voucher_expired_at'])) }} @endif</td>
	                        <td nowrap> {{ ucwords($value['paid_status']) }} </td>
	                        <td nowrap> @if (empty($value['deal_voucher']['transaction_voucher']['transaction']['transaction_grandtotal'])) -  @else {{ 'IDR '.number_format($value['deal_voucher']['transaction_voucher']['transaction']['transaction_grandtotal']) }} @endif</td>
	                    </tr>
	                @endforeach
	                </tbody>
	                @endif
	            </table>
        	</div>
            @if ($userPaginator)
            {{ $userPaginator->fragment('participate')->links() }}
          @endif
        </div>
    </div>
</div>
@endsection
