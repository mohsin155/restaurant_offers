@extends('restaurants.layouts.default')
@section('title','Dashboard')
@section('content')
<div class="pageheader">
    <div class="pageicon"><span class="iconfa-pencil"></span></div>
    <div class="pagetitle">
        <h5>My profile</h5>
        <h1>Update your profile</h1>
    </div>
</div><!--pageheader-->

<div class="maincontent">
    <div class="maincontentinner">

        <div class="widget">
            <h4 class="widgettitle">Profile</h4>
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
                <form class="stdform" action="{{url('businesses/profile')}}" enctype="multipart/form-data" method="post" />
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <p>
                    <label>First Name</label>
                    <span class="field"><input type="text" name="first_name" class="input-xxlarge" value="<?php if(Request::old('first_name')){ echo Request::old('first_name');}elseif(isset($restaurant)){echo $restaurant->first_name;}?>" placeholder="First Name" /></span>
                </p>
                <p>
                    <label>Last Name</label>
                    <span class="field"><input type="text" name="last_name" class="input-xxlarge" value="<?php if(Request::old('last_name')){ echo Request::old('last_name');}elseif(isset($restaurant)){echo $restaurant->last_name;}?>" placeholder="Last Name" /></span>
                </p>
                <p>
                    <label>Email</label>
                    <span class="field"><input type="email" name="email" class="input-xxlarge" value="<?php if(Request::old('email')){ echo Request::old('email');}elseif(isset($restaurant)){echo $restaurant->email;}?>" placeholder="email" /></span>
                </p>
                <p>
                    <label>Mobile Number</label>
                    <span class="field"><input type="text" name="mobile_number" class="input-xxlarge" value="<?php if(Request::old('mobile_number')){ echo Request::old('mobile_number');}elseif(isset($restaurant)){echo $restaurant->mobile_number;}?>" placeholder="Mobile Number" /></span>
                </p>
                <p>
                    <label>Restaurant Name</label>
                    <span class="field"><input type="text" name="restaurant_name" class="input-xxlarge" value="<?php if(Request::old('restaurant_name')){ echo Request::old('restaurant_name');}elseif(isset($restaurant)){echo $restaurant->restaurant_name;}?>" placeholder="First Name" /></span>
                </p>
                <p>
                    <label>Restaurant Details</label>
                    <span class="field"><textarea id="autoResizeTA" cols="80" rows="5" class="span5" style="resize: vertical" name="description"><?php if(Request::old('description')){ echo Request::old('description');}elseif(isset($restaurant)){echo $restaurant->description;}?></textarea></span> 
                </p>
                <p>
                    <label>Logo</label>
                    <span class="field"><input type="file" name="image" class="input-xxlarge" value="" /></span>
                    
                </p>
                <p>
                    <label></label>
                    <span class="field">
                    <img src="{{url('uploads/restaurant')}}/{{$restaurant->image}}" height="100" width="100" /></span>
                    
                </p>
                <span id="img">
                <p>
                    <label>Gallery</label>
                    <span class="field"></span>
                </p>
                @if(!empty($restaurant->gallery))
                @foreach($restaurant->gallery as $gal)
                <p>
                    <span class="field">
                        <img src="{{url('uploads/restaurant/gallery')}}/{{$gal->image_name}}" style="width:100px;height: 100px;" />
                        <a class="btn trash" href="javascript:void(0);" data-id="{{$gal->image_id}}" title="Trash"><span class="icon-trash"></span></a>
                    </span>
                </p>
                @endforeach
                @endif
                <?php for($i=0;$i<5-count($restaurant->gallery);$i++){?>
                <p>
                    <span class="field"><input type="file" name="gallery[]" class="input-xxlarge" value="" /></span>
                </p>
                <?php } ?>
                </span>
                <p>
                    
                    <label>Restaurant Address</label>
                    <span class="field"><textarea id="autoResizeTA" cols="80" rows="5" class="span5 address" style="resize: vertical" name="address"><?php if(Request::old('address')){ echo Request::old('address');}elseif(isset($restaurant)){echo $restaurant->address;}?></textarea></span> 
                </p>
                <p>
                    <label>City</label>
                    <span class="field"><input type="text" name="city" class="input-xxlarge" value="<?php if(Request::old('city')){ echo Request::old('city');}elseif(isset($restaurant)){echo $restaurant->city;}?>" /></span>
                </p>
                <p>
                    <label>Province</label>
                    <span class="field"><input type="text" name="province" class="input-xxlarge" value="<?php if(Request::old('province')){ echo Request::old('province');}elseif(isset($restaurant)){echo $restaurant->province;}?>" /></span>
                </p>
                <p>
                    <label>POstal Code</label>
                    <span class="field"><input type="text" name="postal_code" class="input-xxlarge" value="<?php if(Request::old('postal_code')){ echo Request::old('postal_code');}elseif(isset($restaurant)){echo $restaurant->postal_code;}?>" /></span>
                </p>
                <!--<input name="latitude" class="form-control"  type="hidden"  value="<?php if(Request::old('latitude')){ echo Request::old('latitude');}elseif(isset($restaurant)){echo $restaurant->latitude;}?>">
                <input name="longitude" class="form-control"  type="hidden"  value="<?php if(Request::old('longitude')){ echo Request::old('longitude');}elseif(isset($restaurant)){echo $restaurant->longitude;}?>">
                <p>
                    <label onclick="show_map()">Locate Me</label> 
                <div id="map_canvas" style="display: none;width: 800px;height: 400px;"></div>
                </p>-->
                <p class="stdformbutton">
                    <button class="btn btn-primary" type="submit">Update</button>
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
$(".trash").on('click',function(){
    var image = $(this).attr('data-id');
    var cur = this;
   $.ajax({
      url:'image-delete',
      data:{image_id:image},
      type:"get",
      success:function(data){
          $(cur).parent().parent().remove();
          $("#img").append('<p><span class="field"><input type="file" name="gallery[]" class="input-xxlarge" value="" /></span></p>');
      }
   }); 
});
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
                            var address = $(".address").val();
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

