
<table style="width:100%; padding-top:40px;">
    <thead>
    <tr >
        <td  style="position: relative; vertical-align:top;" >
          <table style="width:100%;" align="left">
            <tbody>
              <tr >
                <td align="left" style="font-size: 14px;text-transform: uppercase;color: {{$companyDetails->secondary_color}};font-weight: normal;padding:0;">{{$companyDetails->name}} </th>
              </tr>
               <tr >
                 <td align="left" style="font-size: 14px;text-transform: uppercase;color: {{$companyDetails->secondary_color}};font-weight:normal;padding:0;">{{$heading ? $heading : ""}}</th>
              </tr>
               <tr >
                 <td align="left" style="font-size: 14px;text-transform: uppercase;color: {{$companyDetails->secondary_color}};font-weight:bold;padding-top: 10px;vertical-align:bottom;">{PAGENO}</th>
              </tr>
            </tbody>
             
          </table>
<!--             <p style="font-size: 14px;text-transform: uppercase;color: rgb(73,73,75);">{{$companyDetails->name}} {{$companyDetails->primary_color}} {{$companyDetails->secondary_color}}</p>
            <p  style="font-size: 14px;text-transform: uppercase;color: rgb(73,73,75);">{{$heading ? $heading : ""}}</p>
            <h6 style="font-size: 14px;text-transform: uppercase;color: rgb(73,73,75);font-weight:bold;">{PAGENO}</h6> -->
        </td>
        <td align="right" >
            <img src="{{$companyDetails->logo_path}}" alt="header logo" style="width: 280px;height: 90px;object-fit:contain;">
        </td>
    </tr>
    
    </thead>
</table>