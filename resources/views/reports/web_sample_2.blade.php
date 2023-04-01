<?php
/**
 * Created by PhpStorm.
 * User: dnasir
 * Date: 7/8/2019
 * Time: 4:12 PM
 */
?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body style="background:url('images/bg.png');background-size: 100% 100%;background-repeat: no-repeat;">
<!-- Button to Open the Modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    Open modal
</button>

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modal Heading</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                Modal body..
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<iframe src="{{url("uploads/pdf/project_report_26.pdf")}}" title="description" style="width:100%; height:800px;"></iframe>
<table style="width:100%;">
    <tr>
        <td style="width: 50%;">
            <table>
                <td style="padding:10px 50px;"><img src="{{url("image/logo.png")}}"></td>
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

<table style="width:100%;">
    <tr>
        <td style="width:50%;background:#00ade6;">
            <table style="width:100%;">
                <tr style="width:100%;">
                    <td style="color:white; width:30%;padding-left:25px;">Project Name:</td>
                    <td style="color:white; width:20%;"></td>
                    <td style="color:white;width:50%;">Test Customer</td>
                </tr>
                <tr>
                    <td style="color:white; width:30%;padding-left:25px;">Address:</td>
                    <td style="color:white; width:20%;"></td>
                    <td style="color:white;width:50%;">St#1</td>
                </tr>
                <tr>
                    <td style="color:white;width:30%;padding-left:25px;">City, State, Zip:</td>
                    <td style="color:white; width:20%;"></td>
                    <td style="color:white;width:50%;">Abc Xyz 123</td>
                </tr>
            </table></td>

        <td style="width:50%;background:#114050;"><table>
                <tr>
                    <td style="color:white;">Location Verified</td>
                    <td style="color:white;">Lat:25.1231666, LONG:12.2661613</td>
                </tr>
                <tr>
                    <td style="color:white;">Inspector:</td>
                    <td style="color:white;">Test User</td>
                </tr>
                <tr>
                    <td style="color:white;">Claim #:</td>
                    <td style="color:white;">H01254232</td>
                </tr>
                <tr>
                    <td style="color:white;">Inspactin Date:</td>
                    <td style="color:white;">9/7/2019</td>
                </tr>
            </table></td>
    <tr>
</table>
<table style="width:100%;">
    <tr style="width:100%;">
        <td style="width:20%;"></td>
        <td style="width:80%;"><h3>Sign the document by adding your name.</h3></td>
    </tr>
    <tr style="">
        <td style="width:20%;"></td>
        <td style="width:80%;"><input type="text" placeholder="Enter your name."/></td>
    </tr>
    <tr style="height: 200px;">
        <td></td>
    </tr>
</table>
<table style="width:100%; display: none;">
    <tr style="width:100%;">
        <td style="width:20%;"></td>
        <td style="width:20%;"><input type="radio" name="select" checked> Roofing</td>
        <td style="width:20%;"><input type="radio" name="select"> Siding</td>
        <td style="width:20%;"><input type="radio" name="select"> Garage Doors</td>
        <td style="width:20%;"></td>
    </tr>

    <tr style="width:100%;">
        <td style="width:20%;padding-top:20px;"></td>
        <td style="width:20%;padding-top:20px;"><input type="radio" name="select" checked>Gutters</td>
        <td style="width:20%;padding-top:20px;"><input type="radio" name="select">Windows</td>
        <td style="width:20%;padding-top:20px;"><input type="radio" name="select">Painting</td>
        <td style="width:20%;padding-top:20px;"></td>
    </tr>
</table>
<table style="width:100%; display: none;">
    <tr>
        <td style="padding:100px 50px;"><img src="{{url("image/image2.png")}}"></td>
        <td style="padding:100px 50px;"><img src="{{url("image/image3.png")}}"></td>
    </tr>
</table>
<table style="width:100%;background: #00ade6; display: none">
    <tr>
        <td style="width:50%;padding:20px 50px;">
            <table>
                <tr>
                    <td style="color:white;">Powered by:</td>
                    <td style="color:white;"><strong>FieldScope</strong></td>
                </tr>
            </table>
        </td>
        <td style="width:50%;padding:20px 50px;">
            <table style="width:100%;">
                <tr>
                    <td style="width:80%;"></td>
                    <td style="width:4%;color:white;">Page:</td>
                    <td style="width:10%;color:white;">1 of 3</td>

                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>