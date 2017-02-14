@extends('restaurants.layouts.default')
@section('title','Dashboard')
@section('content')
<div class="pageheader">
    <a href="{{url('businesses/login')}}"><button class="btn btn-primary searchbar">Signin</button></a>
    <div class="pageicon"><span class="iconfa-pencil"></span></div>
    <div class="pagetitle">
        <h5>Signup</h5>
        <h1>Register your details</h1>
    </div>
</div><!--pageheader-->

<div class="maincontent">
    <div class="maincontentinner">

        <div class="widget">
            <h4 class="widgettitle">Registration Form</h4>
            <div class="widgetcontent">
                @if(!empty($errors) && count($errors)>0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors as $messages)
                        <li> {{$messages}} </li>
                        @endforeach
                    </ul>
                </div>
                @elseif(session('success'))
                <div class="alert alert-success">
                    <ul>
                        <li> {{session('success')}} </li>
                    </ul>
                </div>
                @endif
                <form class="stdform" action="{{url('businesses/signup')}}" enctype="multipart/form-data" method="post" />
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <p>
                    <label>First Name</label>
                    <span class="field"><input type="text" name="first_name" class="input-xxlarge" value="{{old('first_name')}}" placeholder="First Name" /></span>
                </p>
                <p>
                    <label>Last Name</label>
                    <span class="field"><input type="text" name="last_name" class="input-xxlarge" value="{{old('last_name')}}" placeholder="Last Name" /></span>
                </p>
                <p>
                    <label>Email</label>
                    <span class="field"><input type="email" name="email" class="input-xxlarge" value="{{old('email')}}" placeholder="email" /></span>
                </p>
                <p>
                    <label>Mobile Number</label>
                    <span class="field"><input type="text" name="mobile_number" class="input-xxlarge" value="{{old('mobile_number')}}" placeholder="Mobile Number" /></span>
                </p>
                <p>
                    <label>Password</label>
                    <span class="field"><input type="password" name="password" class="input-xxlarge" value="{{old('password')}}" placeholder="Password" /></span>
                </p>
                <p>
                    <label>Restaurant Name</label>
                    <span class="field"><input type="text" name="restaurant_name" class="input-xxlarge" value="{{old('restaurant_name')}}" placeholder="First Name" /></span>
                </p>
                <p>
                    <label>Restaurant Details</label>
                    <span class="field"><textarea id="autoResizeTA" cols="80" rows="5" class="span5" style="resize: vertical" name="description">{{old('description')}}</textarea></span> 
                </p>
                <p>
                    <label>Logo</label>
                    <span class="field"><input type="file" name="image" class="input-xxlarge" value="" /></span>
                </p>
                <p>
                    <label>Restaurant Address</label>
                    <span class="field"><textarea id="autoResizeTA" cols="80" rows="5" class="span5 address" style="resize: vertical" name="address">{{old('address')}}</textarea></span> 
                </p>
                <input name="latitude" class="form-control"  type="hidden"  value="{{old('latitude')}}">
                <input name="longitude" class="form-control"  type="hidden"  value="{{old('longitude')}}">
                <p>
                    <label onclick="show_map()">Locate Me</label> 
                <div id="map_canvas" style="display: none;width: 800px;height: 400px;"></div>
                </p>
                <p class="stdformbutton">
                    <button class="btn btn-primary" type="submit">Register Me</button>
                </p>

                </form>
            </div><!--widgetcontent-->
        </div><!--widget-->
        <div class="footer">
            <div class="footer-left">
                <span>&copy; 2017. All Rights Reserved.</span>
            </div>
            <div class="footer-right">
                <span>Designed by: <a href="">Evalueweb</a></span>
            </div>
        </div><!--footer-->

    </div><!--maincontentinner-->
</div><!--maincontent-->

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDStGALIlafC5yq2Qw1hPBUSBG9Pz0drOY&callback=show_map"></script>
<script>

                        function show_map() {
                            $('#map_canvas').css('display', 'block');
                            if ($('input[name=latitude]').val() != '') {
                                $latitude = $('input[name=latitude]').val();
                            } else {
                                $latitude = 22.973423;
                            }
                            if ($('input[name=longitude]').val() != '') {
                                $longitude = $('input[name=longitude]').val();
                            } else {
                                $longitude = 78.656894;
                            }
                            var map;
                            var elevator;
                            var myOptions = {
                                scrollwheel: false,
                                zoom: 6,
                                center: new google.maps.LatLng($latitude, $longitude),
                                mapTypeId: 'roadmap'
                            };
                            map = new google.maps.Map($('#map_canvas')[0], myOptions);
                            var address = $("#address").val();
                            $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + address + '&sensor=false', null, function (data) {
                                var p = data.results[0].geometry.location;
                                $('input[name^=latitude]').val(p.lat);
                                $('input[name^=longitude]').val(p.lng);
                                //alert($('input[name^=latitude]').eq(x).val());
                                //alert(loopKey+'-'+$('input[name^=longitude]').eq(x).val());
                                var latlng = new google.maps.LatLng(p.lat, p.lng);
                                var marker = new google.maps.Marker({
                                    position: latlng,
                                    map: map,
                                    draggable: true,
                                });
                                google.maps.event.addListener(marker, 'dragend', function (event) {
                                    $('input[name^=latitude]').val(event.latLng.lat());
                                    $('input[name^=longitude]').val(event.latLng.lng());
                                    //alert(event.latLng.lat() + ',' + event.latLng.lng());
                                });
                            });
                        }
</script>
@endsection

