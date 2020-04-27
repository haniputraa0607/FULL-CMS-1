@extends('layouts.main')

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js')}}"></script>
    <script>
        function submit(){
            var value = $('input[name=value]').val();

            if(Number(value) > 60){
                confirm('Maximal timer start is 60');
            }else if(Number(value) < 1){
                confirm('Minimum timer start is 1');
            }else{
                $( "#form" ).submit();
            }
        }
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

    <div class="portlet light form-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers font-green"></i>
                <span class="caption-subject font-green bold uppercase">Setting Timer OVO</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" action="{{ url('transaction/setting/timer-ovo') }}" method="post" id="form">
            {{ csrf_field() }}
            <div class="form-body">
                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Timer Start
                        <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="This value for setting start timer for payment OVO" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" placeholder="Maximal time is 60" maxlength="2" class="form-control price" name="value" value="@if(isset($result['value'])){{$result['value']}}@endif" required>
                    </div>
                </div>
            </div>
            </form>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-10">
                        <button onclick="submit()" class="btn green">
                            <i class="fa fa-check"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
