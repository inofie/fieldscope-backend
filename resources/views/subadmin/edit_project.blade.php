@extends('subadmin.master')
@push('page_level_css')
    <link rel="stylesheet" href="{{asset('assets/validation/bootstrap-datepicker.css')}}" />
@endpush



@section('content')
<!-- New Work  -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card-title">
                <h1 class="main-heading">Projects</h1>
                {{--<button type="button" class="add-btn">
                    Reports
                </button>--}}
                @if(!empty($data['reportUrl']))
                    <a href="{{$data['reportUrl']}}" target="_blank" class="add-btn">Reports</a>
                @endif
            </div>
        </div>
    </div>
    <div class="row edit-profile-row" >
        <form id="update_form" action="{{URL::to('subadmin/project/update/'.$data['project']['id'])}}" method="POST">
            {{csrf_field()}}

        <div class="col-12 col-sm-6 col-md-3">
            <div class="companyinfobody rm-companyinfobody-modified edit-profile-input">
                    <label>Project Name</label>
                <input type="text" class="input" name="name" value="{{$data['project']['name']}}" placeholder="Project Name">
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="companyinfobody rm-companyinfobody-modified edit-profile-input">
                    <label>Claim Number</label>
                <input type="text" class="input" name="claim_num" value="{{$data['project']['claim_num']}}" placeholder="Claim Number">
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="companyinfobody rm-companyinfobody-modified edit-profile-input">
                <label>Inspection Date</label>

                <input class="input datepicker" type="text" name="inspection_date"
                       value="{{\Carbon\Carbon::parse($data['project']['inspection_date'])->format('m/d/y') }}" placeholder="Inspection Date">
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="companyinfobody rm-companyinfobody-modified edit-profile-input">
                    <label>Customer Email</label>
                <input type="text" class="input" readonly name="customer_email" value="{{$data['project']['customer_email']}}" placeholder="Customer Email">
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6">
            <div class="companyinfobody rm-companyinfobody-modified edit-profile-input">
                    <label>Latitude</label>
                <input type="text" class="input" name="lat" value="{{$data['project']['latitude']}}" placeholder="Latitude">
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6">
            <div class="companyinfobody rm-companyinfobody-modified edit-profile-input">
                    <label>Longitude</label>
                <input type="text" class="input" name="long" value="{{$data['project']['longitude']}}" placeholder="Longitude">
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6">
            <div class="companyinfobody rm-companyinfobody-modified edit-profile-input">
                    <label>Street Address</label>
                <input type="text" class="input" name="address1" value="{{$data['project']['address1']}}" id="update_address1" placeholder="Street Address">
            </div>
        </div>

    <div class="col-12 col-sm-6 col-md-6">
            <div class="companyinfobody rm-companyinfobody-modified edit-profile-input">
                <label>Postal Code</label>
                <input type="text" class="input" name="postal_code" value="{{$data['project']['postal_code']}}" placeholder="Postal Code">
            </div>
        </div>


        <div class="col-12 col-sm-6 col-md-6">
            <div class="companyinfobody rm-companyinfobody-modified edit-profile-input">
                <label>Sales Tax</label>
                <input type="text" class="input" name="sales_tax" value="{{$data['project']['sales_tax']}}" placeholder="Sales Tax">
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4">
            <div class="companyinfobody rm-companyinfobody-modified edit-profile-input">
                <label>Inspector</label>
                <select class="input" name="assigned_user_id" style="background-color: #ffffff; border: solid 1px #cfced4; margin-top: 0;">
                    <option disabled selected>-Assign User-</option>
                    @foreach($data['inspectors'] AS $key => $item)
                        <option value="{{$item->id}}"
                        @if($data['project']['assigned_user_id'] == $item->id)
                            selected
                        @endif
                        >{{$item->userNames}}</option>
                    @endforeach
                </select>
            </div>
        </div>

            {{--<div class="col-12 col-sm-6 col-md-4">
                <div class="companyinfobody rm-companyinfobody-modified edit-profile-input">
                        <label>State</label>
                    <input type="text" class="input" placeholder="Kansas">
                </div>
            </div>--}}
            <div class="col-12 col-sm-6 col-md-12">
                <button type="submit" class="btn btn-save bg-modified">
                    <ul class="add-cancel-btn">
                        <li>+</li>
                        <li>Update</li>
                    </ul>
                </button>
            </div>

        </form>
    </div>

    {{--Req Phootos--}}
    <div class="row pt-3 edit-profile-accordion">
        <div class="col-md-8 ">
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
                                                    <a href="" class="photo_detail" data-id="{{$rCatMediaItem['id']}}" data-target="#photo_detail_modal">
                                                        <img class="img-responsive myImg" style="width:200px;height: auto;" src="{{URL::to($rCatMediaItem['image_path'])}}" data-id="{{$rCatMediaItem['id']}}" alt="thumbnail">
                                                    </a>
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
                                                            <a href="" class="photo_detail" data-id="{{$subCatMediaItem['id']}}" data-target="#photo_detail_modal">
                                                                <img class="img-responsive myImg" src="{{URL::to($subCatMediaItem['image_path'])}}" data-id="{{$subCatMediaItem['id']}}" alt="thumbnail" />
                                                            </a>
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

                                                        <a href="" class="photo_detail" data-id="{{$rCatMediaItem['id']}}" data-target="#photo_detail_modal">
                                                            <img class="myImg"
                                                                 src="{{URL::to($rCatMediaItem['image_path'])}}"
                                                                 data-id="{{$rCatMediaItem['id']}}"
                                                                 alt="thumbnail">
                                                        </a>
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

    <div class="row hide">
        <div class="col-12">
            <div class="required-photos">
                <p>
                    Required Photos
                </p>
                <h2>
                    Inspection Photos
                </h2>
            </div>
            <div class="edit-profile-accordion">
                <div class="accordion" id="accordion2">
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2"
                               href="#collapseOne">
                                <div class="img-title">
                                    <div class="title">
                                        Right Elevation <span>(8 / 4)</span>
                                    </div>
                                    <div class="arrow-img">
                                        <img src="{{asset('assets/images/down-arrow.png')}}" alt="..."
                                             class="down-arrow">
                                        <img src="{{asset('assets/images/up-arrow.png')}}" alt="..."
                                             class="up-arrow">
                                    </div>
                                </div>
                            </a>


                        </div>
                        <div id="collapseOne" class="accordion-body collapse">
                            <div class="accordion-inner">
                                Anim pariatur cliche...
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3"
                               href="#collapseTwo">
                                <div class="img-title">
                                    <div class="title">
                                        Roof Inspection <span>(5 / 4)</span>
                                    </div>
                                    <div class="arrow-img">
                                        <img src="{{asset('assets/images/down-arrow.png')}}" alt="..."
                                             class="down-arrow">
                                        <img src="{{asset('assets/images/up-arrow.png')}}" alt="..." class="up-arrow">
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div id="collapseTwo" class="accordion-body collapse">
                            <div class="accordion-inner">
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="inner-item grid">
                                    <figure class="effect-sadie">
                                        <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                                        <figcaption>
                                            <p><i class="fa fa-pen pl-1" title="Edit Project"></i></p>
                                            <a href="#" data-toggle="modal" data-target="#myModal">View more</a>
                                        </figcaption>
                                    </figure>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="photo_detail_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog add-project-modal edit-project-modal" role="document">
        <div class="modal-content">
            <div class="modal-header header-content">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title text-left">{{$data['project']['name']}}</h3>
            </div>
            <div class="modal-body">
                    <div class="modal-card-body">
                        <div class="modal-card-header">
                            <ul>
                                <li><span>Area</span></li>
                                <li><p class="photo_category"></p></li>
                            </ul>
                            <ul>
                                <li><span>Location Verified</span></li>
                                <li><p><span>Lat:</span>{{$data['project']['latitude']}}</p></li>
                            </ul>
                            <ul>
                                <li><span></span></li>
                                <li><p><span>Lat: </span>{{$data['project']['longitude']}}</p></li>
                            </ul>
                            <ul>
                                <li><span>Inspection Date</span></li>
                                <li>
                                    <p>{{\Carbon\Carbon::parse($data['project']['inspection_date'])->format('m/d/y')}}   </p>
                                </li>
                            </ul>
                        </div>
                        <div class="modal-card-img">
                            <img id="photo-preview" src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                        </div>
                        <div class="modal-card-header">
                            <ul>
                                <li><span>Photo Tag:</span></li>
                                <li><p class="photo_tag"></p></li>
                            </ul>
                            <ul>
                                <li><span>Claim #</span></li>
                                <li><p>{{$data['project']['claim_num']}}</li>
                            </ul>
                            <ul>
                                <li><span>Qty</span></li>
                                <li><p class="photo_tag_qty">100</p></li>
                            </ul>
                        </div>
                        <div class="modal-card-footer">
                            <ul>
                                <li>
                                    <span>Annotation:</span>
                                </li>
                                <li>
                                    <p class="annotation"></p>
                                </li>
                            </ul>
                        </div>
                    </div>

            </div>
            <div class="modal-footer footer-align">
                <a href="" class="edit-btn btn-default edit_link">
                    <ul>
                        <li><i class="fa fa-pencil" aria-hidden="true"></i></li>
                        <li>Edit</li>
                    </ul>
                </a>

            </div>
        </div>
    </div>
