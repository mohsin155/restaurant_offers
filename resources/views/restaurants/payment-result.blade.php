@extends('restaurants.layouts.default')
@section('title','Dashboard')
@section('content')
<div class="pageheader">
    <div class="pageicon"><span class="iconfa-pencil"></span></div>
    <div class="pagetitle">
        <h5>Payment</h5>
        <h1>Payment Status</h1>
    </div>
</div><!--pageheader-->

<div class="maincontent">
    <div class="maincontentinner">

        <div class="widget">
            <h4 class="widgettitle">Payment Status</h4>
            <div class="widgetcontent">
                @if($status)
                <div class="alert alert-danger">
                    <ul>
                        <li>{{$message}}</li>
                    </ul>
                </div>
                @else
                <div class="alert alert-success">
                    <ul>
                        <li>{{$message}}</li>
                    </ul>
                </div>
                @endif
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
@endsection