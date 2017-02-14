<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Restaurants</title>
<link rel="stylesheet" href="{{url('restaurants/css/style.default.css')}}" type="text/css" />
<link rel="stylesheet" href="{{url('restaurants/css/style.shinyblue.css')}}" type="text/css" />

<script type="text/javascript" src="{{url('restaurants/js/jquery-1.9.1.min.js')}}"></script>
<script type="text/javascript" src="{{url('restaurants/js/jquery-migrate-1.1.1.min.js')}}"></script>
<script type="text/javascript" src="{{url('restaurants/js/jquery-ui-1.9.2.min.js')}}"></script>
<script type="text/javascript" src="{{url('restaurants/js/modernizr.min.js')}}"></script>
<script type="text/javascript" src="{{url('restaurants/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{url('restaurants/js/jquery.cookie.js')}}"></script>
<script type="text/javascript" src="{{url('restaurants/js/custom.js')}}"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body class="loginpage">

<div class="loginpanel">
    <div class="loginpanelinner">
        <div class="logo animate0 bounceIn"><img src="{{url('logo.jpg')}}" alt="" width="70px"/></div>
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
        <form id="login" action="{{url('businesses/login')}}" method="post" />
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="inputwrapper login-alert">
                <div class="alert alert-error">Invalid username or password</div>
            </div>
            <div class="inputwrapper animate1 bounceIn">
                <input type="email" name="email" id="email" placeholder="Email" value="{{old('email')}}" />
            </div>
            <div class="inputwrapper animate2 bounceIn">
                <input type="password" name="password" value="{{old('password')}}" id="password" placeholder="Password" />
            </div>
            <div class="inputwrapper animate3 bounceIn">
                <button name="submit">Sign In</button>
                
            </div>
        </form>
        <label style="color:#ffff;text-align: center;">Or</label>
            <div class="inputwrapper animate4 bounceIn">
                <a href="{{url('businesses/signup')}}"><button>Signup</button></a>
            </div>
            
        
    </div><!--loginpanelinner-->
</div><!--loginpanel-->

<div class="loginfooter">
    <p>&copy; 2017. All Rights Reserved.</p>
</div>

</body>
</html>