</div>
<!-- Modal End -->
<!-- New Work  End -->


@endsection

@push('page_level_scripts')
    <script src="{{asset('assets/js/moment.min.js')}}" ></script>
    <script src="{{asset('assets/validation/bootstrap-datepicker.js')}}"></script>
    <script type="text/javascript">

        function initAutocomplete(){
            let addressInput = $('input[name="address1"]');
            let options = {
                types: ['street_address'],
                componentRestrictions: {
                    country: ["us"]
                },
                fields: ["name","address_components", "geometry"],
            };

            addressInput.each((i,el)=>{
                var autocomplete = new google.maps.places.Autocomplete(el, options);
                autocomplete.inputId = el.id;
                autocomplete.addListener('place_changed', fillIn);
            });

            function fillIn() {
                console.log("fillIn",this.inputId);

                var place = this.getPlace();
                var myInput = $('#' + this.inputId);

                // console.log('lat, long',place.geometry.location.lat()+', '+place.geometry.location.lng());
                // console.log('place.name',place.name);

                let addr = [];
                place.address_components.filter((el,i)=>{
                    // locality -> CIty
                    // administrative_area_level_1 -> State
                    // postal_code -> Postal Code
                    el.types.map((typeEl,i)=>{

                        if(typeEl == 'locality')
                            addr.city = el.long_name

                        if(typeEl == 'administrative_area_level_1')
                            addr.state = el.short_name

                        if(typeEl == 'postal_code')
                            addr.postal_code = el.long_name
                    })
                });

                /*console.log('place.name',place.name);
                console.log(place.address_components);*/

                console.log('final address',`${place.name}, ${addr.city}, ${addr.state}, ${addr.postal_code}`);

                let formattedAddress = `${place.name}, ${addr.city}, ${addr.state} ${addr.postal_code}`

                myInput.closest("#update_form").find("input[name='lat']").val(place.geometry.location.lat());
                myInput.closest("#update_form").find("input[name='long']").val(place.geometry.location.lng());

                myInput[0].value = formattedAddress;

                console.log('lat',place.geometry.location.lat());
                console.log('lng',place.geometry.location.lng());
                // console.log('lat',myInput.closest("div.form-group").find("input[name='lat']").val());
                // console.log('long',myInput.closest("div.form-group").find("input[name='long']").val());

                // myInput.attr('data-city', place.address_components[3].long_name);
                //
                // myInput.on('datachange', function(){
                //     console.log('datachange')
                //
                //     // var localityData = myInput.data("city");
                //     // myInput.closest('.accommodationDivs').find('.cityRu').val(localityData);
                // });
                //
                // myInput.data('city', place.address_components[3].long_name).trigger('datachange');

            }
        }

        $(document).ready(function () {

            let project = "{{json_encode($data['project'])}}";

            $(".datepicker").datepicker({
                format: 'mm/dd/yy'
            });


            $('a.photo_detail').on('click',function(e){
                e.preventDefault();


                console.log('photo_detail',$(this).data('id'));
                $("#photo-preview").prop('src',$(this).find('img').attr('src'));
                $(this).find('img').attr('src');
                $.ajax({
                    type: "GET",
                    /*enctype: 'multipart/form-data',*/
                    url: `{{URL::to('subadmin/project/photo_details')}}/${$(this).data('id')}`,
                    data: [],
                    // processData: false,
                    // contentType: false,
                    // cache: false,
                    success: (response) => {
                        console.log('ajax good',response);

                        $('#photo_detail_modal').find('p.annotation').text(response.data.note);

                        if(response.data.tags_data.length > 0){
                            $('#photo_detail_modal').find('p.photo_tag').text(response.data.tags_data[0].name);
                            $('#photo_detail_modal').find('p.photo_tag_qty').text(response.data.tags_data[0].qty);
                        } else {
                            $('#photo_detail_modal').find('p.photo_tag').text('N/A');
                            $('#photo_detail_modal').find('p.photo_tag_qty').text('N/A');
                        }

                        $('#photo_detail_modal').find('p.photo_category').text(response.data.category.name);
                        $('#photo_detail_modal').find('a.edit_link').prop('href',`${base_url}/subadmin/photo_feed/edit/${$(this).data('id')}`);

                        $('#photo_detail_modal').modal({show:true});
                        // $('#companyLogoModal').modal('toggle');
                        // $("div.alert-success.success").text(data.message).show();
                        // setTimeout(()=>{
                        //     $("div.alert.alert-success.success").hide();
                        // },2000);
                    }
                });

                // $('#photo_detail').modal({show: true});

            })
        });
    </script>
    <script type="text/javascript">

        $(document).on('show', '.accordion', function (e) {
            //$('.accordion-heading i').toggleClass(' ');
            $(e.target).prev('.accordion-heading').addClass('accordion-opened');
        });

        $(document).on('hide', '.accordion', function (e) {
            $(this).find('.accordion-heading').not($(e.target)).removeClass('accordion-opened');
            //$('.accordion-heading i').toggleClass('fa-chevron-right fa-chevron-down');
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_PLACES_KEY')}}&libraries=places&callback=initAutocomplete&v=3.50&region=us" async defer></script>
@endpush

