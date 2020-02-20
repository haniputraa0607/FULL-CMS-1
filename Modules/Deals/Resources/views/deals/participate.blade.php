@if ($deals['deals_type'] == "Hidden")
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
    
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Participant</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_2">
                <thead>
                    <tr>
                        <th> User </th>
                        <th> Voucher Code </th>
                        <th> Claimed At </th>
                        <th> Outlet Redeem </th>
                        <th> Redeem At </th>
                        <th> Expired At </th>
                        <th> Payment </th>
                    </tr>
                </thead>
                <tbody>
                @if (!empty($user))
                @foreach($user as $value)
                    <tr>
                        <td> {{ $value['user']['name'] }} - {{ $value['user']['phone'] }} </td>
                        <td> {{ $value['voucher_code'] }} </td>
                        <td> @if (empty($value['claimed_at'])) -  @else {{ date('d M Y', strtotime($value['claimed_at'])) }} @endif</td>
                        <td> @if(empty($value['outlet'])) - @else {{ $value['outlet']['outlet_code'] }} - {{ $value['outlet']['outlet_name'] }} @endif </td>
                        <td> @if (empty($value['redeemed_at'])) -  @else {{ date('d M Y', strtotime($value['redeemed_at'])) }} @endif</td>
                        <td> @if (empty($value['voucher_expired_at'])) -  @else {{ date('d M Y', strtotime($value['voucher_expired_at'])) }} @endif</td>
                        <td> {{ ucwords($value['paid_status']) }} </td>                    
                    </tr>
                @endforeach
                </tbody>
                @endif
            </table>
            @if ($userPaginator)
            {{ $userPaginator->fragment('participate')->links() }}
          @endif
        </div>
    </div>
</div>