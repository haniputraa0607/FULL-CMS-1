@extends('layouts.main')

@section('page-style')
@endsection

@section('page-script')
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
            <span class="caption-subject font-dark sbold uppercase font-blue">User Rating Setting</span>
        </div>
    </div>
    <div class="portlet-body form form-horizontal" id="detailRating">
        <form action="#" method="POST">
            @csrf
            <div class="row">
                <label class="col-md-3 control-label text-right">Popup Interval Time <i class="fa fa-question-circle tooltips" data-original-title="Rentang waktu minimal ditampilkannya popup rating" data-container="body"></i></label>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="number" min="1" name="popup_min_interval" class="form-control" required value="{{old('popup_min_interval',$setting['popup_min_interval']['value']??'')}}" /><br/>
                            <span class="input-group-addon">
                                Minutes
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-md-3 control-label text-right">Maximum Refuse Popup <i class="fa fa-question-circle tooltips" data-original-title="Jumlah penolakan maksimal untuk memberikan rating. Setelah jumlah terlampaui, popup tidak akan ditampilkan lagi sampai ada transaksi baru lagi" data-container="body"></i></label>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="number" min="1" class="form-control" name="popup_max_refuse" required value="{{old('popup_max_refuse',$setting['popup_max_refuse']['value']??'')}}" /><br/>
                            <span class="input-group-addon">
                                Times
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-md-3 control-label text-right">Rating Question <i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan ditampilkan di atas pilihan bintang. Klik ikon ini untuk melihat detail." data-container="body" data-toggle="modal" data-target="#modalInfo"></i></label>
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="text" class="form-control" name="rating_question_text" required  value="{{old('rating_question_text',$setting['rating_question_text']['value_text']??'')}}" maxlength="40" /><br/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-3 col-md-5">
                    <div class="form-group">
                        <button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal" tabindex="-1" id="modalInfo" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{env('S3_URL_VIEW')}}img/setting/rating2_preview.png" style="max-height: 75vh">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection