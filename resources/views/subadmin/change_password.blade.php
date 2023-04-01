@extends('subadmin.master')
@section('content')
    <div class="row nomargin" style="margin-top:200px;">
        <div class="col-md-4 col-md-offset-4">
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Enter Current Password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Enter New Password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Confirm Password">
            </div>
            <div class="form-group">
                <input type="submit" class="form-control change" value="Save">
            </div>
        </div>
    </div>
@endsection