@extends('layouts.main')

@section('page-style')
<style type="text/css">
    .sortable-handle {
        cursor: move;
    }
    tbody tr {
        background: white;
    }
</style>
@endsection

@section('page-script')
<script>
    var unsaved = false;
    function recolor() {
        const children = $('tbody').children();
        for (let i = 0; i < children.length; i++) {
            const child = children[i];
            if ($(child).find('[type="checkbox"]').prop('checked')) {
                $(child).removeClass('bg-grey');
            } else {
                $(child).addClass('bg-grey');
            }
        }
    }
    $(document).ready(function() {
        $(window).bind('beforeunload', function() {
            if(unsaved){
                return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
            }
        });

        // Monitor dynamic inputs
        
        $('.sortable').on('switchChange.bootstrapSwitch', ':input', function(){
            unsaved = true;
            recolor();
        });

        $('.sortable').sortable({
            handle: ".sortable-handle",
        });
        $( ".sortable" ).on( "sortchange", function() {unsaved=true;} );
        recolor();
    })
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
            <i class=" icon-layers font-green"></i>
            <span class="caption-subject font-green bold uppercase">Setting Delivery Method</span>
        </div>
    </div>
    <div class="portlet-body">
        <form class="form-horizontal" action="{{ url('transaction/setting/available-shipment') }}" method="post" id="form">
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Maximum Item for External Delivery
                <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimum order untuk delivery" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <input type="number" name="delivery_max_cup" value="{{$delivery_max_cup}}" class="form-control" value="50">
                    <span class="input-group-addon" id="basic-addon2">Cup</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Maximum Distance for Internal Delivery
                <i class="fa fa-question-circle tooltips" data-original-title="Jarak maksimum untuk delivery internal" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <input type="number" name="outlet_delivery_max_distance" value="{{$outlet_delivery_max_distance}}" class="form-control" value="50">
                    <span class="input-group-addon" id="basic-addon2">Meter</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Default Selected
                <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimum order untuk delivery" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-3">
                <select class="form-control" name="delivery_default">
                    <option value="price" @if($delivery_default == 'price') selected @endif>Lowest Price</option>
                    <option value="GO-SEND" @if($delivery_default == 'GO-SEND') selected @endif>GO-SEND</option>
                    <option value="Internal Delivery" @if($delivery_default == 'Internal Delivery') selected @endif>Internal Delivery</option>
                </select>
            </div>
        </div>
        <div class="alert alert-info">Drag [<i class="fa fa-ellipsis-h" style="transform: rotate(90deg);"></i>] handle button to reorder delivery method</div>            
            {{ csrf_field() }}
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Shipment Method</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="sortable">
                    @foreach($shipments as $key => $shipment)
                    <tr>
                        <td class="sortable-handle"><i class="fa fa-ellipsis-h" style="transform: rotate(90deg);"></i></td>
                        <td>{{$shipment['text']}}</td>
                        <td>
                            <input type="checkbox" name="shipments[{{$shipment['code']}}][status]" class="make-switch brand_visibility" data-size="small" data-on-color="info" data-on-text="Enable" data-off-color="default" data-off-text="Disable" value="1" {{$shipment['status']?'checked':''}}>
                        </td>
                        <input type="hidden" name="shipments[{{$shipment['code']}}][dummy]">
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="form-actions text-center">
                <button onclick="unsaved=false" class="btn green">
                    <i class="fa fa-check"></i> Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
