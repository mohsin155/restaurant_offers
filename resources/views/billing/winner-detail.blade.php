@extends('layouts.default')
@section('content')
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Restaurant Details
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-8">
                <table class="table table-bordered table-responsive table-striped">
                    <tr>
                        <th>Winner details</th>
                    </tr>
                    <tr>
                        <th>First Name</th>
                        <td>{{$winner->user->first_name}}</td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td>{{$winner->user->last_name}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$winner->user->email}}</td>
                    </tr>
                    <tr>
                        <th>Mobile Number</th>
                        <td>{{$winner->user->mobile_number}}</td>
                    </tr>
                </table>
                <table class="table table-bordered table-responsive table-striped">
                    <tr>
                        <th>Restaurant details</th>
                    </tr>
                    <tr>
                        <th>Owner Name</th>
                        <td>{{$winner->restaurant->first_name}}&nbsp;{{$winner->restaurant->last_name}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$winner->restaurant->email}}</td>
                    </tr>
                    <tr>
                        <th>Mobile Number</th>
                        <td>{{$winner->restaurant->mobile_number}}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{$winner->restaurant->address}}</td>
                    </tr>
                    <tr>
                        <th>Restaurant Name</th>
                        <td>{{$winner->restaurant->restaurant_name}}</td>
                    </tr>
                </table>
                <table class="table table-bordered table-responsive table-striped">
                    <tr>
                        <th>Billing details</th>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td>{{$winner->amount}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><img src="{{url('uploads/restaurant')}}/{{$winner->bill_image}}" height="200" width="300" /></td>
                    </tr>
                </table>
            </div>
                
        </div>
    </div></div>
@endsection