@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> --}}
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
          $('.summernote').summernote({
            placeholder: 'Category Description',
            tabsize: 2,
            toolbar: [
              ['style', ['style']],
              ['style', ['bold', 'underline', 'clear']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['insert', ['table']],
              ['insert', ['link', 'picture', 'video']],
              ['misc', ['fullscreen', 'codeview', 'help']]
            ],
            height: 120
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-dark sbold uppercase font-blue">New Promo Category</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name
                            <span class="required" aria-required="true"> *
                            </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama Kategori Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="input-icon right">
                                <input type="text" placeholder="Category Name" class="form-control" name="product_promo_category_name" value="{{ old('product_category_name') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Description
                            <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Kategori Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="input-icon right">
                                <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Kategori Produk" data-container="body"></i>
                                <textarea name="product_promo_category_description" class="form-control summernote">{{ old('product_category_description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    {{--
                    <div class="form-group">
                        <label class="col-md-3 control-label">Image <br> <span class="required" aria-required="true"> (300*300) </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar Kategori Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-1">
                            <div class="input-icon right">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                    <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                                <div>
                                      <span class="btn default btn-file">
                                      <span class="fileinput-new"> Select image </span>
                                      <span class="fileinput-exists"> Change </span>
                                      <input type="file" accept="image/*" name="product_category_photo">
                                      </span>
                                      <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    --}}
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection