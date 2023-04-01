<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fieldscope</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    {{--<link rel="icon" href="images/icon.png" type="image/gif" sizes="16x16">--}}
    <link rel="icon" href="{{ asset('image/logo.png') }}" type="image/gif" sizes="16x16">
    {{--<link rel="stylesheet" href="style.css">--}}
    <link href="{{asset('assets/css/web-page/style.css')}}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row" id="small">
        <div class="col-xs-4" >
            {{--<img src="images/logo.png" class="img-responsive">--}}
            <img src="{{asset('assets/web-images/logo.png')}}" class="img-responsive">
        </div>
        <div class="col-xs-8" style="padding-top:15px;">
            <span id="text-color">Already have an Account?<a href="/" class="btn">Login</a></span>
        </div>
        <div class="col-xs-12">
            <div class="header">
                <h1 class="text-color">Loren ipsum is simply dummy text</h1>
                <p>Loren ipsum is simply dummy text,Loren ipsum is simply dummy text,Loren ipsum is simply dummy
                    text,</p>
                <a class="btn" href="/">Get the App Now!</a>
            </div>
        </div>
        <div class="col-xs-12">
            {{--<img src="images/img-1.png" class="img-responsive">            --}}
            <img src="{{asset('assets/web-images/img-1.png')}}" class="img-responsive">
        </div>
    </div>
    <div class="row" id="sec-1">
        <div class="col-md-5"
             >
            {{--style="background-image: url('{{env('BASE_URL')}}image/semi_circle.png');background-repeat: no-repeat;    background-size: 90%;"--}}
            <img src="{{asset('assets/web-images/logo.png')}}" class="img-responsive" id="c1">

            <div class="header">
                <h1 class="text-color">Loren ipsum is simply dummy text</h1>
                <p>Loren ipsum is simply dummy text,Loren ipsum is simply dummy text,Loren ipsum is simply dummy
                    text,</p>
                <a class="btn" href="/">Get the App Now!</a>
            </div>
        </div>
        <div class="col-md-7" id="bg">
            <div class="row">
                <div class="col-md-6 col-md-offset-5">
                    <span class="text-color">Already have an Account?</span><a href="{{URL::to('subadmin/login')}}"><span class="btn">Login</span></a></span>
                </div>
            </div>

            {{--<img src="images/house.png" class="img-responsive">--}}
            <img src="{{asset('assets/web-images/house.png')}}" class="img-responsive">

        </div>
    </div>
    <div class="row" id="sec-2">
        <div class="col-md-4 col-md-offset-1">
            {{--<img src="images/mob.png" class="margin-0 img-responsive">--}}
            <img src="{{asset('assets/web-images/mob.png')}}" class="margin-0 img-responsive">

        </div>
        <div class="col-md-7">
            <h2 class="text-color bold">Why FieldScope</h2>
            <p>loren ipsum is simply dummy text,loren ipsum is simply dummy text,loren ipsum is simply dummy text,
                loren ipsum is simply dummy text,loren ipsum is simply dummy text,</p>
            <p>loren ipsum is simply dummy text,loren ipsum is simply dummy text,loren ipsum is simply dummy text,
                loren ipsum is simply dummy text,loren ipsum is simply dummy text,</p>
            <p>loren ipsum is simply dummy text,loren ipsum is simply dummy text,loren ipsum is simply dummy text,
                loren ipsum is simply dummy text,loren ipsum is simply dummy text,</p>

            <div class="row" id="app-link">
                <!-- <ul class="nav navbar-nav" id="app-link">
                        <li>
                            <a href="/"><img src="images/google.png" ></a>

                        </li>
                        <li>
                            <a href="/"><img src="images/apple.png "></a>
                       </li>
                    </ul> -->
                <div class="col-md-3 col-xs-4  nopadding">
                    <a href="/">
                        {{--<img src="images/apple-1.png"  class="img-responsive">--}}
                        <img src="{{asset('assets/web-images/apple-1.png')}}" class="img-responsive">
                    </a>

                </div>
                <div class="col-md-3 col-xs-4 nopadding">
                    <a href="/">
                        {{--<img src="images/google-1.png" class="img-responsive">--}}
                        <img src="{{asset('assets/web-images/google-1.png')}}" class="img-responsive">
                    </a>

                </div>

            </div>
        </div>
    </div>
    <div class="row" id="sec-3">
        <div class="col-md-12 heading">
            <h2 class="text-center text-color bold">Subscription Plans</h2>
            <p class="text-center">4 Simple Plans to Subscribe and get the most of it at affordable rates</p>
        </div>

        <div class="col-md-5 col-md-offset-1">
            <div class="card" id="card-1">
                <div class="r1">
                    <p class="text-center text-color margin-y-0">FieldScope</p>
                    <h2 class="text-center text-color margin-y-0 bold">Basic</h2>
                </div>
                <div class="row r2">
                    @foreach($data['subs']['basic'] AS $bKey => $bItem)
                        <div class="col-md-6 nopadding col-xs-6">
                            <div class="bg-color">
                                <span class="text-center bold">$ {{$bItem['amount']}}</span><span class="text-small">/user</span>
                                <p class="text-center text-small">{{$bItem['description']}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-12 r3">
                    <div class="text-center">
                        <p>No Contract</p>
                        <p>Free setup and 1 hour of Training</p>
                        <p>14 Day Free Trial</p>
                    </div>

                </div>
                <a class="btn subscribe-bt bold" href="{{URL::to('signup/basic')}}">Subscribe Now</a>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card" id="card-2">
                <div class="r1">
                    <p class="text-center margin-y-0 text-color">FieldScope</p>
                    <h2 class="text-center margin-y-0 text-color bold">Plus</h2>
                </div>
                <div class="row r2">
                    @foreach($data['subs']['plus'] AS $bKey => $bItem)
                        <div class="col-md-6 nopadding col-xs-6">
                            <div class="bg-color">
                                <span class="text-center bold">$ {{$bItem['amount']}}</span><span class="text-small">/user</span>
                                <p class="text-center text-small">{{$bItem['description']}}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="col-md-12 r3">
                    <div class="text-center">
                        <p>Maximum No. of Users 5</p>
                        <p>No contract</p>
                        <p>Free setup and 3 hours of Training</p>
                        <p>14 Day Free Trial</p>
                    </div>
                </div>
                <a class="btn subscribe-bt bold" href="{{URL::to('signup/plus')}}">Subscribe Now</a>
            </div>
        </div>
        <div class="col-md-12 note">
            <p class="text-center"><strong>Get Discount:</strong> 20% Discount for Annual pay on either plan</p>
        </div>

    </div>
    <!--testimonial-->
    <div class="row" id="sec-4">
        <div class="container">
            <h2 class="text-center text-color bold">Testimonials</h2>
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="row mycard">
                                    <div class="col-md-3 col-xs-3">
                                        {{--<img src="images/male.jpg" class="img-responsive">--}}
                                        <img src="{{asset('assets/web-images/male.jpg')}}" class="img-responsive">

                                    </div>
                                    <div class="col-md-9 col-xs-9 quote">
                                        <p>Loren Ipsum is simply dummy text.....,Loren Ipsum is simply dummy text.....
                                            Loren Ipsum is simply dummy text.....,Loren Ipsum is simply dummy text.....
                                        </p>
                                        <p class="text-color">John Smith</p>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-6 col-xs-12 ">
                                <div class="row mycard">
                                    <div class="col-md-3 col-xs-3">
                                        <img src="{{asset('assets/web-images/male.jpg')}}" class="img-responsive">
                                    </div>
                                    <div class="col-md-9 col-xs-9 quote">
                                        <p>Loren Ipsum is simply dummy text.....,Loren Ipsum is simply dummy text.....
                                            Loren Ipsum is simply dummy text.....,Loren Ipsum is simply dummy text.....
                                        </p>
                                        <p class="text-color">John Smith</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="row mycard">
                                    <div class="col-md-3 col-xs-3">
                                        <img src="{{asset('assets/web-images/male.jpg')}}" class="img-responsive">
                                    </div>
                                    <div class="col-md-9 col-xs-9 quote">
                                        <p>Loren Ipsum is simply dummy text.....,Loren Ipsum is simply dummy text.....
                                            Loren Ipsum is simply dummy text.....,Loren Ipsum is simply dummy text.....
                                        </p>
                                        <p class="text-color">John Smith</p>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="row mycard">
                                    <div class="col-md-3 col-xs-3">
                                        <img src="{{asset('assets/web-images/male.jpg')}}" class="img-responsive">

                                    </div>
                                    <div class="col-md-9 col-xs-9 quote">
                                        <p>Loren Ipsum is simply dummy text.....,Loren Ipsum is simply dummy text.....
                                            Loren Ipsum is simply dummy text.....,Loren Ipsum is simply dummy text.....
                                        </p>
                                        <p class="text-color">John Smith</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="row mycard">
                                    <div class="col-md-3 col-xs-3">
                                        <img src="{{asset('assets/web-images/male.jpg')}}" class="img-responsive">
                                    </div>
                                    <div class="col-md-9 col-xs-9 quote">
                                        <p>Loren Ipsum is simply dummy text.....,Loren Ipsum is simply dummy text.....
                                            Loren Ipsum is simply dummy text.....,Loren Ipsum is simply dummy text.....
                                        </p>
                                        <p class="text-color">John Smith</p>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="row mycard">
                                    <div class="col-md-3 col-xs-3">
                                        <img src="{{asset('assets/web-images/male.jpg')}}" class="img-responsive">
                                    </div>
                                    <div class="col-md-9 col-xs-9 quote">
                                        <p>Loren Ipsum is simply dummy text.....,Loren Ipsum is simply dummy text.....
                                            Loren Ipsum is simply dummy text.....,Loren Ipsum is simply dummy text.....
                                        </p>
                                        <p class="text-color">John Smith</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>

</div>
<div class="row" id="prefooter">
    <div class="row" style="position:absolute; top:-20px;">
        <div class="col-md-8 col-xs-6">
            {{--<img src="images/laptop1.png" class="img-responsive">--}}
            <img src="{{asset('assets/web-images/laptop1.png')}}" class="img-responsive">
        </div>
    </div>

    <div class="row" style="background:#e7e7ef;height:275px;padding:100px 0px;">
        <div class="col-md-6 col-md-offset-6 col-xs-6">
            <h4>Loren Ipsum is simply dummy text</h4>
            <p class="">
                <small>Loren ipsum is dummy text</small>
            </p>
            <a class="btn" href="/">Get Now!</a>
        </div>
    </div>
    <div class="row" style="background:#424460;height:100px;">

    </div>
</div>

<!-- <div class="row" id="pre-footer" style="position:relative;">

<div class="col-md-12 nopadding">
<img src="images/abc.png" class="img-responsive">
</div>
<div class="col-md-6 col-offset-6 col-xs-6 col-xs-offset-6"  style="position:absolute;top:30%;">
	<h2>Loren ipsum is simply text</h2>
	<p>Loren ipsum is simply dummy text...,</p>
	<a class="btn subscribe-bt" href="/">Get Now!</a>
</div>
</div> -->
<div class="row" id="prefooter-2">
    <div class="col-md-6">
        <div>
            {{--<img src="images/laptop-img.png" class="img-responsive">--}}
            <img src="{{asset('assets/web-images/laptop.png')}}" class="img-responsive">
        </div>
    </div>
    <div class="col-md-6">
        <h4 class="text-center">Loren Ipsum is simply dummy text</h4>
        <p class="text-center">
            <small>Loren ipsum is dummy text</small>
        </p>
        <div class="text-center"><a class="btn" href="/">Get Now!</a></div>
    </div>
</div>
<div class="row" id="footer">
    <p class="text-center">Copyright FieldScope. All rights Reserved 2019</p>
</div>

</body>
</html>
