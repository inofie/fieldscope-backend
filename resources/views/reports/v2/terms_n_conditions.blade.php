<style>
    .b_border{ border: 1px solid;}
    .r_border{ border: 1px solid red;}
    .g_border{ border: 1px solid darkgreen;}
    .bl_border{ border: 1px solid darkblue;}

    .sign-cell{
        width: 50%;
        text-align: center;
        padding-top: 81px;
    }

    .sign-cell > p {
        font-size: 14px;
        color: {{$companyDetails->secondary_color}};
        border: 1px solid red
    }
</style>
<table width=100%>
    <tbody>
    <tr>
        <td style="padding-top: 2rem;" colspan="2">
            <p style="padding-top: 10px; color: {{$companyDetails->secondary_color}};text-align: justify; font-size: 12px;">
                {!! $termsNConditions[0]['content'] !!}
            </p>
        </td>
    </tr>
    </tbody>
</table>