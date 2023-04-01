<!-- <style>

    table {
        margin: auto;
    }
    .page2-welcome-message > p {
        font-size: 4rem;
        text-transform: uppercase;
        width: 20%;
        line-height: 1.25;
        margin-top: 10rem;
        color: rgb(70,72,72);
        font-weight: 600;
    }
    .page2-company{
        border: solid 1px red ;
    }

    .page2-company > p {
        font-size: 9px;
        text-transform: uppercase;
        /*line-height: 1.25;*/
        margin-top: 5rem;
        font-weight: 600;
        color: rgb(70,72,72);
    }
    .page2-company .designation {
        font-size: 9px;
        text-transform: uppercase;
        /*line-height: 1.25;*/
        font-weight: 500;
        margin-top: 0;
        color: rgb(70,72,72);
    }

    .page2-body-message{
        border: solid 1px red ;
    }

    .page2-body-message > p {
        margin-top: 10px;
        color: rgb(70,72,72);
        text-align: justify;
        font-size: 2px;

    }
    .page2-sig-img{
        border: solid 1px greenyellow ;
        height: 10px;
    }

    .page2-sig-img > img {
        width: 100px;
        height: auto;
        /*max-width: 300px;*/
        margin: 0;
    }
</style> -->
<table width=100% >
    <tbody>
    <tr>
        <td  style="padding-top: 4rem;width: 20%;">
            <h1 style="font-size: 2.5rem;text-transform: uppercase;line-height: 1.25;color: {{$companyDetails->secondary_color}};">Welcome <br />message</h1>
        </td>
    </tr>
    <tr>
        <td  style="padding-top: 4rem;">
            <h5 style="font-size: 1.5rem;text-transform: uppercase;line-height: 1.25;color: {{$companyDetails->secondary_color}};">Paul Emerson</h5>
            <p style="font-size: 1.25rem;text-transform: uppercase;line-height: 1.25;color: {{$companyDetails->secondary_color}};">CEO / Founder</p>
        </td>
    </tr>
    <tr>
        <td style="padding-top: 2rem;">
              <p style="padding-top: 10px; color: {{$companyDetails->secondary_color}};text-align: justify; font-size: 12px;"> {!! $introduction[0]['content'] !!} </p>
        </td>
    </tr>
    <tr>
        <td  align="right" style=" padding-top: 60px;">
            <img src="{{asset('assets/images/sig.png')}}" alt="signature " style=" width: 200px; height: 80px; " />
        </td>
    </tr>
    </tbody>
</table>