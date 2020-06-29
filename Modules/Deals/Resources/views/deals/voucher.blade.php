@if ($deals['deals_voucher_type'] == "List Vouchers")
<form class="form-horizontal" role="form" action="{{ url('deals/update') }}" method="post" enctype="multipart/form-data">
  <div class="form-body">
        
        <div class="form-group">
            <label class="col-md-3 control-label">Input Voucher 
                <span class="required" aria-required="true"> * </span> 
                <br> <small> Separated by new line </small>
            </label>
            <div class="col-md-9">
                  <textarea name="voucher_code" class="form-control listVoucher" rows="10">{{ old('voucher_code') }}</textarea>
            </div>
            <input type="hidden" name="deals_type" value="{{$deals['deals_type']??$deals_type}}">
        </div>
     
  </div>
  <div class="form-actions">
      {{ csrf_field() }}
      <div class="row">
          <div class="col-md-offset-3 col-md-9">
            <input type="hidden" name="id_deals" value="{{ $deals['id_deals'] }}">
            <button type="submit" class="btn green">Submit</button>
          </div>
      </div>
  </div>
</form>

<hr>

@endif


<div class="portlet-body form">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">{{ ucwords($deals['deals_voucher_type']) }} Voucher</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th> Code </th>
                        <th> Status </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                @if (!empty($voucher))
                    @foreach($voucher as $value)
                    <tr>
                        <td> {{ $value['voucher_code'] }} </td>
                        <td> {{ $value['deals_voucher_status'] }} </td>
                        <td> <a data-toggle="confirmation" data-popout="true" class="btn red delete-disc" data-id="{{ $value['id_deals_voucher'] }}"><i class="fa fa-trash-o"></i></a> </td>
                    </tr>
                    @endforeach
                </tbody>
                @endif
            </table>
            @if ($voucherPaginator)
                {{ $voucherPaginator->fragment('voucher')->links() }}
            @endif
        </div>
    </div>
</div>