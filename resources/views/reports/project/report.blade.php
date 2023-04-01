<!DOCTYPE html>
<html lang="en">
<head>
    <style>

        @page {
            background-image: url('{{ public_path("image/bg.png") }}') center center no-repeat;
            /*-webkit-background-size: cover;*/
            background-image-resize: 6;
            margin: 0%;
            size: auto;
        {{--background: url('{{ public_path("images/bg.png") }}') no-repeat center center fixed;--}}
        {{---webkit-background-size: cover;--}}
        {{---moz-background-size: cover;--}}
        {{---o-background-size: cover;--}}
        {{--background-size: cover;--}}


        }

        @font-face {
            font-family: AxiformaRegular;
            src: url('{{ base_path('public/font/Axiforma/Kastelov-AxiformaRegular.otf') }}');
        }

        @font-face {
            font-family: AxiformaBold;
            src: url('{{ base_path('public/font/Axiforma/Kastelov-AxiformaBold.otf') }}');
        }
    </style>
</head>
{{--<htmlpageheader name="page-header">--}}
{{--<table style="width:100%;">--}}
{{--<tr>--}}
{{--<td style="width: 50%;">--}}
{{--<table>--}}
{{--<tr><td style="padding:10px 50px;"><img src="{{ public_path('images/logo.png') }}"></td></tr>--}}
{{--</table>--}}
{{--</td>--}}
{{--<td style="width: 50%;">--}}
{{--<table style="width:100%;">--}}
{{--<tr>--}}
{{--<td style="width:70%;"></td>--}}
{{--<td style="width:30%;">www.fieldscope.com</td>--}}
{{--</tr>--}}
{{--<tr>--}}
{{--<td style="width:70%;"></td>--}}
{{--<td style="width:30%;"><strong>111-222-333</strong></td>--}}
{{--</tr>--}}
{{--</table>--}}
{{--</td>--}}
{{--</tr>--}}
{{--</table>--}}
{{--</htmlpageheader>--}}
<body>
<table style="width:100%;">
    <tr>
        <td style="width: 50%;">
            <table>
                <tr>
                    <td style="padding:10px 50px;"><img src="{{ public_path('image/logo.png') }}"></td>
                </tr>
            </table>
        </td>
        <td style="width: 50%;">
            <table style="width:100%;">
                <tr>
                    <td style="width:70%;"></td>
                    <td style="width:30%;">www.fieldscope.com</td>
                </tr>
                <tr>
                    <td style="width:70%;"></td>
                    <td style="width:30%;"><strong>111-222-333</strong></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="width:100%;border-spacing: 0;">
    <tr>
        <td style="width:50%;background:#00ade6;">
            <table style="width:100%;padding-left:20px;">
                <tr style="width:100%;">
                    <td style="color:white;font-size:12px; "><b>Project Name:</b></td>
                    <td style="color:white;font-size:12px;">Test Customer</td>
                </tr>
                <tr>
                    <td style="color:white;font-size:12px;"><b>Address:</b></td>
                    <td style="color:white;font-size:12px;padding-left:10px;">St#1</td>
                </tr>
                <tr>
                    <td style="color:white;font-size:12px;"><b>City, State, Zip:</b></td>
                    <td style="color:white;font-size:12px;">Abc Xyz 123</td>
                </tr>
            </table>
        </td>
        <td style="width:50%;background:#114050;">
            <table style="padding: 5px 20px;width:100%;">
                <tr>
                    <td style="color:white;font-size:12px;padding-left:10px;"><b>Location Verified:</b></td>
                    <td style="color:white;font-size:12px;padding-left:10px;">Lat:25.1231666, LONG:12.2661613</td>
                </tr>
                <tr>
                    <td style="color:white;font-size:12px;padding-left:10px;"><b>Inspector:</b></td>
                    <td style="color:white;font-size:12px;padding-left:10px;">Test User</td>
                </tr>
                <tr>
                    <td style="color:white;font-size:12px;padding-left:10px;"><b>Claim #:</b></td>
                    <td style="color:white;font-size:12px;padding-left:10px;">H01254232</td>
                </tr>
                <tr>
                    <td style="color:white;font-size:12px;padding-left:10px;"><b>Inspaction Date:</b></td>
                    <td style="color:white;font-size:12px;padding-left:10px;">9/7/2019</td>
                </tr>
            </table>
        </td>
    <tr>
