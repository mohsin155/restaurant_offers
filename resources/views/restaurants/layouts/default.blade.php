<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Restaurant Offers</title>
<link rel="stylesheet" href="{{url('restaurants/css/style.default.css')}}" type="text/css" />

<link rel="stylesheet" href="{{url('restaurants/css/responsive-tables.css')}}" />
<script type="text/javascript" src="{{url('restaurants/js/jquery-1.9.1.min.js')}}"></script>
<script type="text/javascript" src="{{url('restaurants/js/jquery-migrate-1.1.1.min.js')}}"></script>
<script type="text/javascript" src="{{url('restaurants/js/jquery-ui-1.9.2.min.js')}}"></script>
<script type="text/javascript" src="{{url('restaurants/js/modernizr.min.js')}}"></script>
<script type="text/javascript" src="{{url('restaurants/js/bootstrap.min.js')}}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body>

<div class="mainwrapper">
    
    <div class="header">
        <div class="logo"><img src="{{url('logo.jpg')}}" alt="" />
        </div>
        <div class="headerinner">
            <ul class="headmenu">
                
                <li class="right">
                    <div class="userloggedinfo">
                        <!--<img src="images/photos/thumb1.png" alt="" />-->
                        <div class="userinfo">
                            <h5>{{Auth::user()->first_name}} <small>- {{Auth::user()->email}}</small></h5>
                            <ul>
                                <li><a href="{{url('businesses/branches')}}">Branches</a></li>
                                <li><a href="{{url('businesses/profile')}}">Account Settings</a></li>
                                <li><a href="{{url('businesses/logout')}}">Sign Out</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul><!--headmenu-->
        </div>
    </div>
    
    <div class="rightpanel" style="margin-left: 0px;">
        @yield('content')
        
    </div><!--rightpanel-->
    
</div><!--mainwrapper-->
</body>
</html>
