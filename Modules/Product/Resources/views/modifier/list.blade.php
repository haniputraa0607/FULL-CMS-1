<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');

 ?>
 @extends('layouts.main')
@include('list_filter')
@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />


    @endsection

    @section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    @yield('filter_script')
    <script type="text/javascript">
        rules = {
            all_product_modifier :{
                display:'All Product Modifier',
                operator:[],
                opsi:[]
            },
            code :{
                display:'Code',
                operator:[
                    ['=','='],
                    ['like','like']
                ],
                opsi:[]
            },
            text :{
                display:'Name',
                operator:[
                    ['=','='],
                    ['like','like']
                ],
                opsi:[]
            },
            modifier_type :{
                display:'Scope',
                operator:[],
                opsi:[
                    ['Global','Global'],
                    ['Specific','Specific']
                ]
            },
            type :{
                display:'Type',
                operator:[],
                opsi:[
                    ['Ice','Ice']
                ]
            },
            product_modifier_visibility :{
                display:'Default Visibility',
                operator:[],
                opsi:[
                    ['Visible','Visible'],
                    ['Hidden', 'Hidden']
                ]
            },
        };
        var manual = 1;
        $(document).ready(function(){
            $('table').on('switchChange.bootstrapSwitch','.default-visibility',function(){
                if(!manual){
                    manual=1;
                    return false;
                }
                var switcher=$(this);
                var newState=switcher.bootstrapSwitch('state');
                $.ajax({
                    method:'PATCH',
                    url:"{{url('product/modifier')}}/"+switcher.data('id'),
                    data:{
                        product_modifier_visibility:newState?1:0,
                        _token:"{{csrf_token()}}"
                    },
                    success:function(data){
                        if(data.status == 'success'){
                            toastr.info("Success update visibility");
                        }else{
                            manual=0;
                            toastr.warning("Fail update visibility");
                            switcher.bootstrapSwitch('state',!newState);
                        }
                    }
                }).fail(function(data){
                    manual=0;
                    toastr.warning("Fail update visibility");
                    switcher.bootstrapSwitch('state',!newState);
                });
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
    @yield('filter_view')
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">List Product Modifier</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover table-responsive" width="100%">
                <thead>
                    <tr>
                        <th> No </th>
                        <th> Code </th>
                        <th> Name </th>
                        <th> Scope </th>
                        <th> Type </th>
                        <th> Default Visibility </th>
                        @if(MyHelper::hasAccess([182,183,184], $grantedFeature))
                            <th> Action </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($modifiers['data']))
                        @foreach($modifiers['data'] as $modifier)
                            @php $start++  @endphp
                            <tr>
                                <td>{{$start}}</td>
                                <td>{{$modifier['code']}}</td>
                                <td>{{$modifier['text']}}</td>
                                <td>{{$modifier['modifier_type']}}</td>
                                <td>{{$modifier['type']}}</td>
                                <td><input type="checkbox" class="make-switch default-visibility" data-size="small" data-on-color="info" data-on-text="Visible" data-off-color="default" data-id="{{$modifier['id_product_modifier']}}" data-off-text="Hidden" value="1" @if($modifier['product_modifier_visibility']=='Visible') checked @endif></td>
                                @if(MyHelper::hasAccess([182,183,184], $grantedFeature))
                                <td>
                                    <form action="{{url('product/modifier/'.$modifier['id_product_modifier'])}}" method="POST" class="form-inline">
                                        {{method_field('DELETE')}}
                                        {{csrf_field()}}
                                        <button class="btn btn-sm red btnDelete" type="submit" data-toggle="confirmation"><i class="fa fa-trash"></i></button>
                                        <a href="{{url('product/modifier/'.$modifier['code'])}}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="8" class="text-center"><em class="text-muted">No modifiers found</em></td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="col-md-offset-8 col-md-4 text-right">
                <div class="pagination">
                    <ul class="pagination">
                         <li class="page-first{{$prev_page?'':' disabled'}}"><a href="{{$prev_page?:'javascript:void(0)'}}">«</a></li>
                        
                         <li class="page-last{{$next_page?'':' disabled'}}"><a href="{{$next_page?:'javascript:void(0)'}}">»</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>



@endsection