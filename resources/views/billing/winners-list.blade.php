@extends('layouts.default')
@section('content')
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <span>Winners List</span>
                    <!--<span>
                        <a href="{{url('businesses/create-business')}}">
                            <button type="button" class="btn btn-primary" style="float:right;">Add Restaurant</button>
                        </a>
                    </span>-->
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
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
                <div class="table-responsive">
                    <table id="list-table" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Winner</th>
                                <th>Restaurant</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($winners)>0)
                            @foreach($winners as $winner)
                            <tr>
                                <td>{{$winner->name}}</td>
                                <td>{{$winner->restaurant}}</td>
                                <td>{{$winner->amount}}</td>
                                <td><a href="{{url('billing/winner-details')}}/{{$winner->winner_id}}" class="glyphicon glyphicon-eye-open"></a></td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
