@php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
@endphp

@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
      <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
@endsection

@section('content')
@php
  // print_r($point);die();
@endphp
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

    <form role="form" action="{{ url('transaction/balance/filter', date('Ymd')) }}" method="post">
        @include('transaction::log.log_balance_filter')
    </form>

    @include('layouts.notifications')

    @if (!empty($search))
        <div class="alert alert-block alert-info fade in">
            <button type="button" class="close" data-dismiss="alert"></button>
            <h4 class="alert-heading">Displaying search result :</h4>
                <p>{{ $count }}</p><br>
        <a href="{{ url('transaction/balance') }}" class="btn btn-sm btn-warning">Reset</a>
            <br>
        </div>
    @endif

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-red sbold uppercase">{{env('POINT_NAME', 'Points')}} Log User</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
            <thead>
              <tr>
                  <th>User Name</th>
                  <th>User Phone</th>
                  <th>{{env('POINT_NAME', 'Points')}}</th>
                  <th>Source</th>
                  <th>Grand Total</th>
                  <th>Cashback Convers</th>
                  <th>Membership</th>
                  <th>Cashback Percentage</th>
                  {{-- <th>Actions</th> --}}
              </tr>
            </thead>
            <tbody>
                @if(!empty($balance))
                    @foreach($balance as $res)
                        <tr>
                            @if (isset($res['user']['name']))
                                <td>{{ $res['user']['name'] }}</td>
                            @elseif(isset($res['name']))
                                <td>{{ $res['name'] }}</td>
                            @else
                                <td></td>
                            @endif
                            @if (isset($res['user']['phone']))
                                <td>{{ $res['user']['phone'] }}</td>
                            @elseif(isset($res['phone']))
                                <td>{{ $res['phone'] }}</td>
                            @else
                                <td></td>
                            @endif
                            <td>{{ number_format($res['balance']) }}</td>
                            <td>{{ ucwords($res['source']) }}</td>
                            <td>{{ number_format($res['grand_total']) }}</td>
                            <td>{{ number_format($res['ccashback_conversion']) }}</td>
                            <td>{{ $res['membership_level'] }}</td>
                            <td>{{ $res['membership_cashback_percentage'] }} %</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            </table>
                    @if ($balancePaginator)
                      {{ $balancePaginator->links() }}
                    @endif
        </div>
    </div>
@endsection
