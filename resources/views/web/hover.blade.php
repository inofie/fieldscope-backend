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
    <div class="row" id="sec-1">
        <div class="col-md-5" >

            <img src="{{asset('assets/web-images/logo.png')}}" class="img-responsive" id="c1">

            <div class="header">
                <h2 class="text-color">{{$data['message']}}</h2>
                <br>
                <a class="btn" href="/">Get the App Now!</a>
            </div>
        </div>
        <div class="col-md-7" id="bg">
            <div class="row">
                <div class="col-md-6 col-md-offset-5">
                    <span class="text-color">Already have an Account?</span><a href="{{URL::to('subadmin/login')}}"><span class="btn">Login</span></a></span>
                </div>
            </div>


            <img src="{{asset('assets/web-images/house.png')}}" class="img-responsive">

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
