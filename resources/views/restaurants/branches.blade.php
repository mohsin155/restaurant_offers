@extends('restaurants.layouts.default')
@section('title','Dashboard')
@section('content')
<div class="pageheader">
            
            <div class="pageicon"><span class="iconfa-table"></span></div>
            <div class="pagetitle">
                <h5>Branches</h5>
                <h1><a href="{{url('businesses/register-branch')}}">Register New</a></h1>
            </div>
        </div><!--pageheader-->
        <div class="maincontent" style="min-height: 500px;">
    <div class="maincontentinner">
        <h4 class="widgettitle">Restaurant Branches</h4>
        <table class="table table-bordered responsive">
            <colgroup>
                <col class="con0" />
                <col class="con1" />
                <col class="con0" />
                <col class="con1" />
                <col class="con0" />
            </colgroup>
            <thead>
                <tr>
                    <th>Branch Manager</th>
                    <th>Branch Manager</th>
                    <th>Email</th>
                    <th>Location</th>
                    <th>Phone Number</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($branches))
                @foreach($branches as $row)
                <tr>
                    <td>{{$row->first_name}}&nbsp;{{$row->last_name}}</td>
                    <td>{{$row->first_name}}&nbsp;{{$row->last_name}}</td>
                    <td>{{$row->email}}</td>
                    <td>{{$row->address}}</td>
                    <td>{{$row->mobile_number}}</td>
                    <td>@if($row->subscription)
                        Subscribed
                        @else
                        <a href="{{url('businesses/payment-do').'/'.$row->user_id}}">Pending
                        @endif
                    </td>
                    <td>
                        @if(Auth::user()->user_id == $row->user_id)
                        <a href="{{url('businesses/profile').'/'.$row->user_id}}">
                        @else
                        <a href="{{url('businesses/update-branch').'/'.$row->user_id}}">
                        @endif
                        <i class="icon-edit"></i></a>&nbsp;|&nbsp;<i class="icon-trash"></i></td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

        <div class="divider15"></div>


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