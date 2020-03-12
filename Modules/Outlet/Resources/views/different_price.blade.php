@extends('layouts.main')
@include('infinitescroll')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@yield('is-style')
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@yield('is-script')
<script>
    template = {
        differentprice: function(item){
            return `
            <tr class="page${item.page}">
                <td class="text-center">${item.increment}</td>
                <td>${item.outlet_code} - ${item.outlet_name}</td>
                <td class="text-center">
                    <div class="md-checkbox">
                        <input type="checkbox" data-id="${item.id_outlet}" id="checkboxx${item.increment}" name="enable" class="md-checkboxbtn checkbox-different" ${item.outlet_different_price == 1?'checked':''}>
                        <label for="checkboxx${item.increment}">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span>
                        </label>
                    </div>
                </td>
            </tr>
            `;
        }
    };
    function updater(table,response){
        table.parents('.is-container').find('.total-record').text(response.total?response.total:0).val(response.total?response.total:0);
    }
    $(document).ready(function(){
        $('.is-container').on('change','.checkbox-different',function(){
            var status = $(this).is(':checked')?1:0;
            if($(this).data('auto')){
                $(this).data('auto',0);
            }else{
                const selector = $(this);
                $.post({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                    },
                    url: "{{url('outlet/different-price/update')}}",
                    data: {
                        ajax: 1,
                        id_outlet: $(this).data('id'),
                        status: status
                    },
                    success: function(response){
                        selector.data('auto',1);
                        if(response.status == 'success'){
                            toastr.info("Update success");
                            if(response.result == '1'){
                                selector.prop('checked',true);
                            }else{
                                selector.prop('checked',false);
                            }
                        }else{
                            toastr.warning("Update fail");
                            if(status == 1){
                                selector.prop('checked',false);
                            }else{
                                selector.prop('checked',true);
                            }
                        }
                        selector.change();
                    },
                    error: function(data){
                        toastr.warning("Update fail");
                        selector.data('auto',1);
                        if(status == 1){
                            selector.prop('checked',false);
                        }else{
                            selector.prop('checked',true);
                        }
                        selector.change();
                    }
                });
            }
        });
    });
</script>
@endsection

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
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Outlet List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class=" table-responsive is-container">
                <div class="row">
                    <div class="col-md-offset-9 col-md-3">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control search-field" name="keyword" placeholder="Search">
                                <div class="input-group-btn">
                                    <button class="btn blue search-btn"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-infinite">
                    <table class="table table-striped" id="tableTrx" data-template="differentprice"  data-page="0" data-is-loading="0" data-is-last="0" data-url="{{url()->current()}}" data-callback="updater" data-order="promo_campaign_referral_transactions.created_at" data-sort="asc">
                        <thead>
                            <tr>
                                <th style="width: 1%" class="text-center">No</th>
                                <th>Outlet</th>
                                <th style="width: 120px">Different Price</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div><span class="text-muted">Total record: </span><span class="total-record"></span></div>
            </div>
        </div>
    </div>



@endsection