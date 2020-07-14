<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');

 ?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/custom.js?'.date('YmdHis')) }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/service.js?'.date('YmdHis')) }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/discount.js?'.date('YmdHis')) }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/tax.js?'.date('YmdHis')) }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/point.js?'.date('YmdHis')) }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/cashback.js?'.date('YmdHis')) }}" type="text/javascript"></script>
@endsection

@section('content')
<input type="hidden" id="url" value="{{ env('APP_URL') }}transaction/setting/rule/update">
@php
    // print_r($default);die();
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

    @include('layouts.notifications')

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-red sbold uppercase">Transaction Rule</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="tabbable-line boxless tabbable-reversed">
                        <ul class="nav nav-tabs">
                            @if(MyHelper::hasAccess([58], $grantedFeature))
                                {{-- <li class="active">
                                    <a href="#tab_0" data-toggle="tab"> Grand Total </a>
                                </li> --}}
                            @endif
                            {{-- <li>
                                <a href="#tab_2" data-toggle="tab"> Discount </a>
                            </li> --}}
                            {{-- <li>
                                <a href="#tab_1" data-toggle="tab"> Service </a>
                            </li>
                            <li>
                                <a href="#tab_3" data-toggle="tab"> Tax </a>
                            </li> --}}
                            @if(MyHelper::hasAccess([18], $configs))
                            @if(MyHelper::hasAccess([59], $grantedFeature))
                                <li>
                                    <a href="#tab_4" data-toggle="tab"> Point </a>
                                </li>
                            @endif
                            @endif
                            @if(MyHelper::hasAccess([19], $configs))
                            @if(MyHelper::hasAccess([60], $grantedFeature))
                                <li>
                                    <a href="#tab_5" data-toggle="tab"> {{env('POINT_NAME', 'Points')}} </a>
                                </li>
                            @endif
                            @endif
                            {{-- <li>
                                <a href="#tab_6" data-toggle="tab"> Default Price Outlet </a>
                            </li> --}}
                        </ul>
                        {{ csrf_field() }}
                        <div class="tab-content">
                            <div class="tab-pane" id="tab_0">
                                <div class="portlet light bordered" style="padding-bottom: 40px">
                                    Grand total calculation of transactions (<b>Swap the button as you wish</b>)
                                    <i class="fa fa-question-circle tooltips" data-original-title="Urutan perhitungan dalam menghitung grand total dari setiap transaksi" data-container="body"></i>
                                    <div class="portlet-body form">
                                        <div class="form-body">
                                            <div class="col-md-2">
                                                <div id="item1" class="div-drag" >
                                                    {!! $button[0] !!}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div id="item2" draggable="true" class="div-drag" ondrop="drop(event)" ondragover="allowDrop(event)">
                                                    {!! $button[1] !!}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div id="item3" class="div-drag" ondrop="drop(event)" ondragover="allowDrop(event)">
                                                    {!! $button[2] !!}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div id="item4" class="div-drag" ondrop="drop(event)" ondragover="allowDrop(event)">
                                                    {!! $button[3] !!}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div id="item5" class="div-drag" ondrop="drop(event)" ondragover="allowDrop(event)">
                                                    {!! $button[4] !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet light bordered" style="padding-bottom: 40px">
                                    <i class="icon-trash" style="margin: 10px"> Trash (<b>Remove the unnecessary in the trash column</b>)
                                        <i class="fa fa-question-circle tooltips" data-original-title="kolom yang digunakan untuk membuang value tidak terpakai pada kolom diatas dalam menghitung grand total transaksi" data-container="body"></i></i>
                                    <div id="trash" ondrop="drop(event)" ondragover="allowDrop(event)" style="padding-bottom: 40px">
                                        @if (isset($trash))
                                            @foreach ($trash as $key => $row)
                                                {!! $row !!}
                                            @endforeach
                                        @endif
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane" id="tab_1">
                                <div class="portlet light bordered">
                                    <div class="portlet-body">
                                        <h3 class="">Service calculation of transactions
                                            <i class="fa fa-question-circle tooltips" data-original-title="Rumus untuk menghitung service transaksi" data-container="body"></i>
                                        </h3>
                                        <hr>
                                        <div class="m-grid m-grid-demo">
                                            <div class="m-grid-row">
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center">Value
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Klik salah satu value di samping untuk di masukkan kedalam kolom result dan dijadikan rumus" data-container="body"></i>
                                                </div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="subtotal" type="button" class="button-drag btn blue-hoki serviceValue" data-text="Subtotal" onclick="setService(event, 'subtotal')">Subtotal
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Hasil Subtotal Transaksi" data-container="body"></i>
                                                </button>
                                                </div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="discount" type="button" class="button-drag btn green-meadow serviceValue" data-text="Discount" onclick="setService(event, 'discount')">Discount
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total diskon Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="shipping" type="button" class="button-drag btn btn-success serviceValue" data-text="Shipping" onclick="setService(event, 'shipping')">Shipping
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total biaya pengiriman Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="tax" type="button" class="button-drag btn yellow-crusta serviceValue" data-text="Tax" onclick="setService(event, 'tax')">Tax
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total pajak Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="service" type="button" class="button-drag btn blue-madison" disabled>Service
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total service Transaksi" data-container="body"></i>
                                                </button></div>
                                            </div>
                                        </div>
                                        <div class="m-grid m-grid-demo">
                                            <div class="m-grid-row">
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center buttonOperator">Operators
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Operator digunakan jika dalam perhitunga rumus menggunakan lebih dari 1 value dan menghubungkan nilai antar value, cara penggunaan sama seperti pada kolom value" data-container="body"></i>
                                                </div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="kali" type="button" class="button-drag btn btn-default serviceOperator" data-text="*" onclick="setService(event, 'kali')">*</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="bagi" type="button" class="button-drag btn btn-default serviceOperator" data-text="/" onclick="setService(event, 'bagi')">/</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="tambah" type="button" class="button-drag btn btn-default serviceOperator" data-text="+" onclick="setService(event, 'tambah')">+</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="kurang" type="button" class="button-drag btn btn-default serviceOperator" data-text="-" onclick="setService(event, 'kurang')">-</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="kbuka" type="button" class="button-drag btn btn-default serviceKbuka" data-text="(" onclick="setService(event, 'kbuka')">(</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="ktutup" type="button" class="button-drag btn btn-default serviceKtutup" data-text=")" onclick="setService(event, 'ktutup')">)</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center buttonDelete"><button id="delete" type="button" class="button-drag btn btn-danger serviceDelete">Delete
                                                <i class="fa fa-question-circle tooltips" data-original-title="Tombol delete digunakan jika rumus yang sudah dimasukkan pada kolom result salah" data-container="body"></i></button></div>
                                            </div>
                                        </div><br>
                                        <div class="m-grid m-grid-demo">
                                        <div class="m-grid-row">
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-2">Result
                                                <i class="fa fa-question-circle tooltips" data-original-title="Hasil akhir yang akan digunakan untuk menghitung service transaksi" data-container="body"></i>
                                            </div>
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-8">
                                                <div id="targetService">
                                                    @if (isset($service['data']))
                                                        @foreach ($service['data'] as $key => $result)
                                                            @if ($result != '')
                                                                <button style="color: <?php echo $service['attrColor'][$key]; ?>" id="result<?php echo $service['attrKey'][$key]; ?>" type="button" class="button-drag btn btn-default"><?php echo ucwords($result); ?></button>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-2">Value
                                                <i class="fa fa-question-circle tooltips" data-original-title="persen service digunakan untuk menghitung hasil akhir dari service" data-container="body"></i>
                                                <div class="input-group" style="margin: 20px">
                                                    <input id="persen" type="text" class="form-control servicePersen" placeholder="value" value="{{ $service['value']*100 }}">
                                                    <span class="input-group-addon">
                                                        %
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_2">
                                <div class="portlet light bordered">
                                    <div class="portlet-body">
                                        <h3 class="">Discount calculation of transactions
                                            <i class="fa fa-question-circle tooltips" data-original-title="Rumus untuk menghitung diskon transaksi" data-container="body"></i>
                                        </h3>
                                        <hr>
                                        <div class="m-grid m-grid-demo">
                                            <div class="m-grid-row">
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center">Value
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Klik salah satu value di samping untuk di masukkan kedalam kolom result dan dijadikan rumus" data-container="body"></i>
                                                </div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="subtotal" type="button" class="button-drag btn blue-hoki discountValue" data-text="Subtotal" onclick="setDiscount(event, 'subtotal')">Subtotal
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Hasil Subtotal Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="shipping" type="button" class="button-drag btn btn-success discountValue" data-text="Shipping" onclick="setDiscount(event, 'shipping')">Shipping
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total biaya pengiriman Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="tax" type="button" class="button-drag btn yellow-crusta discountValue" data-text="Tax" onclick="setDiscount(event, 'tax')">Tax
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total pajak Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="service" type="button" class="button-drag btn blue-madison discountValue" data-text="Service" onclick="setDiscount(event, 'service')">Service
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total service Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="discount" type="button" class="button-drag btn green-meadow" disabled>Discount
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total diskon Transaksi" data-container="body"></i>
                                                </button></div>
                                            </div>
                                        </div>
                                        <div class="m-grid m-grid-demo">
                                            <div class="m-grid-row">
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center buttonOperator">Operators
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Operator digunakan jika dalam perhitunga rumus menggunakan lebih dari 1 value dan menghubungkan nilai antar value, cara penggunaan sama seperti pada kolom value" data-container="body"></i>
                                                </div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="kali" type="button" class="button-drag btn btn-default discountOperator" data-text="*" onclick="setDiscount(event, 'kali')">*</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="bagi" type="button" class="button-drag btn btn-default discountOperator" data-text="/" onclick="setDiscount(event, 'bagi')">/</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="tambah" type="button" class="button-drag btn btn-default discountOperator" data-text="+" onclick="setDiscount(event, 'tambah')">+</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="kurang" type="button" class="button-drag btn btn-default discountOperator" data-text="-" onclick="setDiscount(event, 'kurang')">-</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="kbuka" type="button" class="button-drag btn btn-default discountKbuka" data-text="(" onclick="setDiscount(event, 'kbuka')">(</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="ktutup" type="button" class="button-drag btn btn-default discountKtutup" data-text=")" onclick="setDiscount(event, 'ktutup')">)</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center buttonDelete"><button id="delete" type="button" class="button-drag btn btn-danger discountDelete">Delete
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Tombol delete digunakan jika rumus yang sudah dimasukkan pada kolom result salah" data-container="body"></i>
                                                </button></div>
                                            </div>
                                        </div><br>
                                        <div class="m-grid m-grid-demo">
                                        <div class="m-grid-row">
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-2">Result
                                                <i class="fa fa-question-circle tooltips" data-original-title="Hasil akhir yang akan digunakan untuk menghitung diskon transaksi" data-container="body"></i>
                                            </div>
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-6">
                                                <div id="targetDiscount">
                                                    @if (isset($discount['data']))
                                                        @foreach ($discount['data'] as $key => $result)
                                                            @if ($result != '')
                                                                <button style="color: <?php echo $discount['attrColor'][$key]; ?>" id="result<?php echo $discount['attrKey'][$key];; ?>" type="button" class="button-drag btn btn-default"><?php echo ucwords($result); ?></button>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-2">Percent
                                                <i class="fa fa-question-circle tooltips" data-original-title="Diskon persen yang didapat user" data-container="body"></i>
                                                <div class="input-group" style="margin: 20px">
                                                    <input id="persen" type="text" class="form-control discountPercent" placeholder="value" value="{{ $discount['percent'] }}">
                                                    <span class="input-group-addon">
                                                        %
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-2">Nominal
                                                <i class="fa fa-question-circle tooltips" data-original-title="Diskon nominal yang didapat user" data-container="body"></i>
                                                <div class="input-group" style="margin: 20px">
                                                    <input id="cashbackMax" type="text" class="form-control discountNominal" placeholder="value" value="{{ $discount['nominal'] }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_3">
                                <div class="portlet light bordered">
                                    <div class="portlet-body">
                                        <h3 class="">Tax calculation of transactions
                                            <i class="fa fa-question-circle tooltips" data-original-title="Rumus untuk menghitung pajak transaksi" data-container="body"></i></h3>
                                        <hr>
                                        <div class="m-grid m-grid-demo">
                                            <div class="m-grid-row">
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center">Value
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Klik salah satu value di samping untuk di masukkan kedalam kolom result dan dijadikan rumus" data-container="body"></i>
                                                </div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="subtotal" type="button" class="button-drag btn blue-hoki taxValue" data-text="Subtotal" onclick="setTax(event, 'subtotal')">Subtotal
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Hasil Subtotal Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="discount" type="button" class="button-drag btn green-meadow taxValue" data-text="Discount" onclick="setTax(event, 'discount')">Discount
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total diskon Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="shipping" type="button" class="button-drag btn btn-success taxValue" data-text="Shipping" onclick="setTax(event, 'shipping')">Shipping
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total biaya pengiriman Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="service" type="button" class="button-drag btn blue-madison taxValue" data-text="Service" onclick="setTax(event, 'service')">Service
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total service Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="tax" type="button" class="button-drag btn yellow-crusta" disabled>Tax
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total pajak Transaksi" data-container="body"></i>
                                                </button></div>
                                            </div>
                                        </div>
                                        <div class="m-grid m-grid-demo">
                                            <div class="m-grid-row">
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center buttonOperator">Operators
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Operator digunakan jika dalam perhitunga rumus menggunakan lebih dari 1 value dan menghubungkan nilai antar value, cara penggunaan sama seperti pada kolom value" data-container="body"></i>
                                                </div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="kali" type="button" class="button-drag btn btn-default taxOperator" data-text="*" onclick="setTax(event, 'kali')">*</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="bagi" type="button" class="button-drag btn btn-default taxOperator" data-text="/" onclick="setTax(event, 'bagi')">/</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="tambah" type="button" class="button-drag btn btn-default taxOperator" data-text="+" onclick="setTax(event, 'tambah')">+</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="kurang" type="button" class="button-drag btn btn-default taxOperator" data-text="-" onclick="setTax(event, 'kurang')">-</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="kbuka" type="button" class="button-drag btn btn-default taxKbuka" data-text="(" onclick="setTax(event, 'kbuka')">(</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="ktutup" type="button" class="button-drag btn btn-default taxKtutup" data-text=")" onclick="setTax(event, 'ktutup')">)</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center buttonDelete"><button id="delete" type="button" class="button-drag btn btn-danger taxDelete">Delete
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Tombol delete digunakan jika rumus yang sudah dimasukkan pada kolom result salah" data-container="body"></i>
                                                </button></div>
                                            </div>
                                        </div><br>
                                        <div class="m-grid m-grid-demo">
                                        <div class="m-grid-row">
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-2">Result
                                                <i class="fa fa-question-circle tooltips" data-original-title="Hasil akhir yang akan digunakan untuk menghitung pajak transaksi" data-container="body"></i>
                                            </div>
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-8">
                                                <div id="targetTax">
                                                    @if (isset($tax['data']))
                                                        @foreach ($tax['data'] as $key => $result)
                                                            @if ($result != '')
                                                                <button style="color: <?php echo $tax['attrColor'][$key]; ?>" id="result<?php echo $tax['attrKey'][$key];; ?>" type="button" class="button-drag btn btn-default"><?php echo ucwords($result); ?></button>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-2">Value
                                                <i class="fa fa-question-circle tooltips" data-original-title="persen pajak digunakan untuk menghitung hasil akhir dari pajak" data-container="body"></i>
                                                <div class="input-group" style="margin: 20px">
                                                    <input id="persen" type="text" class="form-control taxPersen" placeholder="value" value="{{ $tax['value']*100 }}">
                                                    <span class="input-group-addon">
                                                        %
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_4">
                                <div class="portlet light bordered">
                                    <div class="portlet-body">
                                        <h3 class="">Point calculation of transactions
                                            <i class="fa fa-question-circle tooltips" data-original-title="Rumus untuk menghitung point transaksi" data-container="body"></i></h3>
                                        <hr>
                                        <div class="m-grid m-grid-demo">
                                            <div class="m-grid-row">
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center">Value
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Klik salah satu value di samping untuk di masukkan kedalam kolom result dan dijadikan rumus" data-container="body"></i>
                                                </div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="subtotal" type="button" class="button-drag btn blue-hoki pointValue" data-text="Subtotal" onclick="setPoint(event, 'subtotal')">Subtotal
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Hasil Subtotal Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="shipping" type="button" class="button-drag btn btn-success pointValue" data-text="Shipping" onclick="setPoint(event, 'shipping')">Shipping
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total biaya pengiriman Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="tax" type="button" class="button-drag btn yellow-crusta pointValue" data-text="Tax" onclick="setPoint(event, 'tax')">Tax
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total pajak Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="service" type="button" class="button-drag btn blue-madison pointValue" data-text="Service" onclick="setPoint(event, 'service')">Service
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total service Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="discount" type="button" class="button-drag btn green-meadow pointValue" data-text="Discount" onclick="setPoint(event, 'discount')">Discount
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total diskon Transaksi" data-container="body"></i>
                                                </button></div>
                                            </div>
                                        </div>
                                        <div class="m-grid m-grid-demo">
                                            <div class="m-grid-row">
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center buttonOperator">Operators
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Operator digunakan jika dalam perhitunga rumus menggunakan lebih dari 1 value dan menghubungkan nilai antar value, cara penggunaan sama seperti pada kolom value" data-container="body"></i>
                                                </div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="kali" type="button" class="button-drag btn btn-default pointOperator" data-text="*" onclick="setPoint(event, 'kali')">*</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="bagi" type="button" class="button-drag btn btn-default pointOperator" data-text="/" onclick="setPoint(event, 'bagi')">/</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="tambah" type="button" class="button-drag btn btn-default pointOperator" data-text="+" onclick="setPoint(event, 'tambah')">+</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="kurang" type="button" class="button-drag btn btn-default pointOperator" data-text="-" onclick="setPoint(event, 'kurang')">-</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="kbuka" type="button" class="button-drag btn btn-default pointKbuka" data-text="(" onclick="setPoint(event, 'kbuka')">(</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="ktutup" type="button" class="button-drag btn btn-default pointKtutup" data-text=")" onclick="setPoint(event, 'ktutup')">)</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center buttonDelete"><button id="delete" type="button" class="button-drag btn btn-danger pointDelete">Delete
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Tombol delete digunakan jika rumus yang sudah dimasukkan pada kolom result salah" data-container="body"></i>
                                                </button></div>
                                            </div>
                                        </div><br>
                                        <div class="m-grid m-grid-demo">
                                        <div class="m-grid-row">
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-2">Result
                                                <i class="fa fa-question-circle tooltips" data-original-title="Hasil akhir yang akan digunakan untuk menghitung point tiap transaksi" data-container="body"></i>
                                            </div>
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-7">
                                                <div id="targetPoint">
                                                    @if (isset($point['data']))
                                                        @foreach ($point['data'] as $key => $result)
                                                            @if ($result != '')
                                                                <button style="color: <?php echo $point['attrColor'][$key]; ?>" id="result<?php echo $point['attrKey'][$key];; ?>" type="button" class="button-drag btn btn-default"><?php echo ucwords($result); ?></button>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-3">Point Conversion
                                                <i class="fa fa-question-circle tooltips" data-original-title="Total perhitangan tukar transaksi menjadi point untuk user" data-container="body"></i>
                                                <div class="input-group" style="margin: px">
                                                    <input id="persen" type="text" class="form-control pointPersen" placeholder="value" value="{{ $point['value'] }}">
                                                    <span class="input-group-addon">
                                                        {{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}} = 1 Point
                                                    </span>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane active" id="tab_5">
                                <div class="portlet light bordered">
                                    <div class="portlet-body">
                                        <h3 class="">{{env('POINT_NAME', 'Points')}} calculation of transactions
                                            <i class="fa fa-question-circle tooltips" data-original-title="Rumus untuk menghitung cashback transaksi" data-container="body"></i></h3>
                                        <hr>
                                        <div class="m-grid m-grid-demo" style="display: none">
                                            <div class="m-grid-row">
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center">Value
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Klik salah satu value di samping untuk di masukkan kedalam kolom result dan dijadikan rumus" data-container="body"></i>
                                                </div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="subtotal" type="button" class="button-drag btn blue-hoki cashbackValue" data-text="Subtotal" onclick="setCashback(event, 'subtotal')">Subtotal
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Hasil Subtotal Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="shipping" type="button" class="button-drag btn btn-success cashbackValue" data-text="Shipping" onclick="setCashback(event, 'shipping')">Shipping
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total biaya pengiriman Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="tax" type="button" class="button-drag btn yellow-crusta cashbackValue" data-text="Tax" onclick="setCashback(event, 'tax')">Tax
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total pajak Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="service" type="button" class="button-drag btn blue-madison cashbackValue" data-text="Service" onclick="setCashback(event, 'service')">Service
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total service Transaksi" data-container="body"></i>
                                                </button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="discount" type="button" class="button-drag btn green-meadow cashbackValue" data-text="Discount" onclick="setCashback(event, 'discount')">Discount
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Total diskon Transaksi" data-container="body"></i>
                                                </button></div>
                                            </div>
                                        </div>
                                        <div class="m-grid m-grid-demo" style="display: none">
                                            <div class="m-grid-row">
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center buttonOperator">Operators
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Operator digunakan jika dalam perhitunga rumus menggunakan lebih dari 1 value dan menghubungkan nilai antar value, cara penggunaan sama seperti pada kolom value" data-container="body"></i>
                                                </div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="kali" type="button" class="button-drag btn btn-default cashbackOperator" data-text="*" onclick="setCashback(event, 'kali')">*</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="bagi" type="button" class="button-drag btn btn-default cashbackOperator" data-text="/" onclick="setCashback(event, 'bagi')">/</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="tambah" type="button" class="button-drag btn btn-default cashbackOperator" data-text="+" onclick="setCashback(event, 'tambah')">+</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="kurang" type="button" class="button-drag btn btn-default cashbackOperator" data-text="-" onclick="setCashback(event, 'kurang')">-</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="kbuka" type="button" class="button-drag btn btn-default cashbackKbuka" data-text="(" onclick="setCashback(event, 'kbuka')">(</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="ktutup" type="button" class="button-drag btn btn-default cashbackKtutup" data-text=")" onclick="setCashback(event, 'ktutup')">)</button></div>
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center buttonDelete"><button id="delete" type="button" class="button-drag btn btn-danger cashbackDelete">Delete
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Tombol delete digunakan jika rumus yang sudah dimasukkan pada kolom result salah" data-container="body"></i>
                                                </button></div>
                                            </div>
                                        </div><br>
                                        <div class="m-grid m-grid-demo">
                                        <div class="m-grid-row">
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-2">Result
                                                <i class="fa fa-question-circle tooltips" data-original-title="Hasil akhir yang akan digunakan untuk menghitung cashback untuk user" data-container="body"></i>
                                            </div>
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-6" style="display: none">
                                                <div id="targetCashback">
                                                    @if (isset($cashback['data']))
                                                        @foreach ($cashback['data'] as $key => $result)
                                                            @if ($result != '')
                                                                <button style="color: <?php echo $cashback['attrColor'][$key]; ?>" id="result<?php echo $cashback['attrKey'][$key];; ?>" type="button" class="button-drag btn btn-default"><?php echo ucwords($result); ?></button>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-2">{{env('POINT_NAME', 'Points')}} Conversion
                                                <i class="fa fa-question-circle tooltips" data-original-title="Total perhitangan cashback yang didapat user" data-container="body"></i>
                                                <div class="input-group" style="margin: 20px">
                                                    <input id="persen" type="text" class="form-control cashbackPersen" placeholder="value" value="{{ $cashback['value']*100 }}">
                                                    <span class="input-group-addon">
                                                        %
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-2">{{env('POINT_NAME', 'Points')}} Maximum
                                                <i class="fa fa-question-circle tooltips" data-original-title="Total maksimal cashback yang didapat user" data-container="body"></i>
                                                <div class="input-group" style="margin: 20px">
                                                    <input id="cashbackMax" type="text" class="form-control cashbackMax" placeholder="value" value="{{ $cashback['max'] }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_6">
                                <div class="portlet light bordered">
                                    <div class="portlet-body">
                                        <form class="form-horizontal" role="form" action="{{ url('transaction/setting/rule/update') }}" method="post" enctype="multipart/form-data" id="form">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Select Outlet</label>
                                                    <div class="col-md-9">
                                                        <select id="multiple" class="form-control select2-multiple outlet" name="id_outlet" data-placeholder="select outlet" required>
                                                            <optgroup label="Outlet List">
                                                                @if (!empty($outlet))
                                                                    @foreach($outlet as $suw)
                                                                        <option value="{{ $suw['id_outlet'] }}" @if ($default == $suw['id_outlet']) selected @endif>{{ $suw['outlet_name'] }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
