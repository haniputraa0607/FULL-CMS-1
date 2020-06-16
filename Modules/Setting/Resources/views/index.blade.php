@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
          $('.summernote').summernote({
        placeholder: 'Setting',
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['style', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['insert', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['misc', ['fullscreen', 'codeview', 'help']]
        ],
        callbacks: {
            onImageUpload: function(files){
                sendFile(files[0], $(this).attr('id'));
            },
            onMediaDelete: function(target){
                var name = target[0].src;
                token = "<?php echo csrf_token(); ?>";
                $.ajax({
                    type: 'post',
                    data: 'filename='+name+'&_token='+token,
                    url: "{{url('summernote/picture/delete/setting')}}",
                    success: function(data){
                        // console.log(data);
                    }
                });
            }
        }
    });


    function sendFile(file, id){
        token = "<?php echo csrf_token(); ?>";
        var data = new FormData();
        data.append('image', file);
        data.append('_token', token);
        // document.getElementById('loadingDiv').style.display = "inline";
        $.ajax({
            url : "{{url('summernote/picture/upload/setting')}}",
            data: data,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(url) {
                if (url['status'] == "success") {
                    $('#'+id).summernote('editor.saveRange');
                    $('#'+id).summernote('editor.restoreRange');
                    $('#'+id).summernote('editor.focus');
                    $('#'+id).summernote('insertImage', url['result']['pathinfo'], url['result']['filename']);
                }
                // document.getElementById('loadingDiv').style.display = "none";
            },
            error: function(data){
                // document.getElementById('loadingDiv').style.display = "none";
            }
        })
    }
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

    <div class="portlet light form-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers font-green"></i>
                <span class="caption-subject font-green bold uppercase">{{ $sub_title }}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal form-bordered" action="{{ url('setting/update', $id) }}" method="post">
            	{{ csrf_field() }}
                <div class="form-body">
                    <div class="form-group last">
                    	<input type="hidden" name="key" value="{{ $key }}">
                        <label class="control-label col-md-{{$colLabel}}">
                            {{ $label }}
                            <i class="fa fa-question-circle tooltips" data-original-title="@if($label == 'Privacy Policy') Privacy Policy aplikasi dari perusahaan @elseif($label == 'Term Of Services') Term Of Services penggunaan aplikasi dari perusahaan @elseif($label == 'About') dapat diisi dengan profil perusahaan @elseif($label == 'Contact Us') dapat diisi dengan contact perusahaan @elseif($label == 'QR Code expires in') batas waktu qrcode valid @elseif($label == 'Time') waktu minimum yang dibutuhkan untuk menyiapkan pesanan @elseif($span == 'times') notifikasi gagal login akan dikirimkan ke user setelah berapa kali user gagal login @endif" data-container="body"></i>
                        </label>
                        <div class="col-md-{{$colInput}}">
                            @if($key == 'value_text')
                                <textarea class="form-control summernote" id="id_text" name="value">{!! $value !!}</textarea>
                            @else

                                @if(isset($span))
                                    <div class="input-group">
                                @endif
                                    <input type="text" name="value" class="form-control" value="{{ $value }}">
                                @if(isset($span))
                                    <span class="input-group-addon">
                                        {{$span}}
                                    </span>
                                @endif
                                @if(isset($span))
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-{{$colLabel}} col-md-10">
                            <button type="submit" class="btn green">
                                <i class="fa fa-check"></i> Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
