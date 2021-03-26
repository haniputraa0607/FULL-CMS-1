@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
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
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
@endsection

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

    <h1 class="page-title" style="margin-top: 0px;">
        {{$sub_title}}
    </h1>
    @include('layouts.notifications')

    <?php
    $date_start = '';
    $date_end = '';

    if(Session::has('filter-list-gosend')){
        $search_param = Session::get('filter-list-gosend');
        if(isset($search_param['date_start'])){
            $date_start = $search_param['date_start'];
        }

        if(isset($search_param['date_end'])){
            $date_end = $search_param['date_end'];
        }

        if(isset($search_param['rule'])){
            $rule = $search_param['rule'];
        }

        if(isset($search_param['conditions'])){
            $conditions = $search_param['conditions'];
        }
    }
    ?>

    <form role="form" class="form-horizontal" action="{{url()->current()}}?filter=1" method="POST">
        {{ csrf_field() }}
        @include('report::report_gosend.filter_list')
    </form>

    <div class="m-heading-1 border-green m-bordered">
        <p>Default data yang ditampilkan adalah data dengan status <b>"Delivered"</b>. Untuk mencari data dengan status selain <b>"Delivered"</b>, Anda bisa menggunakan filter diatas dengan memilih subject "Status". Export akan menghasilkan data sesuai dengan list data yang tampil saat ini.</p>
        <p>Tombol export akan muncul jika list dibawah tersedia.</p>
    </div>

    <br>
    <div class="row">
        <div class="col-md-7"></div>
        <div class="col-md-5" style="text-align: center;">
            <div style="border: solid 1px black;">
                <h4><b>Total Price GoSend : {{number_format($sum)}}</b></h4>
            </div>
        </div>
    </div>
    <br>

    <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
        <table class="table table-striped table-bordered table-hover" id="tableReport">
            <thead>
            <tr>
                <th scope="col" width="10%"> Outlet </th>
                <th scope="col" width="10%"> Latest Status </th>
                <th scope="col" width="10%"> Link Tracking </th>
                <th scope="col" width="10%"> Transaction Date </th>
                <th scope="col" width="10%"> Receipt Number </th>
                <th scope="col" width="10%"> Order ID </th>
                <th scope="col" width="10%"> Grand Total </th>
                <th scope="col" width="10%"> Price GoSend </th>
                <th scope="col" width="10%"> Detail Receiver </th>
                <th scope="col" width="10%"> Detail Driver </th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($trx))
                @foreach($trx as $val)
                    <tr>
                        <td>{{$val['outlet_code']}} - {{$val['outlet_name']}}</td>
                        <td>
                            <?php
                            $latest_status = $val['latest_status'];
                            $arrStatus = [
                                'confirmed' => 'Booking is received',
                                'allocated' => 'Driver is found',
                                'out_for_pickup' => 'Driver is on their way to pick-up location',
                                'out_for_delivery' => 'Driver is enroute to deliver the item',
                                'cancelled' => 'Booking is cancelled by CS',
                                'delivered' => 'Delivered',
                                'no_driver' => 'Driver not found',
                                'Finding Driver' => 'Finding Driver'
                            ];

                            if(isset($arrStatus[$latest_status]) &&  !is_null($val['latest_status'])){
                                echo $arrStatus[$latest_status];
                            }else{
                                echo '-';
                            }
                            ?>
                        </td>
                        <td><a href="{{$val['live_tracking_url']}}" target="_blank">{{$val['live_tracking_url']}}</a></td>
                        <td>{{date("d F Y H:i", strtotime($val['transaction_date']))}}</td>
                        <td>
                            <a target="_blank" href="{{ url('transaction/detail/') }}/{{ $val['id_transaction'] }}/delivery">{{$val['transaction_receipt_number']}}</a>
                        </td>
                        <td>{{$val['order_id']}}</td>
                        <td>{{number_format($val['transaction_grandtotal'])}}</td>
                        <td>{{number_format($val['transaction_shipment'])}}</td>
                        <td>
                            Name : {{$val['destination_name']}}<br>
                            Phone : {{$val['destination_phone']}}<br>
                            Address : {{$val['destination_address']}}<br>
                        </td>
                        <td>
                            Driver Name : {{$val['driver_name']}}<br>
                            Driver Phone : {{$val['driver_phone']}}<br>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="10" style="text-align: center">Data Not Available</td></tr>
            @endif
            </tbody>
        </table>
    </div>
    <br>
    @if ($trxPaginator)
        {{ $trxPaginator->links() }}
    @endif
@endsection