</table>


<table style="width:100%;margin-top:100px;margin-left:50px;">
    <tr style="width:100%;">

        <td><h1 style="font-family: 'myFirstFont';">Damaged Areas:</h1></td>
    </tr>
</table>
<table style="width:100%; margin-left:60px;margin-top:20px;">
    <tr style="width:100%;">
        <td style="width:20%;padding-left:10px;"><input type="radio" name="select" checked> Roofing</td>
        <td style="width:20%;padding-left:10px;"><input type="radio" name="select"> Siding</td>
        <td style="width:20%;padding-left:10px;"><input type="radio" name="select"> Garage Doors</td>
    </tr>

    <tr style="width:100%;">
        <td style="width:20%;padding-top:15px;padding-left:10px;"><input type="radio" name="select"> Gutters</td>
        <td style="width:20%;padding-top:15px;padding-left:10px;"><input type="radio" name="select"> Windows</td>
        <td style="width:20%;padding-top:15px;padding-left:10px;"><input type="radio" name="select"> Painting</td>
    </tr>
</table>
<table style="width:100%;margin-top:50px;">
    <tr>
        <td><img src="{{ public_path('image/image1.png') }}" style="padding: 50px 0px;"></td>
    </tr>
</table>
<table style="width:100%;background: #00ade6;margin-top:120px;">
    <tr>
        <td style="color:white;width:35%;padding:20px;">Powerd by:<strong>FieldScope</strong></td>
        <td style="color:white;width:40%;"></td>
        <td style="color:white;width:25%;padding:20px;text-align: right;">Page:1 of 3</td>

    </tr>
</table>

{{--page-2 start--}}
<table style="width:100%;">
    <tr>
        <td style="width: 50%;">
            <table>
                <tr>
                    <td style="padding:10px 50px;"><img src="{{ public_path('image/logo.png') }}"></td>
                </tr>
            </table>
        </td>
        <td style="width: 50%;">
            <table style="width:100%;">
                <tr>
                    <td style="width:70%;"></td>
                    <td style="width:30%;">www.fieldscope.com</td>
                </tr>
                <tr>
                    <td style="width:70%;"></td>
                    <td style="width:30%;"><strong>111-222-333</strong></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="width:100%;border-spacing: 0;">
    <tr>
        <td style="width:50%;background:#00ade6;">
            <table style="width:100%;padding-left:20px;">
                <tr style="width:100%;">
                    <td style="color:white;font-size:12px; "><b>Project Name:</b></td>
                    <td style="color:white;font-size:12px;">Test Customer</td>
                </tr>
                <tr>
                    <td style="color:white;font-size:12px;"><b>Address:</b></td>
                    <td style="color:white;font-size:12px;padding-left:10px;">St#1</td>
                </tr>
                <tr>
                    <td style="color:white;font-size:12px;"><b>City, State, Zip:</b></td>
                    <td style="color:white;font-size:12px;">Abc Xyz 123</td>
                </tr>
            </table>
        </td>
        <td style="width:50%;background:#114050;">
            <table style="padding: 5px 20px;width:100%;">
                <tr>
                    <td style="color:white;font-size:12px;padding-left:10px;"><b>Location Verified:</b></td>
                    <td style="color:white;font-size:12px;padding-left:10px;">Lat:25.1231666, LONG:12.2661613</td>
                </tr>
                <tr>
                    <td style="color:white;font-size:12px;padding-left:10px;"><b>Inspector:</b></td>
                    <td style="color:white;font-size:12px;padding-left:10px;">Test User</td>
                </tr>
                <tr>
                    <td style="color:white;font-size:12px;padding-left:10px;"><b>Claim #:</b></td>
                    <td style="color:white;font-size:12px;padding-left:10px;">H01254232</td>
                </tr>
                <tr>
                    <td style="color:white;font-size:12px;padding-left:10px;"><b>Inspaction Date:</b></td>
                    <td style="color:white;font-size:12px;padding-left:10px;">9/7/2019</td>
                </tr>
            </table>
        </td>
    <tr>
