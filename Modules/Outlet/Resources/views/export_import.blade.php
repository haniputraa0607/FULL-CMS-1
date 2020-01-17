<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs    		= session('configs');

?>

@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        database={!!json_encode($brands)!!};
        valuex={single:[],combo:[]};
        @if($old=old('brands'))
            valuex["{{old('outlet_type','single')}}"]={!!json_encode($old)!!};
        @endif
            template={
            single:'\
            <div class="row"><div class="col-md-5 form-group">\
            %select%\
            </div><div class="col-md-1"><button data-id="%id%" class="btn btn-danger remover_btn" type="button"><i class="fa fa-times"></i></button></div></div>',
            combo:'\
            <div class="row">\
                <div class="col-md-5 form-group">%select0%\
                </div>\
                <div class="col-md-2 text-center control-label">AND</div>\
                <div class="col-md-5 form-group">%select1%\
                </div><div class="col-md-1"><button data-id="%id%" class="btn btn-danger remover_btn" type="button"><i class="fa fa-times"></i></button></div>\
            </div>'
        };
        function selectBrand(value){
            if(value=='all'){
                $('#select_brand_container').hide();
            }else{
                $('#select_brand_container').show();
            }
            var type=$('input[name="outlet_type"]:checked').val();
            renderer(type);
        }
        function add(type="single"){
            valuex[type].push({});
            renderer(type);
        }
        function remove(id,type="single"){
            valuex[type].splice(id,1);
            renderer(type);
        }
        function selectBuilder(name,value){
            var templatex='<select name="'+name+'" class="select2 form-control brand_selector" data-placeholder="Select Brand" required><option></option>%option%</select>';
            var option='';
            for(var i=0;i<database.length;i++){
                brand=database[i];
                if(value==brand.id_brand){var more="selected";}else{var more="";}
                option+='<option value="'+brand.id_brand+'" '+more+'>'+brand.name_brand+'</option>';
            }
            templatex=templatex.replace('%option%',option);
            return templatex;
        }
        function renderer(type="single"){
            var db=valuex[type];
            if(db&&db.length<=0&&type!="all"){
                return add(type);
            }
            var tpl=template[type];
            var html='';
            if(type=="single"){
                for(i=0;i<db.length;i++){
                    var name='brands['+i+'][0]';
                    var value='';
                    if(db[i][0]){
                        value=db[i][0];
                    }
                    var select=selectBuilder(name,value);
                    html+=tpl.replace('%select%',select).replace('%id%',i);
                }
            }else if(type=="combo"){
                for(i=0;i<db.length;i++){
                    for(j=0;j<2;j++){
                        var name='brands['+i+']['+j+']';
                        var value='';
                        if(db[i][j]){
                            value=db[i][j];
                        }
                        if(j==0){
                            var select0=selectBuilder(name,value);
                        }else{
                            var select1=selectBuilder(name,value);
                        }
                    }
                    html+=tpl.replace('%select0%',select0).replace('%select1%',select1).replace('%id%',i);
                }
            }
            $('#brand_inner_container').html(html);
            $('.select2').select2({
                placeholder:$(this).data('placeholder')
            });
        }
        $(document).ready(function(){
            $('.select2').select2({
                'placeholder':$(this).data('placeholder')
            });
            $('input[name="outlet_type"]').on('click',function(){
                var value=$('input[name="outlet_type"]:checked').val();
                selectBrand(value);
            });
            selectBrand($('input[name="outlet_type"]:checked').val());
            $('#add_btn').on('click',function(){
                var type=$('input[name="outlet_type"]:checked').val();
                if(type){
                    add(type);
                }
            });
            $('#select_brand_container').on('click','.remover_btn',function(){
                var id=$(this).data('id');
                var type=$('input[name="outlet_type"]:checked').val();
                remove(id,type);
            });
            $('#select_brand_container').on('change','.brand_selector',function(){
                var name=$(this).prop('name');
                var type=$('input[name="outlet_type"]:checked').val();
                var value=$(this).val();
                name=name.replace('brands','valuex["'+type+'"]');
                eval(name+'="'+value+'";');
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

    <div class="tab-pane" id="profileupdate">
        <div class="row profile-account">
            <div class="col-md-3">
                <ul class="ver-inline-menu tabbable margin-bottom-10">
                    <li class="active">
                        <a data-toggle="tab" href="#tab_1-1"><i class="fa fa-database"></i> Export </a>
                        <span class="after"> </span>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#tab_3-3"><i class="fa fa-database"></i> Import Outlet</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#tab_4-4"><i class="fa fa-database"></i> Import Brand Outlet </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <div id="tab_1-1" class="tab-pane active">
                        @if(MyHelper::hasAccess([33], $grantedFeature))
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject font-yellow sbold uppercase">Export Outlet</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <div class="m-heading-1 border-green m-bordered">
                                        <p>Anda bisa melakukan export data outlet. Export data dibagi menjadi 3 tipe :</p><br>
                                        <ul>
                                            <li>All : export semua data outlet dalam 1 sheet.</li>
                                            <li>Single : export outlet berdasarkan brand yang dipilih. Tiap brand akan dituliskan dalam sheet yang berbeda.</li>
                                            <li>Combo : export outlet berdasarkan brand yang dipilih. Tiap brand yang dipilih akan dituliskan dalam sheet yang berbeda. </li>
                                        </ul>
                                    </div>
                                    @if(MyHelper::hasAccess([24,25], $grantedFeature))
                                        @if(MyHelper::hasAccess([24,25], $grantedFeature))
                                            <form class="form-horizontal" role="form" action="{{url('outlet/export')}}" method="post">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Outlet Type <span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-9">
                                                        <div class="md-radio-inline">
                                                            <div class="md-radio">
                                                                <input type="radio" id="radio_all" name="outlet_type" class="md-radiobtn" value="all" required checked>
                                                                <label for="radio_all">
                                                                    <span></span>
                                                                    <span class="check"></span>
                                                                    <span class="box"></span> All </label>
                                                            </div>
                                                            <div class="md-radio">
                                                                <input type="radio" id="radio_single" name="outlet_type" class="md-radiobtn" value="single" required @if(old('outlet_type')=='single') checked @endif>
                                                                <label for="radio_single">
                                                                    <span></span>
                                                                    <span class="check"></span>
                                                                    <span class="box"></span> Single </label>
                                                            </div>
                                                            <div class="md-radio">
                                                                <input type="radio" id="radio_multiple" name="outlet_type" class="md-radiobtn" value="combo" required  @if(old('outlet_type')=='combo') checked @endif>
                                                                <label for="radio_multiple">
                                                                    <span></span>
                                                                    <span class="check"></span>
                                                                    <span class="box"></span> Combo </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group" id="select_brand_container">
                                                    <label class="col-md-3 control-label">Brand<span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-9" id="brand_inner_container"></div>
                                                    <div class="col-md-offset-3 col-md-9">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <button type="button" id="add_btn" class="btn blue">Add</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions">
                                                    {{ csrf_field() }}
                                                    <div class="row">
                                                        <div class="col-md-offset-3 col-md-9">
                                                            <div class="form-group">
                                                                <button type="submit" id="export_btn" class="btn green">Export</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <div id="tab_3-3" class="tab-pane">
                        @if(MyHelper::hasAccess([32], $grantedFeature))
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject font-yellow sbold uppercase">Import Outlet (Only in excel format)</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <div class="m-heading-1 border-green m-bordered">
                                        <p>Anda bisa menambahkan dan mengubah data outlet dengan menggunakan hasil  export diatas dengan tipe export <b style="color: red">All</b>.
                                        </p>
                                        <p style="color: red">Untuk kota silahkan menggunakan list kota yang ada dibawah ini, jika memasukkan kota yang tidak ada pada list maka data outlet tersebut akan gagal disimpan.</p>
                                    </div>
                                    @if(MyHelper::hasAccess([2], $configs))
                                        @if(MyHelper::hasAccess([32], $grantedFeature))
                                            <form class="form-horizontal" role="form" action="{{url('outlet/import')}}" method="post" enctype="multipart/form-data">
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">List City</label>
                                                        <div class="col-md-9">
                                                            <a href= "{{url('outlet/export-city')}}"> <i class="fa fa-file-excel-o"></i> Cities </a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Sample Data</label>
                                                        <div class="col-md-9">
                                                            <a href= "{{url('outlet/sample_data_outlet.xls')}}"> <i class="fa fa-file-excel-o"></i> Sample Import Outlet </a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">File Outlet <span class="required" aria-required="true"> * </span></label>
                                                        <div class="col-md-9">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="input-group input-large">
                                                                    <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                                        <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                                        <span class="fileinput-filename"> </span>
                                                                    </div>
                                                                    <span class="input-group-addon btn default btn-file">
                                                <span class="fileinput-new"> Select file </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="import_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required> </span>
                                                                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions">
                                                    {{ csrf_field() }}
                                                    <div class="row">
                                                        <div class="col-md-offset-3 col-md-9">
                                                            <button type="submit" class="btn green">Import</button>
                                                            <!-- <button type="button" class="btn default">Cancel</button> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <div id="tab_4-4" class="tab-pane">
                        @if(MyHelper::hasAccess([32], $grantedFeature))
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject font-yellow sbold uppercase">Import Brand Outlet (Only in excel format)</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <div class="m-heading-1 border-green m-bordered">
                                        <p>Anda bisa mengubah data brand outlet dengan contoh format excel dibawah ini. Data yang dibutuhkan untuk import brand adalah brand name dan outlet code.</p><br>
                                        Contoh data : <br><br>
                                        <table class="table table-striped table-bordered table-hover dt-responsive" width="30%">
                                            <thead>
                                            <tr>
                                                <th> code_outlet </th>
                                                <th> Brand 1 </th>
                                                <th> Brand 2 </th>
                                                <th> Brand 3 </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td> a01 </td>
                                                <td> YES </td>
                                                <td> NO </td>
                                                <td> YES </td>
                                            </tr>
                                            <tr>
                                                <td> a02 </td>
                                                <td> NO </td>
                                                <td> NO </td>
                                                <td> YES </td>
                                            </tr>
                                            <tr>
                                                <td> a03 </td>
                                                <td> YES </td>
                                                <td> NO </td>
                                                <td> YES </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @if(MyHelper::hasAccess([2], $configs))
                                        @if(MyHelper::hasAccess([32], $grantedFeature))
                                            <form class="form-horizontal" role="form" action="{{url('outlet/import-brand')}}" method="post" enctype="multipart/form-data">
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Export Brand</label>
                                                        <div class="col-md-9">
                                                            <a href= "{{url('outlet/export/brand-outlet')}}"> <i class="fa fa-file-excel-o"></i> Brand </a>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">File Brand Outlet <span class="required" aria-required="true"> * </span></label>
                                                        <div class="col-md-9">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="input-group input-large">
                                                                    <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                                        <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                                        <span class="fileinput-filename"> </span>
                                                                    </div>
                                                                    <span class="input-group-addon btn default btn-file">
                                                <span class="fileinput-new"> Select file </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="import_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required> </span>
                                                                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions">
                                                    {{ csrf_field() }}
                                                    <div class="row">
                                                        <div class="col-md-offset-3 col-md-9">
                                                            <button type="submit" class="btn green">Import</button>
                                                            <!-- <button type="button" class="btn default">Cancel</button> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection