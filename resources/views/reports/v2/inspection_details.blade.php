<!-- <style>
    .b_border{ border: 1px solid;}
    .r_border{ border: 1px solid red;}
    .g_border{ border: 1px solid darkgreen;}
    .b_border{ border: 1px solid darkblue;}

    .query  {
        padding-left: 20px;
    }

    .response  {
        /*padding-right: 80px;*/
    }

    .query-table {
        border: 1px solid;
        border-collapse: collapse;
    }
    .query-table tr{

    }
    .query-table .query{
        border: 1px solid;
        width: 70%;
    }
    .query-table .response{
        border: 1px solid blue;
        width: 20%;
    }
</style> -->

<table style="width:100%;padding-top:2rem;" >
  <tr>
    <td >
      <h2 style="text-transform:uppercase;color: {{$companyDetails->secondary_color}};padding:0;font-size:14px;letter-spacing: 2;">{{$category_name}}</h2>
    </td>
  </tr>
</table>
@if(!empty($survey))
<table  style="width:100%; padding-top:10px;">
  @foreach($survey AS $sKey => $sItem)
  <tr >
    <td  style=" width: 80%; padding-left: 2rem;">
      <p style="padding-bottom: 10px; text-transform:uppercase;color: {{$companyDetails->secondary_color}};padding:0;font-size:14px;letter-spacing: 2;">{{$sItem['query']}}</p>
    </td>

    @if($sItem['type'] == 'text' || $sItem['type'] == 'date')
    <td  style="width: 20%;padding-left: 2rem;text-transform:uppercase;color: {{$companyDetails->secondary_color}};padding:0;font-size:14px;letter-spacing: 2;">{{ $sItem['response'] }}</td>
    @elseif($sItem['type'] == 'sign' )
    <td  style="width: 20%;padding-left: 2rem;text-transform:uppercase;color: {{$companyDetails->secondary_color}};padding:0;font-size:14px;letter-spacing: 2;">
      <img style="width: 200px; border: #808080 solid 1px;" src="{{ $sItem['user_response'] }}">
    </td>
    @else @if(!empty($sItem['options']))
    <td  style="width: 20%;padding-left: 2rem;">
      <p >
        @php $selectedOps = []; @endphp @foreach($sItem['options'] AS $opKey => $opItem) @if($opItem['is_selected']) @php $selectedOps[] = $opItem['title']; @endphp {{--@if(!$loop->last) {{$opItem['title'].", "}} @else {{$opItem['title']}} @endif
        <td style="width:50%;padding-left: 2rem;">
          <p style='text-transform:uppercase;color: {{$companyDetails->secondary_color}};padding:0;font-size:14px;letter-spacing: 2;'>{{(!empty($opItem['is_selected'])) ? 'Selected': ''}}</p>
        </td>--}} @endif @endforeach @php echo implode(', ',$selectedOps); @endphp
      </p>
    </td>
    @elseif($sItem['response']) {{--ELSE Block--}}
    <td  style="width: 20%;padding-left: 2rem;">
      <p style="text-transform:uppercase;color: {{$companyDetails->secondary_color}};padding:0;font-size:14px;letter-spacing: 2;">{{$sItem['response']}}</p>
    </td>
    @endif @endif
  </tr>
  @endforeach
</table>
@else
<table style="width:100%; padding-top: 2rem; ">
  <tr>
    <td style="padding-left:50px;padding-top: 70px;">
      <p >No Survey</p>
    </td>
  </tr>
</table>
@endif