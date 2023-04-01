<table  style="padding:20px 0px;">
    <tr >
        <td>
            <table style="width:100%;padding: 0px 50px;">
                <tr>
                    <td style="width: 50%;padding:0">
                        <table>
                            <tr>
                                <td style="padding:0px 50px 10px 0px;"><img src="{{ public_path('image/logo.png') }}"></td>
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
                                <td style="width:70%; text-align: right;"></td>
                                <td style="width:30%; text-align: right;"><strong>111-222-333</strong></td>
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
                                <td style="color:white;font-size:12px;">{{$project['name']}}</td>
                            </tr>
                            <tr>
                                <td style="color:white;font-size:12px;"><b>Address:</b></td>
                                <td style="color:white;font-size:12px;">{{$project['address1']}}</td>
                            </tr>
                            <tr>
                                <td style="color:white;font-size:12px;"><b>Address:</b></td>
                                <td style="color:white;font-size:12px;">{{$project['address2']}}</td>
                            </tr>
                            <tr>
                                <td style="color:white;font-size:12px;"><b>City, State, Zip:</b></td>
                                <td style="color:white;font-size:12px;">{{$project['complete_address']['complete_address']." ".$project['postal_code']}}</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:50%;background:#114050;">
                        <table style="padding: 5px 20px;width:100%;">
                            <tr>
                                <td style="color:white;font-size:12px;padding-left:10px;"><b>Location Verified:</b></td>
                                <td style="color:white;font-size:12px;padding-left:10px;">Lat:{{$project['latitude']}}, LONG:{{$project['longitude']}}</td>
                            </tr>
                            <tr>
                                <td style="color:white;font-size:12px;padding-left:10px;"><b>Inspector:</b></td>
                                <td style="color:white;font-size:12px;padding-left:10px;">{{$project['assigned_user']['first_name'].' '.$project['assigned_user']['last_name']}}</td>
                            </tr>
                            <tr>
                                <td style="color:white;font-size:12px;padding-left:10px;"><b>Claim #:</b></td>
                                <td style="color:white;font-size:12px;padding-left:10px;">{{$project['claim_num']}}</td>
                            </tr>
                            <tr>
                                <td style="color:white;font-size:12px;padding-left:10px;"><b>Inspection Date:</b></td>
                                <td style="color:white;font-size:12px;padding-left:10px;">{{$project['inspection_date']}}</td>
                            </tr>
                        </table>
                    </td>
                <tr>
            </table>
        </td>
    </tr>
</table>
