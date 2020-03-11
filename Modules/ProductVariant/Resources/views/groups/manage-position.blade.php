@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .sort-icon{
            margin-right: 5px;
        }
        .sort-icon:hover{
            cursor: move;
        }
        .sort-link{
            padding-left: 5px !important;
        }
        .sub-menu a{
            padding-left: 30px;
        }
        .sub-menu.active a,
        .sub-menu-parent.active a{
            color: #555;
            background-color: #eee;
        }
        .sub-menu-parent a{
            padding-left: 20px !important;
        }

        /* product list */
        .product-li{
            padding: 7px 15px;
            border: 1px solid #eee;
            margin-bottom: 15px;
        }
        .product-li:hover{
            background-color: #eee;
        }

    </style>
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            // ordering
            $("#sortable-category").sortable({
                stop: function (event, ui) {
                        sortCategory();
                    },
                items: "li:not(.ui-state-disabled)"
            });
            $(".sortable-category-sub").sortable({
                stop: function (event, ui) {
                        sortSubCategory(event);
                    },
                items: "li:not(.ui-state-disabled-sub)"
            });

            $(".sortable-product").sortable({
                stop: function (event, ui) {
                        sortProduct(event);
                    }
            });

            $("#sortable-category, .sortable-category-sub, .sortable-product").disableSelection();

        });

        var token = "{{ csrf_token() }}";

        // ajax sort category
        function sortCategory() {
            var ids = [];
            // get category id
            $("#sortable-category .main-menu").each(function() {
                var id = $(this).data('id');
                ids.push(id);
            });
            // console.log('ids', ids);

            var data = {_token: token, category_ids: ids};

            $.ajax({
                type : "POST",
                url : "{{ url('product/category/position/assign') }}",
                data : data,
                success : function(result) {
                    if (result.status == "success") {
                        toastr.info("Category has been sorted.");
                    }
                    else if(result.messages != ""){
                        toastr.warning(result.messages);
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to sort category.");
                    }
                }
            });
        }

        // ajax sort subcategory
        function sortSubCategory(e) {
            var ids = [];
            // get category id
            $(e.target).find(".sub-menu").each(function() {
                var id = $(this).data('id');
                ids.push(id);
            });
            console.log('ids', ids);
            var data = {_token: token, category_ids: ids};

            $.ajax({
                type : "POST",
                url : "{{ url('product/category/position/assign') }}",
                data : data,
                success : function(result) {
                    if (result.status == "success") {
                        toastr.info("Subcategory has been sorted.");
                    }
                    else if(result.messages != ""){
                        toastr.warning(result.messages);
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to sort subcategory.");
                    }
                }
            });
        }

        // ajax sort product
        function sortProduct(e) {
            var ids = [];
            // get product id
            $(e.target).find(".product-li").each(function() {
            // $("#sortable-product .main-menu").each(function() {
                var id = $(this).data('id');
                ids.push(id);
            });
            // console.log('ids', ids);

            var data = {_token: token, id_product_group: ids};

            $.ajax({
                type : "POST",
                url : "{{ url('product-variant/group/reorder') }}",
                data : data,
                success : function(result) {
                    if (result.status == "success") {
                        toastr.info("Product has been sorted.");
                    }
                    else if(result.messages != ""){
                        toastr.warning(result.messages);
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to sort product.");
                    }
                }
            });
        }

        // remove sub-menu active class when main-menu tab clicked
        $('.main-menu > a').on('click', function() {
            $('.sub-menu').each(function() {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                }
            });
        });
        // add & remove active class when sub-menu tab clicked
        $('.sub-menu').on('click', function() {
            $('.main-menu').each(function() {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                }
            });
            $(this).parents('.main-menu').addClass('active');
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">List Product Group By Position</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="alert alert-info">
                Drag and drop the item to sort products or categories
            </div>
            <div class="row">
                {{-- category --}}
                <div class="col-md-3 col-sm-3 col-xs-3 category-position">
                    <ul id="sortable-category" class="nav nav-tabs tabs-left">
                        @foreach($category as $key => $cat)
                            @if(empty($cat['child']))
                                <li class="main-menu {{ ($key==0 ? 'active' : '') }}" data-id="{{ $cat['id_product_category'] }}">
                                    <a href="#tab_{{$key}}" class="sort-link" data-toggle="tab">
                                        <i class="sort-icon fa fa-arrows"></i>
                                        {{$cat['product_category_name']}}
                                    </a>
                                </li>
                            @else
                            <li class="main-menu {{ ($key==0 ? 'active' : '') }}" data-id="{{ $cat['id_product_category'] }}">
                                <a href="#!" class="sort-link">
                                    <i class="sort-icon fa fa-arrows"></i>
                                    {{$cat['product_category_name']}}
                                </a>
                                <ul class="nav sortable-category-sub">
                                    <li class="sub-menu-parent ui-state-disabled-sub {{ ($key==0 ? 'active' : '') }}">
                                        <a href="#tab_{{$key}}" data-toggle="tab"> {{$cat['product_category_name']}} </a>
                                    </li>
                                    @foreach($cat['child'] as $keyC => $child)
                                    <li class="sub-menu ui-state-disabled" data-id="{{ $child['id_product_category'] }}">
                                        <a href="#tab_{{$key}}_{{$keyC}}" tabindex="-1" data-toggle="tab">
                                            <i class="sort-icon fa fa-arrows-v"></i>
                                            {{$child['product_category_name']}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                        @endforeach
                        <li class="ui-state-disabled">
                            <a href="#tab_X" data-toggle="tab"> Uncategorized </a>
                        </li>
                    </ul>
                </div>

                {{-- products --}}
                <div class="col-md-9 col-sm-9 col-xs-9 product-position">
                    <div class="tab-content">
                        @foreach($category as $key => $cat)
                            @if(empty($cat['child']))
                                <div class="tab-pane {{ ($key==0 ? 'active' : '') }}" id="tab_{{$key}}">
                                    <ul class="nav sortable-product">
                                        @if(!empty($product))
                                            @foreach($product as $value)
                                                @if (($value['id_product_category']??false) == $cat['id_product_category'])
                                                <li class="product-li" data-id="{{ $value['id_product_group'] }}">
                                                    <i class="sort-icon fa fa-arrows"></i>
                                                    {{ $value['product_group_name'] }}
                                                </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            @else
                                <div class="tab-pane {{ ($key==0 ? 'active' : '') }}" id="tab_{{$key}}">
                                    <ul class="nav sortable-product">
                                        @if(!empty($product))
                                            @foreach($product as $value)
                                                @if (($value['category'][0]['id_product_category']??false) == $cat['id_product_category'])
                                                <li class="product-li" data-id="{{ $value['id_product_group'] }}">
                                                    <i class="sort-icon fa fa-arrows"></i>
                                                    {{ $value['product_group_name'] }}
                                                </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                @foreach($cat['child'] as $keyC => $child)
                                <div class="tab-pane" id="tab_{{$key}}_{{$keyC}}">
                                    <ul class="nav sortable-product">
                                        @if(!empty($product))
                                            @foreach($product as $value)
                                                @if (($value['category'][0]['id_product_category']??false) == $child['id_product_category'])
                                                <li class="product-li" data-id="{{ $value['id_product_group'] }}">
                                                    <i class="sort-icon fa fa-arrows"></i>
                                                    {{ $value['product_group_name'] }}
                                                </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                @endforeach
                            @endif
                        @endforeach
                        <div class="tab-pane" id="tab_X">
                            <ul class="nav sortable-product">
                                @if(!empty($product))
                                    @foreach($product as $value)
                                        @if (empty($value['id_product_category']))
                                        <li class="product-li" data-id="{{ $value['id_product_group'] }}">
                                            <i class="sort-icon fa fa-arrows"></i>
                                            {{ $value['product_group_name'] }}
                                        </li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection