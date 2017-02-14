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
                        <th>First Name</th>
                        <td>{{$business->first_name}}</td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td>{{$business->last_name}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$business->first_name}}</td>
                    </tr>
                    <tr>
                        <th>Mobile Number</th>
                        <td>{{$business->mobile_number}}</td>
                    </tr>
                    <tr>
                        <th>Restaurant Name</th>
                        <td>{{$business->restaurant_name}}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{$business->description}}</td>
                    </tr>
                    <tr>
                        <th>Image</th>
                        <td><img src="{{url('uploads/restaurant')}}/{{$business->image}}" /></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <form action="{{url('businesses/update-status')}}/{{$business->user_id}}" method="post">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <select name="status">
                                <option value="0" <?php echo $business->status==0?"selected":"";?>>Inactive</option>
                                <option value="1"  <?php echo $business->status==1?"selected":"";?>>Active</option></select>
                            <input type="submit" value="Update status" />
                            </form>
                        </td>
                    </tr>
                </table>
                
            </div>
                
        </div>
    </div></div>
@endsection