</table>
<table style="width:100%;">
    <tr>
        <td style="width:50%;">
            <table style="width:100%;">
                <tr>
                    <td style="padding-left:50px;padding-top: 70px;">
                        <img src="{{ public_path('image/image2.png') }}" style="height:350px;">
                    </td>
                </tr>
            </table>
        </td>
        <td style="width:50%;">
            <table>
                <tr>
                    <td style="width: 50%;padding-top: 70px;"><strong>Area:</strong>Roof</td>
                </tr>
                <tr>
                    <td><strong>Folder:</strong>Shingle Damage</td>
                </tr>
                <tr>
                    <td><strong>Cause:</strong>Wind</td>
                </tr>
                <tr>
                    <td><strong>Photo #:</strong>1 of 32</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="width:100%;">
    <tr>
        <td style="width:50%;">
            <table style="width:100%;">
                <tr>
                    <td style="padding-top: 30px;padding-left:50px;">
                        <img src="{{ public_path('image/image3.png') }}" style="height:350px;">
                    </td>
                </tr>
            </table>
        </td>
        <td style="width:50%;">
            <table>
                <tr>
                    <td style="width: 50%;padding-top: 30px;"><strong>Area:</strong>Roof</td>
                </tr>
                <tr>
                    <td><strong>Folder:</strong>Accessories</td>
                </tr>
                <tr>
                    <td><strong>Component:</strong>Pipe Flashings</td>
                </tr>
                <tr>
                    <td><strong>Qty:</strong>2</td>
                </tr>
                <tr>
                    <td style="padding-bottom: 30px;"><strong>Photo #:</strong>1 of 4</td>
                </tr>

            </table>
        </td>
    </tr>
</table>



{{--page-3 start--}}
<table style="width:100%;">
    <tr>
        <td style="width: 50%;">
            <table>
                <tr>
                    <td style="padding:10px 50px;"><img src="{{ public_path('image/logo.png') }}"></td>
                </tr>
            </table>
        </td>
        <td style="width: 50%;">
            <table style="width:100%;">
                <tr>
                    <td style="width:70%;"></td>
                    <td style="width:30%;">www.fieldscope.com</td>
                </tr>
                <tr>
                    <td style="width:70%;"></td>
                    <td style="width:30%;"><strong>111-222-333</strong></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="width:100%;border-spacing: 0;">
    <tr>
        <td style="width:50%;background:#00ade6;">
            <table style="width:100%;padding-left:20px;">
                <tr style="width:100%;">
                    <td style="color:white;font-size:12px;">Project Name:</td>
                    <td style="color:white;font-size:12px;">Test Customer</td>
                </tr>
                <tr>
                    <td style="color:white;font-size:12px;">Address:</td>
                    <td style="color:white;font-size:12px;padding-left:10px;">St#1</td>
                </tr>
                <tr>
                    <td style="color:white;font-size:12px;">City, State, Zip:</td>
                    <td style="color:white;font-size:12px;">Abc Xyz 123</td>
                </tr>
            </table>
        </td>
        <td style="width:50%;background:#114050;">
            <table style="padding: 5px 20px;width:100%;">
                <tr>
                    <td style="color:white;font-size:12px;padding-left:10px;">Location Verified:</td>
                    <td style="color:white;font-size:12px;padding-left:10px;">Lat:25.1231666, LONG:12.2661613</td>
                </tr>
                <tr>
                    <td style="color:white;font-size:12px;padding-left:10px;">Inspector:</td>
                    <td style="color:white;font-size:12px;padding-left:10px;">Test User</td>
                </tr>
                <tr>
                    <td style="color:white;font-size:12px;padding-left:10px;">Claim #:</td>
                    <td style="color:white;font-size:12px;padding-left:10px;">H01254232</td>
                </tr>
                <tr>
                    <td style="color:white;font-size:12px;padding-left:10px;">Inspaction Date:</td>
                    <td style="color:white;font-size:12px;padding-left:10px;">9/7/2019</td>
                </tr>
            </table>
        </td>
    <tr>
