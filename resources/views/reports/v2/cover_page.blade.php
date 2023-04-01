<!-- <style>
    .page8-header-fcol > p {
        font-size: 2.5rem;
        text-transform: uppercase;
        line-height: 0.5;
        color: rgb(73,73,75);
    }
    .page8-header-fcol {
        position: relative;
    }
    .page8-header-fcol .page8-head-dynamic-text{
        margin: 2rem 0 0 0;
    }
    .page8-head-dynamic-text::before {
        content: "09";
        left: -0.75%;
        top: 80%;
        position: absolute;
        color: rgb(73,73,75);
    }
    .page8-head-dynamic-text::after {
        content: "";
        left: -17%;
        top: 83%;
        height: 3px;
        width: 15%;
        background: rgb(138,186,43);
        position: absolute;
    }
    .page8-header-scol > img {
        width: 480px;
        height: 120px;
        margin: 4rem 0 0 0;
    }
    table {
        margin: auto;
    }

    .page8-body-message > p {
        margin-top: 10rem;
        color: rgb(70,72,72);
        text-align: justify;
    }
    .page8-footer-heading > p {
        color: rgb(88,90,90);
        font-size: 3rem;
        font-weight: bold;
        margin: 5rem 0 1rem 2rem;
        letter-spacing: 1.5px;
    }
    .page8-footer-text > p {
        color: rgb(88,90,90);
        font-size: 2rem;
        letter-spacing: 1.5px;
    }
    .page8-footer-text {
        margin-top: 1rem;
    }
    .page8-footer-text .page8-footertext-floatleft {
        width: 25%;
        line-height: 1.125;
        display: block;
        float: left;
        margin-right: 4rem;
        letter-spacing: 1.5px;
    }
    .page8-footer-text > h1 {
        color: rgb(88,90,90);
        font-size: 3rem;
        font-weight: bold;
        margin: 5rem 0 1.5rem 0;
        letter-spacing: 1.5px;
    }
    .page8-footer-hr > hr {
        margin: 0 auto;
        border-top: 5px solid rgb(176,210,76);
        margin-top: 1rem;
    }
    .page8-footer-logo > p {
        display: inline-block;
        color: rgb(162,162,163);
        font-size: 2rem;
        margin-right: 1rem;
        margin-top: 1.25rem;
        margin-bottom: 8rem;
    }
    .page8-footer-logo > img {
        height: 30px;
        width: 150px;
        margin-right: 3rem;
        vertical-align: sub;
        margin-top: 1rem;
    }

    .page8-head-para{

    }
</style> -->
<style>
    .b_border{  border: 0px solid;}
    .r_border{  border: 0px solid red;}
    .g_border{  border: 0px solid lawngreen;}
    .bl_border{ border: 0px solid blue;}
    .y_border{  border: 0px solid yellow;}
    /*@page {*/
    /*    margin: 5mm 10mm 5mm 10mm;*/
    /*}*/
    .services table{
        width: 100%;
        vertical-align: bottom;
        /*border-collapse: collapse;*/
    }
    .services table td{
        font-size: 20px;
        font-weight: bold;
        letter-spacing: 5px;
    }
</style>
<setpageheader value="off"></setpageheader>

