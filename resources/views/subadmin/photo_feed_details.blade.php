@extends('subadmin.master')
@section('content')
<style>
label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 5px;
    font-weight: 700;
    color: #5fa4df;
}
.fa, .fas {
    font-weight: 900;
    color: #5fa4df;
}
body {
    min-height: 100vh;
    font-family: 'Poppins' !important;
    color: #3f3d56;
    box-shadow: 0 0 6px 0 rgb(0 0 0 / 25%);
    background-image: linear-gradient(179deg, rgba(132, 223, 253, 0) 10%, rgba(132, 223, 253, 0.10) 80%, rgba(0, 130, 241, 0.15) 98%) !important;
}
</style>
    <div class="row nomargin">
        <div class="col-md-9">
            <h1>Photo-feed Details</h1>
        </div>
        <div class="col-md-3">
            <div class="container">
                <!-- Trigger the modal with a button -->

            </div>
        </div>
    </div>
    <div class="col-md-6" style="margin: 25px; left: 320px;">
    <div class="card-body">
                <div class="card-header">
                
                <label>{{$media['project']['name']}}<label>
              
                </div>
                <div class="row">

                <div class="col-md-4">
                <label>Area</label>
                {{$media['category']['name']}}
                </div>

                <div class="col-md-4">
                <label>Lat:</label>
                {{$media['project']['latitude']}}
                <label>Long:</label>
                {{$media['project']['longitude']}}
                </div>

                <div class="col-md-4">
                <label>Inspection Date</label>
                {{\Carbon\Carbon::parse($media['project']['inspection_date'])->format('m/d/y') }}
                </div>
                </div>

                <div class="card-img">
                <img src="{{URL::to('uploads/media/'.$media['path'] )}}" class="img-responsive">
                </div>
                
                    <div class="row">
                    <div class="col-md-4">
                    <label>Photo Tag</label>
                    {{$media['area']['name']}}
                    </div>
                    <div class="col-md-4">
                    <label>Claim #</label>
                    {{$media['project']['claim_num']}}
                    </div>

                    <div class="col-md-4">
                    <label>Qty</label>
                    {{$media['category']['min_quantity']}}
                    </div>
                    </div>

                <div class="row">
                <div class="col-md-12">
                <label>Annotation:</label>
                {{$media['note']}}
                </div>
                </div>
                  
                <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-6"></div>
                <div class="col-md-2">
                <a href="{{url('subadmin/photo_feed/edit/'.$id)}}">
                <i class="fa fa-pen pl-1"></i><label>Edit</label></a>
                </div>
                </div>         
</div>
</div>

@endsection







