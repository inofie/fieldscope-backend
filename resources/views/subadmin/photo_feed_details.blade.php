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
.add-btns {
    width: 90px;
    height: 30px;
    color: #000 !important;
    background: #80dfff;
    color: #fff;
    text-transform: capitalize;
    cursor: pointer;
    border: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0;
    padding: 0 !important;
}
.flxSet {
    display: flex;
}
.card-body.setBody {
    padding: 0;
}
.card-body.setBody .card-header h2{
    background:#209fcb;
    padding: 10px;
}
.card-body.setBody .row {
    padding: 0 15px;
}
.card-body.setBody .card-img {
    padding: 0 15px;
    margin-bottom: 15px;
    margin-top: 15px;
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
    <div class="card-body setBody">
                <div class="card-header">
                
                <h2>{{$media['project']['name']}}</h2>
              
                </div>
                <div class="row">

                <div class="col-md-4" style="right: 1px;padding: 0 0 6px 0;">
                <label>Area</label>
                {{$media['category']['name']}}
                </div>

                <div class="col-md-4">
                    <div class="flxSet">
                    <div class="flxSetOne">
                    <label>Lat:</label>
                {{$media['project']['latitude']}}
                    </div>
                    <div class="flxSetOne">
                    <label>Long:</label>
                {{$media['project']['longitude']}}
                    </div>
                </div>
                
                
               
                </div>

                <div class="col-md-4" style="left: 50px;padding: 0 0 6px 0;">
                <label>Inspection Date</label>
                {{\Carbon\Carbon::parse($media['project']['inspection_date'])->format('m/d/y') }}
                </div>
                </div>

                <div class="card-img">
                <img src="{{URL::to('uploads/media/'.$media['path'] )}}" class="img-responsive">
                </div>
                
                    <div class="row">
                    <div class="col-md-4" style="right: 1px;padding: 0 0 6px 0;">
                    <label>Photo Tag</label>
                    {{$media['area']['name']}}
                    </div>
                    <div class="col-md-4">
                    <label>Claim #</label>
                    {{$media['project']['claim_num']}}
                    </div>

                    <div class="col-md-4" style="left: 50px;padding: 0 0 6px 0;">
                    <label>Qty</label>
                    {{$media['category']['min_quantity']}}
                    </div>
                    </div>

                <div class="row">
                <div class="col-md-12" style="right: 1px;padding: 0 0 6px 0;word-wrap: break-word;">
                <label>Annotation:</label>
                {{$media['note']}}
                </div>
                </div>
                  
                <div class="row" style="    padding-bottom: 15px;">
                <div class="col-md-4"></div>
                <div class="col-md-6"></div>
                <div class="col-md-2">
                <div class="buttons">
                <a href="{{url('subadmin/photo_feed/edit/'.$id)}}" class="btn add-btns btn-add">
                <ul class="d-flex align-items-center">
                <li>
                <i class="fa fa-pen pl-1"></i>
                </li>
                <li class="ml-4">
                    Edit
                </li>
                </ul>
                </a>
                </div>
                </div>
                </div>         
</div>
</div>

@endsection







