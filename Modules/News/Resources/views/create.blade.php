<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');
 ?>
@extends('layouts.main-closed')

@section('page-style')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOHBNv3Td9_zb_7uW-AJDU6DHFYk-8e9Y&v=3.exp&signed_in=true&libraries=places"></script>

    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css" />
   <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/typeahead/typeahead.css')}}" rel="stylesheet" type="text/css" />
	 <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css')}}" rel="stylesheet" type="text/css" />

   <style type="text/css">
     .sort-icon{
      position: absolute;
      top: 7px;
      left: 0px;
      z-index: 10;
      color: #777;
      cursor: move;
     }
     .mt-checkbox.mt-checkbox-outline{
      margin-bottom: 7px;
     }
     input[type="time"].form-control{
      line-height: normal;
     }
     .datepicker{
      padding: 6px 12px;
     }
   </style>
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/typeahead/handlebars.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/typeahead/typeahead.bundle.min.js') }}" type="text/javascript"></script>
     <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
    <script>

     $('.datepicker').datepicker({
        'format' : 'd-M-yyyy',
        'todayHighlight' : true,
        'autoclose' : true
    });
        var map;

        @if (!empty(old('news_event_latitude')))
          var lat = "{{old('news_event_latitude')}}";
        @else
          var lat = "-7.7972";
        @endif

        @if (!empty(old('news_event_longitude')))
          var long = "{{old('news_event_longitude')}}";
        @else
          var long = "110.3688";
        @endif

        var markers = [];

        function initialize() {
          var haightAshbury = new google.maps.LatLng(lat,long);
          var marker        = new google.maps.Marker({
              position:new google.maps.LatLng(lat,long),
              map: map,
              anchorPoint: new google.maps.Point(0, -29)
          });

          var mapOptions = {
              zoom: 12,
              center: haightAshbury,
              mapTypeId: google.maps.MapTypeId.ROADMAP
          };

          var infowindow = new google.maps.InfoWindow({
              content: '<p>Marker Location:</p>'
          });

          map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

          var input = /** @type  {HTMLInputElement} */(
              document.getElementById('pac-input'));

              var types = document.getElementById('type-selector');
              map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
              map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

              var autocomplete = new google.maps.places.Autocomplete(input);

              autocomplete.bindTo('bounds', map);

              var infowindow = new google.maps.InfoWindow();

              google.maps.event.addListener(autocomplete, 'place_changed', function() {
              deleteMarkers();
              infowindow.close();
              marker.setVisible(true);
              var place = autocomplete.getPlace();
              if (!place.geometry) {
                  return;
              }

            // If the place has a geometry, then present it on a map.
              if (place.geometry.viewport) {
                  map.fitBounds(place.geometry.viewport);
              } else {
                  map.setCenter(place.geometry.location);
                  map.setZoom(17);  // Why 17? Because it looks good.
              }
                  addMarker(place.geometry.location);
              });

              google.maps.event.addListener(map, 'click', function(event) {

              deleteMarkers();
              addMarker(event.latLng);
              marker.openInfoWindowHtml(latLng);
              infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
              infowindow.open(map, marker);
          });
          // Adds a marker at the center of the map.
          addMarker(haightAshbury);
        }

        function placeMarker(location) {
          marker = new google.maps.Marker({
            position: location,
            map: map,
          });

          markers.push(marker);

          infowindow = new google.maps.InfoWindow({
             content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()
          });
          infowindow.open(map,marker);
        }

        // Add a marker to the map and push to the array.

        function addMarker(location) {
          var marker = new google.maps.Marker({
            position: location,
            map: map
          });

          $('#lat').val(location.lat());
          $('#lng').val(location.lng());
          markers.push(marker);
        }

        // Sets the map on all markers in the array.

        function setAllMap(map) {
          for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
          }
        }

        // Removes the markers from the map, but keeps them in the array.
        function clearMarkers() {
          setAllMap(null);
        }

        // Shows any markers currently in the array.
        function showMarkers() {
          setAllMap(map);
        }

        // Deletes all markers in the array by removing references to them.
        function deleteMarkers() {
          clearMarkers();
          markers = [];
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <script type="text/javascript">
        var video={!!json_encode(old('news_video',[]))!!};
        var video_template="<div class=\"input-group\" style=\"margin-bottom:5px\">\
          <input name=\"news_video[]\" type=\"url\" class=\"form-control featureVideoForm video-content\" id=\"newsVideo%id%\" placeholder=\"Example: https://www.youtube.com/watch?v=u9_2wWSOQ\" value=\"%value%\"  data-id=\"%id%\" required>\
          <span class=\"input-group-btn\">\
            <button class=\"btn btn-danger remove-video-btn\" type=\"button\" data-id=\"%id%\"><i class=\"fa fa-times\"></i></button>\
          </span>\
        </div>";
        var video_template_2= "<input name=\"news_video[]\" type=\"url\" class=\"form-control featureVideoForm video-content\" id=\"newsVideo%id%\" placeholder=\"Example: https://www.youtube.com/watch?v=u9_2wWSOQ\" value=\"%value%\"  data-id=\"%id%\" required>";

        function drawVideo(){
          if(video.length<=0){
            return addVideo();
          }
          var html="";
          @if(MyHelper::hasAccess([106], $configs))
          video.forEach(function(vrb,id){
            html+=video_template.replace(/%id%/g,id).replace('%value%',vrb);
          });
          @else
          video.forEach(function(vrb,id){
              html+=video_template_2.replace(/%id%/g,id).replace('%value%',vrb);
          });
          @endif
          $('#video-container').html(html);
        }

        function addVideo(){
          video.push('');
          drawVideo();
        }

        $(document).ready(function() {
            token = '<?php echo csrf_token()?>';

            $('.summernote').summernote({
                placeholder: 'News Content Long',
                tabsize: 2,
                height: 120,
                fontNames: ['Open Sans'],
                callbacks: {
                    onFocus: function() {
                        $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/content-long.jpg')}}")
                    },
                    onImageUpload: function(files){
                        sendFile(files[0], $(this).attr('id'));
                    },
                    onMediaDelete: function(target){
                        var name = target[0].src;
                        token = "<?php echo csrf_token(); ?>";
                        $.ajax({
                            type: 'post',
                            data: 'filename='+name+'&_token='+token,
                            url: "{{url('summernote/picture/delete/news')}}",
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
                    url : "{{url('summernote/picture/upload/news')}}",
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

            /* INIT JS */
            // $('.featureOutlet').hide();
            // $('.featureLocation').hide();
            // $('.featureProduct').hide();
            // $('.featureTreatment').hide();
            // $('.featureDate').hide();
            // $('.featureTime').hide();

            /* BUTTON TO TEXT */
            @if (empty(old('news_button_form_text')))
              $('.featureForm').hide();
            @else
              $('.featureForm').show();
              $('.featureFormForm').prop('required',true);
            @endif

            /* featureForm: show/hide input types */
            $('.featureForm').on('change', '.form_input_types', function() {
              var parent = $(this).parents('.mt-repeater-cell');
              var type = $(this).val();

              if( !(type == "Dropdown Choice" || type == "Radio Button Choice" || type == "Multiple Choice") ){
                parent.find('.form_input_options').hide();
                parent.find('.form_input_options input').prop('required',false);
              }
              else{
                parent.find('.form_input_options').show();
                parent.find('.form_input_options input').prop('required',true);
              }

              if( type == "Short Text" || type == "Long Text" || type == "Date" ){
                parent.find('.form_input_autofill').show();
              }
              else{
                parent.find('.form_input_autofill').hide();
              }

              // is unique
              if( type == "Short Text" || type == "Long Text" || type == "Number Input" ){
                parent.find('.is_unique').show();
              }
              else{
                parent.find('.is_unique').hide();
              }
            });

            // required tagsinput options
            $('.featureForm').on('itemAdded', '.tagsinput', function(event) {
                $(this).prop('required',false);
                $(this).prev().find('input').prop('required',false);
            });

            // unrequired tagsinput options
            $('.featureForm').on('itemRemoved', '.tagsinput', function(event) {
              if ($(this).val() == ""){
                $(this).prop('required',true);
                $(this).prev().find('input').prop('required',true);
              }
            });

            /* sortable */
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();

			/* OUTLET */
            @if (empty(old('news_outlet_text')))
              $('.featureOutlet').hide();
            @else
              $('.featureOutlet').show();
              $('.featureOutletForm').prop('required',true);
            @endif

            /* PRODUCT */
            @if (empty(old('news_product_text')))
              $('.featureProduct').hide();
            @else
              $('.featureProduct').show();
              $('.featureProductForm').prop('required',true);
            @endif

            /* VIDEO */
            @if (empty(old('news_video')))
              $('.featureVideo').hide();
            @else
              $('.featureVideo').show();
              $('.featureVideoForm').prop('required',true);
            @endif

            /* LOCATION */
            @if (empty(old('news_event_location_name')))
              $('.featureLocation').hide();
            @else
              $('.featureLocation').show();
              $('.featureLocationForm').prop('required',true);
            @endif

            /* DATE */
            @if (empty(old('news_event_date_start')))
              $('.featureDate').hide();
            @else
              $('.featureDate').show();
              $('.featureDateForm').prop('required',true);
            @endif

            /* TIME */
            @if (empty(old('news_event_time_start')))
              $('.featureTime').hide();
            @else
              $('.featureTime').show();
              $('.featureTimeForm').prop('required',true);
            @endif

			 /* BUTTON TO FORM */
            $('#featureForm').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureForm', state);
                $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news1.jpg')}}")
                $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news2.jpg')}}")
            });

            /* OUTLET */
            $('#featureOutlet').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureOutlet', state);
                $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.jpg')}}")
                $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/outlet.jpg')}}")
            });

            /* VIDEO */
            $('#featureVideo').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureVideo', state);
                if(state){
                  drawVideo();
                }else{
                  $('#video-container').html('');
                }
                $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.jpg')}}")
                $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/video.jpg')}}")
            });

            /* LOCATION */
            $('#featureLocation').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureLocation', state);
                $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.jpg')}}")
                $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/event.jpg')}}")
            });

            /* PRODUCT */
            $('#featureProduct').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureProduct', state);
                $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.jpg')}}")
                $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/product.jpg')}}")
            });

            /* DATE */
            $('#featureDate').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureDate', state);
                $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.jpg')}}")
                $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/event.jpg')}}")
            });

            /* TIME */
            $('#featureTime').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureTime', state);
                $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.jpg')}}")
                $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/event.jpg')}}")
            });

            /* PUBLISH DATE */
            @if(old('news_publish_date'))
            $('.showPublish').show();
            @endif
            $('.publishType').click(function() {
              // tampil duluk
              $('.showPublish').show();

              if ($(this).val() == "always") {
                $('.always').hide();
                $('.always').removeAttr('required');
              }
              else {
                $('.always').show();
                $('.always').prop('required', true);
              }
            });

            $(".file").change(function(e) {
                var type      = $(this).data('jenis');
                var widthImg  = 0;
                var heightImg = 0;

                if (type == "square") {
                widthImg  = 500;
                heightImg = 500;
                }
                else {
                widthImg  = 750;
                heightImg = 375;
                }

                var _URL = window.URL || window.webkitURL;
                var image, file;

                if ((file = this.files[0])) {
                    image = new Image();

                    image.onload = function() {
                        if (this.width == widthImg && this.height == heightImg) {
                            // image.src = _URL.createObjectURL(file);
                        }
                        else {
                            toastr.warning("Please check dimension of your photo.");
                            $(this).val("");
                            // $('#remove_square').click()
                            // image.src = _URL.createObjectURL();

                            if (type == "square") {
                                $('#field_image_square').val("");
                                $('#image_square').children('img').attr('src', 'https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image');
                            }
                            else {
                                $('#field_image_landscape').val("");
                                $('#image_landscape').children('img').attr('src', 'https://www.placehold.it/750x375/EFEFEF/AAAAAA&amp;text=no+image');
                            }
                            console.log($(this).val())
                            // console.log(document.getElementsByName('news_image_luar'))
                        }
                    };

                    image.src = _URL.createObjectURL(file);
                }

            });
            @if(old('news_video'))
            drawVideo();
            @endif
        });
    </script>
    <script type="text/javascript">
        function actionForm(identity, state) {
            if (state) {
                $('.'+identity).show();
                $('.'+identity+'Form').prop('required',true);

                // jika lokasi
                if (identity == "featureLocation") {
                    initialize();
                }
            }
            else {
                $('.'+identity).hide();
                $('.'+identity+'Form').removeAttr('required');
                $('.'+identity+'Form').val('');
            }
        }

        $('#field_title').focus(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/title.jpg')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/title2.jpg')}}")
        })
        $('#field_post_date').focus(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/post-date.jpg')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/post-date2.jpg')}}")
        })
        $('#field_content_short').focus(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/content-short.jpg')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news4.jpg')}}")
        })
        $('#field_image_square').focus(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/image-square.jpg')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news4.jpg')}}")
        })
        $('#field_image_landscape').focus(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/image-landscape2.jpg')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/image-landscape.jpg')}}")
        })
        $('.field_event').focus(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.jpg')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/event.jpg')}}")
        })
        $('.featureVideoForm').focus(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.jpg')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/video.jpg')}}")
        })
        $('.featureProductForm').focus(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.jpg')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/product.jpg')}}")
        })
        $('.featureOutletForm').focus(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.jpg')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/outlet.jpg')}}")
        })
        $("input[name='publish_type']").change(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news1.jpg')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news2.jpg')}}")
        })
        $(".field_publish_date").focus(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news1.jpg')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news2.jpg')}}")
        })
        $(document).on('focus', '#selectOutlet .select2', function (e) {
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.jpg')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/outlet.jpg')}}")
        })
        $(document).on('focus', '#selectProduct .select2', function (e) {
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.jpg')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/product.jpg')}}")
        })
        $(document).on('focus', '#selectCategory .select2', function (e) {
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news1.jpg')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news2.jpg')}}")
        })
        $('#add-video-btn').on('click',addVideo);
        $('#video-container').on('click','.remove-video-btn',function(){
          var id=$(this).data('id');
          video.splice(id,1);
          drawVideo();
        });
        $('#video-container').on('change','.video-content',function(){
          var id=$(this).data('id');
          video[id]=$(this).val();
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
                <span class="caption-subject font-blue sbold uppercase ">New News</span>
            </div>
        </div>
        <div class="portlet-body m-form__group row">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <img src="{{env('S3_URL_VIEW') }}{{('img/news/news1.jpg')}}"  style="box-shadow: 0 0 5px rgba(0,0,0,.08); width:100%" alt="tutorial" id="tutorial1">
                        <img src="{{env('S3_URL_VIEW') }}{{('img/news/news2.jpg')}}" style="box-shadow: 0 0 5px rgba(0,0,0,.08); width:100%" alt="tutorial" id="tutorial2">
                    </div>
                    <div class="col-md-8">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Post Date
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal news dibuat" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" id="field_post_date" class="datepicker form-control" name="news_post_date" value="{{ old('news_post_date') }}" style="background-color:#fff" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
							<div class="col-md-3">
								<div class="input-group">
									<input type="time" class="form-control" name="news_post_time" value="{{ date('H:i', strtotime(old('news_post_date'))) }}" required>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i class="fa fa-clock-o"></i>
										</button>
									</span>
								</div>
							</div>
                        </div>

                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Publish Date
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih apakah new akan selalu ditampilkan atau dalam waktu yang dibatasi (always show/ date limit)" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="optionsRadios4" name="publish_type" class="md-radiobtn publishType" value="limit" @if(old('publish_type')=='limit') checked @endif>
                                        <label for="optionsRadios4">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Date Limit </label>
                                    </div>
                                    <div class="md-radio">
                                        <input type="radio" id="optionsRadios5" name="publish_type" class="md-radiobtn publishType" value="always" @if(old('publish_type')=='always') checked @endif required>
                                        <label for="optionsRadios5">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Always Show </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group showPublish" style="display: none;">
                            <label class="col-md-3 control-label"> </label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="datepicker form-control field_publish_date" name="news_publish_date" value="{{ old('news_publish_date') }}" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 always">
                                <div class="input-group">
                                    <input type="text" class="datepicker form-control always field_publish_date" name="news_expired_date" value="{{ old('news_expired_date') }}">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

<!--                         <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Header Title
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan Header news" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" id="" class="form-control field_title" name="news_title" value="{{ old('news_title') }}" placeholder="Header Title" required>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                News Title
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan judul news" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" id="field_title" class="form-control field_title" name="news_title" value="{{ old('news_title') }}" placeholder="News Title" required>
                            </div>
                        </div>

                        <div class="form-group" id="selectCategory">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                News Category
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih kategori News" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-5">
                                <select name="id_news_category" class="form-control select2">
                                  <option></option>
                                  @foreach($categories as $category)
                                  <option value="{{$category['id_news_category']}}" @if(old('id_news_category')==$category['id_news_category']) selected @endif>{{$category['category_name']}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Image Square
                                <span class="required" aria-required="true"> * </span>
                                <br>
                                <span class="required" aria-required="true"> (500*500) </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran persegi ditampilkan pada list news" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                    <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" id="image_square" style="max-width: 200px; max-height: 200px;"></div>
                                    <div>
                                        <span class="btn default btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" id="field_image_square" class="file" accept="image/*" data-jenis="square" name="news_image_luar" required>

                                        </span>

                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Image Landscape
                                <span class="required" aria-required="true"> * </span>
                                <br>
                                <span class="required" aria-required="true"> (750*375) </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran landscape ditampilkan pada header halaman detail news ukuran persegi ditampilkan pada list news" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 100px;">
                                    <img src="https://www.placehold.it/750x375/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" id="image_landscape" style="max-width: 200px; max-height: 100px;"></div>
                                    <div>
                                        <span class="btn default btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" accept="image/*" id="field_image_landscape" class="file" name="news_image_dalam" data-jenis="landscape" required>

                                        </span>

                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Content Short
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi singkat news" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <textarea name="news_content_short" id="field_content_short" class="form-control" placeholder="Content Short News" required>{ { old('news_content_short') } }</textarea>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Content Long
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Isi konten news" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <textarea name="news_content_long" id="field_content_long" class="form-control summernote">{{ old('news_content_long') }}</textarea>
                            </div>
                        </div>

                        <!-- EVENT DATE -->
                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Featured Date
                                <i class="fa fa-question-circle tooltips" data-original-title="Feature date 'ON' jika news berkenaan dengan tanggal event" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <span class="m-switch">
                                    <label>
                                    <input type="checkbox" class="make-switch" id="featureDate" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (!empty(old('news_event_date_start'))) checked @endif>
                                    <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>

                        <div class="form-group featureDate">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label">Date Start <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="text" id="field_event_date_start" class="datepicker form-control featureDateForm field_event" name="news_event_date_start" value="{{ old('news_event_date_start') }}" style="background-color:#fff" readonly>
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureDate">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label">Date End <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="text" id="field_event_date_end" class="datepicker form-control featureDateForm field_event" name="news_event_date_end" value="{{ old('news_event_date_end') }}" style="background-color:#fff" readonly>
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- EVENT TIME -->
                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Featured Time
                                <i class="fa fa-question-circle tooltips" data-original-title="feature time 'ON' jika new berkenaan dengan waktu event" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <span class="m-switch">
                                    <label>
                                    <input type="checkbox" class="make-switch" id="featureTime" data-size="small" data-on-color="info" name="toggle_time" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (!empty(old('news_event_time_start'))) checked @endif>
                                    <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>

                        <div class="form-group featureTime">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label">Time Start <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="time"  id="field_event_time_start" class="form-control featureTimeForm field_event" name="news_event_time_start" value="{{ old('news_event_time_start') }}">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-clock-o"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureTime">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label">Time End <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="time"  id="field_event_time_end" class="form-control featureTimeForm field_event" name="news_event_time_end" value="{{ old('news_event_time_end') }}">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-clock-o"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- LOCATION -->
                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Featured Location
                                <i class="fa fa-question-circle tooltips" data-original-title="feature location 'ON' jika new berkenaan dengan tempat event" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <span class="m-switch">
                                    <label>
                                    <input type="checkbox" class="make-switch" id="featureLocation" data-size="small" name="toggle_location" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (!empty(old('news_event_location_name'))) checked @endif>
                                    <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>

                        <div class="form-group featureLocation">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label">Location Name <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" id="field_event_location" class="form-control featureLocationForm field_event" name="news_event_location_name" value="{{ old('news_event_location_name') }}" placeholder="Location name or name of a place">
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureLocation">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label">Contact Person</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" id="field_event_contact" class="form-control field_event" name="news_event_location_phone" value="{{ old('news_event_location_phone') }}" placeholder="Contact Person in location">
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureLocation">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label">Address </label>
                                </div>
                                <div class="col-md-9">
                                    <textarea type="text" id="field_event_address" class="form-control field_event" name="news_event_location_address" placeholder="Event's Address">{{ old('news_event_location_address') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureLocation">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label">Maps
                                </div>
                                <div class="col-md-9">
                                    <input id="pac-input"  id="field_event_map" class="controls field_event" type="text" placeholder="Enter a location" style="padding:10px;width:50%" onkeydown="if (event.keyCode == 13) return false;" name="news_event_location_map" value="{{ old('newsevent_location_map') }}">
                                    <div id="map-canvas" style="width:900;height:380px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureLocation">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label"></label>
                                </div>
                                <div class="col-md-9">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="news_event_latitude" value="{{ old('news_event_latitude') }}" id="lat" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="news_event_longitude" value="{{ old('news_event_longitude') }}" id="lng" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIDEO -->
                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Featured Video
                                <i class="fa fa-question-circle tooltips" data-original-title="feature video 'ON' jika ingin menambahkan video pada news" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <span class="m-switch">
                                    <label>
                                    <input type="checkbox" class="make-switch" id="featureVideo" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (!empty(old('news_video_text'))) checked @endif>
                                    <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>

                        <div class="form-group featureVideo">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label">Title <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" id="field_video_text" class="form-control featureVideoForm" name="news_video_text" value="{{ old('news_video_text') }}" placeholder="Featured Video Title">
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureVideo">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label">Link Video <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-9" id="video-container"></div>
                                @if(MyHelper::hasAccess([106], $configs))
                                <div class="col-md-offset-3 col-md-9" style="margin-top: 10px">
                                  <button class="btn blue" type="button" id="add-video-btn"><i class="fa fa-plus"></i> Add</button>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- OUTLET -->
                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Featured Outlet
                                <i class="fa fa-question-circle tooltips" data-original-title="feature Outlet 'ON' jika new berkenaan dengan outlet" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <span class="m-switch">
                                    <label>
                                    <input type="checkbox" class="make-switch" id="featureOutlet" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (!empty(old('news_outlet_text'))) checked @endif>
                                    <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>

                        <div class="form-group featureOutlet">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label">Title <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" id="field_outlte_title" class="form-control featureOutletForm" name="news_outlet_text" value="{{ old('news_outlet_text') }}" placeholder="Featured Outlet Title">
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureOutlet">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label">Outlet <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-9" id="selectOutlet">
                                    <select id="outlet"  id="field_outlet_select" class="form-control select2-multiple featureOutletForm" multiple data-placeholder="Select Outlet" name="id_outlet[]">
                                        <optgroup label="Outlet List">
                                            @if (!empty($outlet))
                                                @foreach($outlet as $suw)
                                                    <option value="{{ $suw['id_outlet'] }}" @if(in_array($suw['id_outlet'],old('id_outlet',[]))) selected @endif>{{ $suw['outlet_name'] }}</option>
                                                @endforeach
                                            @endif
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- PRODUCT -->
                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Featured Product
                                <i class="fa fa-question-circle tooltips" data-original-title="feature product 'ON' jika new berkenaan dengan produk" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <span class="m-switch">
                                    <label>
                                    <input type="checkbox" class="make-switch" id="featureProduct" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (!empty(old('news_product_text'))) checked @endif>
                                    <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>

                        <div class="form-group featureProduct">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label">Title <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" id="field_product_title" class="form-control featureProductForm" name="news_product_text" value="{{ old('news_product_text') }}" placeholder="Featured Product Title">
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureProduct">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label">Product <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-9" id="selectProduct">
                                    <select id="field_product_select" class="form-control select2-multiple featureProductForm" multiple data-placeholder="Select Product" name="id_product[]">
                                        <optgroup label="Product List">
                                            <option value="">Select Product</option>
                                            @if (!empty($product))
                                                @foreach($product as $suw)
                                                    <option value="{{ $suw['id_product_group'] }}" @if(in_array($suw['id_product_group'],old('id_product',[]))) selected @endif>{{ $suw['product_group_name'] }}</option>
                                                @endforeach
                                            @endif
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>

						@if(MyHelper::hasAccess([107], $configs))
                            <!-- BUTTON TO FORM -->
                            <div class="form-group" id="customform">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Custom Form
                                    <i class="fa fa-question-circle tooltips" data-original-title="Button to Form 'ON' jika news memiliki form yang harus diisi" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-9">
                                    <span class="m-switch">
                                        <label>
                                        <input name="custom_form_checkbox" type="checkbox" class="make-switch" id="featureForm" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (!empty(old('news_button_form_text'))) checked @endif>
                                        <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group featureForm">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-9">
                                    <div class="col-md-3">
                                        <label class="control-label">Button Text <span class="required" aria-required="true"> * </span> </label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control featureFormForm" name="news_button_form_text" value="{{ old('news_button_form_text') }}" placeholder="Button to Form text">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group featureForm">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-9">
                                    <div class="col-md-3">
                                        <label class="control-label">Button Exp <span class="required" aria-required="true"> * </span> </label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" class="datepicker form-control featureFormForm field_event" name="news_button_form_expired" value="@if(!empty(old('news_button_form_expired'))){{ date('d-M-Y',strtotime(old('news_button_form_expired'))) }}@endif">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group featureForm">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-9">
                                    <div class="col-md-3">
                                        <label class="control-label">Success Msg</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control field_event" name="news_form_success_message" value="{{ old('news_form_success_message') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group featureForm">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-9">
                                    <div class="col-md-12">
                                        <div class="form-group mt-repeater">
                                            <div data-repeater-list="customform" id="sortable">
                                                <div data-repeater-item class="mt-repeater-item mt-overflow" style="border-bottom: 1px #ddd;">
                                                    <div class="mt-repeater-cell" style="position: relative;">
                                                        <div class="sort-icon">
                                                            <i class="fa fa-arrows"></i>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="col-md-2">
                                                                <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                                                    <i class="fa fa-close"></i>
                                                                </a>
                                                            </div>
                                                            <div class="input-icon right">
                                                                <div class="col-md-4" style="padding-top: 5px;">
                                                                    Input Name
                                                                    <i class="fa fa-question-circle tooltips" data-original-title="Nama Input pada Form" data-container="body"></i>
                                    <span class="required" aria-required="true"> * </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6" >
                                                                <div class="input-icon right">
                                                                    <input type="text" name="form_input_label" class="form-control demo featureFormForm">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="margin-top:20px">
                                                            <div class="input-icon right">
                                                                <div class="col-md-offset-2 col-md-4" style="padding-top: 5px;">
                                                                    Input Types
                                                                    <i class="fa fa-question-circle tooltips" data-original-title="Tipe inputan user" data-container="body"></i>
                                    <span class="required" aria-required="true"> * </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6" >
                                                                <select class="form-control form_input_types featureFormForm" name="form_input_types">
                                                                    <option value="Short Text">Short Text</option>
                                                                    <option value="Long Text">Long Text</option>
                                                                    <option value="Number Input">Number Input</option>
                                                                    <option value="Date">Date</option>
                                                                    <option value="Date & Time">Date & Time</option>
                                                                    <option value="Dropdown Choice">Dropdown Choice</option>
                                                                    <option value="Radio Button Choice">Radio Button Choice</option>
                                                                    <option value="Multiple Choice">Multiple Choice</option>
                                                                    <option value="File Upload">File Upload</option>
                                                                    <option value="Image Upload">Image Upload</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 form_input_options" style="margin-top:20px; display: none;">
                                                            <div class="input-icon right">
                                                                <div class="col-md-offset-2 col-md-4" style="padding-top: 5px;">
                                                                    Input Options
                                                                    <i class="fa fa-question-circle tooltips" data-original-title="Warna teks nama level pada aplikasi" data-container="body"></i>
                                    <span class="required" aria-required="true"> * </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6" >
                                                                <div class="input-icon right">
                                                                    <input type="text" name="form_input_options" class="form-control demo tagsinput" data-role="tagsinput" placeholder="comma (,) separated">
                                                                </div>
                                                            </div>
                                                        </div>
                            <div class="col-md-12 form_input_autofill" style="margin-top:20px;">
                                <div class="input-icon right">
                                <div class="col-md-offset-2 col-md-4" style="padding-top: 5px;">
                                    Input Autofill
                                    <i class="fa fa-question-circle tooltips" data-original-title="Isian otomatis dari data profil user" data-container="body"></i>
                                </div>
                                </div>
                                <div class="col-md-6" >
                                <div class="input-icon right">
                                    <select class="form-control" name="form_input_autofill">
                                    <option value="">--None--</option>
                                    <option value="Name">Name</option>
                                    <option value="Phone">Phone</option>
                                    <option value="Email">Email</option>
                                    <option value="Gender">Gender</option>
                                    <option value="City">City</option>
                                    <option value="Birthday">Birthday</option>
                                    </select>
                                </div>
                                </div>
                            </div>

                            <div class="col-md-12" style="margin-top:20px;">
                                <div class="input-icon right">
                                <div class="col-md-offset-2 col-md-4" style="padding-top: 5px;">
                                    Is Required
                                    <i class="fa fa-question-circle tooltips" data-original-title="Apakah wajib diisi?" data-container="body"></i>
                                </div>
                                </div>
                                <div class="col-md-6" >
                                <div class="input-icon right">
                                    <div class="mt-checkbox-list">
                                    <label class="mt-checkbox mt-checkbox-outline">
                                        <input type="checkbox" name="is_required" value="1">
                                        <span></span>
                                    </label>
                                    </div>
                                </div>
                                </div>
                            </div>

                            <div class="col-md-12 is_unique" style="margin-top:20px;">
                                <div class="input-icon right">
                                <div class="col-md-offset-2 col-md-4" style="padding-top: 5px;">
                                    Is Unique
                                    <i class="fa fa-question-circle tooltips" data-original-title="Apakah data unik?" data-container="body"></i>
                                </div>
                                </div>
                                <div class="col-md-6" >
                                <div class="input-icon right">
                                    <div class="mt-checkbox-list">
                                    <label class="mt-checkbox mt-checkbox-outline">
                                        <input type="checkbox" name="is_unique" value="1">
                                        <span></span>
                                    </label>
                                    </div>

                                </div>
                                </div>
                            </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-action col-md-12">
                                                <div class="col-md-2"></div>
                                                <div class="col-md-10">
                                                    @if(MyHelper::hasAccess([12], $grantedFeature))
                                                        <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add">
                                                        <i class="fa fa-plus"></i> Add New Input</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <hr style="width:95%; margin-left:auto; margin-right:auto; margin-bottom:20px">
                        </div>
                        <div class="col-md-offset-6 col-md-4">
                            <button type="submit" class="btn green">Submit</button>
                            <!-- <button type="button" class="btn default">Cancel</button> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection