@extends('layouts.main')

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
            <span class="caption-subject font-green bold uppercase">Contact Email for Refund Rejected Order</span>
        </div>
    </div>
    <div class="portlet-body">
        <form class="form-horizontal" action="{{ url()->current() }}" method="post" id="form">
            @csrf
            <div class="form-group">
                <div class="input-icon right">
                    <label class="col-md-3 control-label">
                    Contact Email
                    <i class="fa fa-question-circle tooltips" data-original-title="Alamat email yang akan ditampilkan untuk dihubungi customer ketika mengalami pembatalan transaksi karena delivery rejected" data-container="body"></i>
                    </label>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="string" name="transaction_email_contact" value="{{$transaction_email_contact}}" class="form-control">
                    </div>
                </div>
            </div>
            <hr/>
            <div class="form-group">
                <div class="input-icon right">
                    <label class="col-md-3 control-label">
                    </label>
                </div>
                <div class="col-md-3">
                    <button onclick="unsaved=false" class="btn green">
                        <i class="fa fa-check"></i> Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