<div  style="display: flex; flex-direction: row; ">
    {{--  Left Section  --}}
    <div
         style="margin-left:60px;width:50.5%; height: 150px;
            background-image: url('{{asset('assets/images/reportimage.png')}}');background-repeat: no-repeat;background-size: 100% 100%;float:left;">

        <div class="g_border" style="height: 200px;">
            <h1 class="y_border" style="
            padding-top: 150px;
    font-family: OpenSans;
    font-size: 40px;
    font-weight: bold;
    line-height: 1.2;
    letter-spacing: 6px;
    text-align: left;
    color: #fff;
    padding-left: 25px;"> {{strtoupper($companyDetails['report_name'])}} </h1>
            {{--        INSPECTION REPORT --}}
            {{--        {{strtoupper($companyDetails['report_name'])}} --}}
            <p style="font-family: OpenSans;
                    font-size: 22px;
                    font-weight: 600;
                    line-height: 1.21;
                    letter-spacing: 2.03px;
                    text-align: left;
                    color: {{$companyDetails->primary_color}};
                    padding-left: 32px;
                    /* padding-right: 100px; */
                    padding-bottom: 300px;">
                {{$projectDetails['inspection_date']}}
            </p>
        </div>
    </div>

    {{--  Right Section  --}}
    <div class="r_border" style="width:40%;  " >
        <img src="{{$companyDetails['logo_path']}}" style="width: 250px; height:80px; margin: 70px 0px 40px 30px;"/>
        <h1 style="margin-left: 30px; font-family: OpenSans;
            font-size: 30px;
            font-weight: 800;
            line-height: 0.39;
            color: {{$companyDetails->secondary_color}};">{{ucwords($projectDetails['name'])}}</h1>
        <p style="margin-left: 30px;
                font-size: 20px;
                color: {{$companyDetails->secondary_color}};
                line-height: 1.3;">
            {{$projectDetails['address1']}}
        </p>
        <p style="margin-left: 30px;
                font-size: 20px;
                color: {{$companyDetails->secondary_color}};
                line-height: 1.3;
                ">
            Claim# {{$projectDetails['claim_num']}} <br>
            Location Lat:{{$projectDetails['latitude']}}, Long: {{$projectDetails['longitude']}}
        </p>
    </div>
</div>

{{-- Below Cover Image Block--}}
<div
        class=""
        style=" margin:-190px 0px 0px 0px;
                background-image: url('{{$companyDetails['report_cover_image']}}');background-repeat: no-repeat;background-size: 100% 100%;
                /*height:200px;*/
              "
    >
    <div class="y_border"
            style="width: 100%; height: 420px;"
    >
        <div class="g_border" style="width: 400px; margin: -50px 0px 0px 450px; padding-top: 0px;color: #fff;">
            <h1 style="margin: 0px;font-size: 30px;">{{$userDetails['first_name']}} {{$userDetails['last_name']}}</h1>
            <p style="margin: 0px;font-size: 18px;">{{$userDetails['phone']}}</p>
            <p style="margin: 0px;font-size: 18px;">{{$userDetails['email']}}</p>
            <p style="margin: 20px 0px;margin-right: 100px;font-size: 18px;">{{$projectDetails['address1']}}</p>
            <p style="margin: 0px;font-size: 18px;">{{$companyDetails['phone']}}</p>
            <P style="margin: 0px;font-size: 18px;">{{$companyDetails['email']}}</P>
            <p style="margin: 0px;font-size: 18px;">{{$companyDetails['website']}}</p>
        </div>

        {{-- Services Block --}}
        <div class="services r_border" style="width: 100%;text-align: center; margin-top: 20px; padding: 0px 40px;
                display: inline; color:{{$companyDetails->primary_color}};">

        <table class="bl_border" >
            <tr><td style="height: 155px;">

                    <table>

                        @php
                            $servicesArr = explode(',',$companyDetails['services']);
                            //dd($companyDetails->primary_color);
                            $serviceCounter = 0;
                        @endphp

                        @foreach($servicesArr AS $servItem)
                            @if($serviceCounter == 0)
                                <tr style="color:grey;" >
                                    @endif
                                <td style="color:{{$companyDetails->primary_color}};" class="y_border">&nbsp;{{strtoupper($servItem)}}</td>
                                    @php  $serviceCounter++; @endphp
                                        @if($serviceCounter == 4)
                                            @php  $serviceCounter = 0@endphp
                                    </tr>
                                @endif

                                @endforeach

                    </table>

                </td></tr>
        </table>


            {{--                <span style="color:#b0d24c;">    &nbsp;SIDING</span>--}}

        </div>

        {{-- Powered By Block --}}
        <div style="width: 100%; text-align: right; margin-top: 40px;" class="y_border">
            <span style="display: inline-block;color: white;
        font-size: 10px; vertical-align: baseline;">Powered By:</span>
            <img src="{{asset('assets/images/footer-logo.png')}}" alt="" style="width: 90px;
        height: 15px;
        margin-right: 20px;vertical-align: middle;">
        </div>
    </div>

{{--    <div class="r_border" style="height: 130px; background-color: #0abca6"></div>--}}
</div>


<setpagefooter value="off"></setpagefooter>