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
            <span class="caption-subject font-green bold uppercase">Setting Payment Method</span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="alert alert-info">Drag [<i class="fa fa-ellipsis-h" style="transform: rotate(90deg);"></i>] handle button to reorder payment method</div>            <form class="form-horizontal" action="{{ url('transaction/setting/available-payment') }}" method="post" id="form">
            {{ csrf_field() }}
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Payment Gateway</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="sortable">
                    @foreach($payments as $key => $payment)
                    <tr>
                        <td class="sortable-handle"><i class="fa fa-ellipsis-h" style="transform: rotate(90deg);"></i></td>
                        <td>{{$payment['payment_gateway']}}</td>
                        <td>{{$payment['payment_method']}}</td>
                        <td>
                            <input type="checkbox" name="payments[{{$payment['code']}}][status]" class="make-switch brand_visibility" data-size="small" data-on-color="info" data-on-text="Enable" data-off-color="default" data-off-text="Disable" value="1" {{$payment['status']?'checked':''}}>
                        </td>
                        <input type="hidden" name="payments[{{$payment['code']}}][dummy]">
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
