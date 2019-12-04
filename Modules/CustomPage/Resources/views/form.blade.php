<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
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

        @if (!empty($detail['custom_page_event_latitude']))
          var lat = "{{$detail['custom_page_event_latitude']}}";
        @elseif (!empty($result['custom_page_event_latitude']))
          var lat = "{{$result['custom_page_event_latitude']}}";
        @else
          var lat = "-7.7972";
        @endif

        @if (!empty($detail['custom_page_event_longitude']))
          var long = "{{$detail['custom_page_event_longitude']}}";
        @elseif (!empty($result['custom_page_event_latitude']))
          var lat = "{{$result['custom_page_event_latitude']}}";
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
        $(document).ready(function() {
            token = '<?php echo csrf_token()?>';

            $('.summernote').summernote({
                placeholder: 'News Content Long',
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['misc', ['fullscreen', 'codeview', 'help']]
                ],
                fontNames: ['Product Sans'],
                fontNamesIgnoreCheck: ['Product Sans'],
                callbacks: {
                    onFocus: function() {
                        $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.png')}}")
                        $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/content-long.png')}}")
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
            @if (isset($detail) && empty($detail['custom_page_image_header']))
              $('.featureImage').hide();
            @elseif (isset($result) && empty($result['custom_page_image_header']))
              $('.featureImage').hide();
            @elseif (empty($detail['custom_page_image_header']) && empty($result['custom_page_image_header']))
              $('.featureImage').hide();
            @else
              $('.featureImage').show();
              @if (isset($detail) && !empty($detail['custom_page_image_header']))
                  $('.featureImageForm').prop('required', false);
                @elseif (isset($result) && !empty($result['custom_page_image_header']))
                  $('.featureImageForm').prop('required', false);
                @else
                  $('.featureImageForm').prop('required',true);
                @endif
            @endif

            /* featureImage: show/hide input types */
            $('.featureImage').on('change', '.form_input_types', function() {
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
            $('.featureImage').on('itemAdded', '.tagsinput', function(event) {
                $(this).prop('required',false);
                $(this).prev().find('input').prop('required',false);
            });

            $('.mt-repeater-add').on('click', function(event) {
                $('.previewImage').last().attr('src', 'https://www.placehold.it/750x375/EFEFEF/AAAAAA&amp;text=no+image');
                $('.btnImage').last().show();
                $('.featureImageForm').last().prop('type', 'file');
                $('.featureImageForm').last().val('');
                $('.featureImageForm').last().prop('required',true);
                console.log(event)
            });

            // unrequired tagsinput options
            $('.featureImage').on('itemRemoved', '.tagsinput', function(event) {
              if ($(this).val() == ""){
                $(this).prop('required',true);
                $(this).prev().find('input').prop('required',true);
              }
            });

            /* sortable */
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();

            /* OUTLET */
            @if (isset($detail) && empty($detail['custom_page_outlet']))
              $('.featureOutlet').hide();
            @elseif (isset($result) && empty($result['custom_page_outlet']))
              $('.featureOutlet').hide();
            @elseif (empty($detail['custom_page_outlet']) && empty($result['custom_page_outlet']))
              $('.featureOutlet').hide();
            @else
              $('.featureOutlet').show();
              $('.featureOutletForm').prop('required',true);
            @endif

            /* PRODUCT */
            @if (isset($detail) && empty($detail['custom_page_product']))
              $('.featureProduct').hide();
            @elseif (isset($result) && empty($result['custom_page_product']))
              $('.featureProduct').hide();
            @elseif (empty($detail['custom_page_product']) && empty($result['custom_page_product']))
              $('.featureProduct').hide();
            @else
              $('.featureProduct').show();
              $('.featureProductForm').prop('required',true);
            @endif

            /* BUTTON */
            @if (isset($detail) && empty($detail['custom_page_button_form']))
              $('.featureButton').hide();
              $('#custom_page_button_form').val('');
              $('#custom_page_button_form_text').val('');
            @elseif (isset($result) && empty($result['custom_page_button_form']))
              $('.featureButton').hide();
              $('#custom_page_button_form').val('');
              $('#custom_page_button_form_text').val('');
            @elseif (empty($detail['custom_page_button_form']) && empty($result['custom_page_button_form']))
              $('.featureButton').hide();
              $('#custom_page_button_form').val('');
              $('#custom_page_button_form_text').val('');
            @else
              $('.featureButton').show();
              $('.featureButtonForm').prop('required',false);
            @endif

            /* VIDEO */
            @if (isset($detail) && empty($detail['custom_page_video']))
              $('.featureVideo').hide();
            @elseif (isset($result) && empty($result['custom_page_video']))
              $('.featureVideo').hide();
            @elseif (empty($detail['custom_page_video']) && empty($result['custom_page_video']))
              $('.featureVideo').hide();
            @else
              $('.featureVideo').show();
              $('.featureVideoForm').prop('required',true);
            @endif

            /* LOCATION */
            @if (isset($detail) && empty($detail['custom_page_event_location_name']))
              $('.featureLocation').hide();
            @elseif (isset($result) && empty($result['custom_page_event_location_name']))
              $('.featureLocation').hide();
            @elseif (empty($detail['custom_page_event_location_name']) && empty($result['custom_page_event_location_name']))
              $('.featureLocation').hide();
            @else
              $('.featureLocation').show();
              $('.featureLocationForm').prop('required',true);
            @endif

            /* DATE */
            @if (isset($detail) && empty($detail['custom_page_event_date_start']))
              $('.featureDate').hide();
            @elseif (isset($result) && empty($result['custom_page_event_date_start']))
              $('.featureDate').hide();
            @elseif (empty($detail['custom_page_event_date_start']) && empty($result['custom_page_event_date_start']))
              $('.featureDate').hide();
            @else
              $('.featureDate').show();
              $('.featureDateForm').prop('required',true);
            @endif

            /* TIME */
            @if (isset($detail) && empty($detail['custom_page_event_time_start']))
              $('.featureTime').hide();
            @elseif (isset($result) && empty($result['custom_page_event_time_start']))
              $('.featureTime').hide();
            @elseif (empty($detail['custom_page_event_time_start']) && empty($result['custom_page_event_time_start']))
              $('.featureTime').hide();
            @else
              $('.featureTime').show();
              $('.featureTimeForm').prop('required',true);
            @endif

            /* OUTLET */
            $('#featureOutlet').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureOutlet', state);
                $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.png')}}")
                $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/outlet.png')}}")
            });

            /* VIDEO */
            $('#featureVideo').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureVideo', state);
                $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.png')}}")
                $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/video.png')}}")
            });

            /* LOCATION */
            $('#featureLocation').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureLocation', state);
                $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.png')}}")
                $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/event.png')}}")
            });

            /* PRODUCT */
            $('#featureProduct').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureProduct', state);
                $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.png')}}")
                $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/product.png')}}")
            });

            /* BUTTON */
            $('#featureButton').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureButton', state);
                $('#custom_page_button_form').val('Call').trigger('change')
            });

            /* DATE */
            $('#featureDate').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureDate', state);
                $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.png')}}")
                $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/event.png')}}")
            });

            /* TIME */
            $('#featureTime').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureTime', state);
                $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.png')}}")
                $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/event.png')}}")
            });

			 /* IMAGE HEADER */
            $('#featureImage').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureImage', state);
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.png')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/image-landscape.png')}}")
            });

            /* PUBLISH DATE */
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
                        else if (this.width == this.height && type == "icon" && $(".file").val().split('.').pop().toLowerCase() == 'png') {
                            // image.src = _URL.createObjectURL(file);
                        }
                        else {
                            toastr.warning("Please check dimension of your photo.");
                            $(this).val("");

                            if (type == "square" || type == "icon") {
                                $('#field_image_square').val("");
                                $('#image_square').children('img').attr('src', 'https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image');
                            }
                        }
                    };
                    image.src = _URL.createObjectURL(file);
                }

            });
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
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/title.png')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/title2.png')}}")
        })
        $('#field_post_date').focus(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/post-date.png')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/post-date2.png')}}")
        })
        $('#field_content_short').focus(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/content-short.png')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news4.png')}}")
        })
        $('#field_image_square').focus(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/image-square.png')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news4.png')}}")
        })
        $('#field_image_landscape').focus(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.png')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/image-landscape.png')}}")
        })
        $('.field_event').focus(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.png')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/event.png')}}")
        })
        $('.featureVideoForm').focus(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.png')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/video.png')}}")
        })
        $('.featureProductForm').focus(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.png')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/product.png')}}")
        })
        $('.featureOutletForm').focus(function(){
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.png')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/outlet.png')}}")
        })
        $("input[name='publish_type']").change(function(){
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news2.png')}}")
        })
        $(".field_publish_date").focus(function(){
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news2.png')}}")
        })
        $(document).on('focus', '#selectOutlet .select2', function (e) {
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.png')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/outlet.png')}}")
        })
        $(document).on('focus', '#selectProduct .select2', function (e) {
            $('#tutorial1').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/news3.png')}}")
            $('#tutorial2').attr('src', "{{env('S3_URL_VIEW') }}{{('img/news/product.png')}}")
        })

        $(document).on('change', '#custom_page_button_form', function (e) {
            if (this.value == "Open Page") {
                $('#inputValue').hide().prop('required',false);
                $('#selectValue').show().prop('required',true);
            } else if (this.value == "Call") {
                $('#inputValue').show().prop('required',true);
                $('#selectValue').hide().prop('required',false);
                $('input[name="custom_page_button_form_text_value"]').attr("placeholder", "Example: 0811223344");
                $('#lable_button_form').replaceWith('<label class="control-label" id="lable_button_form">Number<span class="required" aria-required=""> * </span> </label>')
            } else if (this.value == "Link") {
                $('#inputValue').show().prop('required',true);
                $('#selectValue').hide().prop('required',false);
                $('input[name="custom_page_button_form_text_value"]').attr("placeholder", "Example: https://www.youtube.com/watch?v=u9_2wWSOQ");
                $('#lable_button_form').replaceWith('<label class="control-label" id="lable_button_form">Link<span class="required" aria-required=""> * </span> </label>')
            }
        })
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
                <span class="caption-subject font-blue sbold uppercase ">New Custom Page</span>
            </div>
        </div>
        <div class="portlet-body m-form__group row">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <img src="{{env('S3_URL_VIEW') }}{{('img/news/news2.png')}}" style="width:100%" alt="tutorial" id="tutorial2">
                    </div>
                    <div class="col-md-8">
                    <div class="form-body">

                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Header Title
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan Header news" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" id="" class="form-control" name="custom_page_title" @if (isset($detail['custom_page_title'])) value="{{ $detail['custom_page_title'] }}" disabled @elseif (isset($result['custom_page_title'])) value="{{ $result ['custom_page_title'] }}" @else value="{{ old('custom_page_title') }}" @endif placeholder="Header Title" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Menu Title
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama untuk menu" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" id="" class="form-control" name="custom_page_menu" @if (isset($detail['custom_page_menu'])) value="{{ $detail['custom_page_menu'] }}" disabled @elseif (isset($result['custom_page_menu'])) value="{{ $result ['custom_page_menu'] }}" @else value="{{ old('custom_page_menu') }}" @endif placeholder="Menu Title" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Icon Image
                                <span class="required" aria-required="true"> * </span>
                                <br>
                                <span class="required" aria-required="true"> (Only PNG) </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran square ditampilkan pada list button" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                    <img @if (isset($detail['custom_page_icon_image'])) src="{{env('S3_URL_API')}}{{$detail['custom_page_icon_image']}}" disabled @elseif (isset($result['custom_page_icon_image'])) src="{{env('S3_URL_API')}}{{$result['custom_page_icon_image']}}" @else src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" @endif alt="">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" id="image_icon" style="max-width: 200px; max-height: 200px;"></div>
                                    <div>
                                        <span class="btn default btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" accept="image/png" id="field_image_icon" class="file" @if (isset($detail['custom_page_icon_image'])) value="'c:\fakepath\icon_image='.{{$detail['custom_page_icon_image']}}" disabled @elseif (isset($result['custom_page_icon_image'])) value="'icon_image='.{{$result['custom_page_icon_image']}}" @else value="{{ old('custom_page_icon_image') }}" required @endif name="custom_page_icon_image" data-jenis="icon">
                                        </span>
                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- IMAGE HEADER -->
						<div class="form-group">
							<div class="input-icon right">
								<label class="col-md-3 control-label">
								Featured Image Header
								<i class="fa fa-question-circle tooltips" data-original-title="Image Header 'ON' jika custom page memiliki image header" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-9">
								<span class="m-switch">
									<label>
									<input name="custom_form_checkbox" type="checkbox" class="make-switch" id="featureImage" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (isset($detail['custom_page_image_header'])) checked disabled @elseif (isset($result['custom_page_image_header'])) checked @endif @if (!empty(old('custom_page_image_header'))) checked @endif>
									<span></span>
									</label>
								</span>
							</div>
                        </div>

						<div class="form-group featureImage">
							<label class="col-md-3 control-label"></label>
							<div class="col-md-9">
								<div class="col-md-12">
									<div class="form-group mt-repeater">
										<div data-repeater-list="customform" id="sortable">
                                            @php
                                                if (isset($detail['custom_page_image_header'])) {
                                                    $custom_page_image_header = $detail['custom_page_image_header'];
                                                } elseif (isset($result['custom_page_image_header'])) {
                                                    $custom_page_image_header = $result['custom_page_image_header'];
                                                } else {
                                                    $custom_page_image_header = null;
                                                }
                                            @endphp
                                            @if ($custom_page_image_header != null)
                                            @foreach ($custom_page_image_header as $item)
                                            <div data-repeater-item class="mt-repeater-item mt-overflow" style="border-bottom: 1px #ddd;">
                                                <div class="mt-repeater-cell" style="position: relative;">
                                                    <div class="sort-icon">
                                                        <i class="fa fa-arrows tooltips" data-original-title="Ubah urutan form dengan drag n drop" data-container="body"></i>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-2">
                                                            <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                                                <i class="fa fa-close"></i>
                                                            </a>
                                                        </div>
                                                        <div class="input-icon right">
                                                            <label class="col-md-3 control-label">
                                                            Image Landscape
                                                            <span class="required" aria-required="true"> * </span>
                                                            <br>
                                                            <span class="required" aria-required="true"> (750*375) </span>
                                                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran landscape ditampilkan pada header halaman detail news ukuran persegi ditampilkan pada list news" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 100px;">
                                                                <img class='previewImage' src="{{env('S3_URL_API')}}{{$item['custom_page_image']}}" alt="">
                                                                </div>
                                                                <div class="fileinput-preview fileinput-exists thumbnail" id="image_landscape" style="max-width: 200px; max-height: 100px;"></div>
                                                                <div class='btnImage' hidden>
                                                                    <span class="btn default btn-file">
                                                                    <span class="fileinput-new"> Select image </span>
                                                                    <span class="fileinput-exists"> Change </span>
                                                                    <input type="text" accept="image/*" value="{{'id_image_header='.$item['id_custom_page_image']}}" id="field_image_landscape" class="file form-control demo featureImageForm" name="custom_page_image_header" data-jenis="landscape">
                                                                    </span>
                                                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            @else
                                            <div data-repeater-item class="mt-repeater-item mt-overflow" style="border-bottom: 1px #ddd;">
                                                <div class="mt-repeater-cell" style="position: relative;">
                                                    <div class="sort-icon">
                                                        <i class="fa fa-arrows tooltips" data-original-title="Ubah urutan form dengan drag n drop" data-container="body"></i>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-2">
                                                            <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                                                <i class="fa fa-close"></i>
                                                            </a>
                                                        </div>
                                                        <div class="input-icon right">
                                                            <label class="col-md-3 control-label">
                                                            Image Landscape
                                                            <span class="required" aria-required="true"> * </span>
                                                            <br>
                                                            <span class="required" aria-required="true"> (750*375) </span>
                                                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran landscape ditampilkan pada header halaman detail news ukuran persegi ditampilkan pada list news" data-container="body"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 100px;">
                                                                <img class='previewImage' src="https://www.placehold.it/750x375/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                                                </div>
                                                                <div class="fileinput-preview fileinput-exists thumbnail" id="image_landscape" style="max-width: 200px; max-height: 100px;"></div>
                                                                <div class='btnImage'>
                                                                    <span class="btn default btn-file">
                                                                    <span class="fileinput-new"> Select image </span>
                                                                    <span class="fileinput-exists"> Change </span>
                                                                    <input type="file" accept="image/*" id="field_image_landscape" class="file form-control demo featureImageForm" name="custom_page_image_header" data-jenis="landscape">
                                                                    </span>
                                                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        @if (!isset($detail))
										<div class="form-action col-md-12">
											<div class="col-md-2"></div>
											<div class="col-md-10">
												@if(MyHelper::hasAccess([12], $grantedFeature))
													<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add">
													<i class="fa fa-plus"></i> Add New Input</a>
												@endif
											</div>
										</div>
                                        @endif
									</div>
								</div>
							</div>
						</div>

                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Content Long
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Isi konten news" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <textarea name="custom_page_description" id="field_content_long" class="form-control summernote">@if (isset($detail['custom_page_description'])) {{ $detail['custom_page_description'] }} @elseif (isset($result['custom_page_description'])) {{ $result ['custom_page_description'] }} @else {{ old('custom_page_description') }} @endif</textarea>
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
                                    <input type="checkbox" class="make-switch" id="featureDate" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (isset($detail['custom_page_event_date_start'])) checked disabled @elseif (isset($result['custom_page_event_date_start'])) checked @endif @if (!empty(old('custom_page_event_date_start'))) checked @endif>
                                    <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>

                        <div class="form-group featureDate">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <label class="control-label">Date Start <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="text" id="field_event_date_start" class="datepicker form-control featureDateForm field_event" name="custom_page_event_date_start"  @if (isset($detail['custom_page_event_date_start'])) value="{{$detail['custom_page_event_date_start']}}" disabled @elseif (isset($result['custom_page_event_date_start'])) value="{{$result['custom_page_event_date_start']}}" @else value="{{ old('custom_page_event_date_start') }}" @endif style="background-color:#fff" readonly>
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
                                <div class="col-md-4">
                                    <label class="control-label">Date End <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="text" id="field_event_date_end" class="datepicker form-control featureDateForm field_event" name="custom_page_event_date_end" @if (isset($detail['custom_page_event_date_end'])) value="{{$detail['custom_page_event_date_end']}}" disabled @elseif (isset($result['custom_page_event_date_end'])) value="{{$result['custom_page_event_date_end']}}" @else value="{{ old('custom_page_event_date_end') }}" @endif style="background-color:#fff" readonly>
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
                                    <input type="checkbox" class="make-switch" id="featureTime" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (isset($detail['custom_page_event_time_start'])) checked disabled @elseif (isset($result['custom_page_event_time_start'])) checked @endif @if (!empty(old('custom_page_event_time_start'))) checked @endif>
                                    <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>

                        <div class="form-group featureTime">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <label class="control-label">Time Start <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="time"  id="field_event_time_start" class="form-control featureTimeForm field_event" name="custom_page_event_time_start" @if (isset($detail['custom_page_event_time_start'])) value="{{$detail['custom_page_event_time_start']}}" disabled @elseif (isset($result['custom_page_event_time_start'])) value="{{$result['custom_page_event_time_start']}}" @else value="{{ old('custom_page_event_time_start') }}" @endif>
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
                                <div class="col-md-4">
                                    <label class="control-label">Time End <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="time"  id="field_event_time_end" class="form-control featureTimeForm field_event" name="custom_page_event_time_end" @if (isset($detail['custom_page_event_time_end'])) value="{{$detail['custom_page_event_time_end']}}" disabled @elseif (isset($result['custom_page_event_time_end'])) value="{{$result['custom_page_event_time_end']}}" @else value="{{ old('custom_page_event_time_end') }}" @endif>
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
                                    <input type="checkbox" class="make-switch" id="featureLocation" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (isset($detail['custom_page_event_location_name'])) checked disabled @elseif (isset($result['custom_page_event_location_name'])) checked @endif @if (!empty(old('custom_page_event_location_name'))) checked @endif>
                                    <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>

                        <div class="form-group featureLocation">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <label class="control-label">Location Name <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="field_event_location" class="form-control featureLocationForm field_event" name="custom_page_event_location_name" @if (isset($detail['custom_page_event_location_name'])) value="{{$detail['custom_page_event_location_name']}}" disabled @elseif (isset($result['custom_page_event_location_name'])) value="{{$result['custom_page_event_location_name']}}" @else value="{{ old('custom_page_event_location_name') }}" @endif placeholder="Location name or name of a place">
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureLocation">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <label class="control-label">Contact Person</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="field_event_contact" class="form-control field_event" name="custom_page_event_location_phone" @if (isset($detail['custom_page_event_location_phone'])) value="{{$detail['custom_page_event_location_phone']}}" disabled @elseif (isset($result['custom_page_event_location_phone'])) value="{{$result['custom_page_event_location_phone']}}" @else value="{{ old('custom_page_event_location_phone') }}" @endif placeholder="Contact Person in location">
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureLocation">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <label class="control-label">Address </label>
                                </div>
                                <div class="col-md-8">
                                    <textarea type="text" id="field_event_address" class="form-control field_event" name="custom_page_event_location_address" placeholder="Event's Address">@if (isset($detail['custom_page_event_location_address'])) {{$detail['custom_page_event_location_address']}} @elseif (isset($result['custom_page_event_location_address'])) {{$result['custom_page_event_location_address']}} @else {{ old('custom_page_event_location_address') }} @endif</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureLocation">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <label class="control-label">Maps
                                </div>
                                <div class="col-md-8">
                                    <input id="pac-input"  id="field_event_map" class="controls field_event" type="text" placeholder="Enter a location" style="padding:10px;width:50%" onkeydown="if (event.keyCode == 13) return false;" name="custom_page_event_location_map" @if (isset($detail['custom_page_event_location_map'])) value="{{$detail['custom_page_event_location_map']}}" disabled @elseif (isset($result['custom_page_event_location_map'])) value="{{$result['custom_page_event_location_map']}}" @else value="{{ old('custom_page_event_location_map') }}" @endif>
                                    <div id="map-canvas" style="width:900;height:380px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureLocation">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <label class="control-label"></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="col-md-6">
                                        <input type="text" id="field_event_latitude" class="form-control" name="custom_page_event_latitude" @if (isset($detail['custom_page_event_latitude'])) value="{{$detail['custom_page_event_latitude']}}" disabled @elseif (isset($result['custom_page_event_latitude'])) value="{{$result['custom_page_event_latitude']}}" @else value="{{ old('custom_page_event_latitude') }}" @endif id="lat" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="custom_page_event_longitude" @if (isset($detail['custom_page_event_longitude'])) value="{{$detail['custom_page_event_longitude']}}" disabled @elseif (isset($result['custom_page_event_longitude'])) value="{{$result['custom_page_event_longitude']}}" @else value="{{ old('custom_page_event_longitude') }}" @endif id="lng" readonly>
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
                                    <input type="checkbox" class="make-switch" id="featureVideo" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (isset($detail['custom_page_video_text'])) checked disabled @elseif (isset($result['custom_page_video_text'])) checked @endif @if (!empty(old('custom_page_video_text'))) checked @endif>
                                    <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>

                        <div class="form-group featureVideo">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <label class="control-label">Title <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="field_video_text" class="form-control featureVideoForm" name="custom_page_video_text" @if (isset($detail['custom_page_video_text'])) value="{{$detail['custom_page_video_text']}}" disabled @elseif (isset($result['custom_page_video_text'])) value="{{$result['custom_page_video_text']}}" @else value="{{ old('custom_page_video_text') }}" @endif placeholder="Featured Video Title">
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureVideo">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <label class="control-label">Link Video <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-8">
                                    <input name="custom_page_video" id="field_video_link" type="url" class="form-control featureVideoForm" @if (isset($detail['custom_page_video'])) value="{{$detail['custom_page_video']}}" disabled @elseif (isset($result['custom_page_video'])) value="{{$result['custom_page_video']}}" @else value="{{ old('custom_page_video') }}" @endif placeholder="Example: https://www.youtube.com/watch?v=u9_2wWSOQ">
                                </div>
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
                                    <input type="checkbox" class="make-switch" id="featureOutlet" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (isset($detail['custom_page_outlet_text'])) checked disabled @elseif (isset($result['custom_page_outlet_text'])) checked @endif @if (!empty(old('custom_page_outlet_text'))) checked @endif>
                                    <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>

                        <div class="form-group featureOutlet">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <label class="control-label">Title <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="field_outlte_title" class="form-control featureOutletForm" name="custom_page_outlet_text" @if (isset($detail['custom_page_outlet_text'])) value="{{$detail['custom_page_outlet_text']}}" disabled @elseif (isset($result['custom_page_outlet_text'])) value="{{$result['custom_page_outlet_text']}}" @else value="{{ old('custom_page_outlet_text') }}" @endif placeholder="Featured Outlet Title">
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureOutlet">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <label class="control-label">Outlet <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-8" id="selectOutlet">
                                    <select id="outlet"  id="field_outlet_select" class="form-control select2-multiple featureOutletForm" multiple data-placeholder="Select Outlet" name="id_outlet[]">
                                        <optgroup label="Outlet List">
                                            @php
                                                if (!empty($result['custom_page_outlet'])) {
                                                $selectedOutlet = array_pluck($result['custom_page_outlet'], 'id_outlet');
                                                } elseif (!empty($detail['custom_page_outlet'])) {
                                                $selectedOutlet = array_pluck($detail['custom_page_outlet'], 'id_outlet');
                                                } else {
                                                $selectedOutlet = [];
                                                }
                                            @endphp

                                            @if (!empty($outlet))
                                                @foreach($outlet as $suw)
                                                    <option value="{{ $suw['id_outlet'] }}" @if (in_array($suw['id_outlet'], $selectedOutlet)) selected @endif>{{ $suw['outlet_name'] }}</option>
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
                                    <input type="checkbox" class="make-switch" id="featureProduct" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (isset($detail['custom_page_product_text'])) checked disabled @elseif (isset($result['custom_page_product_text'])) checked @endif @if (!empty(old('custom_page_product_text'))) checked @endif>
                                    <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>

                        <div class="form-group featureProduct">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <label class="control-label">Title <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="field_product_title" class="form-control featureProductForm" name="custom_page_product_text" @if (isset($detail['custom_page_product_text'])) value="{{$detail['custom_page_product_text']}}" disabled @elseif (isset($result['custom_page_product_text'])) value="{{$result['custom_page_product_text']}}" @else value="{{ old('custom_page_product_text') }}" @endif placeholder="Featured Product Title">
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureProduct">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <label class="control-label">Product <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-8" id="selectProduct">
                                    <select id="field_product_select" class="form-control select2-multiple featureProductForm" multiple data-placeholder="Select Product" name="id_product[]">
                                        <optgroup label="Product List">
                                            @php
                                            if (!empty($result['custom_page_product'])) {
                                                $selectedProduct = array_pluck($result['custom_page_product'], 'id_product');
                                            } elseif (!empty($detail['custom_page_product'])) {
                                                $selectedProduct = array_pluck($detail['custom_page_product'], 'id_product');
                                            } else {
                                                $selectedProduct = [];
                                            }
                                            @endphp
                                            @if (!empty($product))
                                                @foreach($product as $suw)
                                                    <option value="{{ $suw['id_product'] }}" @if (in_array($suw['id_product'], $selectedProduct)) selected @endif>{{ $suw['product_name'] }}</option>
                                                @endforeach
                                            @endif
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- BUTTON FORM -->
                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Featured Button
                                <i class="fa fa-question-circle tooltips" data-original-title="feature button 'ON' jika custom page ingin menggunakan button" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <span class="m-switch">
                                    <label>
                                    <input type="checkbox" class="make-switch" id="featureButton" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (isset($detail['custom_page_button_form'])) checked disabled @elseif (isset($result['custom_page_button_form'])) checked @endif @if (!empty(old('custom_page_button_form'))) checked @endif>
                                    <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>

                        <div class="form-group featureButton">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <label class="control-label">Button Form <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-8" id="selectProduct">
                                    <select class="form-control" id="custom_page_button_form" name="custom_page_button_form" @if (isset($detail)) disabled @endif>
                                        <option value="Call" @if (isset($detail['custom_page_button_form']) && $detail['custom_page_button_form'] == "Call") selected @elseif (isset($result['custom_page_button_form']) && $result['custom_page_button_form'] == "Call") selected @else @endif>Call</option>
                                        <option value="Link" @if (isset($detail['custom_page_button_form']) && $detail['custom_page_button_form'] == "Link") selected @elseif (isset($result['custom_page_button_form']) && $result['custom_page_button_form'] == "Link") selected @else @endif>Link</option>
                                        {{-- <option value="Open Page" @if (isset($detail['custom_page_button_form']) && $detail['custom_page_button_form'] == "Open Page") selected @elseif (isset($result['custom_page_button_form']) && $result['custom_page_button_form'] == "Open Page") selected @else @endif>Open Page</option> --}}
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureButton">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <label class="control-label" id="lable_button_form">Value<span class="required" aria-required=""> * </span> </label>
                                </div>
                                <div id="inputValue" class="col-md-8">
                                    <input type="text" class="form-control" name="custom_page_button_form_text_value" @if (isset($detail['custom_page_button_form_text_value'])) value="{{$detail['custom_page_button_form_text_value']}}" disabled @elseif (isset($result['custom_page_button_form_text_value'])) value="{{$result['custom_page_button_form_text_value']}}" @else value="{{ old('custom_page_button_form_text_value') }}" @endif placeholder="Featured Button Value">
                                </div>
                                {{-- <div hidden id="selectValue" class="col-md-9">
                                    <select class="form-control" id="custom_page_button_form_text" name="custom_page_button_form_text" @if (isset($detail)) disabled @endif>
                                        <option value="Home" @if (isset($detail['custom_page_button_form_text']) && $detail['custom_page_button_form_text'] == "Home") selected @elseif (isset($result['custom_page_button_form_text']) && $result['custom_page_button_form_text'] == "Home") selected @else @endif>Home</option>
                                        <option value="News" @if (isset($detail['custom_page_button_form_text']) && $detail['custom_page_button_form_text'] == "News") selected @elseif (isset($result['custom_page_button_form_text']) && $result['custom_page_button_form_text'] == "News") selected @else @endif>News</option>
                                        <option value="Product" @if (isset($detail['custom_page_button_form_text']) && $detail['custom_page_button_form_text'] == "Product") selected @elseif (isset($result['custom_page_button_form_text']) && $result['custom_page_button_form_text'] == "Product") selected @else @endif>Product</option>
                                        <option value="Outlet" @if (isset($detail['custom_page_button_form_text']) && $detail['custom_page_button_form_text'] == "Outlet") selected @elseif (isset($result['custom_page_button_form_text']) && $result['custom_page_button_form_text'] == "Outlet") selected @else @endif>Outlet</option>
                                        <option value="Inbox" @if (isset($detail['custom_page_button_form_text']) && $detail['custom_page_button_form_text'] == "Inbox") selected @elseif (isset($result['custom_page_button_form_text']) && $result['custom_page_button_form_text'] == "Inbox") selected @else @endif>Inbox</option>
                                        <option value="Deals" @if (isset($detail['custom_page_button_form_text']) && $detail['custom_page_button_form_text'] == "Deals") selected @elseif (isset($result['custom_page_button_form_text']) && $result['custom_page_button_form_text'] == "Deals") selected @else @endif>Deals</option>
                                        <option value="Contact Us" @if (isset($detail['custom_page_button_form_text']) && $detail['custom_page_button_form_text'] == "Contact Us") selected @elseif (isset($result['custom_page_button_form_text']) && $result['custom_page_button_form_text'] == "Contact Us") selected @else @endif>Contact Us</option>
                                        <option value="Link" @if (isset($detail['custom_page_button_form_text']) && $detail['custom_page_button_form_text'] == "Link") selected @elseif (isset($result['custom_page_button_form_text']) && $result['custom_page_button_form_text'] == "Link") selected @else @endif>Link</option>
                                        <option value="Logout" @if (isset($detail['custom_page_button_form_text']) && $detail['custom_page_button_form_text'] == "Logout") selected @elseif (isset($result['custom_page_button_form_text']) && $result['custom_page_button_form_text'] == "Logout") selected @else @endif>Logout</option>
                                    </select>
                                </div> --}}
                            </div>
                        </div>

                        <div class="form-group featureButton">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <label class="control-label">Text Button<span class="required" aria-required=""> * </span> </label>
                                </div>
                                <div id="inputValue" class="col-md-8">
                                    <input type="text" class="form-control" name="custom_page_button_form_text_button" @if (isset($detail['custom_page_button_form_text_button'])) value="{{$detail['custom_page_button_form_text_button']}}" disabled @elseif (isset($result['custom_page_button_form_text_button'])) value="{{$result['custom_page_button_form_text_button']}}" @else value="{{ old('custom_page_button_form_text_button') }}" @endif placeholder="Featured Button Value">
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <hr style="width:95%; margin-left:auto; margin-right:auto; margin-bottom:20px">
                        </div>
                        @if (!isset($detail))
                        <div class="col-md-offset-6 col-md-4">
                            <button type="submit" class="btn green">Submit</button>
                            <!-- <button type="button" class="btn default">Cancel</button> -->
                        </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection