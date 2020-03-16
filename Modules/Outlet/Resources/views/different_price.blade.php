@extends('layouts.main')

@section('page-style')
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .multiple-select {
            height: 70vh !important;
        }
    </style>
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script>
        function block(status = true){
            if(status){
                $('.to-block :input').attr('disabled','disabled');
            }else{
                $('.to-block :input').removeAttr('disabled');
            }
        }
        function reload(){
            block();
            $.post({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                },
                url: "{{url('outlet/different-price')}}",
                data: {
                    ajax: 1,
                    keyword: $('input[name="keyword"]').val()
                },
                success: function(response){
                    $('#different-price,#global-price').html('');
                    response.forEach(item => {
                        const option = `<option value="${item.id_outlet}">${item.outlet_code} - ${item.outlet_name}</option>`;
                        if(item.outlet_different_price){
                            $('#different-price').append(option);
                        }else{
                            $('#global-price').append(option);
                        }
                    });
                    block(false);
                },
                error: function(data){
                    block(false);
                    toastr.danger('Load list outlet fail');
                }
            });
        }
        $(document).ready(function(){
            $('#btn-to-different').on('click',function(){
                block();
                const outlets = $('#global-price').val();
                if(outlets){
                    $.post({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                        },
                        url: "{{url('outlet/different-price/update')}}",
                        data: {
                            ajax: 1,
                            id_outlet: outlets,
                            status: 1
                        },
                        success: function(response){
                            if(response.status == 'success'){
                                toastr.info("Update success");
                                outlets.forEach(item => {
                                    const optionData = $(`option[value="${item}"]`);
                                    optionData.remove();
                                    const option = `<option value="${item}">${optionData.text()}</option>`;
                                    $('#different-price').append(option);
                                });
                            }else{
                                toastr.warning("Update fail");
                            }
                            block(false);
                        },
                        error: function(data){
                            toastr.warning("Update fail");
                            block(false);
                        }
                    });
                }else{
                    toastr.warning("No outlet selected");
                    block(false);
                }
            })
            $('#btn-to-global').on('click',function(){
                block();
                const outlets = $('#different-price').val();
                if(outlets){
                    $.post({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                        },
                        url: "{{url('outlet/different-price/update')}}",
                        data: {
                            ajax: 1,
                            id_outlet: outlets,
                            status: 0
                        },
                        success: function(response){
                            if(response.status == 'success'){
                                toastr.info("Update success");
                                outlets.forEach(item => {
                                    const optionData = $(`option[value="${item}"]`);
                                    optionData.remove();
                                    const option = `<option value="${item}">${optionData.text()}</option>`;
                                    $('#global-price').append(option);
                                });
                            }else{
                                toastr.warning("Update fail");
                            }
                            block(false);
                        },
                        error: function(data){
                            toastr.warning("Update fail");
                            block(false);
                        }
                    });
                }else{
                    toastr.warning("No outlet selected");
                    block(false);
                }
            });
            $('.filter-form').on('submit',event => {
                event.preventDefault();
                reload();
            });
            $('.filter-form').submit();
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

    <div class="portlet light bordered to-block">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Outlet Different Price</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row">
                <div class="col-md-offset-9 col-md-3">
                    <form class="filter-form">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control search-field" name="keyword" placeholder="Search">
                                <div class="input-group-btn">
                                    <button class="btn blue search-btn" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <h3 class="text-center bold">Global Price</h3>
                    <div class="form-group">
                        <select name="" id="global-price" class="multiple-select form-control" multiple></select>
                    </div>
                </div>
                <div class="col-md-2" style="margin-top: 33vh">
                    <button class="btn blue btn-block text-center" id="btn-to-different"><i class="fa fa-arrow-right"></i></button>
                    <button class="btn blue btn-block text-center" id="btn-to-global"><i class="fa fa-arrow-left"></i></button>
                </div>
                <div class="col-md-5">
                    <h3 class="text-center bold">Different Price</h3>
                    <div class="form-group">
                        <select name="" id="different-price" class="multiple-select form-control" multiple></select>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
