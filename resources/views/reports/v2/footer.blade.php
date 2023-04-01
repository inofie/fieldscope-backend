<table style="width:100%;margin: 0;  border-collapse:true " >
    <tbody>
        <tr >
            <td colspan="2"  style="padding-bottom:10px;">
                <h1 style="color: {{$companyDetails->secondary_color}};font-size: 16px;font-weight: bold;margin: 5rem 0 1.5rem 2rem;text-transform:uppercase;">{{$project['name']}} </h1>
            </td>
        </tr>
        <tr>
            <td  style=" width: 25%;padding-top:0px;margin-top:0px;vertical-align:top;">
                @php
                    $addressArr = explode(',', $project['address1'], 2);
                @endphp
                <p  style="color: {{$companyDetails->secondary_color}};font-size: 12px;padding-top:0px;margin-top:0px"> {{$addressArr[0]}} </p>
                <p  style="color: {{$companyDetails->secondary_color}};font-size: 12px;padding-top:0px;margin-top:0px"> {{$addressArr[1]}}</p>
            </td>
            <td   style=" width: 75%;vertical-align:top;">
                <p style="color: {{$companyDetails->secondary_color}};font-size: 12px;">Claim# {{$project['claim_num']}} <br> <span>Location Lat:{{$project['latitude']}}, Long: {{$project['longitude']}}</span></p>
            </td>
        </tr>
        <tr >
            <td colspan="2" style="width:100%;">
                <hr style="width:100%;margin-top:10px;margin-bottom:5px;height:3px;border-width:0;color:{{$companyDetails->primary_color}};">
            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" style=" padding-bottom: 30px;">
                <p style="display: inline-block;color: rgb(162,162,163);font-size: 12px;vertical-align: middle;">Powered By: </p>
                <img src="{{asset('assets/images/fieldscope-footer-logo.png')}}" alt="footer logo" style="margin-right: 20px;width: 90px;height: 15px;vertical-align: middle;">
            </td>
        </tr>
    </tbody>
</table>