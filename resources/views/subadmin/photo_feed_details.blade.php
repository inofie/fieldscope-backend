@extends('subadmin.master')
@section('content')

    
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
    <div class="col-md-7" style="margin: 25px; left: 300px;">
    <div class="card-body">
                <div class="card-header">
                <ul class="new-card address-icon">
                <li>
                <h2>{{$media['project']['name']}}<h2>
                </li>
                </ul>
                </div>
        
                <label>Area</label>
                {{$media['category']['name']}}&nbsp;&nbsp;
           
                <label>Latitude</label>
                {{$media['project']['latitude']}}&nbsp;&nbsp;
          
                <label>Longitude</label>
                {{$media['project']['longitude']}}&nbsp;&nbsp;
        
                <label>Inspection Date</label>
                {{\Carbon\Carbon::parse($media['project']['inspection_date'])->format('m/d/y') }}
         
                <div class="card-img">
                <img src="{{URL::to('uploads/media/'.$media['path'] )}}" id="my-image" style="/*display: none;*/ height:800px; width:800px;" >
                </div>
                
                
                <label>Photo Tag</label>
                {{$media['area']['name']}}&nbsp;&nbsp;&nbsp;
                
                <label>Claim #</label>
                {{$media['project']['claim_num']}}&nbsp;&nbsp;&nbsp;
           
                <label>Qty</label>
                {{$media['category']['min_quantity']}}

                <div class="card-footer">
                <ul>
                <label>Annotation</label>
                {{$media['note']}}
                </ul>
                
               <ul>
                <div class="col-md-3  card-col-modified">
                        <a href="{{url('subadmin/photo_feed/edit/'.$id)}}">
                        <i class="fa fa-pen pl-1"></i></a>
                </div>
            </ul>
                
                </div>
    </div>
</div>

@endsection







