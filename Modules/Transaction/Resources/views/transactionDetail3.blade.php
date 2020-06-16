<?php
    use App\Lib\MyHelper;
    $configs = session('configs');
 ?>
@include('transaction::transaction.transaction_detail')
@extends('layouts.main')
@section('page-style')
@yield('sub-page-style')
@endsection

@section('page-script')

<script>

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

    @if(isset($data['detail']['order_id_qrcode']))
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content" style="border-radius: 42.3px; border: 0;">
                    <div class="modal-body">
                        <img class="img-responsive" style="display: block; width: 100%; padding: 30px" src="{{ $data['detail']['order_id_qrcode'] }}">
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- <div id="modal-usaha">
        <div class="modal-usaha-content">
        </div>
    </div> -->
    @yield('sub-content')

    </div>
@endsection
