<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs     = session('configs');
 ?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOHBNv3Td9_zb_7uW-AJDU6DHFYk-8e9Y&v=3.exp&signed_in=true&libraries=places"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $('.timepicker').timepicker({
            autoclose: true,
            minuteStep: 5,
            showSeconds: false,

        });
        // sortable
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();
    </script>
    <script>
        var map;

        var markers = [];

        function initialize(latNow, longNow) {
          var haightAshbury = new google.maps.LatLng(latNow,longNow);
          var marker        = new google.maps.Marker({
            position:new google.maps.LatLng(latNow,longNow),
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
              // marker.openInfoWindowHtml(latLng);
              // infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
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

        google.maps.event.addDomListener(window, 'load', initialize());
    </script>

    <script type="text/javascript">

        $(document).ready(function(){
            /* MAPS */
            longNow = "{{ $outlet[0]['outlet_longitude'] }}";
            latNow = "{{ $outlet[0]['outlet_latitude'] }}";

            if (latNow == "" || longNow == "") {
              navigator.geolocation.getCurrentPosition(function(position){
                  initialize(position.coords.latitude, position.coords.longitude);
              },
              function (error) {
                if (error.code == error.PERMISSION_DENIED)
                  initialize(-7.7972, 110.3688);
              });
            }
            else {
              initialize(latNow, longNow);
            }

            /*=====================================*/

            // untuk show atau hide informasi photo
            if ($('.deteksi').data('dis') != 1) {
                $('.deteksi-trigger').hide();
            }
            else {
                $('.deteksi-trigger').show();
            }

            let token = "{{ csrf_token() }}";

            // hapus gambar
            $('.hapus-gambar').click(function() {
                let id     = $(this).data('id');
                let parent = $(this).parent().parent().parent().parent();

                $.ajax({
                    type : "POST",
                    url : "{{ url('outlet/photo/delete') }}",
                    data : "_token="+token+"&id_outlet_photo="+id,
                    success : function(result) {

                        if (result == "success") {
                            parent.remove();
                            toastr.info("Photo has been deleted.");
                        }
                        else {
                            toastr.warning("Something went wrong. Failed to delete photo.");
                        }
                    }
                });
            });

            // change info
            $('#infoOutlet').click(function() {
            //   initialize();
            // console.log(latNow)
            // console.log(latNow)

            // initialize(latNow, longNow);

            });

            $('#province').change(function() {
                var isi         = $('#province').val();

                $.ajax({
                    type    : "POST",
                    url     : "<?php echo url('outlet/get/city')?>",
                    data    : "_token="+token+"&id_province="+isi,
                    success : function(result) {
                        if (result['status'] == "success") {
                            $('#city').prop('disabled', false);

                            var city           = result['result'];
                            var selectCity = '<option value=""></option>';

                            for (var i = 0; i < city.length; i++) {
                                selectCity += '<option value="'+city[i]['id_city']+'|'+city[i]['city_postal_code']+'" >'+city[i]['city_name']+'</option>';
                            }

                            $('#city').html(selectCity);
                        }
                        else {
                            $('#city').prop('disabled', true);
                        }
                    }
                });
            });

            $('#city').change(function() {
                var isi = $('#city').val();

                var isi = isi.split('|');

                $('#id_city').val(isi[0]);
            });

        });
    </script>

    <script type="text/javascript">
        $('#sample_1').dataTable({
            order: [0, "asc"],
            "columnDefs": [
                { "width": "100", "targets": 0 }
            ]
        });
        $('#sample_1').on('click', '.delete', function() {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('outlet/detail/'.$outlet[0]['outlet_code'].'/admin/delete') }}",
                data : "_token="+token+"&id_user_outlet="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Admin Outlet has been deleted.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete admin outlet.");
                    }
                }
            });
        });
        $(".file").change(function(e) {
            var widthImg  = 600;
            var heightImg = 300;

            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (this.width == widthImg && this.height == heightImg) {
                        // image.src = _URL.createObjectURL(file);
                       $('#formimage').submit()
                    }
                    else {
                        toastr.warning("Please check dimension of your photo.");
                        $(this).val("");

                        $('#imageoutlet').children('img').attr('src', 'https://www.placehold.it/600x300/EFEFEF/AAAAAA&amp;text=no+image');
                    }
                };

                image.src = _URL.createObjectURL(file);
            }

        });
    </script>
    <script type="text/javascript">
    $(document).on('click', '.same', function() {
      var open = $(this).parent().parent().parent().find('.kelas-open').val();
      var close = $(this).parent().parent().parent().find('.kelas-close').val();
      if (open == '') {
        alert('Open field cannot be empty');
        $(this).parent().parent().parent().find('.kelas-open').focus();
        return false;
      }

      if (close == '') {
        alert('Close field cannot be empty');
        $(this).parent().parent().parent().find('.kelas-close').focus();
        return false;
      }

      if ($(this).is(':checked')) {
        var check = $('input[name="ampas[]"]:checked').length;
        var count = $('.same').prop('checked', false);
        $(this).prop('checked', true);

        if (check == 1) {
            var all_open = $('.kelas-open');
            var array_open = [];
            for (i = 0; i < all_open.length; i++) {
              array_open.push(all_open[i]['defaultValue']);
            }
            sessionStorage.setItem("item_open", array_open);

            var all_close = $('.kelas-close');
            var array_close = [];
            for (i = 0; i < all_close.length; i++) {
              array_close.push(all_close[i]['defaultValue']);
            }
            sessionStorage.setItem("item_close", array_close);
        }

        $('.kelas-open').val(open);
        $('.kelas-close').val(close);

      } else {

          var item_open = sessionStorage.getItem("item_open");
          var item_close = sessionStorage.getItem("item_close");

          var myarr_open = item_open.split(",");
          var myarr_close = item_close.split(",");
          $('.kelas-open').each(function(i, obj) {
              $(this).val(myarr_open[i]);
          });

          $('.kelas-close').each(function(i, obj) {
              $(this).val(myarr_close[i]);
          });

          $(this).parent().parent().parent().find('.kelas-open').val(open);
          $(this).parent().parent().parent().find('.kelas-close').val(close);
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

    <div class="portlet light bordered">
        <div class="portlet-title tabbable-line">
            <div class="caption">
                <span class="caption-subject font-blue bold uppercase">{{ $outlet[0]['outlet_code'] }}</span>
            </div>
            <ul class="nav nav-tabs">

                <li class="active" id="infoOutlet">
                    <a href="#info" data-toggle="tab" > Info </a>
                </li>
{{--                <li id="pinOutlet">--}}
{{--                    <a href="#pin" data-toggle="tab" > Update Pin </a>--}}
{{--                </li>--}}
                @if(MyHelper::hasAccess([29], $grantedFeature))
                    <li>
                        <a href="#photo" data-toggle="tab"> Photo </a>
                    </li>
                @endif
                @if(MyHelper::hasAccess([4], $configs))
                    @if(MyHelper::hasAccess([34], $grantedFeature))
                        <li>
                            <a href="#holiday" data-toggle="tab"> Holiday </a>
                        </li>
                    @endif
                @endif
                @if(MyHelper::hasAccess([5], $configs))
                    @if(MyHelper::hasAccess([39,40,41], $grantedFeature))
                        <li>
                            <a href="#admin" data-toggle="tab"> Admin Outlet </a>
                        </li>
                    @endif
                @endif
                <li>
                    <a href="#schedule" data-toggle="tab"> Schedule </a>
                </li>
            </ul>
        </div>
        <div class="portlet-body">
            <div class="tab-content">
                <div class="tab-pane active" id="info">
                    @include('outlet::info')
                </div>
                <div class="tab-pane" id="pin">
                    @include('outlet::pin')
                </div>
                <div class="tab-pane" id="photo">
                    @include('outlet::photo')
                </div>
                <div class="tab-pane" id="holiday">
                    @include('outlet::holiday')
                </div>
                <div class="tab-pane" id="admin">
                    @include('outlet::admin')
                </div>
                <div class="tab-pane" id="schedule">
                    @include('outlet::schedule_open')
                </div>
            </div>
        </div>
    </div>


@endsection