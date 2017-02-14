@extends('restaurants.layouts.default')
@section('title','Dashboard')
@section('content')
<div class="pageheader">
            
            <div class="pageicon"><span class="iconfa-table"></span></div>
            <div class="pagetitle">
                <h5>Payment</h5>
                <h1><a href="#">Pay Now</a></h1>
            </div>
        </div><!--pageheader-->
        <div class="maincontent" style="min-height: 500px;">
    <div class="maincontentinner">
        <div class="widget">
            <h4 class="widgettitle">Profile</h4>
            <div class="widgetcontent">
                <p>Test card : 378282246310005</p>
                <p>Test Expiration Date : 01/2024</p>
<form class="stdform" id="checkout" method="post" action="{{url('businesses/add-order')}}">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <input type="hidden" name="user_id" value="{{$user_id}}" />
    <input type="hidden" name="amount" value="10" />
  <div id="payment-form"></div>

  <p class="stdformbutton">
                    <button class="btn btn-primary" type="submit">Pay $10</button>
                </p>
</form>
            </div></div>
        <div class="footer">
            <div class="footer-left">
                <span>&copy; 2017. All Rights Reserved.</span>
            </div>
            <div class="footer-right">
                <span>Designed by: <a href="">Evalueweb</a></span>
            </div>
        </div><!--footer-->
    </div></div>
        
<script src="https://js.braintreegateway.com/js/braintree-2.30.0.min.js"></script>
<script>
// We generated a client token for you so you can test out this code
// immediately. In a production-ready integration, you will need to
// generate a client token on your server (see section below).
var clientToken = "{{$client_token}}";

braintree.setup(clientToken, "dropin", {
  container: "payment-form"
});
</script>
@endsection