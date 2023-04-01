@extends('subadmin.master')
@section('content')
    <style>
      
        #accordion .glyphicon { margin-right:10px; }
        .panel-collapse>.list-group .list-group-item:first-child {border-top-right-radius: 0;border-top-left-radius: 0;}
        .panel-collapse>.list-group .list-group-item {border-width: 1px 0;}
        .panel-collapse>.list-group {margin-bottom: 0;}
        .panel-collapse .list-group-item {border-radius:0;}

        .panel-collapse .list-group .list-group {margin: 0;margin-top: 10px;}
        .panel-collapse .list-group-item li.list-group-item {margin: 0 -15px;border-top: 1px solid #ddd !important;border-bottom: 0;padding-left: 30px;}
        .panel-collapse .list-group-item li.list-group-item:last-child {padding-bottom: 0;}

        .panel-collapse div.list-group div.list-group{margin: 0;}
        .panel-collapse div.list-group .list-group a.list-group-item {border-top: 1px solid #ddd !important;border-bottom: 0;padding-left: 30px;}
        .panel-collapse .list-group-item li.list-group-item {border-top: 1px solid #DDD !important;}
        .thumbnails {list-style: none; }
        .thumbnails li{display: inline-block; padding: 10px 10px;
            }
        .thumbnails li .thumbnail {
            height: auto; margin-bottom: 0;}
        .thumbnails li .thumbnail img{width:100px; object-fit: contain}
        .panel-collapse  {    padding: 30px 30px;}
      .pdf-modal .modal-body {
          height: 75vh;
        }
        .pdf-modal .modal-body iframe {
          width: 100%;
          height: 100%;
        }
        .pdf-modal .modal-title {
          display: inline-block;
          font-weight: 600;
        }
        .pdf-modal .modal-footer {
          display: flex;
          justify-content: space-between;
          width: 100%;
          align-items: center;
        }  
        .pdf-modal .modal-footer::after,
        .pdf-modal .modal-footer::before {
          content: none;
        }
        #signature canvas.jSignature {
          height: 150px !important;
          width: 300px !important;
        }
        .pdf-modal .modal-dialog.modal-lg {
          width: 100%;
          margin: 0;
      }
      .pdf-modal .modal-header {
    text-align: left;
}
      .pdf-modal .modal-content {
    margin-top: 0;
}
    </style>
    <div class="row">
        <a href="{{URL::to('subadmin/project')}}"> <img src="{{asset('image/back.png')}}" class="img-responsive wd-40" /></a>
        <div class="col-md-12" >
            <div class="row">
                <div class="bg-project row">
                    <div class="col-md-3">
                        <h1 class="main-heading white">Project Detail</h1>
                    </div>
                    <div class="col-md-9">

                        <div class="row">
                            <div class="col-md-2"><h5 class="white">Project Name:</h5></div>
                            <div class="col-md-4"><h5 class="white">{{$data['project']['name']}}</h5></div>
                            <div class="col-md-2"><h5 class="white">Claim #:</h5></div>
                            <div class="col-md-4"><h5 class="white">{{$data['project']['claim_num']}}</h5></div>
                        </div>
{{--                        <div class="row">--}}
{{--                            <div class="col-md-2"><h5 class="white">State, City:</h5></div>--}}
{{--                            <div class="col-md-4"><h5 class="white">{{$data['location']['state']['name']}}, {{$data['location']['city']['name']}}</h5></div>--}}
{{--                            <div class="col-md-2"><h5 class="white">Zip Code:</h5></div>--}}
{{--                            <div class="col-md-4"><h5 class="white">{{$data['project']['postal_code']}}</h5></div>--}}
{{--                        </div>--}}
                        <div class="row">
                            <div class="col-md-2"><h5 class="white">Latitude:</h5></div>
                            <div class="col-md-4"><h5 class="white">{{$data['project']['latitude']}}</h5></div>
                            <div class="col-md-2"><h5 class="white">Longitude:</h5></div>
                            <div class="col-md-4"><h5 class="white">{{$data['project']['longitude']}}</h5></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><h5 class="white">Inspection Date:</h5></div>
                            <div class="col-md-4"><h5 class="white">{{$data['project']['inspection_date']}}</h5></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><h5 class="white">Address:</h5></div>
                            <div class="col-md-10"><h5 class="white">{{$data['project']['address1']}} </h5></div>
                        </div>

                        <div class="row">
                            <div class="col-md-2"><h5 class="white">Customer Email:</h5></div>
                            <div class="col-md-10"><h5 class="white">{{$data['project']['customer_email']}} </h5></div>
                        </div>
                    </div>
                </div>

                {{--Req Phootos--}}
                <div class="row pt-3">
                    <div class="col-md-8">
                        <h2 class="heading2">Required Photos</h2>
                    </div>
                    <div class="col-md-4 text-right">
                        @if(!empty($data['reportUrl']))
                            <a href="{{$data['reportUrl']}}" target="_blank" class="btn btn-add mt-0">reports</a>
                        @endif
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="panel-group" id="accordion">
                            @foreach($data['proMedia']['required_category']  AS $rCatkey => $rCatItem)
                                @if($rCatItem['media_count'] > 0  )
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#r_collapse_{{$rCatkey}}" aria-expanded="false" aria-controls="r_collapse_{{$rCatkey}}">
                                                    </span>{{$rCatItem['category_name']}} ({{$rCatItem['media_count']}}/{{$rCatItem['category_min_quantity']}}) </a>
                                            </h4>
                                        </div>
                                        <div id="r_collapse_{{$rCatkey}}" class="panel-collapse collapse" role="tabpanel">
                                            @if(!empty($rCatItem['media']) )
                                                <ul class="thumbnails">
                                                    @foreach($rCatItem['media'] AS $rCatMediaKey => $rCatMediaItem)
                                                        <li class="span4">
                                                            <div class="thumbnail">
                                                                <img class="img-responsive myImg" style="width:200px;height: auto;" src="{{URL::to($rCatMediaItem['image_path'])}}" data-id="{{$rCatMediaItem['id']}}" alt="thumbnail">
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <div id="img-popup">
                                                    <div class="text-center well">
                                                        <h5>No Media</h5>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                {{--Inspection Photos --}}
                <div class="row nomargin">
                    <div class="col-md-12">
                        <h2 class="heading2">Inspection Photos</h2>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="panel-group" id="accordion">
                            @foreach($data['proMedia']['damaged_category']  AS $dCatkey => $dCatItem)
                                @if($dCatItem['media_count'] > 0)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#d_collapse_{{$dCatkey}}" aria-expanded="false" aria-controls="d_collapse_{{$dCatkey}}">
                                                    </span>{{$dCatItem['category_name']}} ({{$dCatItem['media_count']}} / {{$dCatItem['category_min_quantity']}}) </a>
                                            </h4>
                                        </div>
                                        <div id="d_collapse_{{$dCatkey}}" class="panel-collapse collapse" role="tabpanel">

                                            @if(!empty($dCatItem['get_child']))
                                                <ul class="thumbnails">
                                                @foreach($dCatItem['get_child'] AS $subCatKey => $subCatItem)
                                                    @if(!empty($subCatItem['media']) )
                                                            @foreach($subCatItem['media'] AS $subCatMediaKey => $subCatMediaItem)
                                                                <li class="span4">
                                                                    <div class="thumbnail">
                                                                        <img class="myImg" src="{{URL::to($subCatMediaItem['image_path'])}}" data-id="{{$subCatMediaItem['id']}}" alt="thumbnail" />
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                    @else
{{--                                                        <div class="text-center well">--}}
{{--                                                            <h5>No Media 2</h5>--}}
{{--                                                        </div>--}}
                                                    @endif

                                                @endforeach
                                                </ul>
                                            @else
                                                <div class="text-center well">
                                                    <h5>No PhotoView</h5>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                {{--Additional Photos--}}
                @if($data['proMedia']['additional_photos'][0]['media_count'] > 0)
                    <div class="row nomargin">
                        <div class="col-md-12">
                            <h2 class="heading2">Additional Photos</h2>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="panel-group" id="accordion">
                                @if(!empty($data['proMedia']['additional_photos']))
                                    @foreach($data['proMedia']['additional_photos']  AS $aCatkey => $aCatItem)
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion"
                                                       href="#a_collapse_{{$aCatkey}}" aria-expanded="false"
                                                       aria-controls="a_collapse_{{$aCatkey}}">{{$aCatItem['category_name']}}</a>
                                                </h4>
                                            </div>
                                            <div id="a_collapse_{{$aCatkey}}" class="panel-collapse collapse"
                                                 role="tabpanel">
                                                @if(!empty($aCatItem['media']) )

                                                    <ul class="thumbnails">
                                                        @foreach($aCatItem['media'] AS $rCatMediaKey => $rCatMediaItem)
                                                            <li class="span4">
                                                                <div class="thumbnail">
                                                                    <img class="myImg"
                                                                         src="{{URL::to($rCatMediaItem['image_path'])}}"
                                                                         data-id="{{$rCatMediaItem['id']}}"
                                                                         alt="thumbnail">
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <div class="text-center well">
                                                        <h5>No Media</h5>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#a_collapse_0" aria-expanded="false" aria-controls="a_collapse_0">
                                                    </span>{{$aCatItem['category_name']}}</a>
                                            </h4>
                                        </div>
                                        <div id="a_collapse_0" class="panel-collapse collapse" role="tabpanel">
                                            <div class="text-center well">
                                                <h5>No Media</h5>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
            </div>
        </div>
    </div>
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <img id="img01" src="" style="width:100%;">
                </div>
                <div class="modal-footer logoimagefooter">
                    <!-- <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">Edit</button> -->
                    <a class="btn btn-save bg-modified" id="edit" href="">Edit</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('page_level_scripts')
    <script src="{{ asset('assets/js/jSignature.min.js') }}"></script>
    <script>

        $(document).ready(function(){
          
            $("#signature").jSignature();
          
            $('.myImg').click(function(){
                var image_src = $(this).attr('src');
                $('#img01').attr('src',image_src);
                $('#myModal').modal('show');

                let id = $(this).data('id');

                $('#myModal').find('#edit').attr('href', '{{url('subadmin/photo_feed/edit')}}/' + id);

                // https://fieldscope.qa.retrocubedev.com/subadmin/photo_feed/edit/620
            })
          
            $('._view_pdf').click( function(){
                let pdf_url = $(this).data('pdf-url');
                $('#_iframe_pdf_url').attr('src',pdf_url);
            })
          
            $('#_signature_submit').click( function(e){
                e.preventDefault();
                var $sigdiv = $("#signature")
                var datapair = $sigdiv.jSignature("getData", "svgbase64");
                let image_url = "data:" + datapair[0] + "," + datapair[1] 
                $.ajax({
                    type:'POST',
                    url: '{{ URL::to("subadmin/project/save-signature") }}',
                    data:{
                       signature_url: image_url,
                       id: '{{ $data["id"] }}',
                       pdf_url: $('#_iframe_pdf_url').attr('src')
                    },
                    beforeSend: function(){
                        $('#_signature_submit').attr('disabled','disabled');
                    },
                    success: function(data){
                        console.log('_signature_submit',data);
                        return false;
                    }
                });
            })
          
          
        });
      
        
        
        //
        // // Get the modal
        // var modal = document.getElementById("myModal");
        //
        // // Get the image and insert it inside the modal - use its "alt" text as a caption
        // var img = document.getElementById("myImg");
        // var modalImg = document.getElementById("img01");
        // var captionText = document.getElementById("caption");
        // img.onclick = function(){
        //     modal.style.display = "block";
        //     modalImg.src = this.src;
        //     captionText.innerHTML = this.alt;
        // }
        //
        // // Get the <span> element that closes the modal
        // var span = document.getElementsByClassName("close")[0];
        //
        // // When the user clicks on <span> (x), close the modal
        // span.onclick = function() {
        //     modal.style.display = "none";
        // }
    </script>
@endpush
