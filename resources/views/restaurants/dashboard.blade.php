@extends('restaurants.layouts.default')
@section('title','Dashboard')
@section('content')
<div class="maincontent">
    <div class="maincontentinner">

        <div class="widget">
            <h2 class="widgettitle"><a href="{{url('businesses/profile')}}" style="color: #ffff;">Udate Profile</a></h2>
            <div class="widgetcontent">

                <dl class="dl-horizontal">
                    <dt>First name</dt>
                    <dd>{{$restaurant->first_name}}</dd>
                    <dt>Last name</dt>
                    <dd>{{$restaurant->last_name}}</dd>
                    <dt>Email</dt>
                    <dd>{{$restaurant->email}}</dd>
                    <dt>Mobile Number</dt>
                    <dd>{{$restaurant->mobile_number}}</dd>
                    <dt>Restaurant Name</dt>
                    <dd>{{$restaurant->restaurant_name}}</dd>
                    <dt>Restaurant Details</dt>
                    <dd>{{$restaurant->description}}</dd>
                    <dt>Restaurant Address</dt>
                    <dd>{{$restaurant->address}}</dd>
                    <dt>Restaurant City</dt>
                    <dd>{{$restaurant->city}}</dd>
                    <dt>Restaurant Province</dt>
                    <dd>{{$restaurant->province}}</dd>
                    <dt>Restaurant Postal</dt>
                    <dd>{{$restaurant->postal_code}}</dd>
                    <dt>Logo</dt>
                    <dd><img src="{{url('uploads/restaurant')}}/{{$restaurant->image}}" height="100" width="100" /></dd>
                    <dt>Gallery</dt>
                    @if(!empty($restaurant->gallery))
                    @foreach($restaurant->gallery as $gal)

                    <dd><img src="{{url('uploads/restaurant/gallery')}}/{{$gal->image_name}}" style="height: 100px;width: 100px;" /></dd>
                    @endforeach
                    @endif
                </dl>
            </div><!--widgetcontent-->
        </div>


        <div class="footer">
            <div class="footer-left">
                <span>&copy; 2017. All Rights Reserved.</span>
            </div>
            <div class="footer-right">
                <span>Designed by: <a href="">Evalueweb</a></span>
            </div>
        </div><!--footer-->
    </div></div>
@endsection