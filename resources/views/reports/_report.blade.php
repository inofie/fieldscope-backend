<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<style>

   .page-break {
        page-break-after: always;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
    }

    .column {
        float: left;
        width: 50%;
        padding: 10px;
    }

    .row {
        display: flex;
    }

    ul {
        list-style: none;
    }

    .right li {
        text-align: right;
    }
</style>
<div class="row" style="background:white;height:80px;">
    <div class="column">
        {{--<img src="{{URL::to('assets/images/report/logo.png')}}" style="padding:10px;">--}}
    </div>
    <div class="column">
        <ul class="right" style="margin:0px;">
            <li style="font-size:15px;padding:0px 15px;">www.fieldscope.com</li>
            <li style="font-size:15px;padding:0px 15px;">0800-111-222-101</li>
        </ul>
    </div>
</div>

<div class="row" style="height:120px;">
    <div class="column" style="background-color:#00ade6;">
        <div class="row">
            <div class="column" style="padding:0;">
                <p style="color:white;margin:5px;">Project Name:</p>
            </div>
            <div class="column" style="padding:0;">
                <p style="color:white;margin:5px;font-family: Kastelov;">Test Customer</p>
            </div>

        </div>
        <div class="row">
            <div class="column" style="padding:0;">
                <p style="color:white;margin:5px;">Address:</p>
            </div>
            <div class="column" style="padding:0;">
                <p style="color:white;margin:5px; font-family: Kastelov;">St#1</p>
            </div>

        </div>
        <div class="row">
            <div class="column" style="padding:0;">
                <p style="color:white;margin:5px;">City, State, Zip:</p>
            </div>
            <div class="column" style="padding:0;">
                <p style="color:white;margin:5px;font-family: Kastelov;">Abc Xyz 123</p>
            </div>

        </div>

    </div>
    <div class="column" style="background-color:#114050;">
        <div class="row">
            <div class="column" style="padding:0;">
                <p style="color:white;margin:3px;">Location Verified:</p>
            </div>
            <div class="column" style="padding:0;">
                <p style="color:white;margin:3px;font-family: Kastelov;">LAT:25.30164646, LONG:25.30136164</p>
            </div>

        </div>
        <div class="row">
            <div class="column" style="padding:0;">
                <p style="color:white;margin:3px;">Inspector:</p>
            </div>
            <div class="column" style="padding:0;">
                <p style="color:white;margin:3px;font-family: Kastelov;">Test User</p>
            </div>

        </div>
        <div class="row">
            <div class="column" style="padding:0;">
                <p style="color:white;margin:3px;">Claim #:</p>
            </div>
            <div class="column" style="padding:0;">
                <p style="color:white;margin:3px;font-family: Kastelov;">H01234645</p>
            </div>

        </div>
        <div class="row">
            <div class="column" style="padding:0;">
                <p style="color:white;margin:3px;">Inspection Date:</p>
            </div>
            <div class="column" style="padding:0;">
                <p style="color:white;margin:3px;font-family: Kastelov;">7/4/2019</p>
            </div>

        </div>
    </div>
</div>
<div id="content">
    <div class="row">
        <div class="column" style="width:100%;">
            <h1 style="text-align:center;font-weight:bold;font-size:20px;margin:10px;">Component List</h1>
        </div>
    </div>
    <div class="row">
        <div class="column" style="width:100%;padding-left:20%;padding-top:0px;">
            <ul style="list-style:none;margin:0;">
                <li><strong style="font-size:17px;">Roof:</strong>
                    <ul class="component" style="list-style:none;">
                        <li style="width:100%;margin:0px;">
                            <div class="row">
                                <div class="column" style="width:40%;">Pipe Flashing</div>
                                <div class="column" style="width:60%;">2</div>
                            </div>
                        </li>
                        <li style="width:100%;margin:0px;">
                            <div class="row">
                                <div class="column" style="width:40%;">Small Chimneys</div>
                                <div class="column" style="width:60%;">1</div>
                            </div>
                        </li>
                        <li style="width:100%;margin:0px;">
                            <div class="row">
                                <div class="column" style="width:40%;">Painted Box Vent</div>
                                <div class="column" style="width:60%;">8</div>
                            </div>
                        </li>
                        <li style="width:100%;margin:0px;">
                            <div class="row">
                                <div class="column" style="width:40%;">Gutter Apron</div>
                                <div class="column" style="width:60%;">Yes</div>
                            </div>
                        </li>
                        <li style="width:100%;margin:0px;">
                            <div class="row">
                                <div class="column" style="width:40%;">Drip Edge</div>
                                <div class="column" style="width:60%;">Yes</div>
                            </div>
                        </li>
                    </ul>
                </li>
                <li style="width:100%;margin:0px;">
                    <strong style="font-size:17px;">Gutters:</strong>
                    <ul class="component" style="list-style:none;">
                        <li style="width:100%;margin:0px;">
                            <strong style="font-size:16px;">Front Elevation</strong>
                        </li>
                        <li style="width:100%;margin:0px;">
                            <div class="row">
                                <div class="column" style="width:40%;">A-Elbow</div>
                                <div class="column" style="width:60%;">3</div>
                            </div>
                        </li>
                        <li style="width:100%;margin:0px;">
                            <div class="row">
                                <div class="column" style="width:40%;">B-Elbow</div>
                                <div class="column" style="width:60%;">1</div>
                            </div>
                        </li>
                        <li style="width:100%;margin:0px;">
                            <div class="row">
                                <div class="column" style="width:40%;">Outside Miter</div>
                                <div class="column" style="width:60%;">1</div>
                            </div>
                        </li>
                        <li style="width:100%;margin:0px;">
                            <div class="row">
                                <div class="column" style="width:40%;">Inside Miter</div>
                                <div class="column" style="width:60%;">2</div>
                            </div>
                        </li>
                        <li style="width:100%;margin:0px;">
                            <div class="row">
                                <div class="column" style="width:40%;">3 x 4 Downspout</div>
                                <div class="column" style="width:60%;">23'</div>
                            </div>
                        </li>
                        <li style="width:100%;margin:0px;">
                            <strong style="font-size:16px;">Right Elevation</strong>
                        </li>
                        <li style="width:100%;margin:0px;">
                            <div class="row">
                                <div class="column" style="width:40%;">A-Elbow</div>
                                <div class="column" style="width:60%;">3</div>
                            </div>
                        </li>
                        <li style="width:100%;margin:0px;">
                            <div class="row">
                                <div class="column" style="width:40%;">B-Elbow</div>
                                <div class="column" style="width:60%;">1</div>
                            </div>
                        </li>
                        <li style="width:100%;margin:0px;">
                            <div class="row">
                                <div class="column" style="width:40%;">Outside Miter</div>
                                <div class="column" style="width:60%;">1</div>
                            </div>
                        </li>
                        <li style="width:100%;margin:0px;">
                            <div class="row">
                                <div class="column" style="width:40%;">3 x 4 Downspout</div>
                                <div class="column" style="width:60%;">23'</div>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>

<div class="row" style="background:#00ade6;height:80px;" id="footer">
    <div class="column" style="padding-left:5%;">
        <p style="color:white;letter-spacing:1px;margin:15px;font-size:20px;font-family:Kastelov;">Powered By:<strong>
                FieldScope</strong></p>
    </div>
    <div class="column" style="padding-right:5%;">
        <p style="text-align:right;color:white;1px;margin:15px;font-size:20px;font-family: Kastelov;">Page:1 of 3</p>
    </div>
</div>
<div class="page-break">
    <h1>Next page content</h1>
</div>
</body>

</html>