</table>
<table style="width:100%;margin:50px 0px;">
    <tr style="width:100%;">
        <td style="width:30%;"></td>
        <td style="width:40%;"><h1 style="text-align:center;">Component List</h1></td>
        <td style="width:30%;"></td>
    </tr>
</table>
<table style="margin-left:80px;">
    <tr>

        <th style="text-align: left;">
            <h3 style="padding-bottom: 5px;"> Roof</h3>
        </th>
        <th></th>
    </tr>
    <tr>
        <td style="width:50%;padding-left:40px;font-size:18px;">Pipe Fleshing</td>
        <td style="width:50%;padding-left:50px;font-size:18px;">2</td>
    </tr>
    <tr>
        <td style="width:50%;padding-left:40px;font-size:18px;">Small Chimneys</td>
        <td style="width:50%;padding-left:50px;font-size:18px;">1</td>
    </tr>
    <tr>
        <td style="width:50%;padding-left:40px;font-size:18px;">Painted Box Vent</td>
        <td style="width:50%;padding-left:50px;font-size:18px;">8</td>
    </tr>
    <tr>
        <td style="width:50%;padding-left:40px;font-size:18px;">Gutter Apron</td>
        <td style="width:50%;padding-left:50px;font-size:18px;">Yes</td>
    </tr>
    <tr>
        <td style="width:50%;padding-left:40px;font-size:18px;">Drip Edge</td>
        <td style="width:50%;padding-left:50px;font-size:18px;">Yes</td>
    </tr>

</table>
<table style="margin-left:80px;margin-bottom:30px;margin-top:60px;">
    <tr>
        <th>
            <h3 style="padding-bottom: 5px;">Gutters</h3>
        </th>
    </tr>
</table>

<table style="margin-left:120px;width:50%;">
    <tr>
        <th style="text-align:left;width:50%;font-size:20px"><b>Front Elevation</b></th>
        <th style="text-align:left;width:50%;"></th>
    </tr>
    <tr>
        <td style="padding-left:5px;font-size:18px;">A-Elbow</td>
        <td style="width:50%;padding-left:30px;font-size:18px;">3</td>
    </tr>
    <tr>
        <td style="padding-left:5px;font-size:18px;">B-Elbow</td>
        <td style="width:50%;padding-left:30px;">1</td>
    </tr>
    <tr>
        <td style="padding-left:5px;font-size:18px;">Outside Miter</td>
        <td style="width:50%;padding-left:30px;">1</td>
    </tr>
    <tr>
        <td style="padding-left:5px;font-size:18px;">Inside Miter</td>
        <td style="width:50%;padding-left:30px;">2</td>
    </tr>
    <tr>
        <td style="padding-left:5px;font-size:18px;">3 x 4 Downspout</td>
        <td style="width:50%;padding-left:30px;">23'</td>
    </tr>

    <tr>
        <th style="text-align:left;width:50%;font-size: 20px;padding-top:30px;"><b>Right Elevation</b></th>
        <th style="text-align:left;width:50%;"></th>
    </tr>
    <tr>
        <td style="padding-left:5px;font-size:18px;">A-Elbow</td>
        <td style="width:50%;padding-left:30px;">3</td>
    </tr>
    <tr>
        <td style="padding-left:5px;font-size:18px;">B-Elbow</td>
        <td style="width:50%;padding-left:30px;">1</td>
    </tr>
    <tr>
        <td style="padding-left:5px;font-size:18px;">Outside Miter</td>
        <td style="width:50%;padding-left:30px;">1</td>
    </tr>
    <tr>
        <td style="padding-left:5px;font-size:18px;">3 x 4 Downspout</td>
        <td style="width:50%;padding-left:30px;">23'</td>
    </tr>

</table>

<table style="width:100%;background: #00ade6;margin-top:140px;">
    <tr>
        <td style="color:white;width:35%;padding:20px;">Powerd by:<strong>FieldScope</strong></td>
        <td style="color:white;width:40%;"></td>
        <td style="color:white;width:25%;padding:20px;text-align: right;">Page:3 of 3</td>

    </tr>
</table>

</body>
</html>